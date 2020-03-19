<?php
namespace Controller;

use App\DB;

class AdminController {
    function venuePage(){
        $viewData['reserveList'] = DB::fetchAll("SELECT R.*, IFNULL(P.name, '삭제된 행사장') place_name, U.name user_name, U.identity user_id 
                                                FROM reserve_placement R
                                                LEFT JOIN placement P
                                                ON R.placement = P.id, users U
                                                WHERE U.id = R.user_id");
        admin_view("admin__venue", $viewData);
    }

    function venueManagerPage(){
        $viewData['placements'] = DB::fetchAll("SELECT * FROM placement");
        admin_view("admin__venue-manager", $viewData);
    }

    function transportPage(){
        $viewData['reserveList'] = DB::fetchAll("SELECT R.*, U.identity AS user_id, T.name AS transport_name
                                               FROM reserve_transport AS R, users AS U, transport AS T 
                                                WHERE U.id = R.user_id AND T.id = R.transportation");
        admin_view("admin__transport", $viewData);
    }

    function transportManagerPage(){
        $viewData['transports'] = DB::fetchAll("SELECT * FROM transport");
        admin_view("admin__transport-manager", $viewData);
    }
    

    function removePlacement($id){
        $placement = DB::find("placement", $id);
        if(!$placement) back("해당 행사장이 존재하지 않습니다.");
        DB::execute("DELETE FROM placement WHERE id = ?", [$id]);
        redirect("/admin/venue-manager", "행사장이 삭제되었습니다.");
    }

    function removeTransport($id){
        $transport = DB::find("transport", $id);
        if(!$transport) back("해당 교통편이 존재하지 않습니다.");
        DB::execute("DELETE FROM transport WHERE id = ?", [$id]);
        redirect("/admin/transportation-manager", "교통편이 삭제되었습니다.");
    }
}