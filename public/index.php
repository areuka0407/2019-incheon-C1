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

/* JSON LOAD */
use App\DB;
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
            json_encode($item->user, JSON_UNESCAPED_UNICODE),
            DB::find("placement", $item->placement)->image
        ];
        DB::execute("INSERT INTO reserve_placement(placement, since, until, name, created_at, user, image) VALUES (?, ?, ?, ?, ?, ?, ?)", $data);
    }
}

/* /JSON LOAD */


require SRC.DS."web.php";
