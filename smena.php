<?php
session_start();
if (!isset($_SESSION['qwerty2003'])) {
    // Если сессия не установлена, перенаправляем пользователя на страницу авторизации
    header('Location: index.php');
    exit;
}
// Для примера сделал чтобы у пользователя было 30 секунд на то , чтобы поменять пароль потом страница ему не доступна.P.S Кука создается на podtcodaforvosst.
if (!isset($_COOKIE['baby2003'])) {

    header('Location: index.php');
    exit;
}
require "db.php";
?>
<?php
$errors = array();

if (isset($_POST['smena'])) {
    $pass = $_POST['pass'];
    $pass1 = $_POST['pass1'];

    // Проверка наличия пароля
    if (empty($pass)) {
        $errors[] = "Введите пароль";
    }
    // Проверка минимальной и максимальной длины пароля
    if (strlen($pass) < 7 || strlen($pass) > 15) {
        $errors[] = "Пароль должен содержать от 7 до 15 символов";
    }
    // Проверка наличия только латинских букв, цифр и спецсимволов в пароле (без пробелов)
    if (!preg_match('/^(?=.*\d.*\d.*\d|.*[^\w\d\s].*[^\w\d\s].*[^\w\d\s])(?=.*[a-zA-Z])(?!.*\s).{7,15}$/', $pass)) {
        $errors[] = "Пароль должен содержать минимум 3 цифры или спецсимвола";
    }
    // Проверка на совпадение паролей
    if ($pass != $pass1) {
        $errors[] = "Пароли не совпадают";
    }
    // Проверка на совпадение с предыдущим паролем
    else {
        $sql = "SELECT pass FROM users WHERE email = ?";
        $query = $dbh->prepare($sql);
        $query->execute([$_SESSION['mail']]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result && md5($pass . "dskfasd2") == $result['pass']) {
            $errors[] = "Нельзя использовать один и тот же пароль несколько раз";
        }
    }

    if (count($errors) > 0) {

        unset($_SESSION['code']);
    } else {
        // Обновление пароля в базе данных
        $pass = md5($pass . "dskfasd2");
        $sql = "UPDATE users SET pass = ? WHERE email = ?";
        $query = $dbh->prepare($sql);
        $query->execute([$pass, $_SESSION['mail']]);

        // Очистка сессии и перенаправление на страницу авторизации
        unset($_SESSION['code']);
        unset($_SESSION['qwerty2003']);
        header('location: index.php');
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
                            <h1>Смена пароля</h1>
                        </center><br>
                    </span>
                    <form method="post">
                        <div class="field">
                            <label for="pass">Новый пароль:</label>
                            <input type="password" name="pass" id="pass">
                        </div>
                        <div class="field">
                            <label for="pass1">Повторите пароль:</label>
                            <input type="password" name="pass1" id="pass1"><br><br>
                        </div>
                        <div class="field">
                            <input type="submit" name="smena" value="Сменить пароль">
                        </div>
                    </form>
                    <?php if (!empty($errors)) { ?>
                        <div class="field padding-bottom--24">
                            <ul style="list-style: none; color:red;">
                                <?php foreach ($errors as $error) { ?>
                                    <li style="color: red;"><?php echo $error; ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
</body>

</html>