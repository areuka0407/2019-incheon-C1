<?php
namespace Controller;

use App\DB;

class MainController {
    function indexPage(){
        view("index");
    }

    function ajaxByList($table){
        $list = DB::fetchAll("SELECT * FROM `{$table}`");
        json_response($list);
    }

    function ajaxByItem($table, $id){
        $item = DB::find($table, $id);
        json_response($item);
    }
}