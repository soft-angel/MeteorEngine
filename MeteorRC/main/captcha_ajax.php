<?
$count=4;	/* количество символов */
$width=100; /* ширина картинки */
$height=48; /* высота картинки */
$font_size_min=18; /* минимальная высота символа */
$font_size_max=25; /* максимальная высота символа */
$font_file=$_SERVER["DOCUMENT_ROOT"] . "/MeteorRC/fonts/Comic_Sans_MS.ttf"; /* путь к файлу относительно w3captcha.php */
$char_angle_min=-12; /* максимальный наклон символа влево */
$char_angle_max=12;	/* максимальный наклон символа вправо */
$char_angle_shadow=8;	/* размер тени */
$char_align=40;	/* выравнивание символа по-вертикали */
$start=5;	/* позиция первого символа по-горизонтали */
$interval=20;	/* интервал между началами символов */
$chars="0123456789"; /* набор символов */

$image=imagecreatetruecolor($width, $height);
$bg_r = isset($_GET['bg_r'])?(int)$_GET['bg_r']:255;
$bg_g = isset($_GET['bg_g'])?(int)$_GET['bg_g']:255;
$bg_b = isset($_GET['bg_b'])?(int)$_GET['bg_b']:255;

$col_r = isset($_GET['col_r'])?(int)$_GET['col_r']:000;
$col_g = isset($_GET['col_g'])?(int)$_GET['col_g']:000;
$col_b = isset($_GET['col_b'])?(int)$_GET['col_b']:000;

$background_color=imagecolorallocate($image, $bg_r, $bg_g, $bg_b); /* rbg-цвет фона */
// $font_color=imagecolorallocate($image, rand(10, 200), rand(100, 150), rand(5, 50)); /* rbg-цвет тени */

imagefill($image, 0, 0, $background_color);

$str="";

$num_chars=strlen($chars);
for ($i=0; $i<$count; $i++)
{
	$char=$chars[rand(0, $num_chars-1)];
	$font_size=rand($font_size_min, $font_size_max);
	$char_angle=rand($char_angle_min, $char_angle_max);
	imagettftext($image, $font_size, $char_angle, $start, $char_align, imagecolorallocate($image,$col_r, $col_g, $col_b), $font_file, $char);
	imagettftext($image, $font_size, $char_angle+$char_angle_shadow*(rand(0, 1)*2-1), $start, $char_align, $background_color, $font_file, $char);
	$start+=$interval;
	$str.=$char;
}

$_SESSION["CAPTCHA"]=$str;

if (function_exists("imagepng"))
{
	header("Content-type: image/png");
	imagepng($image);
}
elseif (function_exists("imagegif"))
{
	header("Content-type: image/gif");
	imagegif($image);
}
elseif (function_exists("imagejpeg"))
{
	header("Content-type: image/jpeg");
	imagejpeg($image);
}

imagedestroy($image);
