<?php
    session_start();

    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), substr($uri, strrpos($uri,"/")));
    if (isset($_SESSION["login"])){
        $extra = "/index/index.html.php";
        header( "Location: https://$host$uri/$extra");
        exit;
    }
    
    $email = $_POST["email"];
    $password = $_POST["user_password"];

    if (empty($email) || empty($password)){
        $message_empty = "メールアドレスとパスワードを入力してください";
        $_SESSION["message_empty"] = $message_empty;
        $extra = "login/userLogin.html.php";
        header( "Location: https://$host$uri/$extra");
        exit;
    }
    
    include "../dbConnect.php";
    $sql = "select * from users where email = '$email'";

    if ($result = mysqli_fetch_assoc(mysqli_query($conn, $sql))){
        if (password_verify($password, $result["password"])){
            $_SESSION["login"] = $result["user_id"];
            mysqli_close($conn);
            $extra = "index/index.html.php";
            header( "Location: https://$host$uri/$extra");
        }else{
            $message_password = "パスワードが間違っています";
            $_SESSION["message_password"] = $message_password;
            $extra = "login/userLogin.html.php";
            header( "Location: https://$host$uri/$extra");
        }
    }else{
        $message_email = "登録したメールアドレスを入力してください";
        $_SESSION["message_email"] = $message_email;
        $extra = "login/userLogin.html.php";
        header( "Location: https://$host$uri/$extra");
    }
?>