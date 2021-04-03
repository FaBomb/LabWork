<?php
    include "../dbConnect.php";
    session_start();

    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    
    $id = $_POST["id"];
    $email = $_POST["email"];
    $user_name = $_POST["user_name"];
    $unit = $_POST["unit"];
    $team = $_POST["team"];
    $grade = $_POST["grade"];
    $infList = ["メールアドレス" => $email,"名前" => $user_name,
                "係" => $unit,"班" => $team,"学年" => $grade];

    function checkEmpty($obj){
        if (empty($obj)){
            return $obj;
        }
    }

    if (empty($email) || empty($user_name) || 
        empty($unit) || empty($team) || empty($grade)){
            mysqli_close($conn);
            foreach($infList as $key => $val){
                if (empty($val)){
                    $_SESSION[$key] = $key."を入力してください";
                }else{
                    $_SESSION[$key] = $val;
                }
            }
            $extra = "userEdit.html.php";
            header( "Location: https://$host$uri/$extra" );
            exit;
    }else{
        $sql = "UPDATE users SET email = '$email', user_name = '$user_name',
                unit = '$unit', team = '$team', grade = '$grade' WHERE user_id = $id";
    }
    if ($result = mysqli_query($conn, $sql)){
        session_destroy();
        mysqli_close($conn);
        $extra = "labAdmin.html.php";
        header( "Location: https://$host$uri/$extra");
    }
?>