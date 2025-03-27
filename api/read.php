<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


include_once('../core/initialize.php');



if (!isset($db)) {
    echo json_encode(['error' => 'Veritabanı bağlantısı sağlanamadı']);
    exit;
}

$post = new Post($db);



$result = $post->read();
if ($result === false || $result === null) {
    echo json_encode(['error' => 'Veritabanı sorgusu başarısız']);
    exit;
}

$num = $result->rowCount();

if ($num > 0) {
    $post_arr = array();
    $post_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );
        array_push($post_arr['data'], $post_item);
    }
    echo json_encode($post_arr);
} else {
    echo json_encode(['message' => 'Post Bulunamadı']);
}
?>