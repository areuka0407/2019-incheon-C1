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
        
        $image = $_FILES['image'];
        if(!is_file($image['tmp_name'])) back("행사장 대표 이미지가 업로드 되지 않았습니다.");
        if(!preg_match("/^image\/(jpeg|png|gif)$/", $image['type'])) back("이미지 파일이 아닙니다.");
        
        
        DB::getConnection()->beginTransaction();
        try {
            $ext = substr($image['name'], strrpos('.', $image['name']));
            $imagePath = PUB.DS."images".DS."placement";
            do {
                $filename = random_str(8) . $ext;
            } while(is_file($imagePath.DS.$filename));
            move_uploaded_file($image['tmp_name'], $imagePath.DS.$filename);
    
            $input = [$place_id, $start_date, $end_date, $name, json_encode([user()->name], JSON_UNESCAPED_UNICODE), $filename];
            DB::execute("INSERT INTO reserve_placement(placement, since, until, name, created_at, user, image) VALUES (?, ?, ?, ?, NOW(), ?, ?)", $input);
            DB::getConnection()->commit();
            redirect("/reservation/placement", "예약이 완료되었습니다.");
        } catch (\Exception $e){
            back("행사장 예약 도중 문제가 발생했습니다.");
            DB::getConnection()->rollBack();
        }
    }
}