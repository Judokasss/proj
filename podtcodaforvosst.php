<?php
session_start();
require "db.php";
?>
<?php
if (isset($_POST['codepodt'])) {
    if (isset($_POST['code']) && trim($_POST['code']) == $_SESSION['code']) {
        $_SESSION['qwerty2003'] = ($_POST['code'] == $_SESSION['code']);
        setcookie('baby2003', true, time() + 30);
        unset($_SESSION['code']);
        header('location: smena.php');
    } else {
        $err = "Неверный код ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
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
    <a href="index.php">Вернуться на главную</a>
    <div class="box-root padding-top--24 flex-flex flex-direction--column" style="flex-grow: 1; z-index: 9;">
        <div class="box-root padding-top--48 padding-bottom--24 flex-flex flex-justifyContent--center">

        </div>
        <div class="formbg-outer">
            <div class="formbg">
                <div class="formbg-inner padding-horizontal--48">
                    <span class="padding-bottom--15">
                        <center>
                            <h1>Введите код</h1>
                        </center><br>Введите код , который пришел к вам на email.
                    </span>
                    <form method="POST" id="stripe-login">
                        <div class="field padding-bottom--24">
                            <label for="email">Code</label>
                            <input type="text" name="code">
                        </div>
                        <div class="field padding-bottom--24">
                            <input type="submit" name="codepodt" value="Далее">
                            <center><?php echo '<p style="color: red ;">' . $err ?><br /></center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</body>

</html>