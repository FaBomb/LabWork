<?php 
    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    
    include "../dbConnect.php";

    
    $number = $_POST["num"];
    $title = $_POST["title"];
    $date = $_POST["date"];
    $start_hour = $_POST["start_hour"];
    $start_minute = $_POST["start_minute"];
    $end_hour = $_POST["end_hour"];
    $end_minute = $_POST["end_minute"];

    session_start();
    
    if (isset($_SESSION["number"]) && isset($_SESSION["title"]) && isset($_SESSION["date"])){
        unset($_SESSION["number"]);
        unset($_SESSION["title"]);
        unset($_SESSION["date"]);
    }
    $_SESSION["number"] = $number;
    $_SESSION["title"] = $title;
    $_SESSION["date"] = $date;

    $sql = "SELECT minute_id FROM minutes WHERE number=$number AND title='$title' AND date='$date'";
    if ($result = mysqli_query($conn, $sql)){
        if (isset(mysqli_fetch_assoc($result)["minute_id"])){
            mysqli_close($conn);
            $extra = "createIndex.html.php";
            header( "Location: https://$host$uri/$extra");
            exit;
        }
    };

    $sql = "INSERT INTO minutes(number, title, date, start_hour, start_minute, end_hour, end_minute) 
            VALUES($number , '$title', '$date', $start_hour, $start_minute, $end_hour, $end_minute)";
    echo $sql;
    mysqli_query($conn, $sql);

    $sql = "SELECT minute_id FROM minutes WHERE number=$number AND title='$title' AND date='$date'";
    if ($result = mysqli_query($conn, $sql)){
        $minute_id = mysqli_fetch_assoc($result)["minute_id"];
    }else{
        echo "データベース接続エラー";
    }

    foreach ($_POST as $key => $val){
        if (preg_match('/attend/',$key)){
            $sql = "INSERT INTO atendees(minute_id, atend) 
                    VALUES($minute_id , '$val')";
            mysqli_query($conn, $sql);
        }
        elseif (preg_match('/absent/',$key)){
            $sql = "INSERT INTO atendees(minute_id, absent) 
                    VALUES($minute_id , '$val')";
            mysqli_query($conn, $sql);
        }
        elseif (preg_match('/early_leave/',$key)){
            $sql = "INSERT INTO atendees(minute_id, early_leave) 
                    VALUES($minute_id , '$val')";
            mysqli_query($conn, $sql);
        }
    }

    mysqli_close($conn);
    $extra = "seminarMinute.html.php";
    header( "Location: https://$host$uri/$extra");

?>