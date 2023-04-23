<?php
session_start();
require "db.php";
?>
<?php
$log = $_COOKIE['login'];
$active = "active";
if (isset($_POST['podt'])) {
    if (isset($_POST['code']) && trim($_POST['code']) == $_SESSION['code']) {
        $pass = md5($pass . "dskfasd2");
        $sql = ("UPDATE users SET `confirmed` = ? where `login` = ?");
        $query = $dbh->prepare($sql);
        $query->execute([$active, $log]);

        if ($query) {
            setcookie('login', $_POST['login'], time() - 20 * 24 * 60 * 60);
            setcookie('name', $_POST['name'], time() - 60 * 60 * 24);
            setcookie('email', $_POST['email'], time() - 60 * 60 * 24);
            header('location: index.php');
        }
    } else {
        $err = "Неверный код ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="5laba.css">
    <link rel="stylesheet" type="text/css" href="vost.css">
    <meta name="viewport" content="user-scalable=no">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My first site</title>
    <link rel="apple-touch-icon" sizes="57x57" href="apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>

<body>
    <div class="box-root padding-top--24 flex-flex flex-direction--column" style="flex-grow: 1; z-index: 9;">
        <div class="box-root padding-top--48 padding-bottom--24 flex-flex flex-justifyContent--center">

        </div>
        <div class="formbg-outer">
            <div class="formbg">
                <div class="formbg-inner padding-horizontal--48">
                    <span class="padding-bottom--15">
                        <center>
                            <h1>Восстановление пароля</h1><br>
                        </center>
                    </span>
                    <form method="POST">
                        <div class="field padding-bottom--24">
                            <label for="email">Введите код подтверждения</label>
                            <input type="text" placeholder="Введите код подтверждения" name="code" id='code' required>
                            <center>
                                <p style="color: black;font-size: 24px;"> <?php echo $_COOKIE['name'] ?></p>
                            </center>
                            <p style="color: black;">У вас есть 24ч для подтверждения аккаунта почты </p>
                            <strong>
                                <p style="color: black; "><?php echo $_COOKIE['email'] ?></p><br><br>
                            </strong>
                            <input class="glow-button" type="submit" name="podt" value="Подтвердить" /><br><br>
                            <center> <a style="color: blue;" href="index.php">Вернуться на главную</a><br /></center>
                            <center> <?php echo '<p style="color: red">' . $err ?></center>
                        </div>

                    </form>
                </div>
            </div>
        </div>

</body>

</html>