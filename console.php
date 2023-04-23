<?php
require 'db.php';
session_start();
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_image = $_POST['product_image'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $_SESSION['cart_total_quantity'];
    $_SESSION['cart_total_quantity']++;

    // проверяем, есть ли уже товар в корзине, если да - увеличиваем количество
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = array(
            'image' => $product_image,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => 1
        );
    }
    header('location: console.php');
}
if (isset($_POST['editor'])) {
    $sql = ("UPDATE console SET `product_name` = ?, `product_price` = ?, `product_image` = ?, `product_images` = ?, `description` = ? WHERE `id` = ? ");
    $query = $dbh->prepare($sql);
    $query->execute([$_POST["product_name"], $_POST["product_price"], $_POST["product_image"], $_POST["product_images"], $_POST["description"], $_POST["id"]]);
    header('location: console.php');
}
if (isset($_POST['delete'])) {
    $sql = ("DELETE FROM console WHERE id = ?");
    $query = $dbh->prepare($sql);
    $query->execute([$_POST["id"]]);
    header('location: console.php');
}
if (isset($_POST['addtocart'])) {
    $addtitle = $_POST['addtitle'];
    $addimage = $_FILES['addimage'];
    $addprice = $_POST['addprice'];
    $addimages = $_POST['addimages'];
    $adddescription = $_POST['adddescription'];
    $avatar = $_FILES['addimage'];
    $avatar_name = $avatar['name'];
    $avatar_tmp_name = $avatar['tmp_name'];
    $avatar_size = $avatar['size'];
    $avatar_error = $avatar['error'];
    $avatar_ext = strtolower(pathinfo($avatar_name, PATHINFO_EXTENSION));
    $allowed_exts = array('jpg', 'jpeg', 'png');

    if (in_array($avatar_ext, $allowed_exts) && $avatar_error === 0 && $avatar_size <= 5242880) { // validate avatar file
        $avatar_new_name = uniqid('', true) . '.' . $avatar_ext;
        $avatar_dest = 'Uplo/' . $avatar_new_name;
        move_uploaded_file($avatar_tmp_name, $avatar_dest);

        $slider_photos = $_FILES['addimages'];
        $slider_photos_count = count($slider_photos['name']);
        $slider_photo_dest = '';

        for ($i = 0; $i < $slider_photos_count; $i++) {
            $slider_photo_name = $slider_photos['name'][$i];
            $slider_photo_tmp_name = $slider_photos['tmp_name'][$i];
            $slider_photo_size = $slider_photos['size'][$i];
            $slider_photo_error = $slider_photos['error'][$i];
            $slider_photo_ext = strtolower(pathinfo($slider_photo_name, PATHINFO_EXTENSION));
            if (in_array($slider_photo_ext, $allowed_exts) && $slider_photo_error === 0 && $slider_photo_size <= 5242880) { // validate slider photo file
                $slider_photo_new_name = uniqid('', true) . '.' . $slider_photo_ext;
                $slider_photo_dest .= 'Uplo/' . $slider_photo_new_name . ',';
                move_uploaded_file($slider_photo_tmp_name, 'Uplo/' . $slider_photo_new_name);
            } else {
                $err = 'Ошибка при загрузке файлов слайдера.';
            }
        }
        $slider_photo_dest = rtrim($slider_photo_dest, ',');

        $sql = "INSERT INTO console (product_name, product_image, product_price, product_images, description) VALUES (?, ?, ?, ?, ?)";
        $query = $dbh->prepare($sql);
        $query->execute([$addtitle, $avatar_dest, $addprice, $slider_photo_dest, $adddescription]);
        header('Location: console.php');
    } else {
        $err = 'Ошибка при загрузке файла.';
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
                <p style="font-size: 30px;  padding-top: 0px; padding-left: 20px; color: rgba(0, 0, 0, 0.767); font-family: Playfair Display;">Игровые PC</p>
            </center>
            <div class="razdel" style="flex-wrap: wrap;">
                <?php
                $sql = "SELECT * FROM console";
                $query = $dbh->prepare($sql);
                $query->execute();
                $products = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php if (!empty($products)) : ?>
                    <?php foreach ($products as $product) : ?>
                        <div class="container1">
                            <div class="wrapper">
                                <div class="banner-image">
                                    <h1><?= $product['product_name'] ?></h1>
                                    <img style="width:270px; height:200px;" src="<?= $product['product_image'] ?>" alt="">
                                </div>
                                <p><br /></p>
                            </div>

                            <p style="color:white; margin: 0;"><?= number_format($product['product_price'], 0, '.', ' ') ?> ₽</p>
                            <div class="button-wrapper">
                                <div class="section full-height">
                                    <?php
                                    $product_id = $product['id'];
                                    ?>
                                    <input class="modal-btn" type="checkbox" id="modal-btn<?= $product_id ?>" name="modal-btn" />
                                    <label for="modal-btn<?= $product_id ?>">Подробное описание <i class="uil uil-expand-arrows"></i></label>
                                    <div class="modal">
                                        <div class="modal-wrap">
                                            <div class="slider" id="slider<?= $product_id ?>">
                                                <?php
                                                $images = explode(',', $product['product_images']);
                                                $firstImage = true;
                                                foreach ($images as $image) {
                                                    if ($firstImage) {
                                                        echo '<img src="' . $image . '" alt="">';
                                                        $firstImage = false;
                                                    } else {
                                                        echo '<img style = "display:none;"src="' . $image . '" alt="" ">';
                                                    }
                                                }
                                                ?>
                                                <?php if (($_SESSION['login']['login'] == 'admin123')) {
                                                ?>
                                                    <form method="post">
                                                        <div style="display: flex; flex-direction: column; align-items: center;">
                                                            <label for="id" style="margin-bottom: 10px;">ID товара:</label>
                                                            <input readonly id="id" type="text" name="id" value="<?php echo $product['id'] ?>" style="padding: 5px; margin-bottom: 20px; width: 300px; font-size: 16px; text-align: center; border: 1px solid #ccc; border-radius: 5px;">

                                                            <label for="title" style="margin-bottom: 10px;">Название:</label>
                                                            <input id="title" type="text" name="product_name" value="<?php echo $product['product_name'] ?>" style="padding: 5px; margin-bottom: 20px; width: 300px; font-size: 16px; text-align: center; border: 1px solid #ccc; border-radius: 5px;">

                                                            <label for="price" style="margin-bottom: 10px;">Цена:</label>
                                                            <input id="price" type="text" name="product_price" value="<?php echo $product['product_price'] ?>" style="padding: 5px; margin-bottom: 20px; width: 300px; font-size: 16px; text-align: center; border: 1px solid #ccc; border-radius: 5px;">

                                                            <label for="main_photo" style="margin-bottom: 10px;">Основное фото:</label>
                                                            <input id="main_photo" name="product_image" value="<?php echo $product['product_image'] ?>" style="padding: 5px; margin-bottom: 20px; width: 300px; font-size: 16px; text-align: center; border: 1px solid #ccc; border-radius: 5px;">

                                                            <label for="photo_slide" style="margin-bottom: 10px;">Фото для слайдеров:</label>
                                                            <input id="photo_slide" name="product_images" value="<?php echo $product['product_images'] ?>" style="padding: 5px; margin-bottom: 20px; width: 300px; font-size: 16px; text-align: center; border: 1px solid #ccc; border-radius: 5px;">

                                                            <label for="description" style="margin-bottom: 10px;">Описание:</label>
                                                            <textarea name="description" id="description" style="height: 250px; width: 300px; padding: 5px; margin-bottom: 20px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px;"><?php echo $product['description'] ?></textarea>
                                                            <input class="shine-button" type="submit" name="editor" value="Редактировать" style="padding: 10px 20px; background-color: #4CAF50; color: #fff; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;">
                                                            <input class="shine-button" type="submit" name="delete" value="Удалить карточку" style="padding: 10px 20px; background-color: red; color: #fff; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;">
                                                        </div>
                                                    </form>
                                                <?php } ?>
                                                <form method="post">
                                                    <input type="hidden" name="product_image" value="<?php echo $product['product_image'] ?>">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['id'] ?>">
                                                    <input type="hidden" name="product_name" value="<?php echo $product['product_name'] ?>">
                                                    <input type="hidden" name="product_price" value="<?php echo $product['product_price'] ?> ">
                                                    <button class="shine-button" type="submit" name="add_to_cart">Добавить в корзину 🛒</button>
                                                </form>

                                            </div>
                                            <button class="prev" data-product-id="<?= $product_id ?>">&#10094;</button>
                                            <button class="next" data-product-id="<?= $product_id ?>">&#10095;</button>
                                            <p style="font-size:10px;"> <em><strong><?= $product['description'] ?></strong><br></em>

                                            </p>
                                        </div>
                                    </div>
                                    <a href="https://front.codes/" class="logo" target="_blank">
                                        <img src="" alt="">
                                    </a>
                                </div>
                                <button class="btn fill">Купить сейчас</button><br>
                                <p class="small">*Внешний вид компьютера носит ознакомительный характер и может незначительно отличаться в зависимости от пользовательской конфигурации. Проверить итоговый состав компонентов, наличие тех или иных опций вы сможете нажав кнопку "Спецификация" или в момент оформления заказа в личном кабинете. </p>
                            </div>
                        </div>
                    <?php endforeach  ?>
                <?php endif ?>
            </div>
            <div id="myModal12" class="modal12">
                <div class="modal-content12">
                    <span class="close">&times;</span>
                    <p>Добавление карточки товара</p>
                    <form method="post" enctype="multipart/form-data">
                        <center>
                            <div class="beatifull">
                                <input type="text" name="addtitle" placeholder="Название" required><br>
                                <input type="file" name="addimage" placeholder="Главное фото" required><br>
                                <input type="text" name="addprice" placeholder="Цена" required><br>
                                <label>Слайдеры для товара</label>
                                <input type="file" multiple name="addimages[]" placeholder="Слайдеры" required><br>
                                <input type="text" name="adddescription" placeholder="Описание" required><br>
                                <button class="shine-button" type="submit" name="addtocart">Добавить карточку</button><br>
                                <?= '<p style="color: red ;">' . $err ?>
                            </div>
                        </center>
                    </form>
                </div>
            </div>
            <?php if (($_SESSION['login']['login'] == 'admin123')) { ?>
                <center><button class="shine-button123" type="submit" name="add_to_cart" id="myBtn"></button></center>
            <?php } ?>
        </div>

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
    <script>
        $(document).ready(function() {
            $('.modal-btn').on('change', function() {
                if ($(this).is(':checked')) {
                    var productId = $(this).attr('id').replace('modal-btn', '');
                    $('#slider' + productId + ' img').hide();
                    $('#slider' + productId + ' img:first-of-type').show();
                }
            });
            $('.prev, .next').click(function() {
                var productId = $(this).data('product-id');
                var slideIndex = $('#slider' + productId + ' img:visible').index() + 1;
                var slides = $('#slider' + productId + ' img').length;
                if ($(this).hasClass('prev')) {
                    slideIndex--;
                    if (slideIndex < 1) {
                        slideIndex = slides;
                    }
                } else {
                    slideIndex++;
                    if (slideIndex > slides) {
                        slideIndex = 1;
                    }
                }
                $('#slider' + productId + ' img').hide();
                $('#slider' + productId + ' img:nth-of-type(' + slideIndex + ')').show();
            });
        });
    </script>
    <script>
        // Получаем модальное окно
        var modal = document.getElementById("myModal12");

        // Получаем кнопку, которая открывает модальное окно
        var btn = document.querySelector('.shine-button123');

        // Получаем элемент <span>, который используется для закрытия модального окна
        var span = document.getElementsByClassName("close")[0];

        // Когда пользователь кликает на кнопку, открываем модальное окно
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Когда пользователь кликает на <span> (x), закрываем модальное окно
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Когда пользователь кликает в любое место вне модального окна, закрываем его
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
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