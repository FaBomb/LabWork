<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image" href="../img/logo.jpg">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <title>LabWork</title>
</head>
<body>
    <?php
        session_start();
        if (empty($_SESSION["学年"])){
            $grade = "";
        }else{
            $grade = $_SESSION["学年"];
        }
        if (empty($_SESSION["名前"])){
            $name = "";
        }else{
            $name = $_SESSION["名前"];
        }
        if (empty($_SESSION["メールアドレス"])){
            $email = "";
        }else{
            $email = $_SESSION["メールアドレス"];
        }
        if (empty($_SESSION["班"])){
            $team = "";
        }else{
            $team = $_SESSION["班"];
        }
        if (empty($_SESSION["係"])){
            $unit = "";
        }else{
            $unit = $_SESSION["係"];
        }
        if (empty($_SESSION["パスワード"])){
            $password = "";
        }else{
            $password = $_SESSION["パスワード"];
        }
        $grade_list = ["B3", "B4", "M1", "M2"];
        $team_list = ["都市班", "健康班", "伝統建築班", "未来班"];
        $unit_list = ["運営係", "経理書籍係", "PC係", "レク・英語係", "計測機器係", "遺産係", "ブランディング係"];
    ?>
    <div class="wrapper">
        <header>
            <a class="logo" href="../index/index.html.php"><img src="../img/logo.jpg" alt="ロゴ"></a>
        </header>
        <div class="admin">
            <form action="userCreate.php" method="post" class="enter">
                <h3>学年:
                    <select name="grade">
                        <?php 
                            foreach ($grade_list as $val){
                                if ($grade == $val){
                                    echo "<option selected>".$val."</option>";
                                }else{
                                    echo "<option>".$val."</option>";
                                }
                            }
                        ?>
                    </select>
                </h3>
                <h3>名前: <input type="text" name="user_name" placeholder = 
                            "<?php if (!empty($_SESSION) && preg_match("/してください$/", $name))
                                {echo $name;} ?>" value = 
                                    "<?php if (!empty($_SESSION) && !preg_match("/してください$/", $name))
                                        {echo $name;} ?>"></h3>
                <h3>メールアドレス: <input type="text" name="email" placeholder = 
                            "<?php if (!empty($_SESSION) && preg_match("/してください$/", $email))
                                {echo $email;} ?>" value = 
                                    "<?php if (!empty($_SESSION) && !preg_match("/してください$/", $email))
                                        {echo $email;} ?>"></h3>
                <h3>班: 
                    <select name="team">
                        <?php 
                            foreach ($team_list as $val){
                                if ($team == $val){
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
                                if ($unit == $val){
                                    echo "<option selected>".$val."</option>";
                                }else{
                                    echo "<option>".$val."</option>";
                                }
                            }
                        ?>
                    </select>
                </h3>
                <h3>パスワード: <input type="text" name="password" placeholder = 
                            "<?php if (!empty($password))
                                {echo $password;} ?>"></h3>
                <input type="submit" value="送信">
            </form>
            <div class="lab_members">
                <table>
                    <tr class="bold">
                        <th>学年</th>
                        <th>名前</th>
                        <th>班</th>
                        <th>係</th>
                    </tr>
                    <?php
                        include "../dbConnect.php";
                        $sql = "SELECT * FROM users ORDER BY grade";
                        if ($result = mysqli_query($conn, $sql)){
                            while ($row = mysqli_fetch_assoc($result)){
                                $id = $row["user_id"];
                                echo
                                    "<tr>".
                                        "<td>".$row["grade"]."</td>".
                                        "<td>".$row["user_name"]."</td>".
                                        "<td>".$row["team"]."</td>".
                                        "<td>".$row["unit"]."</td>".
                                        "<td class='btns'>".
                                            "<form action='userEdit.html.php' method = 'post'>
                                                <button type='submit'>
                                                    <i class='fas fa-pencil-alt'></i>
                                                </button>".
                                                "<input type='hidden' name = 'id' value = '$id' >".
                                            "</form>".
                                        "</td>".
                                        "<td class='btns'>".
                                            "<form action='userDelete.php' method = 'post'>
                                                <button type='submit'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>".
                                                "<input type='hidden' name = 'id' value = '$id' >".
                                            "</form>".
                                        "</td>".
                                    "</tr>";
                            }
                        }
                        mysqli_close($conn);
                    ?>
                </table>
            </div>
        </div>
        <?php include "../footer.html.php" ?>
    </div>
</body>
</html>