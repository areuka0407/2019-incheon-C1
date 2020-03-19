<?php

function dump(){
    foreach(func_get_args() as $arg){
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function dd(){
    dump(...func_get_args());
    exit;
}


function user(){
    return isset($_SESSION['user']) ? $_SESSION['user'] : false;
}

function redirect($url, $message = ""){
    echo "<script>";
    if($message) echo "alert('$message');";
    echo "location.href = '$url';";
    echo "</script>";
    exit;
}

function back($message = ""){
    echo "<script>";
    if($message) echo "alert('$message');";
    echo "history.back();";
    echo "</script>";
    exit;
}

function view($pageName, $data = []){
    extract($data);

    require VIEW_TEMPLATE.DS."header.php";
    require VIEW.DS.$pageName.".php";
    require VIEW_TEMPLATE.DS."footer.php";
}

function admin_view($pageName, $data = []){
    extract($data);

    require VIEW_TEMPLATE.DS."admin__header.php";
    require VIEW.DS.$pageName.".php";
    require VIEW_TEMPLATE.DS."admin__footer.php";
}

function random_str($length){
    $str = "qwertyuiopasdfghjklzxcvbnm12345678909QWERTYUIOPASDFGHJKLZXCVBNM";
    $result = "";
    for($i = 0; $i < $length ; $i++){
        $result .= $str[rand(0, strlen($str) - 1)];
    }
    return $result;
}

function session($key, $value = null){
    if(is_null($value)){
        $result = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $result;
    }
    else {
        $_SESSION[$key] = $value;
    }
}

function json_response($data){ 
    header("Content-Type: application/json");
    echo json_encode($data);
    exit;
}

function emptyInvalidate(){
    foreach($_POST as $item){
        if(trim($item) === "") back("모든 내용을 입력해 주세요.");
    }
}

function time2min($timeText){
    if(!preg_match("/^(?<hour>[0-9]{2}):(?<minute>[0-9]{2})$/", $timeText, $matches)) return 0;
    return (int)$matches['hour'] * 60 + (int)$matches['minute'];
}

function min2time($min){
    $hour = floor($min / 60);
    $min = $min % 60;

    if($hour < 10) $hour = "0{$hour}";
    if($min < 10) $min = "0{$min}";
    return "$hour:$min";
}

function admin(){
    return !user() || !user()->grade ? false : user();
}