<?php
session_start();


define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__));
define("SRC", ROOT.DS."src");
define("PUB", __DIR__);
define("VIEW", SRC.DS."Views");
define("VIEW_TEMPLATE", VIEW.DS."templates");


require SRC.DS."autoload.php";
require SRC.DS."helper.php";
require SRC.DS."web.php";