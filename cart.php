<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Корзина товаров</title>
    <link rel="stylesheet" type="text/css" href="css/cart.css">
</head>

<body>
    <form method="POST" name="cart">
        <table style="margin-top: 20px ;margin-bottom: 20px ; ">
            <thead>
                <tr>
                <tr>
                    <td colspan="5">
                        <h1>Корзина товаров</h1>
                    </td>
                </tr>
                <th>Название товара</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Итого</th>
                <th></th>
                <?php if (empty($_SESSION['cart'])) { ?>
                    <tr>
                        <td colspan="4">
                            <h1 style="user-select: none;">
                                <p style="text-align:center; font-size: 24px; color: #000;">Корзина пуста</p>
                            </h1>
                    </tr>
                <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Проверка на удаление товара из корзины
                if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
                    // Удаление товара из корзины
                    unset($_SESSION['cart'][$_GET['remove']]);

                    // Перенаправление на текущую страницу
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
                // Проверка на изменение количества товара в корзине
                if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
                    // Обновление количества товаров в корзине
                    foreach ($_POST['quantity'] as $product_id => $quantity) {
                        if (isset($_SESSION['cart'][$product_id])) {
                            $_SESSION['cart'][$product_id]['quantity'] = intval($quantity);
                        }
                    }
                    // Перенаправление на текущую страницу
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
                // Инициализация общей стоимости
                $total = 0;
                // Инициализация общего количества товаров
                $total_quantity = 0;

                // Проверка на наличие товаров в корзине
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    // Перебор товаров в корзине
                    foreach ($_SESSION['cart'] as $product_id => $product) {
                        // Вывод информации о товаре
                        echo '<tr>';
                        echo '<td>';
                        echo '<div style="display: flex; flex-direction: row;">';
                        echo '<img src="' . $product['image'] . '" alt="" style="height: 130px; width: 90px;">';
                        echo '<div style="margin-left: 10px;">';
                        echo '<h3 style="margin-top: 0;">' . $product['name'] . '</h3>';
                        echo '</div>';
                        echo '</div>';
                        echo '</td>';
                        echo '<td>' . number_format($product['price'], 0, '.', ' ') . ' ₽</td>';
                        echo '<td><input type="number" value="' . $product['quantity'] . '" min="1" max="15" name="quantity[' . $product_id . ']"></td>';
                        echo '<td>' . number_format($product['price'] * $product['quantity'], 0, '.', ' ') . ' ₽</td>';
                        echo '<td><a href="?remove=' . $product_id . '">Удалить</a></td>';
                        echo '</tr>';
                        // Подсчет общей стоимости
                        $total += $product['price'] * $product['quantity'];
                        $formatted_total = number_format($total, 0, '.', ' ');
                        // Подсчет общего количества товаров
                        $total_quantity += $product['quantity'];
                    }
                }
                $_SESSION['cart_total_quantity'] = $total_quantity;
                // Вывод общей стоимости
                echo '<tr>';
                echo '<td colspan="3" align="right">Итого:</td>';
                echo '<td>' . $formatted_total . ' ₽</td>';
                echo '<td><button type="submit" name="update_cart">Обновить корзину</button></td>';
                echo '</tr>';
                ?>
            </tbody>
        </table>
    </form>
    <?php
    if (isset($_POST['update_cart'])) {
        // Обновление количества товаров в корзине
        foreach ($_POST['quantity'] as $product_id => $quantity) {
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] = intval($quantity);
            }
        }
        // Перенаправление на текущую страницу
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
    ?>
</body>

</html>