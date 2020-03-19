<?php
namespace Controller;

use App\DB;

class ReservationController {
    /**
     * Placement
     */

    function placementPage(){
        view("reserve__placement");
    }

    function addPlaceReservation(){
        emptyInvalidate();
        extract($_POST);

        $placement = DB::find("placement", $place_id);
        if(!$placement) back("존재하지 않는 행사장입니다.");
        
        $image = $_FILES['image'];
        if(!is_file($image['tmp_name'])) back("행사장 대표 이미지가 업로드 되지 않았습니다.");
        if(!preg_match("/^image\/(jpeg|png|gif)$/", $image['type'])) back("이미지 파일이 아닙니다.");


        if($start_date > $end_date) back("시작일은 종료일보다 미래일 수 없습니다.");

        $rest = json_decode($placement->rest);
        $startDay = (int)date("w", strtotime($start_date));
        $endDay = (int)date("w", strtotime($end_date));
        if($startDay <= $endDay) {
            foreach($rest as $restDay){
                if($startDay <= $restDay && $restDay <= $endDay) back("행사장 휴무일에는 예약을 하실 수 없습니다.");
            }
        }

        $isReserved = DB::fetch("SELECT * FROM reserve_placement 
                                WHERE placement = ?
                                AND timestamp(since) <= timestamp(?)
                                AND timestamp(?) <= timestamp(until)", [$place_id, $end_date, $start_date]);
        // dd($isReserved, $start_date, $end_date);
        if($isReserved) back("해당일은 이미 예약이 되어있습니다.");
        
        
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

    /**
     * Transportation
     */

     function transportPage(){
         view("reserve__transport");
     }
}