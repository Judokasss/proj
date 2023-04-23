<?php
require "db.php";
require "func.php";
session_start();
$login = $_POST['login'];
$name = $_POST['name'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$pass1 = $_POST['pass1'];
// date_default_timezone_set('Asia/Yekaterinburg');
$date1 = date("Y-m-d H:i:s");

if (isset($_POST['send'])) {
    $sql = ("SELECT * FROM `users` WHERE `login` = ? OR `email` = ?");
    $query = $dbh->prepare($sql);
    $query->execute([$login, $email]);
    $res = $query->fetch(PDO::FETCH_ASSOC);
    if (trim($_POST['login']) == "" || trim($_POST['name']) == "" || trim($_POST['pass'] == "" || trim($_POST['captcha']) == "" || trim($_POST['email']) == "")) {
        $err = "Заполните все поля!!!";
    } elseif (strtolower($_POST['captcha']) !== $_SESSION['captcha']) {
        $err = "Ошибка в капче";
    } else if (mb_strlen($login) < 4 || mb_strlen($login) > 90 || strtolower($login) == 'admin123' || !preg_match('/^[^<>]*$/u', $login)) {
        $err = "Недопустимая длина логина";
    } else if (mb_strlen($name) < 3 || mb_strlen($name) > 40 || strtolower($name) == 'admin' || !preg_match('/^[^<>]*$/u', $name)) {
        $err = "Недопустимая длина имени";
    } else if (is_numeric($name)) {
        $err = "Имя не должно содежать цифр!";
    } else if (mb_strlen($pass) < 3 || mb_strlen($pass) > 11 || !preg_match('/^[^<>]*$/u', $pass)) {
        $err = "Недопустимая длина пароля";
    } else if ($res['login'] == $login) {
        $err = "Такой логин уже существует!!!";
    } else if ($res['email'] == $email) {
        $err = "Пользователь с данной почтой уже существует";
    } else if (!preg_match("#[0-9]+#", $pass)) {
        $err = "Пароль должен содержать цифр(ы)-у";
    } else if (!preg_match("#[а-яА-Яa-zA-Z]+#", $pass)) {
        $err = "Пароль должен содежать минимум букву";
    } else if ($pass != $pass1) {
        $err = "Пароли не совпадают";
    } else {
        $path = 'Uplo/' . time() . $_FILES['avatar']['name'];
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $path)) { //Если файл не загр , то по дефолту у юзера картинка по умолчанию.
            $path = 'Uplo/pol.png';
            //header('location: rega.php');
        }
        sendEmail($email, $name, $confirmationCode);
        $pass = md5($pass . "dskfasd2");
        $sql = ("INSERT INTO `users` (login, name, pass, avatar, email, date1 ) VALUES(?, ?, ?, ?, ?, ?)");
        $query = $dbh->prepare($sql);
        $query->execute([$login, $name, $pass, $path, $email, $date1]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="5laba.css">
    <link rel="stylesheet" href="vost.css">
    <title>Document</title>
</head>
<!-- <a href="index.php">Вернуться на главную</a> -->
<div class="box-root padding-top--24 flex-flex flex-direction--column" style="flex-grow: 1; z-index: 9;">
    <div class="box-root padding-top--48 padding-bottom--24 flex-flex flex-justifyContent--center">

    </div>
    <div class="formbg-outer">
        <div class="formbg">
            <div class="formbg-inner padding-horizontal--48">
                <span class="padding-bottom--15">
                    <center>
                        <h1>Регистрация</h1>
                    </center>
                </span>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="field padding-bottom--24">
                        <center>
                            <p>Место для вашего аватара</p>
                        </center>
                        <input type="file" name="avatar">
                        <input type="text" name="login" placeholder="Введите логин">
                        <input type="text" name="name" placeholder="Введите имя">
                        <input type="email" name="email" placeholder="Введите почту">
                        <input type="password" name="pass" placeholder="Введите пароль">
                        <input type="password" name="pass1" placeholder="Повторите пароль">
                        <input type="text" name="captcha" placeholder="Введите символы с картинки">
                        <center>
                            <div class="cap"><img src="captcha.php"></div>
                        </center>
                        <?php echo '<p style="color: red; text-align:center;">' . $errcap ?>
                    </div>
                    <div class="field padding-bottom--24">
                        <input type="submit" name="send" value="Далее">
                        <center><?php echo '<p style="color: red ;">' . $err ?><br /></center>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['send'])) {
        if (!$err) {
            setcookie("login", $_POST['login'], time() + 20 * 24 * 60 * 60);
            setcookie("name", $_POST['name'], time() + 60 * 60 * 24);
            setcookie("email", $_POST['email'], time() + 60 * 60 * 24);
        }
    }
    ?>
    </body>

</html>