<?php 
function get_users_password($json_file){
    $details=file_get_contents($json_file);
    $details=json_decode($details,true);
    return $details;
}

function get_emails($json_file){
    $details=file_get_contents($json_file);
    $details=json_decode($details,true);
    return $details;
}

function get_messages($json_file){
    $details=file_get_contents($json_file);
    $details=json_decode($details,true);
    return $details;
}

function upload_new_iamge_profile(){
    $users=get_users_password("users.json");
    if (isset($_FILES["proimg"])){
        $path="./profile-images/{$_FILES['proimg']['name']}";
        move_uploaded_file($_FILES["proimg"]["tmp_name"],$path);
        $users[$_COOKIE["username"]]["proimg"]=$path;
    }
    $jsonobj=json_encode($users);
    file_put_contents("users.json",$jsonobj);
}

function rename_profile(){
    $users=get_users_password("users.json");
    if (isset($_POST["changepro"])){
        $users[$_COOKIE["username"]]["profile"]=$_POST["changepro"];
    }
    $jsonobj=json_encode($users);
    file_put_contents("users.json",$jsonobj);
}

function sent_image(){
    $users=get_users_password("users.json");
    if (isset($_FILES["send-image"])){
        $path="./sent-images/{$_FILES['send-image']['name']}";
        move_uploaded_file($_FILES["send-image"]["tmp_name"],$path);
        $massages=get_messages("messages.json");
        $mymsg=$_COOKIE["username"]."|"."image"."|".$path;
        array_push($massages,$mymsg);
        $obj_msgs=json_encode($massages);
        file_put_contents("messages.json",$obj_msgs);
        header("location: chatroom.php");
    }
    $jsonobj=json_encode($users);
    file_put_contents("users.json",$jsonobj);
}

function block($username,$usersblock){
    if (isset($_POST["block"])){
        $ub=file_get_contents($usersblock);
        $ub=json_decode($ub,true);
        array_push($ub,$username);
        $jsonobj=json_encode($ub);
        file_put_contents("block-users.json",$jsonobj);
    }    
}

function unblock($username,$usersblock){
    if (isset($_POST["unblock"])){
        $ub=file_get_contents($usersblock);
        $ub=json_decode($ub,true);
        $ub=array_diff($ub,[$username]);
        $ub=array_values($ub);
        $jsonobj=json_encode($ub);
        file_put_contents("block-users.json",$jsonobj);
    }    
}

function get_block_users($json_file){
    $details=file_get_contents($json_file);
    $details=json_decode($details,true);
    return $details;
}