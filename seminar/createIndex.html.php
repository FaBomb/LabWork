<?php 
    // ログインチェック
    include "../loginCheck.php";

    // 日付
    date_default_timezone_set("Asia/Tokyo");
    $date = date("Y-m-d");

    // データベース接続
    include "../dbConnect.php";
    $sql = 'SELECT user_id, user_name, team, unit, grade FROM users';
    if ($result = mysqli_query($conn, $sql)){
        while ($row = mysqli_fetch_assoc($result)){
            $user_list[$row['user_id']] = $row["user_name"];
        }
    }
    mysqli_close($conn);
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
    <div class="wrapper">
        <header>
            <a class="logo" href="../index/index.html.php"><img src="../img/logo.jpg" alt="ロゴ"></a>
            <nav>
                <a href="../unit/unit.html.php">UNIT</a>
                <a href="../logout.php">LOGOUT</a>
            </nav>
        </header>
        <div class="create">
            <form action="title.php" method="POST">
                <!-- タイトル -->
                <h1>
                    第
                    <select type="number" name="num" size="1" class="hour">
                        <?php
                            for($i=1; $i<=24; $i++){
                                echo "<option value=$i>$i</option>";
                            }
                        ?>
                    </select>
                    回
                    <select name="title">
                        <option value="自主">自主</option>
                        <option value="本">本</option>
                    </select>
                    ゼミ議事録
                </h1>
                <!-- 日付 -->
                <div class="date">
                    <input type="date" name="date" value=<?php echo $date?>>
                </div>
                <!-- 時刻 -->
                <div class="time">
                    <h3 class="time">START：
                        <select type="number" name="start_hour" size="1" class="hour">
                            <?php
                                for($i=1; $i<=24; $i++){
                                    echo "<option value=$i>$i</option>";
                                }
                            ?>
                        </select>
                        <div class="split">：</div>
                        <select type="number" name="start_minute" size="1" class="minute">
                            <?php
                                for($i=0; $i<60; $i+=10){
                                    echo "<option value=$i>".str_pad($i, 2, 0, STR_PAD_LEFT)."</option>";
                                }
                            ?>
                        </select>
                    </h3>
                    <h3 class="time">FINISH：
                        <select type="number" name="end_hour" size="1" class="hour">
                            <?php
                                for($i=1; $i<=24; $i++){
                                    echo "<option value=$i>$i</option>";
                                }
                            ?>
                        </select>
                        <div class="split">：</div>
                        <select type="number" name="end_minute" class="minute">
                            <?php
                                for($i=0; $i<60; $i+=10){
                                    echo "<option value=$i>".str_pad($i, 2, 0, STR_PAD_LEFT)."</option>";
                                }
                            ?>
                        </select>
                    </h3>
                </div>
                <!-- 出席者 -->
                <div class="attendees">
                    <h2>出席者</h2>
                    <div id="attend" ondragover="dragover(event)" ondrop="drop(event)">
                        <?php
                            foreach ($user_list as $key => $val){
                                echo "<input id=$val draggable='true' ondragstart='dragstart(event)'
                                         type='text' name='attend_$val' value=$val>";
                            }
                        ?>
                    </div>
                    <h2>欠席者</h2>
                    <div id="absent" ondragover="dragover(event)" ondrop="drop(event)">
                    </div>
                    <h2>早退者</h2>
                    <div id="early_leave" ondragover="dragover(event)" ondrop="drop(event)">
                    </div>
                </div>
                <input type="submit" value="作成">
            </form>
        </div>

        <?php include "../footer.html.php" ?>
    </div>
</body>
<script>
    function dragstart(event){
        event.dataTransfer.setData("text", event.target.id);
    }
    function dragover(event){
        event.preventDefault();
    }
    function drop(event){
        const id_name = event.dataTransfer.getData("text");
        const drag_elm =document.getElementById(id_name);
        const val =document.getElementById(id_name).value;
        event.currentTarget.appendChild(drag_elm);
        const parent_id =document.getElementById(id_name).parentNode.id;
        drag_elm.name = parent_id+"_"+val;
        event.preventDefault();
    }
</script>
