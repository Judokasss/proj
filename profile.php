<?php
session_start();
if (!isset($_SESSION['login'])) {
    // Если сессия не установлена, перенаправляем пользователя на страницу авторизации
    header('Location: index.php');
    exit;
}
require 'db.php';
$login = $_SESSION['login']['login'];
$sql = $dbh->prepare("SELECT * FROM users WHERE login = ?"); // Подготовка SQL-запроса к базе данных к запуску
$sql->execute([$login]); // выполнение подготовленного запроса
$result = $sql->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['upload'])) {
    $avatar = $_FILES['avatar'];
    $avatar_name = $avatar['name'];
    $avatar_tmp_name = $avatar['tmp_name'];
    $avatar_size = $avatar['size'];
    $avatar_error = $avatar['error'];
    $avatar_ext = strtolower(pathinfo($avatar_name, PATHINFO_EXTENSION));

    $allowed_exts = array('jpg', 'jpeg', 'png');
    if (in_array($avatar_ext, $allowed_exts)) {
        if ($avatar_error === 0) {
            if ($avatar_size <= 5242880) { // 5 MB (Максимальный размер файла)
                $avatar_new_name = uniqid('', true) . '.' . $avatar_ext;
                $avatar_dest = 'Uplo/' . $avatar_new_name;
                move_uploaded_file($avatar_tmp_name, $avatar_dest);
                // Сохраняем имя файла в базу данных
                $sql = $dbh->prepare("UPDATE users SET avatar = ? WHERE login = ?");
                $sql->execute([$avatar_dest, $login]);
                // Обновляем данные в сессии
                $_SESSION['login']['avatar'] = $avatar_dest;
                header('Location: profile.php');
                exit;
            } else {
                $err = 'Размер файла превышает 5 МБ';
            }
        } else {
            $err = 'Произошла ошибка при загрузке файла';
        }
    } else {
        $err = 'Неподдерживаемый тип файла. Разрешены только JPG, JPEG, PNG';
    }
}
$prof_name = trim($_POST['prof_name']);
$prof_tel = trim($_POST['prof_tel']);
$prof_city = trim($_POST['prof_city']);
$prof_country = trim($_POST['prof_country']);
$prof_address = trim($_POST['prof_address']);
if (isset($_POST['save'])) {
    if ($prof_name === '' || $prof_tel === '' || $prof_city === '' || $prof_country === '' || $prof_address === '') {
        $err = "Пожалуйста, заполните все поля";
    } else {
        $sql = ("UPDATE users SET `name` = ?, `tel` = ?, `city` = ?, `country` = ?, `address` = ? WHERE `login` = ?");
        $query = $dbh->prepare($sql); // подготовка запроса к выполнению
        $query->execute([$prof_name, $prof_tel, $prof_city, $prof_country, $prof_address, $login]); // выполнение запроса
        header("Location: profile.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            font-family: sans-serif;
        }

        @media(max-width:991px) {
            .gallery-item {
                flex: 33.3%;
            }
        }

        @media(max-width:768px) {
            .gallery-item {
                flex: 50%;
            }
        }

        @media(max-width:530px) {
            .gallery-item {
                flex: 100%;
            }
        }

        @media only screen and (max-width: 992px) {
            .razdel {
                position: relative;
                display: flex;
                flex-wrap: wrap;
                overflow: hidden;
                justify-content: center;
                font-size: 0;
                margin-top: 0;


            }

            @media only screen and (max-width: 768px) {}

            .razdel {
                position: relative;
                display: flex;
                flex-wrap: wrap;
                overflow: hidden;
                justify-content: center;
                font-size: 0;
                margin-top: 0;
            }

            .Fuut a {

                justify-content: center;
                color: #3e310b;
                left: 10px;
            }

            .Fuut p {
                text-align: center;
                color: #3e310b;
                left: 10px;
                font-size: 15px;
            }
        }

        @media only screen and (max-width: 480px) {}

        @media only screen and (max-width: 320px) {}
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoGGy</title>
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
    <div class="preloader">
        <div class="preloader__row">
            <div class="preloader__item"></div>
            <div class="preloader__item"></div>
        </div>
    </div>
    <style>
        .preloader {
            /*фиксированное позиционирование*/
            position: fixed;
            /* координаты положения */
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            /* фоновый цвет элемента */
            background: #e0e0e0;
            /* размещаем блок над всеми элементами на странице (это значение должно быть больше, чем у любого другого позиционированного элемента на странице) */
            z-index: 1001;
        }

        .preloader__row {
            position: relative;
            top: 50%;
            left: 50%;
            width: 70px;
            height: 70px;
            margin-top: -35px;
            margin-left: -35px;
            text-align: center;
            animation: preloader-rotate 2s infinite linear;
        }

        .preloader__item {
            position: absolute;
            display: inline-block;
            top: 0;
            background-color: #337ab7;
            border-radius: 100%;
            width: 35px;
            height: 35px;
            animation: preloader-bounce 2s infinite ease-in-out;
        }

        .preloader__item:last-child {
            top: auto;
            bottom: 0;
            animation-delay: -1s;
        }

        @keyframes preloader-rotate {
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes preloader-bounce {

            0%,
            100% {
                transform: scale(0);
            }

            50% {
                transform: scale(1);
            }
        }

        .loaded_hiding .preloader {
            transition: 0.3s opacity;
            opacity: 0;
        }

        .loaded .preloader {
            display: none;
        }
    </style>
    <nav style="user-select: none;" class="navbar">
        <div class="container">
            <a href="index.html" class="navbar-brand">GAMEZONE</a>
            <div class="navbar-wrap">
                <div class="burger">
                    <span></span>
                </div>
                <ul style="user-select: none;" class="navbar-menu">
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="#podval">Контакты</a></li>
                    <?php if (isset($_SESSION['login']['login']) && !empty($_SESSION['login']['login'])) { ?>
                        <li><a href="logout.php">Выйти</a></li>
                    <?php } else { ?>

                        <li><a href="auth.php">Войти</a></li>
                        <li><a href="rega.php">Зарегистрироваться</a></li><?php } ?>
                    <li><a href="cart.php" class="cart-link">Корзина &#128722;<?php if ($_SESSION['cart_total_quantity'] > 0) { ?><sup><?= ($_SESSION['cart_total_quantity']) ?></sup><?php } ?></a></li>
                    <li><a href="profile.php">
                            <div class="profile">
                                <span style="font-size:16px ;">Мой профиль</span>
                                <img class="no-style" src="<?= $result['avatar'] ?>" alt="Profile picture">
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="overlay"></div>
        </div>
    </nav><br><br><br>
    <div class="conteiner">
        <form style="margin-top: 4%; " action="" method="post" enctype="multipart/form-data">
            <center>
                <div class="addtoprifile" style="min-height: 620px; width: 450px; background-color: white;border-radius: 20px; " class="a1">
                    <img src="<?= $result['avatar'] ?>" alt="Profile Picture" class="profile-pic1">
                    <h2><?= $result['name'] ?></h2>
                    <p style=" font-size: 18px;">Email: <?= $result['email'] ?></p>
                    <p style=" font-size: 18px;">Телефон: <?= $result['tel'] ?></p>
                    <p style=" font-size: 18px;">Город: <?= $result['city'] ?></p>
                    <p style=" font-size: 18px;">Страна: <?= $result['country'] ?></p>
                    <p style=" font-size: 18px;">Адрес: <?= $result['address'] ?></p>
                    <input class="modal-btn" type="checkbox" id="modal-btn" name="modal-btn" />
                    <label for="modal-btn">Редактировать профиль</label></br></br>

                    <div class="modal">
                        <div class="modal-wrap">
                            <img src="<?= $result['avatar'] ?>" alt="Profile Picture" class="profile-pic2">
                            <div class="form-group">
                                <label for="avatar" class="form-label">Выберите файл</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                                    <button type="submit" class="btn2 btn-primary" name="upload">Загрузить</button>
                                </div>
                            </div>
                            <h2>Имя: <input class="text-field__input" type="text" name="prof_name" value="<?= $result['name'] ?>"></h2>
                            <p style=" font-size: 18px;">Телефон: <input class="text-field__input" type="text" name="prof_tel" value="<?= $result['tel'] ?>" required></p>
                            <p style=" font-size: 18px;">Город: <input class="text-field__input" type="text" name="prof_city" value="<?= $result['city'] ?>" required></p>
                            <p style=" font-size: 18px;">Страна: <input class="text-field__input" type="text" name="prof_country" value="<?= $result['country'] ?>" required></p>
                            <p style=" font-size: 18px;">Адрес: <input class="text-field__input" type="text" name="prof_address" placeholder="город,улица,индекс" value="<?= $result['address'] ?>" required></p>
                            <?= $err ?>
                            <button class="buttonincart" type="submit" name="save">Сохранить изменения</button>
        </form>
        </center>
    </div>
    </div>
    </div>
    </form>
    </div>
    <script src="JSburger/menu.js"></script>
    <script>
        window.onload = function() {
            document.body.classList.add('loaded_hiding');
            window.setTimeout(function() {
                document.body.classList.add('loaded');
                document.body.classList.remove('loaded_hiding');
            }, 500);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
<footer>
    <div class="social">
        <p id="podval">
            Наши Контакты:
        </p>
        <a href="#"><img src="vk.png" width="40" height="40" alt=""></a>
        <a href="#"><img src="youtube.png" width="40" height="40" alt=""></a>
        <a href="#"><img src="Telega.png" width="40" height="40" alt=""></a>
        <a href="#"><img src="Insta.png" width="40" height="40" alt=""></a>
        <h6 style="padding-top: 1px; padding-left: 20px; color: rgba(232, 243, 232, 0.511);">© 2022 DoGGy.ru. Все права защищены. Запрещается копирование информации.</h6>
    </div>

</footer>

</html>