<?php
session_start();

define("SALT", "UIOwuX5PNnm4a2orlR8ENANdTUJ3GdOu");
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__));
define("SRC", ROOT.DS."src");
define("PUB", __DIR__);
define("VIEW", SRC.DS."Views");
define("VIEW_TEMPLATE", VIEW.DS."templates");

require SRC.DS."autoload.php";
require SRC.DS."helper.php";

use App\DB;

// APPEND ADMIN
$result = DB::fetch("SELECT * FROM users WHERE grade = 1");
if(!$result) {
    $data = ["admin", hash("sha256", "1234".SALT), "관리자", "010-0000-0000", 1];
    DB::execute("INSERT INTO users(identity, password, name, phone, grade) VALUES (?, ?, ?, ?, ?)", $data);
    $admin_id = DB::getConnection()->lastInsertId();
} else $admin_id = $result->id;


/* JSON LOAD */
$cnt = count(DB::fetchAll("SELECT * FROM placement"));
if($cnt == 0){
    $fileRead = file_get_contents(PUB.DS."data".DS."placement.json");
    $placement = json_decode($fileRead);
    
    foreach($placement as $item){
        $data = [
                    $item->name, $item->score, $item->description, $item->price, 
                    json_encode($item->rest, JSON_UNESCAPED_UNICODE), 
                    $item->image[0]
                ];
        DB::execute("INSERT INTO placement(name, score, description, price, rest, image) VALUES (?, ?, ?, ?, ?, ?)", $data);
    }
}


$cnt = count(DB::fetchAll("SELECT * FROM reserve_placement"));
if($cnt == 0){
    $fileRead = file_get_contents(PUB.DS."data".DS."reservation.json");
    $reservation = json_decode($fileRead);
    
    foreach($reservation as $item){
        $data = [
            $item->placement,
            date("Y-m-d", strtotime($item->since)),
            date("Y-m-d", strtotime($item->until)),
            $item->name,
            date("Y-m-d", strtotime($item->createdAt)), 
            $admin_id,
            DB::find("placement", $item->placement)->image
        ];
        DB::execute("INSERT INTO reserve_placement(placement, since, until, name, created_at, user_id, image) VALUES (?, ?, ?, ?, ?, ?, ?)", $data);
    }
}

$cnt = count(DB::fetchAll("SELECT * FROM transport"));
if($cnt == 0){
    $fileRead = file_get_contents(PUB.DS."data".DS."transportation.json");
    $transport = json_decode($fileRead);
    
    foreach($transport as $item){
        $data = [
            $item->name, $item->description, $item->interval, json_encode($item->cycle),
            json_encode($item->rest), $item->price, $item->limit
        ];
        DB::execute("INSERT INTO transport(name, description, interval_time, cycle, rest, price, limit_count) VALUES (?, ?, ?, ?, ?, ?, ?)", $data);
    }    
}

$cnt = count(DB::fetchAll("SELECT * FROM reserve_transport"));
if($cnt == 0){
    $fileRead = file_get_contents(PUB.DS."data".DS."transportation_reservation.json");
    $reserve = json_decode($fileRead);
    
    foreach($reserve as $item){
        $data = [
            $admin_id, $item->transportation, $item->date, $item->time,
            json_encode($item->member, JSON_UNESCAPED_UNICODE),
            $item->price
        ];
        DB::execute("INSERT INTO reserve_transport(user_id, transportation, date, time, member, price, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())", $data);
    }    
}

/* /JSON LOAD */


require SRC.DS."web.php";
