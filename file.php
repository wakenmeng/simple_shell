<?php
/*
$type = $_POST('type');
$data = json_decode($_POST('data'));

switch($type) {
    case "ls":
        echo json_encode();
        break;
    case "cd":
        echo json_encode();
        break;
    case "mkdir":
        echo json_encode();
        break;
    default: 
        break;
}
 */

function deal_map() {
    $fd = fopen('map.txt', 'r');
    $result = fread($fd, filesize('map.txt'));
    //$line = explode('\n', $result);
    $result = explode(' ', $result);
    var_dump($result);
}
deal_map();

function insert_map() {
    $fd = fopen('map.txt', 'w');
}
?>
