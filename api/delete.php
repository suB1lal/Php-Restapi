<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once('../core/initialize.php');

if (!isset($db)) {
    echo json_encode(['error' => 'Veritabanı bağlantısı sağlanamadı']);
    exit;
}

$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));

$post->id = $data->id;

//DELETE post

if ($post->delete()) {
    echo json_encode(
        array('message' => 'Post Silme Başarılı')
    );
}else{
    echo json_encode(
        array('message'=> 'Post Silinemedi')
    );
}
