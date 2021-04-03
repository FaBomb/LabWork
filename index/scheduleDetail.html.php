<?php 
    include "../dbConnect.php";
    $schedule_id = $_POST["schedule_id"];

    function join_members(){
        global $schedule_id;
        global $conn;
        $sql = "SELECT * FROM joinMembers WHERE schedule_id = ".$schedule_id;
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)){
            $members[] = $row["user_id"];
        }
        $flag = True;
        foreach ($members as $val){
            if ($flag == True){
                $sql = "SELECT user_name FROM users WHERE user_id = ".$val;
                $flag = False;
            }else{
                $user = " OR user_id = ".$val;
                $sql = $sql.$user;
            }
        }
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)){
            $join_members_list[] = $row["user_name"];
        }
        return $join_members_list;
    }
    
    $sql = "SELECT * FROM schedules WHERE schedule_id = ".$schedule_id;
    if ($result = mysqli_query($conn, $sql)){
        $row = mysqli_fetch_assoc($result);
        $year = $row["year"];
        $month = $row["month"];
        $day = $row["day"];
        $title = $row["title"];
        $content = $row["content"];
        $url = $row["url"];
        $start_hour = $row["start_hour"];
        $start_minute = $row["start_minute"];
        $end_hour = $row["end_hour"];
        $end_minute = $row["end_minute"];
        $user_id = $row["user_id"];
    }

    $sql = "SELECT user_name FROM users WHERE user_id = ".$user_id;
    if ($result = mysqli_query($conn, $sql)){
        $user_name = mysqli_fetch_assoc($result)["user_name"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image" href="../img/logo.jpg">
    <link rel="stylesheet" href="../style.css">
    <title>LabWork</title>
</head>
<body>
    <div class="wrapper">
        <?php include "../header.html.php" ?>
        <div class="box">
            <h1><?php echo $title ?></h1>
            <table>
                <tr>
                    <td class="left"><h2>日程：</h2></td>
                    <td class="right"><p><?php echo $month."月".$day."日" ?></p></td>
                </tr>
                <tr>
                    <td class="left"><h2>時間：</h2></td>
                    <td class="right"><p>
                        <?php 
                            echo $start_hour.":".str_pad($start_minute, 2, 0, STR_PAD_LEFT).
                                " ~ ".$end_hour.":".str_pad($end_minute, 2, 0, STR_PAD_LEFT)
                        ?>
                    </p></td>
                </tr>
                <tr>
                    <td class="left"><h2>詳細：</h2></td>
                    <td class="right"><p><?php echo $content ?></p></td>
                </tr>
                <tr>
                    <td class="left"><h2>ZOOM URL：</h2></td>
                    <td class="right"><a href="<?php echo $url ?>"  target="_blank"><?php echo $url ?></td>
                </tr>
                <tr>
                    <td class="left"><h2>参加者：</h2></td>
                    <td class="right">
                        <p>
                            <?php
                                $join_members_list = join_members();
                                $flag = True;
                                foreach ($join_members_list as $val){
                                    if ($flag == True){
                                        echo $val;
                                        $flag = False;
                                    }else{
                                        echo ", ".$val;
                                    }
                                }
                            ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="left"><h2>投稿者：</h2></td>
                    <td class="right"><p><?php echo $user_name ?></p></td>
                </tr>
            </table>
        </div>
        <a href="index.html.php" class="back">BACK</a>
        <?php include "../footer.html.php" ?>
    </div>
</body>
</html>