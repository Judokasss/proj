<?php
session_start();
require "db.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="css/feedbackform.css">
    <style>
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
                font-size: 25px;
            }


        }

        @media only screen and (max-width: 480px) {
            .poster {
                border: 4px #5c00b34b solid;
                width: 250px;
                height: 170px;
                background-color: rgba(111, 0, 255, 0.082);
                box-shadow: 3px 3px 5px #999;
                ;

            }

            textarea {
                width: 150px;
                height: 50px;
            }
        }

        @media only screen and (max-width: 320px) {}
    </style>
    <meta name="viewport" content="user-scalable=no">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My first site</title>
    <script src="https://www.google.com/recaptcha/api.js"></script>
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
            <a href="index.php" class="navbar-brand">GAMEZONE</a>
            <div class="navbar-wrap">
                <div class="burger">
                    <span></span>
                </div>
                <ul style="user-select: none;" class="navbar-menu">
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="#podval">Контакты</a></li>
                    <?php if (isset($_SESSION['login']['login']) && !empty($_SESSION['login']['login'])) { ?>
                        <li><a href="logout.php">Выйти</a></li>
                        <li><a href="cart.php" class="cart-link">Корзина &#128722;<?php if ($_SESSION['cart_total_quantity'] > 0) { ?><sup><?= ($_SESSION['cart_total_quantity']) ?></sup><?php } ?></a></li>
                        <li><a href="profile.php">
                                <div class="profile">
                                    <span style="font-size:16px ;">Мой профиль</span>
                                    <img class="no-style" src="<?= $_SESSION['login']['avatar'] ?>" alt="Profile picture">
                                </div>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li><a href="auth.php">Войти</a></li>
                        <li><a href="rega.php">Зарегистрироваться</a></li>
                        <li><a href="cart.php" class="cart-link">Корзина &#128722;<?php if ($_SESSION['cart_total_quantity'] > 0) { ?><sup><?= ($_SESSION['cart_total_quantity']) ?></sup><?php } ?></a></li><?php } ?>
                </ul>
            </div>
            <div class="overlay"></div>
        </div>
    </nav><br><br><br>
    <div class="conteiner">
        <div class="page">
            <center>
                <p style="font-size: 35px;  padding-top: 0px; padding-left: 20px; color: rgba(0, 0, 0, 0.767); font-family: Playfair Display;">GameZone</p>
            </center>
            <div class="razdel">
                <a href="contacts.php" class="card">
                    <img src="image/pk3.png" alt="balloon with an emoji face" class="card__img">
                    <span class="card__footer">
                        <span class="textcenterspan"><strong>Игровые PC</strong></span>
                    </span>
                </a>
                <a href="laptop.php" class="card">
                    <img src="image/ноут.png" alt="balloon with an emoji face" class="card__img">
                    <span class="card__footer">
                        <span class="textcenterspan"><strong>Игровые ноутбуки</strong></span>
                    </span>
                </a>
                <a href="console.php" class="card">
                    <img style="margin-top:100px ;" src="image/PS5-Transparent.png" alt="balloon with an emoji face" class="card__img">
                    <span class="card__footer">
                        <span class="textcenterspan"><strong>Консоли</strong></span>
                    </span>
                </a>
            </div>
            <hr size=3px width=500000000 px align="left">
            <div class="carta">
                <p style="font-size: 35px;  padding-top: 0px; padding-left: 20px; color: rgba(0, 0, 0, 0.767); font-family: Playfair Display;">Где мы находимся:</p>
                <center>
                    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Abf5c5117f18d6fa2ea20408ef7dc45ce52abe3a27e381bf0c2147eecc0773c6b&amp;width=900&amp;height=222&amp;lang=ru_RU&amp;scroll=true"></script>
                </center>
                <center>
                    <h3 style="font-family: Playfair Display;font-size: 35px;padding-top: 0px; padding-left: 20px;color: rgba(0, 0, 0, 0.767);">Обратная связь:</h3>
                </center>
                <center>
                    <div class="container12">
                        <!-- content содержит содержимое формы -->
                        <div class="content">
                            <!-- Левая колонка: адрес, телефоны, email. Можете добавить свое -->
                            <div class="left-side">
                                <div class="address details">
                                    <!-- Вместо классов: название шрифтовых иконок (fontawesome.com) -->
                                    <i class="fas fa-map-marker-alt"></i>
                                    <!-- topic - заголовок, text-one, text-two - текст -->
                                    <div class="topic">Адрес</div>
                                    <div class="text-one">г.Ханты-Мансийск</div>
                                    <div class="text-two">Сдунческая улица 7</div>
                                </div>
                                <div class="phone details">
                                    <i class="fas fa-phone-alt"></i>
                                    <div class="topic">Телефон</div>
                                    <div class="text-one">8-800-000-00-00</div>
                                    <div class="text-two">8-900-000-00-00</div>
                                </div>
                                <div class="email details">
                                    <i class="fas fa-envelope"></i>
                                    <div class="topic">Email</div>
                                    <div class="text-one">support@site.com</div>
                                    <div class="text-two">admin@site.com</div>
                                </div>
                            </div>
                            <!-- Правая колонка: сама форма -->
                            <div class="right-side">
                                <!-- Заголовок для формы -->
                                <div class="topic-text">Отправьте нам сообщение</div>
                                <!-- Какой-то дополнительный текст -->
                                <p>
                                    Если у вас есть какие-то вопросы или предложения по сотрудничеству -
                                    заполните форму ниже
                                </p>
                                <!-- Форма обратной связи -->
                                <form id="feedback-form">
                                    <div class="input-box">
                                        <input id="inp1" name="name" type="text" placeholder="Ваше имя" />
                                    </div>
                                    <div class="input-box">
                                        <input id="inp2" name="email" type="text" placeholder="Введите email" />
                                    </div>
                                    <div class="input-box message-box">
                                        <textarea id="inp3" name="message" placeholder="Сообщение"></textarea>
                                    </div>
                                    <?php if (isset($err)) {
                                        echo $err;
                                    } ?><br><br>
                                    <div class="button">
                                        <div class="g-recaptcha" data-sitekey="6Lf3rJolAAAAAEmyBY9x1wWc_Nf3xbS0Ks4wsGje"></div><br>
                                        <input type="submit" name="send" value="Отправить" />
                                    </div>
                                </form>
                                <div id="form-response"></div>
                            </div>
                        </div>
                    </div>
                </center>
                <!-- Подключение шрифтовых иконок, можно получить на fontawesome.com -->
                <script src="https://kit.fontawesome.com/fce9a50d02.js" crossorigin="anonymous"></script>
            </div>
        </div>
        <script src="JSburger/menu.js"></script>
        <script>
            window.onload = function() {
                document.body.classList.add('loaded');
            }
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#feedback-form").submit(function(event) {
                    event.preventDefault(); // отменяем действие по умолчанию 

                    var formNm = $(this);
                    $.ajax({
                        type: "POST",
                        url: 'form_handler.php',
                        data: formNm.serialize(),
                        beforeSend: function() {
                            if ($('#inp1').val() == '' || $('#inp2').val() == '' || $('#inp3').val() == '') {
                                $('#form-response').html('<p style="text-align:center">Заполните все поля формы</p>');
                            } else {
                                $('#form-response').html('<p style="text-align:center">Отправка...</p>');
                            }
                        },
                        success: function(data) {
                            $('#form-response').html(data);
                            if (data.indexOf("Ваше сообщение успешно отправлено!") >= 0) {
                                formNm[0].reset();
                            }
                        },
                        error: function(jqXHR, text, error) {
                            $('#form-response').html('<p style="color:red">' + error + '</p>');
                        }
                    });
                });
            });
        </script>
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