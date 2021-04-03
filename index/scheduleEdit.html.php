<?php 
    include "../dbConnect.php";
    $schedule_id = $_POST["schedule_id"];
    $sql = "SELECT * FROM schedules WHERE schedule_id = $schedule_id";
    if ($reault = mysqli_query($conn, $sql)){
        while ($row = mysqli_fetch_assoc($reault)){
            $month = $row["month"];
            $day = $row["day"];
            $title = $row["title"];
            $content = $row["content"];
            $url = $row["url"];
            $year = $row["year"];
            $week = $row["week"];
            $start_hour = $row["start_hour"];
            $start_minute = $row["start_minute"];
            $end_hour = $row["end_hour"];
            $end_minute = $row["end_minute"];
            session_start();
            $user_id = $_SESSION["login"];
        }
    }else{
        echo "データベース接続失敗";
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
        <div class="modal edit_modal">
            <h1><?php echo $month."月".$day; ?>日の予定</h1>
            <form action="scheduleEdit.php" method="POST">
                <h3>予定:<input type="text" name="title" value=<?php echo $title ?>></h3>
                <h3>詳細:<input type="text" name="content" value=<?php echo $content ?>></h3>
                <h3>ZoomURL:<input type="text" name="url" value=<?php echo $url ?>></h3>
                <h3>開始時刻:
                    <select type="number" name="start_hour" size="1" class="select_left">
                        <?php
                            for($i=1; $i<=24; $i++){
                                if ($i == $start_hour){
                                    echo "<option value=$i selected>$i</option>";
                                }else{
                                    echo "<option value=$i>$i</option>";
                                }
                            }
                        ?>
                    </select>:
                    <select type="number" name="start_minute" size="1">
                        <?php
                            for($i=0; $i<60; $i+=10){
                                if ($i == $start_minute){
                                    echo "<option value=$i selected>$i</option>";
                                }else{
                                    echo "<option value=$i>$i</option>";
                                }
                            }
                        ?>
                    </select>
                </h3>
                <h3>終了時刻:
                    <select type="number" name="end_hour" size="1" class="select_left">
                        <?php
                            for($i=1; $i<=24; $i++){
                                if ($i == $end_hour){
                                    echo "<option value=$i selected>$i</option>";
                                }else{
                                    echo "<option value=$i>$i</option>";
                                }
                            }
                        ?>
                    </select>:
                    <select type="number" name="end_minute" size="1">
                        <?php
                            for($i=0; $i<60; $i+=10){
                                if ($i == $end_minute){
                                    echo "<option value=$i selected>$i</option>";
                                }else{
                                    echo "<option value=$i>$i</option>";
                                }
                            }
                        ?>
                    </select>
                </h3>
                <input type="submit" value="EDIT">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION["login"]; ?>">
                <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">
                <input type="hidden" name="year" value="<?php echo $year; ?>">
                <input type="hidden" name="month" value="<?php echo $month; ?>">
            </form>
        </div>
        <a href="index.html.php" class="back">BACK</a>
        <?php include "../footer.html.php" ?>
    </div>
</body>
</html>