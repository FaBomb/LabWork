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
        <header>
            <a class="logo" href="../index/index.html.php"><img src="../img/logo.jpg" alt="ロゴ"></a>
        </header>
        <?php
            session_start();
            if (isset($_POST["id"])){
    
                include "../dbConnect.php";
                $id = $_POST["id"];
                $_SESSION["id"] = $id;
                $sql = "select * from users where user_id = $id";
    
                if ($result = mysqli_query($conn, $sql)){
                    $row = mysqli_fetch_assoc($result);
                    
                    $_SESSION["名前"] = $row["user_name"];
                    $_SESSION["学年"] = $row["grade"];
                    $_SESSION["メールアドレス"] = $row["email"];
                    $_SESSION["班"] = $row["team"];
                    $_SESSION["係"] = $row["unit"];
                    mysqli_close($conn);
                }
            }else{
                $id = $_SESSION["id"];
            }
            $grade_list = ["B3", "B4", "M1", "M2"];
            $team_list = ["都市班", "健康班", "伝統建築班", "未来班"];
            $unit_list = ["運営係", "経理書籍係", "PC係", "レク・英語係", "計測機器係", "遺産係", "ブランディング係"];
        ?>
        <div class="admin">
            <form action="userEdit.php" method="post" class="enter">
                <h3>学年:
                    <select name="grade">
                        <?php 
                            foreach ($grade_list as $val){
                                if ($_SESSION["学年"] == $val){
                                    echo "<option selected>".$val."</option>";
                                }else{
                                    echo "<option>".$val."</option>";
                                }
                            }
                        ?>
                    </select>
                </h3>
                <h3>名前: <input type="text" name="user_name" placeholder = 
                            "<?php if (!empty($_SESSION) && preg_match("/してください$/", $_SESSION["名前"]))
                                {echo $_SESSION["名前"];} ?>" value = 
                                    "<?php if (!empty($_SESSION) && !preg_match("/してください$/", $_SESSION["名前"]))
                                        {echo $_SESSION["名前"];} ?>"></h3>
                <h3>メールアドレス: <input type="text" name="email" placeholder = 
                            "<?php if (!empty($_SESSION) && preg_match("/してください$/", $_SESSION["メールアドレス"]))
                                {echo $_SESSION["メールアドレス"];} ?>" value = 
                                    "<?php if (!empty($_SESSION) && !preg_match("/してください$/", $_SESSION["メールアドレス"]))
                                        {echo $_SESSION["メールアドレス"];} ?>"></h3>
                <h3>班:
                    <select name="team">
                        <?php 
                            foreach ($team_list as $val){
                                if ($_SESSION["班"] == $val){
                                    echo "<option selected>".$val."</option>";
                                }else{
                                    echo "<option>".$val."</option>";
                                }
                            }
                        ?>
                    </select>
                </h3>
                <h3>係:
                    <select name="unit">
                        <?php 
                            foreach ($unit_list as $val){
                                if ($_SESSION["係"] == $val){
                                    echo "<option selected>".$val."</option>";
                                }else{
                                    echo "<option>".$val."</option>";
                                }
                            }
                        ?>
                    </select>
                </h3>
                <input type="submit" value="EDIT">
                <input type="hidden" name = "id" value = "<?php echo $id; ?>">
            </form>
            <a href="labAdmin.html.php" <?php session_destroy(); ?>>BACK</a>
        </div>
        <?php include "../footer.html.php" ?>
    </div>
</body>
</html>