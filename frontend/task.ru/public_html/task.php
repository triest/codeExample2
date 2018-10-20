<?php
require_once ('DB.php');
$db=new DB("localhost","a0188141_task","a0188141_task","a0188141");
if($_SERVER['REQUEST_METHOD']=='GET'){
    echo json_encode($db->query("SELECT * FROM task"));
    http_response_code(200);
} elseif ($_SERVER['REQUEST_METHOD']=='POST'){
       // echo 'is POST1';
        $postBody=file_get_contents('php://input');
        $postBody=json_decode($postBody);

        $id=htmlspecialchars($_POST["id"]);
        echo $id;
         $post_text=htmlspecialchars($_POST["text"]);
         $del=htmlspecialchars($_POST["del"]);
            $date=date("Y-m-d H:i:s");

            if ($id == '' and $del=='') {
                $sql = "INSERT INTO task (text,date_current)  VALUES ('$post_text','$date')";
            }
            elseif ($del!=''){
                $sql="DELETE FROM `task` WHERE id='$del'";
            }
            else {
                echo '<br>';
                echo 'id not null';
                $sql = "UPDATE task SET text='$post_text' where id='$id'";

            }



        if(!$db->query($sql)){
            $rez=false;
        }else{
            $rez=true;
        }
        echo json_encode(['test'=>'test','body'=>$post_text,'rez'=>$rez]);
      //  DB::query('INSERT INTO task (text,date_current  VALUES ($post_text)');
        http_response_code(200);

}
    else{
        http_response_code(405);
    }

?>