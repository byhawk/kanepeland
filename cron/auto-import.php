<?php
/**
 * Evantis Home - Auto Import Cron Job
 *
 * Bu script cronjob ile çalıştırılarak otomatik JSON import yapar
 *
 * Cronjob Kurulumu (cPanel):
 * Command: /usr/bin/php /home/username/public_html/cron/auto-import.php
 * Schedule: Her gün 03:00 (0 3 * * *)
 */

// Direct access check
if (php_sapi_name() !== 'cli') {
    die('Bu script sadece komut satırından çalıştırılabilir!');
}

// Load configuration
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/functions.php';

// Log file
$log_file = dirname(__DIR__) . '/logs/auto-import-' . date('Y-m-d') . '.log';
$log_dir = dirname($log_file);

if (!is_dir($log_dir)) {
    mkdir($log_dir, 0755, true);
}

function writeLog($message) {
    global $log_file;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND);
    echo "[$timestamp] $message\n";
}

writeLog("=== Auto Import Started ===");

// JSON source path (scraper output)
$json_source = dirname(__DIR__) . '/scraper-data/products_database.json';

if (!file_exists($json_source)) {
    writeLog("ERROR: JSON dosyası bulunamadı: $json_source");
    exit(1);
}

writeLog("JSON dosyası bulundu: $json_source");

// Read and parse JSON
$json_content = file_get_contents($json_source);
$products_data = json_decode($json_content, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    writeLog("ERROR: JSON parse hatası: " . json_last_error_msg());
    exit(1);
}

$total = count($products_data);
$imported = 0;
$updated = 0;
$failed = 0;
$errors = [];

writeLog("Toplam $total ürün işlenecek");

$db->beginTransaction();

