<?php
namespace Controller;

use App\DB;

class PlacementController {
    function reservePage(){
        view("placement__reserve");
    }

    function addReservation(){
        emptyInvalidate();
        extract($_POST);

        $placement = DB::find("placement", $place_id);
        if(!$placement) back("존재하지 않는 행사장입니다.");
        
        dd($_POST, $_FILES);
        $image = $_FILES['image'];
        if(!is_file($image['tmp_name'])) back("행사장 대표 이미지가 업로드 되지 않았습니다.");
        dd($image['type']);
        

        $input = [$place_id, $start_date, $end_date, $name, json_encode([user()->name], JSON_UNESCAPED_UNICODE)];
        DB::execute("INSERT INTO reserve_placement(placement, since, until, name, created_at, user) VALUES (?, ?, ?, ?, NOW(), ?)", $input);
    }
}