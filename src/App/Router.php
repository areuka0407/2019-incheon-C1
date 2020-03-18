<?php
namespace App;

class Router {
    static $pageList = [];
    static function __callStatic($func, $args){
        if(strtoupper($func) === $_SERVER['REQUEST_METHOD']){
            self::$pageList[] = $args;
        }
    }

    static function connect(){
        $current_url = explode("?", $_SERVER['REQUEST_URI'])[0];
        foreach(self::$pageList as $page){
            $page__url = $page[0];
            $page__action = $page[1];

            $regex = preg_replace("/\//", "\\/", $page__url);
            $regex = preg_replace("/{([^\/]+)}/", "([^\/])", $regex);
            if(preg_match("/^".$regex."$/", $current_url, $matches)){
                unset($matches[0]);
                $split = explode("@", $page__action);
                $conName = "Controller\\{$split[0]}";
                $controller = new $conName();
                $controller->{$split[1]}(...$matches);

                exit;
            }
        }
        echo "해당 페이지는 존재하지 않는 페이지입니다.";
    }
}