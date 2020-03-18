<?php

use App\Router;

/**
 * Main
 */

Router::get("/", "MainController@indexPage");

/**
 * User
 */

Router::get("/sign-up/captcha", "UserController@captchaImage");

Router::connect();