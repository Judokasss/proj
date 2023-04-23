<?php
session_start();
require "db.php";
require "func.php";
$login = $_POST['login'];
$pass = $_POST['pass'];
if (isset($_POST['send'])) {
    if (trim($_POST['login']) == "" ||  trim($_POST['pass'] == "")) {
        $err = "Заполните все поля!!!";
    }

    $pass = md5($pass . "dskfasd2");
    $sql = ("SELECT * FROM `users` WHERE `login` = ? AND `pass` = ? ");
    $query = $dbh->prepare($sql);
    $query->execute([$login, $pass]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $err = "Неверный логин или пароль";
        $_SESSION['count']++;
    }
    if ($user['confirmed'] == 'inactive') {
        $err = "Ваша почта не подтверждена";
        $_SESSION['count']++;
        setcookie("login", $_POST['login'], time() + 20 * 24 * 60 * 60);
        $name = $_COOKIE['name'];
        $email = $_COOKIE['email'];
        sendEmail($email, $name, $confirmationCode);
    }
    if (isset($_SESSION['count']) && ($_SESSION['count']) >= 3) {
        if (isset($_POST['captcha']) && strtolower($_POST['captcha']) !== $_SESSION['captcha']) {
            $errcap = "Ошибка в капче";
        }
    }
    if (!$err && !$errcap) {
        $_SESSION['login'] = [
            "login" => $user['login'],
            "name" => $user['name'],
            "avatar" => $user['avatar']
        ];
        header('location: index.php');
        unset($_SESSION['count']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="vost.css">
    <title>Document</title>
</head>

<body>

    <a href="index.php">Вернуться на главную</a>
    <div class="box-root padding-top--24 flex-flex flex-direction--column" style="flex-grow: 1; z-index: 9;">
        <div class="box-root padding-top--48 padding-bottom--24 flex-flex flex-justifyContent--center">

        </div>
        <div class="formbg-outer">
            <div class="formbg">
                <div class="formbg-inner padding-horizontal--48">
                    <span class="padding-bottom--15">
                        <center>
                            <h1>Авторизация</h1>
                        </center>
                    </span>
                    <form method="POST" id="stripe-login">
                        <div class="field padding-bottom--24">
                            <label for="email">Логин</label>
                            <input type="text" name="login" placeholder="Введите логин">
                            <label for="email">Пароль</label>
                            <input type="password" name="pass" placeholder="Введите пароль">

                            <?php if (isset($_SESSION['count']) && ($_SESSION['count'] >= 3)) { ?>
                                <label for="Capcha">Введите капчу</label>
                                <input type="text" name="captcha" placeholder="Введите символы с картинки" required>
                                <center>
                                    <div class="cap"><img src="captcha.php"></div>
                                </center>
                            <?php } ?>

                            <?php echo '<p style="color: red; text-align:center;">' . $errcap ?>
                        </div>
                        <div class="field padding-bottom--24">
                            <input type="submit" name="send" value="Далее">
                            <center><?php echo '<p style="color: red ;">' . $err ?><br /></center>
                            <a style="color: blue;" href="vost.php">Забыли пароль?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</body>

</html>