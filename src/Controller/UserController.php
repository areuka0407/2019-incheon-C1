<?php
namespace Controller;

use App\DB;

class UserController {
    function signUp(){
        define("SALT", "UIOwuX5PNnm4a2orlR8ENANdTUJ3GdOu");

        emptyInvalidate();
        extract($_POST);

        if(DB::fetch("SELECT * FROM users WHERE identity = ?", [$identity])) back("중복된 아이디 입니다.");
    
        $checkPW = preg_match("/^(?=.*[a-zA-Z].*)(?=.*[0-9].*)(?=.*[!@#$%^&*\(\)].*)([a-zA-Z0-9!@#$%^&*\(\)]{6,20})$/", $password);
        if($checkPW == false) back("비밀번호는 [영문/숫자/특수문자]로 6~20자 이내로 작성되어야 합니다.");

        $checkNM = preg_match("/^([가-힣ㄱ-ㅎㅏ-ㅣ]{2,4})$/u", $name);
        if($checkNM == false) back("이름은 [한글]로 2~4자 이내로 작성되어야 합니다.");

        $checkPH = preg_match("/^([0-9]+)$/", $phone);
        if($checkPH == false) back("전화번호는 [숫자]로만 작성되어야 합니다.");

        if($_SESSION['captcha'] !== $captcha) back("자동가입방지 입력문자가 일치하지 않습니다.");

        $password = hash("sha256", $password . SALT);
        DB::execute("INSERT INTO users(identity, password, name, phone) VALUES (?, ?, ?, ?)", [$identity, $password, $name, $phone]);

        redirect("/", "회원가입 되었습니다.");
    }

    function captchaImage(){
        $fontsize = 15;
        $width = 400;
        $height = 50;
        $fontPath = PUB.DS."fonts".DS."NanumBarunGothic.ttf";

        $captcha = random_str(6);
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

    function checkCaptcha(){
        $input = isset($_POST['input']) ? $_POST['input'] : "";
        json_response($input === $_SESSION['captcha']);
    }

    function checkOverlapId(){
        $identity = isset($_POST['identity']) ? $_POST['identity'] : "";
        $isOverlap = DB::fetch("SELECT * FROM users WHERE identity = ?", [$identity]);
        json_response($identity === "" || $isOverlap);
    }
}