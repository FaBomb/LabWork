<?php 
    // ログインチェック
    include "../loginCheck.php";
    unset($_SESSION["year"]);

    // データベース接続
    include "../dbConnect.php";
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
                <a href="../seminar/createIndex.html.php">MINUTE</a>
                <a href="../unit/unit.html.php">UNIT</a>
                <a href="../logout.php">LOGOUT</a>
            </nav>
        </header>
        <div class="create">
            <a href="createIndex.html.php">作成</a>
        </div>
        <div class="edit">
            <?php
                $sql = 'SELECT * FROM minutes';
                if ($result = mysqli_query($conn, $sql)){
                    while ($row = mysqli_fetch_assoc($result)){
                        echo '
                        <form action="edit.php" method="POST">
                            <input type="submit" class="title" value="第'.$row["number"].'回'.$row["title"].'ゼミ">
                            <input type="hidden" name="num" value="'.$row["number"].'">
                            <input type="hidden" name="title" value="'.$row["title"].'">
                            <input type="hidden" name="date" value="'.$row["date"].'">
                        </form>
                        ';
                    }
                }
                mysqli_close($conn);
            ?>
        </div>
        <?php include "../footer.html.php" ?>
    </div>
</body>
