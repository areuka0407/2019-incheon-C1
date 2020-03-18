<?php
namespace Controller;

class UserController {
    function captchaImage(){
        $fontsize = 15;
        $width = 400;
        $height = 50;
        $fontPath = PUB.DS."fonts".DS."NanumBarunGothic.ttf";

        $captcha = random_str(10);
        session("captcha", $captcha);

        $image = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 64, 64, 64);

        imagefill($image, 0, 0, $white);
        
        $boundingBox = imagettfbbox($fontsize, 0, $fontPath, $captcha);
        $textWidth = $boundingBox[2] - $boundingBox[0];
        $textHeight = $boundingBox[7] - $boundingBox[1];
        $textX = $width / 2 - $textWidth / 2;
        $textY = $height / 2 - $textHeight / 2;

        // 캡챠 문자
        imagettftext($image, $fontsize, 0, $textX, $textY, $black, $fontPath, $captcha);

        // 자동 스캔 방지
        $moveCount = 10;
        $moveUnit = $width / $moveCount;
        for($i = $moveUnit; $i < $width; $i += $moveUnit){
            $lineWidth = rand(1, 3);
            imagesetthickness($image, $lineWidth);
            imageline($image, $i, -10, rand(- $width / 4, $width + $width / 4), $height + 10, $black);
        }

        header("Content-Type: image/jpeg");
        imagejpeg($image);
    }
}