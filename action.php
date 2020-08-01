<?php
session_start(); //必须处于程序顶部

$captcha      = trim($_GET['captcha']);                                          // 验证码
$pre          = trim($_GET['pre']);                                              // 图片前缀
$picture_name = 'picture/' . $pre . "_" . time() . '.jpg';                       // 保存的图片路径
$result       = move_uploaded_file($_FILES['webcam']['tmp_name'], $picture_name);// 保存图片

if (strcasecmp($captcha, $_SESSION['captch_code']) !== 0) {
	echo "验证码错误";
    exit();
}
if (!$result) {
	echo "保存图片失败";
	exit();
}

$url_raw = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI'])  . $picture_name;
$url = str_replace('\\', '/', $url_raw);
echo "上传成功 \n" . "图片路径:" . $url;