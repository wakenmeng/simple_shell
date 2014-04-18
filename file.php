<?php
$type = $_POST["type"];//命令
$data = $_POST["data"];//命令参数，当前位置等

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
//处理ls命令
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
//处理cd命令，分为绝对路径，相对路径和cd ..返回上一级
function fun_cd($data){
    $pid = $data['id'];
    $arg = explode('/',$data['arg']);
    if($arg[0]=='') 
    {   //绝对路径
        $pid = '-1';
        $arg[0]='/';
    }
    $res = array();
    $final=array();
    $fd = fopen('map.txt', 'r');
    $read = fread($fd,filesize('map.txt'));
    $line = explode("\n",$read);
    //处理cd ..
    if(count($arg)==1 && $arg[0]==".."){
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
                array_push($final,$res);
                break;
            }
        }
    }
    else{
        //处理绝对和相对路径
        foreach ($arg as $dir) {
            foreach($line as $l)
            {
                $re = explode(' ',$l);
                if((int)$re[4]==(int)$pid && $re[1]==$dir)
                {
                    if((int)$re[3]==1){
                        //判错，并非文件夹
                        fclose($fd);
                        $res['er']=":Not a directory";
                        return $res;
                    }
                    else{
                        $res['id']=$re[0];
                        $res['name']=$re[1];
                        $res['lvl']=$re[2];
                        $res['type']=$re[3];
                        $res['pid']=$re[4];
                        $pid=$res['id'];
                        array_push($final,$res);
                        break;
                    }
                }
            }
        if(empty($final)){
            //判错，目标或目标路径中的文件不存在
            fclose($fd);
            $res['empty']=$dir;
           $res['er']=$dir.":No such file or directory";
            return $res;
            }
        $res=array();
        }
    }
    fclose($fd);
    return $final;
}
//处理mkdir命令
function fun_mkdir($data)
{
    $pid=$data['id'];
    $arg=$data['arg'];
    //判重，声明文件夹是否已有重名文件夹存在
    $fd=fopen('map.txt','r');
    $read = fread($fd, filesize('map.txt'));
    $line = explode("\n",$read);
    foreach ($line as $l) {
       $re=explode(' ', $l);
       if((int)$pid==(int)$re[4] && $arg==$re[1] && (int)$re[3]==0)
       {
        $res['er']="mkdir: cannot create directory\'".$arg."\': File exists";
        return $res;
       } 
    }
    $lvl=(int)$data['lvl']+1;
    $string = "\n".count($line)." ".$arg." ".$lvl." ".'0'." ".$pid;
    file_put_contents('map.txt',$string,FILE_APPEND);
    return '';
}
?>
