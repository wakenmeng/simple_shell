<?php
$type = $_POST["type"];
$data = $_POST['data'];
switch($type) {
    case "ls":
        echo json_encode(fun_ls($data['pid']));
        break;
    case "cd":
        //echo json_encode();
        break;
    case "mkdir":
        //echo json_encode();
        break;
    default: 
        break;
}
 

function deal_map() {
    $fd = fopen('map.txt', 'r');
    $result = fread($fd, filesize('map.txt'));
    //$line = explode('\n', $result);
    $result = explode(' ', $result);
    var_dump($result);
}
function fun_ls($pid) {
    $res=array();
    $final =array();
    $fd = fopen('map.txt', 'r');
    $result = fread($fd, filesize('map.txt'));
    $line = explode("\n", $result);
    foreach($line as $l)
    {
        $re = explode(' ', $l);
        if((int)$re[4]==(int)$pid)
        {
            $res['id']=$re[0];
            $res['name']=$re[1];
            $res['lvl']=$re[2];
            $res['type']=$re[3];
            $res['pid']=$re[4];
            array_push($final,$res);
            $res=array();
        }
       // var_dump($re);

        //var_dump($re[4]);

    }
    return $final;
}


function insert_map() {
    $fd = fopen('map.txt', 'w');
}
?>