try {
    foreach ($products_data as $index => $product) {
        try {
            // Progress
            if (($index + 1) % 10 == 0) {
                writeLog("İşlenen: " . ($index + 1) . "/$total");
            }

            // Required fields check
            if (empty($product['name']) || empty($product['url'])) {
                $failed++;
                $errors[] = "Ürün #$index: İsim veya URL eksik";
                continue;
            }

            // Create slug
            $slug = createSlug($product['name']);

            // Extract price
            $price = 0;
            if (isset($product['price'])) {
                $price = preg_replace('/[^0-9]/', '', $product['price']);
                $price = $price / 100;
            }

            // Find or create category
            $category_id = null;
            if (isset($product['category'])) {
                $category_slug = createSlug($product['category']);
                $stmt = $db->prepare("SELECT id FROM categories WHERE slug = :slug");
                $stmt->execute(['slug' => $category_slug]);
                $category = $stmt->fetch();

                if (!$category) {
                    $stmt = $db->prepare("INSERT INTO categories (name, slug) VALUES (:name, :slug)");
                    $stmt->execute([
                        'name' => $product['category'],
                        'slug' => $category_slug
                    ]);
                    $category_id = $db->lastInsertId();
                    writeLog("Yeni kategori oluşturuldu: {$product['category']}");
                } else {
                    $category_id = $category['id'];
                }
            }

            // Check if exists
            $stmt = $db->prepare("SELECT id FROM products WHERE slug = :slug");
            $stmt->execute(['slug' => $slug]);
            $existing = $stmt->fetch();

            $main_image = $product['main_image'] ?? $product['thumbnail'] ?? '';

            if ($existing) {
                // Update
                $stmt = $db->prepare("
                    UPDATE products SET
                        category_id = :category_id,
                        name = :name,
                        description = :description,
                        price = :price,
                        main_image = :main_image,
                        updated_at = NOW()
                    WHERE id = :id
                ");
                $stmt->execute([
                    'id' => $existing['id'],
                    'category_id' => $category_id,
                    'name' => $product['name'],
                    'description' => $product['description'] ?? '',
                    'price' => $price,
                    'main_image' => $main_image
                ]);
                $product_id = $existing['id'];
                $updated++;
            } else {
                // Insert
                $stmt = $db->prepare("
                    INSERT INTO products (
                        category_id, name, slug, description, price,
                        main_image, sku, status
                    ) VALUES (
                        :category_id, :name, :slug, :description, :price,
                        :main_image, :sku, 1
                    )
                ");
                $stmt->execute([
                    'category_id' => $category_id,
                    'name' => $product['name'],
                    'slug' => $slug,
                    'description' => $product['description'] ?? '',
                    'price' => $price,
                    'main_image' => $main_image,
                    'sku' => $product['sku'] ?? null
                ]);
                $product_id = $db->lastInsertId();
                $imported++;
            }

            // Import images
            if (!empty($product['images']) && is_array($product['images'])) {
                $stmt = $db->prepare("DELETE FROM product_images WHERE product_id = :product_id");
                $stmt->execute(['product_id' => $product_id]);

                $sort_order = 0;
                foreach ($product['images'] as $image_url) {
                    $stmt = $db->prepare("
                        INSERT INTO product_images (product_id, image_url, sort_order)
                        VALUES (:product_id, :image_url, :sort_order)
                    ");
                    $stmt->execute([
                        'product_id' => $product_id,
                        'image_url' => $image_url,
                        'sort_order' => $sort_order++
                    ]);
                }
            }

            // Import specifications
            if (!empty($product['specifications']) && is_array($product['specifications'])) {
                $stmt = $db->prepare("DELETE FROM product_specifications WHERE product_id = :product_id");
                $stmt->execute(['product_id' => $product_id]);

                $sort_order = 0;
                foreach ($product['specifications'] as $key => $value) {
                    if (is_string($value)) {
                        $stmt = $db->prepare("
                            INSERT INTO product_specifications (product_id, spec_key, spec_value, sort_order)
                            VALUES (:product_id, :spec_key, :spec_value, :sort_order)
                        ");
                        $stmt->execute([
                            'product_id' => $product_id,
                            'spec_key' => $key,
                            'spec_value' => $value,
                            'sort_order' => $sort_order++
                        ]);
                    }
                }
            }

        } catch (Exception $e) {
            $failed++;
            $errors[] = $product['name'] . ': ' . $e->getMessage();
            writeLog("ERROR: " . $product['name'] . ' - ' . $e->getMessage());
        }
    }

    $db->commit();
    writeLog("Database commit başarılı");

    // Log import
    $stmt = $db->prepare("
        INSERT INTO import_logs (
            file_name, total_products, imported_products,
            updated_products, failed_products, status
        ) VALUES (:file_name, :total, :imported, :updated, :failed, :status)
    ");
    $stmt->execute([
        'file_name' => 'auto-import-' . date('Y-m-d'),
        'total' => $total,
        'imported' => $imported,
        'updated' => $updated,
        'failed' => $failed,
        'status' => $failed > 0 ? 'partial' : 'success'
    ]);

    writeLog("=== Import Completed ===");
    writeLog("Toplam: $total");
    writeLog("Yeni: $imported");
    writeLog("Güncellenen: $updated");
    writeLog("Başarısız: $failed");

    if (!empty($errors)) {
        writeLog("\nHatalar:");
        foreach ($errors as $error) {
            writeLog("  - $error");
        }
    }

    // Send email notification (optional)
    if (SITE_EMAIL) {
        $subject = "Evantis Home - Auto Import Raporu";
        $message = "Auto import tamamlandı\n\n";
        $message .= "Toplam: $total\n";
        $message .= "Yeni: $imported\n";
        $message .= "Güncellenen: $updated\n";
        $message .= "Başarısız: $failed\n";

        mail(SITE_EMAIL, $subject, $message);
    }

    exit(0);

} catch (Exception $e) {
    $db->rollBack();
    writeLog("FATAL ERROR: " . $e->getMessage());
    exit(1);
}
?>
