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
            $page__permission = isset($page[2]) ? $page[2] : null;
            
            $regex = preg_replace("/\//", "\\/", $page__url);
            $regex = preg_replace("/{([^\/]+)}/", "([^\/]+)", $regex);
            if(preg_match("/^".$regex."$/", $current_url, $matches)){
                if($page__permission == "admin" && !admin()) return http_response_code(401);
                else if($page__permission == "user" && !user()) return back("로그인 후 이용하실 수 있습니다.");
                else if($page__permission == "guest" && user()) return back("로그인 후엔 이용하실 수 없습니다.");

                unset($matches[0]);
                $split = explode("@", $page__action);
                $conName = "Controller\\{$split[0]}";
                $controller = new $conName();
                $controller->{$split[1]}(...$matches);

                exit;
            }
        }
        http_response_code(404);
    }
}