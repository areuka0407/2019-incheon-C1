<?php
namespace Controller;

use App\DB;

class MainController {
    function indexPage(){
        $viewData['events'] = DB::fetchAll("SELECT R.*, P.id placement_id, P.name placement_name 
                                            FROM reserve_placement R, placement P 
                                            WHERE P.id = R.placement AND timestamp(since) > NOW() 
                                            ORDER BY since ASC LIMIT 0, 3");
        view("index", $viewData);
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