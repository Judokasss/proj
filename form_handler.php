<?php

require "func.php";

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && !empty($_POST['name'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));
    $allowed_domains = array("mail.ru", "yandex.ru", "gmail.com");

    if ($name === '' || $email === '' || $message === '') {
        $err = "Пожалуйста, заполните все поля";
    } else {
        // Проверка правильности email и разрешенность домена
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $err = "Пожалуйста, введите правильный email";
        } else {
            $domain = substr(strrchr($email, "@"), 1);
            if (!in_array($domain, $allowed_domains)) {
                $err = "Неккоректная почта";
            } else {
                // Проверка reCAPTCHA
                $recaptcha_secret_key = "6Lf3rJolAAAAAELgfZaasr8IFDaNTc7Z4X_vpuzj";
                $recaptcha_response = $_POST['g-recaptcha-response'];
                $remoteip = $_SERVER['REMOTE_ADDR'];
                // Формируем запрос к API Google reCAPTCHA
                $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret_key . "&response=" . $recaptcha_response . "&remoteip=" . $remoteip;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $recaptcha_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $recaptcha_response_json = curl_exec($ch);
                curl_close($ch);
                $recaptcha_response_data = json_decode($recaptcha_response_json);
                if (!$recaptcha_response_data->success) {
                    $err = "Пожалуйста, пройдите проверку reCAPTCHA";
                } else {
                    // Если проверка reCAPTCHA прошла успешно, отправляем форму на обработку
                    formsend($email, $name, $message);
                    echo "Спасибо, " . $name . ", мы свяжемся с вами в самое ближайшее время!";
?>
                    <script>
                        setTimeout(function() {
                            $('#inp1').val('');
                            $('#inp2').val('');
                            $('#inp3').val('');
                            $('#form-response').empty();
                            grecaptcha.reset();
                        }, 2000); // обновляем капчу через 2 секунды
                    </script>
<?php
                }
            }
            // Логирование результатов проверки reCAPTCHA
            if ($recaptcha_response_data->success) {
                error_log('reCAPTCHA success: ' . $remoteip . ' - ' . date("F j, Y, g:i a") . PHP_EOL, 3, 'recaptcha.log');
            } else {
                error_log('reCAPTCHA failed: ' . $remoteip . ' - ' . date("F j, Y, g:i a") . PHP_EOL, 3, 'recaptcha.log');
            }
        }
    }

    if (isset($err)) {
        echo $err;
    }
} else {
    echo "Некорректный запрос";
}
?>