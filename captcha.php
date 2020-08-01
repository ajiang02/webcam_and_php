<?php
session_start();//必须处于程序顶部

$width = 100;
$height = 30;
$image = imagecreatetruecolor($width,$height);    // 生成100*30的底图
$black = imagecolorallocate($image,0,0,0);        // 黑色
$bgcolor = imagecolorallocate($image,255,255,255);// write
imagefill($image,0,0,$bgcolor);                   // 填充背景
 
$captch_code = "";//用于记录验证码内容

//生成4位随机验证码内容
for($i=0;$i<4;$i++){
    $fontsize = 6;
    $fontcolor = imagecolorallocate($image,rand(0,100),rand(0,100),rand(0,100));//验证码颜色深
    $data = 'abcdefghijkmnpqrstuvwxyABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
    $fontcontent = substr($data,rand(0,strlen($data)-1),1);//从$data对象中随机获取一个字符
    $captch_code .= $fontcontent;
    $x = ($i*100/4)+rand(5,10);
    $y = rand(5,15);//设置验证码位置
    imagestring($image,$fontsize,$x,$y,$fontcontent,$fontcolor);
}
$_SESSION['captch_code'] = $captch_code;
 
for($i<0;$i<200;$i++){
    //增加干扰点
    $pointcolor = imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200));//干扰点颜色浅
    imagesetpixel($image,rand(1,$width-1),rand(1,$height-1),$pointcolor);
}
 
for($i=0;$i<3;$i++){
    //增加干扰线
    $linecolor = imagecolorallocate($image,rand(100,200),rand(100,200),rand(100,200));//干扰线颜色更浅
    imageline($image,rand(1,$width-1),rand(1,$height-1),rand(1,$width-1),rand(1,$height-1),$linecolor);
}
 
header('Content-Type:image/png');
imagepng($image);     // 输出图像
imagedestroy($image); // end销毁图片
