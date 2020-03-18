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
    echo "location.href = '$url';";
    if($message) echo "alert('$message');";
    echo "</script>";
}

function back($message = ""){
    echo "<script>";
    echo "history.back()";
    if($message) echo "alert('$message');";
    echo "</script>";
}

function view($pageName, $data = []){
    extract($data);

    require VIEW_TEMPLATE.DS."header.php";
    require VIEW.DS.$pageName.".php";
    require VIEW_TEMPLATE.DS."footer.php";
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