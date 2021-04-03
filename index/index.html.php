<?php 
    // ログインチェック
    include "../loginCheck.php";

    // カレンダー
    date_default_timezone_set("Asia/Tokyo");

    if (empty($_POST["year"]) && empty($_SESSION["year"])){
        $year = date("Y");
    }
    elseif(empty($_SESSION["year"])){
        $year = $_POST["year"];
    }
    else{
        $year = $_SESSION["year"];
    }

    if (empty($_POST["month"]) && empty($_SESSION["month"])){
        $month = date("n");
    }elseif(empty($_POST["month"]) && !empty($_SESSION["month"])){
        $month = $_SESSION["month"];
    }elseif($_POST["month"]==13){
        $month = 12;
        $year--;
        $_SESSION["year"] = $year;
    }elseif($_POST["month"]==0){
        $month = 1;
        $year++;
        $_SESSION["year"] = $year;
    }else{
        $month = $_POST["month"];
        $_POST["year"] = $year;
    }
    
    $today_year = date("Y");
    $today_month = date("n");
    $today_day = date("d");
    $today_last_day = date("j", mktime(0, 0, 0, $today_month+1, 0, $today_year));
    
    $last_day = date("j", mktime(0, 0, 0, $month+1, 0, $year));
    $calender = array();
    $k = 0;

    for ($i = 1; $i < $last_day+1; $i++){
        $week = date("w", mktime(0,0,0, $month, $i, $year));
        if ($i == 1){
            for ($j = 1; $j <= $week; $j++){
                $calender[$k]["day"] = "";
                $k++;
            }
        }
        $calender[$k]["day"] = $i;
        $k++;
        if ($i == $last_day){
            for ($j = 1; $j <= 6-$week; $j++){
                $calender[$k]["day"] = "";
                $k++;
            }
        }
    }

    // SQL
    include "../dbConnect.php";
    // 参加者リストの作成
    $sql = 'SELECT user_id, user_name, team, unit, grade FROM users';
    if ($result = mysqli_query($conn, $sql)){
        while ($row = mysqli_fetch_assoc($result)){
            $user_list[$row['user_id']] = $row["user_name"];
            $team_list[] = [$row['team'] => $row["user_id"]];
            $unit_list[] = [$row['unit'] => $row["user_id"]];
            $grade_list[] = [$row['grade'] => $row["user_id"]];
            $all_list[] = $row['user_id'];
        }
    }
    foreach ($grade_list as $key => $val){
        foreach ($val as $team_name => $member){
            if ($team_name == "B3"){
                $b3_list[] = $member;
            }elseif ($team_name == "B4"){
                $b4_list[] = $member;
            }elseif ($team_name == "M1"){
                $m1_list[] = $member;
            }elseif ($team_name == "M2"){
                $m2_list[] = $member;
            }
        }
    }
    foreach ($team_list as $key => $val){
        foreach ($val as $team_name => $member){
            if ($team_name == "未来班"){
                $future_list[] = $member;
            }elseif ($team_name == "都市班"){
                $city_list[] = $member;
            }elseif ($team_name == "健康班"){
                $health_list[] = $member;
            }elseif ($team_name == "伝統建築班"){
                $history_list[] = $member;
            }
        }
    }
    foreach ($unit_list as $key => $val){
        foreach ($val as $team_name => $member){
            if ($team_name == "PC係"){
                $pc_list[] = $member;
            }elseif ($team_name == "運営係"){
                $admin_list[] = $member;
            }elseif ($team_name == "経理書籍係"){
                $book_list[] = $member;
            }elseif ($team_name == "レク・英語係"){
                $english_list[] = $member;
            }elseif ($team_name == "計測機器係"){
                $machine_list[] = $member;
            }elseif ($team_name == "遺産係"){
                $heritage_list[] = $member;
            }elseif ($team_name == "ブランディング係"){
                $branding_list[] = $member;
            }
        }
    }

    function catch_schedule($Y, $M, $d){
        global $conn;
        $sql = "SELECT schedule_id, title, content, url, user_name, year, month, day
                FROM schedules
                JOIN users 
                ON schedules.user_id = users.user_id
                WHERE year = $Y AND month = $M AND day = $d";
        
        if ($rault = mysqli_query($conn, $sql)){
            while ($row = mysqli_fetch_assoc($rault)){
                echo '
                    <h5>
                        <form action="scheduleDetail.html.php" method="post">
                            <input type="submit" class="title" value="'.$row["title"].'">
                            <input type="hidden" name="schedule_id" value="'.$row["schedule_id"].'">
                        </form>
                    </h5>
                    <div class="btns">
                        <form action="scheduleEdit.html.php" method="post">
                            <button type="submit">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <input type="hidden" name="schedule_id" value="'.$row["schedule_id"].'">
                        </form>
                        <form action="scheduleDelete.php" method="post">
                            <button type="submit">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <input type="hidden" name="schedule_id" value="'.$row["schedule_id"].'">
                        </form>
                    </div>
                    ';
            }
        }else{
            echo "データベース接続失敗";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image" href="../img/logo.jpg">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <title>LabWork</title>
</head>
<body>
    <?php include "../header.html.php" ?>
    <div class="main">
        <div class="side">
            <div class="nextSchedule">
                <h3>NEXT SCHEDULE</h3>
                <?php
                    // 直近のスケジュールリストの作成
                    if ($today_day == $today_last_day){
                        $tomorrow = 1;
                        if ($today_month == 12){
                            $tomorrow_month = 1;
                            $tomorrow_year = $today_year+1;
                        }else{
                            $tomorrow_month = $today_month+1;
                            $tomorrow_year = $today_year;
                        }
                    }else{
                        $tomorrow = $today_day + 1;
                        $tomorrow_month = $today_month;
                        $tomorrow_year = $today_year;
                    }
                    $sql = "SELECT schedule_id, month, day, title, url, start_hour, start_minute, end_hour, end_minute
                            FROM schedules WHERE (year = $today_year AND month = $today_month AND day = $today_day) 
                            OR (year = $tomorrow_year AND month = $tomorrow_month  AND day = $tomorrow)
                            ORDER BY month,day, start_hour, start_minute";
                    $result = mysqli_query($conn, $sql);
                    echo "<table>";
                    while ($row = mysqli_fetch_assoc($result)){
                        echo 
                        "<tr><td class='left'>".
                            $row["month"]."/".$row["day"]."<br>".$row["start_hour"].":".
                            str_pad($row["start_minute"], 2, 0, STR_PAD_LEFT)."～".
                            $row["end_hour"].":".str_pad($row["end_minute"], 2, 0, STR_PAD_LEFT)."</td>".
                           '<td class="right">
                                <form action="scheduleDetail.html.php" method="post">
                                    <button type="submit">'.$row["title"].'</button>
                                    <a href="'.$row["url"].'" target="_blank">'.$row["url"].'</a>
                                    <input type="hidden" name="schedule_id" value="'.$row["schedule_id"].'">
                                </form>
                            </td>'.
                        "</tr>";
                    }
                    echo "</table>";
    
                ?>
            </div>
            <div class="toDo">
                <h3>TO DO</h3>
                <?php
                    // TODOリストの作成
                    $tomorrow = $today_day + 1;
                    $sql = "SELECT schedule_id, month, day, title, url, start_hour, start_minute, end_hour, end_minute
                            FROM schedules WHERE year = $today_year
                            AND month = $today_month AND day = $today_day OR day = $tomorrow
                            ORDER BY start_hour";
                    $result = mysqli_query($conn, $sql);
                    echo "<table>";
                    echo "</table>";
    
                ?>
            </div>
            <div class="UNIT">
                <?php
                $sql = 'SELECT unit FROM users WHERE user_id = '.$_SESSION["login"];
                $result = mysqli_query($conn, $sql);
                echo "<h3>".str_replace("係", "", mysqli_fetch_assoc($result)["unit"])." UNIT</h3>";
                    // 係活動リストの作成
                    $tomorrow = $today_day + 1;
                    $sql = "SELECT schedule_id, month, day, title, url, start_hour, start_minute, end_hour, end_minute
                            FROM schedules WHERE year = $today_year
                            AND month = $today_month AND day = $today_day OR day = $tomorrow
                            ORDER BY start_hour";
                    $result = mysqli_query($conn, $sql);
                    echo "<table>";
                   
                    echo "</table>";
    
                ?>
            </div>
        </div>
        <div class="calender">
            <div class="date">
                <form action="index.html.php" method="post">
                    <input type="submit" value="<">
                    <input type="hidden" name="month" value="
                    <?php
                            if ($month > 1){
                                echo $month-1;
                            }else{
                                echo 13;
                            }
                            ?>">
                </form>
                <div class="num">
                    <h2><?php echo $month ?></h2>
                    <p><?php echo $year ?></p>
                </div>
                <form action="index.html.php" method="post">
                    <input type="submit"  value=">">
                    <input type="hidden" name="month" value="
                        <?php 
                            if ($month < 12){
                                echo $month+1;
                            }else{
                                echo 0;
                            }
                        ?>">
                </form>
            </div>
            <table>
                <tr>
                    <th class="sun">Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
                <?php
                    $cnt = 0;
                    foreach ($calender as $key => $val){
                        $day = $val["day"];
                        if ($cnt == 0){
                            if ($today_year == $year && $today_month == $month && $today_day == $day){
                                echo "<tr>"."<td id='today'><p>".$day."</p><div class='long_text'>";
                            }else{
                                echo "<tr>"."<td><p>".$day."</p><div class='long_text'>";
                            }
                            if (!empty($day)){
                                catch_schedule($year, $month, $day);
                                echo "<br><button class='add_btn' id='btn_$day'>+</button>";
                ?>
                                <?php include "modal.html.php"; ?>
                <?php
                            }
                            echo "</td>";
                            $cnt++;
                        }elseif (0 < $cnt && $cnt < 6){
                            if ($today_year == $year && $today_month == $month && $today_day == $day){
                                echo "<td id='today'><p>".$day."</p><div class='long_text'>";
                            }else{
                                echo "<td><p>".$day."</p><div class='long_text'>";
                            }
                            if (!empty($day)){
                                catch_schedule($year, $month, $day);
                                echo "<br><button class='add_btn' id='btn_$day'>+</button>";
                ?>
                                <?php include "modal.html.php"; ?>
                <?php
                            }
                            echo "</div></td>";
                            $cnt++;
                        }elseif ($cnt == 6){
                            if ($today_year == $year && $today_month == $month && $today_day == $day){
                                echo "<td id='today'><p>".$day."</p><div class='long_text'>";
                            }else{
                                echo "<td><p>".$day."</p><div class='long_text'>";
                            }
                            if (!empty($day)){
                                catch_schedule($year, $month, $day);
                                echo "<br><button class='add_btn' id='btn_$day'>+</button>";
                ?>
                                <?php include "modal.html.php"; ?>
                <?php
                            }
                            echo "</div></td>"."</tr>";
                            $cnt = 0;
                        }
                    }
                ?>
                <div id="mask" class="hidden"></div>
            </table>
        </div>
    </div>
    <?php mysqli_close($conn); ?>
</body>
<script>
    for (let i = 1; i <= <?php echo $last_day ?>; i++){
        eval("const btn_" + i + " = document.getElementById('btn_" + i + "');")
        eval("const close_" + i + " = document.getElementById('close_" + i + "');")
        eval("const modal_" + i + " = document.getElementById('modal_" + i + "');")

        eval("btn_" + i + ".addEventListener('click', function(){ modal_"+i+".classList.remove('hidden');mask.classList.remove('hidden');});") 
        eval("close_" + i + ".addEventListener('click', function(){ modal_"+i+".classList.add('hidden');mask.classList.add('hidden');});") 
        const mask = document.getElementById("mask");
        
        mask.addEventListener("click", function(){
            eval("modal_" + i + ".classList.add('hidden');")
            mask.classList.add("hidden");
        });
    }
</script>
</html>