<?php
session_start();
$width = 100;
$height = 60;
$count = 4; //кол-во символов капчи
$count_small = 40;
// $fon_let_amount	= 40; //количество символов на фоне
$font_size = 16; //размер шрифта
$font = dirname(__FILE__) .'/Orpheus.ttf'; //путь к файлу шрифта
$letters = array("G","L","Q","R","4","5","2","Z");
$colors = array("90", "110", "130", "150", "170", "190", "210");
$linenum = rand(3,5);
$img = imagecreatetruecolor($width, $height);
$fon = imagecolorallocate($img, 250, 250, 250);
imagefill($img, 0, 0, $fon);
for($i = 0; $i < $count_small; $i++){
    $size = rand($font_size - 11, $font_size + 2);
    $angle = rand(0, 45);//поворот символов 
    $x = rand($width * 0.1, $width - $width * 0.1);
    $y = rand($height * 0.2, $height);
    $color = imagecolorallocatealpha($img, rand(0, 255), rand(0, 255),rand(0, 255), 100);
    $fontfile = $font;
    $text = $letters[rand(0, sizeof ($letters) - 1)]; 
    imagettftext($img, $size, $angle, $x, $y, $color, $fontfile, $text);
}

for($i = 0; $i < $count; $i++){
    $size = rand($font_size * 2 - 2, $font_size * 2 + 2);
    $angle = rand(-10, -15);//поворот символов 
    $x = ($i * 1.4) * $font_size + 5;
    $y = $height/2 + $size/2 ;
    $color = imagecolorallocatealpha($img, $colors[rand(0, sizeof($colors) - 1)], $colors[rand(0, sizeof($colors) - 1)], $colors[rand(0, sizeof($colors) - 1)], rand(20, 40));
    $fontfile = $font;
    $text = $letters[rand(0, sizeof ($letters) - 1)]; 
    $captcha[] = $text;
    imagettftext($img, $size, $angle, $x, $y, $color, $fontfile, $text);
}
for ($i=0; $i<$linenum; $i++){
    $color = imagecolorallocate($img, 0, 0, 0); // Случайный цвет c изображения
    imageline($img, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
}
    $captcha = strtolower(implode("",$captcha));
    $_SESSION ['captcha'] = $captcha;
    header("Content-type: image/gif");
    imagegif($img);
