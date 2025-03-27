<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/initialize.php');

if (!isset($db) || $db === null) {
    echo json_encode(['error' => 'Veritabanı bağlantısı sağlanamadı']);
    exit;
}

// Category sınıfı üzerinden nesne oluştur
$post = new Category($db);

try {
    $result = $post->read();

    if (!$result) {
        echo json_encode(['error' => 'Veritabanı sorgusu başarısız']);
        exit;
    }

    $post_arr = array();
    $post_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $post_arr['data'][] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'create_at' => $row['create_at']
        ];
    }

    if (empty($post_arr['data'])) {
        echo json_encode(['message' => 'Kategori bulunamadı']);
    } else {
        echo json_encode($post_arr);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Bir hata oluştu: ' . $e->getMessage()]);
}
?>
