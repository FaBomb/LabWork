<?php
    include "../dbConnect.php";
    session_start();

    $email = $_POST["email"];
    $user_name = $_POST["user_name"];
    if (!empty($_POST["password"])){
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    }else{
        $password = "";
    }
    $unit = $_POST["unit"];
    $team = $_POST["team"];
    $grade = $_POST["grade"];
    $infList = ["メールアドレス" => $email,"名前" => $user_name,
                "パスワード" => $password,"係" => $unit,"班" => $team,"学年" => $grade];

    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

    function checkEmpty($obj){
        if (empty($obj)){
            return $obj;
        }
    }

    if (empty($email) || empty($user_name) || empty($password) || 
        empty($unit) || empty($team) || empty($grade)){
            mysqli_close($conn);
            foreach($infList as $key => $val){
                if (empty($val)){
                    $_SESSION[$key] = $key."を入力してください";
                }else{
                    $_SESSION[$key] = $val;
                }
            }
            $extra = "labAdmin.html.php";
            header( "Location: https://$host$uri/$extra" );
            exit;
    }else{
        $sql = "INSERT INTO users(email, user_name, password, unit, team, enable, grade) 
                VALUES('$email', '$user_name', '$password', '$unit',
                '$team', 1, '$grade')";
    }
    if ($result = mysqli_query($conn, $sql)){
        session_destroy();
        mysqli_close($conn);
        $extra = "labAdmin.html.php";
        header( "Location: https://$host$uri/$extra" );
    }
?>