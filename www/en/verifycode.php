<?php

//实例化redis
$redis = new Redis();
//连接redis
$redis->connect('127.0.0.1', 6379);
$vc = $_GET['vc'];
if($redis->exists($vc)) {
	$vcode = $redis->get($vc);
} else {
	exit('非法操作');
}

getCode(6, 60, 20, $vcode);

function getCode($num,$w,$h,$vcode) {
	$code = $vcode;
	//4位验证码也可以用rand(1000,9999)直接生成
	//将生成的验证码写入session，备验证页面使用
	//创建图片，定义颜色值
	Header("Content-type: image/PNG");
	$im = imagecreate($w, $h);
	$black = imagecolorallocate($im, 0, 0, 0);
	$gray = imagecolorallocate($im, 200, 200, 200);
	$bgcolor = imagecolorallocate($im, 255, 255, 255);

	imagefill($im, 0, 0, $gray);

	//画边框
	imagerectangle($im, 0, 0, $w-1, $h-1, $black);

	//随机绘制两条虚线，起干扰作用
	$style = array (
		$black,
		$black,
		$black,
		$black,
		$black,
		$gray,
		$gray,
		$gray,
		$gray,
		$gray
	);
	imagesetstyle($im, $style);
	$y1 = rand(0, $h);
	$y2 = rand(0, $h);
	$y3 = rand(0, $h);
	$y4 = rand(0, $h);
	imageline($im, 0, $y1, $w, $y3, IMG_COLOR_STYLED);
	imageline($im, 0, $y2, $w, $y4, IMG_COLOR_STYLED);

	//在画布上随机生成大量黑点，起干扰作用;
	for ($i = 0; $i < 80; $i++) {
		imagesetpixel($im, rand(0, $w), rand(0, $h), $black);
	}
	//将数字随机显示在画布上,字符的水平间距和位置都按一定波动范围随机生成
	$strx = rand(3, 8);
	for ($i = 0; $i < $num; $i++) {
		$strpos = rand(1, 6);
		imagestring($im, 5, $strx, $strpos, substr($code, $i, 1), $black);
		$strx += rand(8, 12);
	}
	imagepng($im);
	imagedestroy($im);
}
?>
