<?php
$type = $_POST["type"];
$data = $_POST["data"];

switch($type) {
    case "ls":
        echo json_encode(fun_ls($data['id']));
        break;
    case "cd":
        echo json_encode(fun_cd($data));
        //echo json_encode();
        break;
    case "mkdir":
        echo json_encode(fun_mkdir($data));
        //echo json_encode();
        break;
    default: 
        break;
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

    }
    fclose($fd);
    return $final;
}
function fun_cd($data){
    $pid = $data['id'];
    $arg = $data['arg'];
    $res = array();
    $fd = fopen('map.txt', 'r');
    $read = fread($fd,filesize('map.txt'));
    $line = explode("\n",$read);
    if($arg==".."){
        if($data['pid']==-1){
            fclose($fd);
            return $res;
        } 
        else
        foreach($line as $l)
        {
            $re = explode(' ',$l);
            if((int)$re[0]==(int)$data['pid'])
            {
                $res['id']=$re[0];
                $res['name']=$re[1];
                $res['lvl']=$re[2];
                $res['type']=$re[3];
                $res['pid']=$re[4];
            }
        }
    }
    else{
        foreach($line as $l)
        {
            $re = explode(' ',$l);
            if((int)$re[4]==(int)$pid && $re[1]==$arg)
            {
                if((int)$re[3]==1)
                    $res['er']=":Not a directory";
                else{
                    $res['id']=$re[0];
                    $res['name']=$re[1];
                    $res['lvl']=$re[2];
                    $res['type']=$re[3];
                    $res['pid']=$re[4];
                }
            }
        }
        if(empty($res))
            $res['er']=":No such file or directory";
    }
    fclose($fd);
    return $res;
}
function fun_mkdir($data)
{
    $id=$data['id'];
    $arg=$data['arg'];
    $line=count(file('map.txt'));
    $string = "\n".$line." ".$arg." ".'0'." ".'0'." ".$id;
    file_put_contents('map.txt',$string,FILE_APPEND);
    return '';
}
?>
