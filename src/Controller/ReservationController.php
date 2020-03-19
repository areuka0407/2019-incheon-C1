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
    
            $input = [$place_id, $start_date, $end_date, $name, user()->id, $filename];
            DB::execute("INSERT INTO reserve_placement(placement, since, until, name, created_at, user_id, image) VALUES (?, ?, ?, ?, NOW(), ?, ?)", $input);
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

     function addTransportReservation(){
        emptyInvalidate();
        extract($_POST);

        $transport = DB::find("transport", $transport_id);
        $restDays = json_decode($transport->rest);
        $reserveDay = (int)date("w", strtotime($date));
        if(in_array($reserveDay, $restDays)) back("교통편의 휴무일에는 예약을 하실 수 없습니다.");

        $cycle = json_decode($transport->cycle);
        $workTimes = [];
        
        for($i = time2min($cycle[0]); $i < time2min($cycle[1]); $i += (int)$transport->interval_time){
            $workTimes[] = min2time($i);
        }
        if(!in_array($time, $workTimes)) back("교통편이 운행하지 않는 시간에는 예약을 하실 수 없습니다.");

        $isEvents = DB::fetch("SELECT * FROM reserve_placement 
                               WHERE timestamp(since) <= timestamp(?) AND timestamp(?) <= timestamp(until)", [$date, $date]);
        if(!$isEvents) back("행사 일정이 없는 기간에는 예약을 하실 수 없습니다.");

        $totalCnt = (int)$cnt_child + (int)$cnt_adult + (int)$cnt_old;
        if($totalCnt == 0) back("탑승 인원은 최소 1명이 되어야합니다.");
        
        $reserveCount = 0;
        $sameReservation = DB::fetchAll("SELECT * FROM reserve_transport WHERE transportation = ? AND date = ? AND time = ?", [$transport_id, $date, $time]);
        foreach($sameReservation as $res){
            $member = json_decode($res->member);
            $reserveCount += $member->old + $member->adult + $member->kids;
        }
        if($transport->limit_count - $reserveCount < $totalCnt) back("좌석이 부족하여 예약을 하실 수 없습니다.");

        $price_child = $transport->price * 60 / 100 * $cnt_child;
        $price_adult = $transport->price * $cnt_adult;
        $price_old = $transport->price * ($transport->price <= 20000 ? 0 : $transport->price <= 100000 ? 50 : 80) / 100 * $cnt_old;

        $member = (object)[
            "old" => $cnt_old,
            "adult" => $cnt_adult,
            "kids" => $cnt_child
        ];
        $date = [user()->id, $transport_id, $date, $time, json_encode($member), $price_child + $price_adult + $price_old];
        DB::execute("INSERT INTO reserve_transport(user_id, transportation, date, time, member, price) VALUES (?, ?, ?, ?, ?, ?)", $date);

        redirect("/reservation/transportation", "예약이 완료되었습니다.");
     }
}