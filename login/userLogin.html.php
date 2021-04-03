<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image" href="../img/logo.jpg">
    <title>LabWork</title>
</head>
<body>
    <?php session_start() ?>
    <header>
        <a class="logo" href="../index/index.html.php"><img src="../img/logo.jpg" alt="ロゴ"></a>
    </header>
    <div class="login_validate">
        <div class="emty">
            <?php 
                if (isset($_SESSION["message_empty"])){
                    echo "<h2>".$_SESSION["message_empty"]."</h2>";
                }
                unset($_SESSION["message_empty"]);
            ?>
        </div>
        <div class="email">
            <?php 
                if (isset($_SESSION["message_email"])){
                    echo "<h2>".$_SESSION["message_email"]."</h2>";
                }
                unset($_SESSION["message_email"]);
            ?>
        </div>
        <div class="password">
            <?php 
                if (isset($_SESSION["message_password"])){
                    echo "<h2>".$_SESSION["message_password"]."</h2>";
                }
                unset($_SESSION["message_password"]);
            ?>
        </div>
    </div>
    <div class="login">
        <form action="userCheck.php" method="post">
            <h2>Enjoy your research!!</h2>
            <input type="text" name="email" placeholder="Email：@stu.hosei.ac.jp">
            <input type="text" name="user_password" placeholder="PassWord">
            <input type="submit" value="LOG IN">
        </form>
    </div>
    <?php include "../footer.html.php" ?>
</body>
</html>