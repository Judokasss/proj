<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$confirmationCode = generateConfirmationCode();
// $confirmationCode = $_SESSION['confirmationCode'];
function sendEmail($email, $name, $confirmationCode)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.yandex.ru';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'Flickshoter@yandex.ru';
        $mail->Password   = 'vmtfwnyrxhotheiy';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;
        $mail->CharSet = 'UTF-8';

        //Recipients
        $mail->setFrom('Flickshoter@yandex.ru', 'Жабинью');
        $mail->addAddress($email, $name);
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Код подтверждения для регистрации';
        $mail->Body    = 'Ваш код: ' . $confirmationCode;
        $mail->send();
        $_SESSION['code'] = $confirmationCode;
        header('location: podtverzd.php');
    } catch (Exception $e) {
        // echo "Ошибка попробуйте еще";
        echo '<p class = "yolo" style="color: aqua; text-align:center;">' . $err = "Ошибка попробуйте еще";
    }
}
function sendEmailvosst($email, $confirmationCode)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.yandex.ru';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'Flickshoter@yandex.ru';
        $mail->Password   = 'vmtfwnyrxhotheiy';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;
        $mail->CharSet = 'UTF-8';

        //Recipients
        $mail->setFrom('Flickshoter@yandex.ru', 'Жабинью');
        $mail->addAddress($email);
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Код подтверждения для регистрации';
        $mail->Body    = 'Ваш код: ' . $confirmationCode;
        $mail->send();
        $_SESSION['code'] = $confirmationCode;
        header('location: podtcodaforvosst.php');
    } catch (Exception $e) {
        // echo "Ошибка попробуйте еще";
        echo '<p class = "yolo" style="color: aqua; text-align:center;">' . $err = "Ошибка попробуйте еще";
    }
}

function generateConfirmationCode()
{
    $confirmationCode = '';
    $digits = '0123456789';
    for ($i = 0; $i < 6; $i++) {
        $confirmationCode .= $digits[rand(0, 9)];
    }
    return $confirmationCode;
}
function formsend($email, $name, $message)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.yandex.ru';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'Flickshoter@yandex.ru';
        $mail->Password   = 'vmtfwnyrxhotheiy';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;
        $mail->CharSet = 'UTF-8';

        //Recipients
        $mail->setFrom('Flickshoter@yandex.ru', 'Жабинью');
        $mail->addAddress('Flickshoter@yandex.ru');
        //Content
        $mail->isHTML(true);  //Set email format to HTML
        $mail->Subject = 'Форма обратной связи';
        $mail->Body    = '<p>Сообщение от:' . ' ' . $name . '</p>' . '<p>Email:' . ' ' . $email . '</p>' . '<p>Сообщение:</p>' . '<p>' . $message . '</p>';
        $mail->send();
    } catch (Exception $e) {
        // echo "Ошибка попробуйте еще";
        echo '<p class = "yolo" style="color: aqua; text-align:center;">' . $err = "Ошибка попробуйте еще";
    }
}
