<?php
    try{
        include "lib/lib_hash.php";
        if (!isset($_COOKIE["token"])) {
            if (isset($_POST["login"])&&isset($_POST["password"])){
                $connection_to_db = new MongoClient();
                $collection= $connection_to_db-> league -> users;
                $filter=array("login"=> $_POST["login"],"password"=> create_password_hash($_POST["password"]));
                $user = $collection->findOne($filter);
                if ($user!==null){
                $token=create_token();
                $update_field = array ('$set' => array("token" =>  $token));
                $option = array("upsert" => true);
                $collection -> update($user, $update_field, $option);
                $connection_to_db->close();
                setcookie ("token", $token);
                header('Location:/testsite.local/index.html');
                }
                else {
                    $connection_to_db->close();
                    echo '<p align="center">Access denied! Check your login/password</p>';
                }
            }
        }
        else{
            header('Location:/testsite.local/index.html');
        }
    }catch(MongoConnectionException $e) {
        header("HTTP/1.0 500 Server Mongodb is not avalaible");
        }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Добро пожаловать</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
	<link rel="shortcut icon" href="favicon.ico">
</head>
<body>
<div class="container">
    <form class="form-signin" method="POST" action="loginform.php" role="form">
        <h2 class="form-signin-heading">Авторизация</h2>
        <input id="login" name="login" type="text" class="form-control" placeholder="Логин" maxlength="10" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required autofocus>
        <input id="password" name="password" type="password" class="form-control" placeholder="Пароль" maxlength="10" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,}$" required autofocus>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
        <a href="restore_password.php" class="btn-link mar-rgt">Забыли пароль ?</a>
        <a href="registerform.php" class="btn-link mar-lft">Создать новый аккаунт</a>
    </form>
</div>
</body>
</html>