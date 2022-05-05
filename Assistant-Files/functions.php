<?php

function insert_user($username, $name, $email, $password){
    $db= new PDO('mysql:host=localhost;dbname=chatproject','root');
    $stmt = $db->prepare("insert into users(userName, name, profile, email, password) values (:username, :name, :profile, :email, :password)");
    $stmt->execute(['username' => $username, 'name' => $name, 'profile' => $username, 'email' => $email, 'password' => $password]);
}

function get_userNames(){
    ($DB = new PDO('mysql:host=localhost;dbname=chatproject','root'));
    $stmt = $DB->query('select userName from users');
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function getnames(){
    $DB = new PDO('mysql:host=localhost;dbname=chatproject','root');
    $stmt = $DB->query('select userName, name from users');
    return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

function get_profile_name(){
    $DB = new PDO('mysql:host=localhost;dbname=chatproject','root');
    $stmt = $DB->query('select username, profile from users');
    return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

function get_profile_image(){
    $DB = new PDO('mysql:host=localhost;dbname=chatproject','root');
    $stmt = $DB->query('select username ,proimg from users');
    return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

function get_users_passwords(){
    $DB = new PDO('mysql:host=localhost;dbname=chatproject','root');
    $stmt = $DB->query('select userName, password from users');
    return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

function get_emails(){
    $DB = new PDO('mysql:host=localhost;dbname=chatproject','root');
    $stmt = $DB->query('select email from users');
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function get_messages(){
    $DB = new PDO('mysql:host=localhost;dbname=chatproject','root');
    $stmt = $DB->query('select * from messages');
    return $stmt->fetchAll(PDO::FETCH_UNIQUE);
}

function send_message(){

    if (isset($_FILES["send-image"])){
        $path="./sent-images/{$_FILES['send-image']['name']}";
        move_uploaded_file($_FILES["send-image"]["tmp_name"],$path);
        $type = 'image';
        $message = $path;
    }

    elseif(count($_GET)>0){
        $message = $_GET['msg'];
        $type = 'text';
    }

    if(isset($_FILES["send-image"]) || count($_GET)>0) {
        $db = new PDO('mysql:host=localhost;dbname=chatproject', 'root');
        $stmt = $db->prepare("insert into messages(username, type, message) values (:username, :type, :message);");
        $stmt->execute(['username' => $_COOKIE['username'], 'type' => $type, 'message' => $message]);

        header("location: chatroom.php");
    }
}

function delete_message(){
    $db = new PDO('mysql:host=localhost;dbname=chatproject', 'root');
    $stmt = $db->prepare("delete from messages where id = :id;");
    $stmt->execute(['id' => $_COOKIE['deleted_msg']]);

    setcookie("deleted_msg","",-1);

    header("location: chatroom.php");
}

function edit_message(){
    $db = new PDO('mysql:host=localhost;dbname=chatproject', 'root');
    $stmt = $db->prepare("update messages set message = :message where id = :id;");
    $stmt->execute(['id' => $_COOKIE['num_msg'], 'message' => $_COOKIE["edited_msg"]]);

    setcookie("edited_msg","",-1);
    setcookie("num_msg","",-1);

    header("location: chatroom.php");

}

function upload_new_iamge_profile(){
    if (isset($_FILES["proimg"])){
        $path="./profile-images/{$_FILES['proimg']['name']}";
        move_uploaded_file($_FILES["proimg"]["tmp_name"],$path);

        $db = new PDO('mysql:host=localhost;dbname=chatproject', 'root');
        $stmt = $db->prepare("update users set proimg = :proimg where username = :username;");
        $stmt->execute(['username' => $_COOKIE['username'], 'proimg' => $path]);
    }
}

function rename_profile(){
    if (isset($_POST["changepro"])){
        $db = new PDO('mysql:host=localhost;dbname=chatproject', 'root');
        $stmt = $db->prepare("update users set profile = :profile where username = :username;");
        $stmt->execute(['username' => $_COOKIE['username'], 'profile' => $_POST["changepro"]]);
    }
}

function block($username){
    $db= new PDO('mysql:host=localhost;dbname=chatproject','root');
    $stmt = $db->prepare("insert into blockusers(username) values (:username)");
    $stmt->execute(['username' => $username]);
}

function unblock($username){
    $db= new PDO('mysql:host=localhost;dbname=chatproject','root');
    $stmt = $db->prepare("delete from blockusers where username = :username;");
    $stmt->execute(['username' => $username]);
}

function get_block_users(){
    $DB = new PDO('mysql:host=localhost;dbname=chatproject','root');
    $stmt = $DB->query('select username from blockusers');
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}