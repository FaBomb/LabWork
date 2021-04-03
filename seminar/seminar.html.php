<?php 
    // ログインチェック
    include "../loginCheck.php";
    unset($_SESSION["year"]);
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
                <a href="../seminar/seminarMinute.html.php">MINUTE</a>
                <a href="../unit/unit.html.php">UNIT</a>
                <a href="../logout.php">LOGOUT</a>
            </nav>
        </header>
    
        <?php include "../footer.html.php" ?>
    </div>
</body>
