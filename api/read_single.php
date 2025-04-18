<?php
//hata ayıklama
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

echo "Kod buraya kadar çalışıyor<br>"; // Test 1

include_once('../core/initialize.php');

echo "initialize.php dahil edildi<br>"; // Test  2

$post = new Post($db);

$post->id=isset($_GET['id']) ? $_GET['id'] : die();
$post->read_single();

$post_arr = array(
    'id'=>$post->id,
    'title'=>$post->title,
    'body'=>$post->body,
    'author'=>$post->author,
    'category_id'=>$post->category_id,
    'category_name'=>$post->category_name,
);

//json

print_r(json_encode($post_arr));
?>