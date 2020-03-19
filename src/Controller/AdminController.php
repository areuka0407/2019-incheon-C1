<?php
namespace Controller;

use App\DB;

class AdminController {
    function venuePage(){
        $viewData['reserveList'] = DB::fetchAll("SELECT R.*, P.name place_name FROM reserve_placement R, placement P WHERE R.placement = P.id");
        admin_view("admin__venue", $viewData);
    }

    function venueManagerPage(){
        admin_view("admin__venue-manager");
    }

    function transportPage(){
        admin_view("admin__transport");
    }

    function transportManagerPage(){
        admin_view("admin__transport-manager");
    }
}