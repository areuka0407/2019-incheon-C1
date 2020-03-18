<?php

use App\Router;

/**
 * Main
 */

Router::get("/", "MainController@indexPage");

/**
 * User
 */

Router::post("/sign-up", "UserController@signUp");

Router::get("/sign-up/captcha", "UserController@captchaImage");
Router::post("/sign-up/check-captcha", "UserController@checkCaptcha");
Router::post("/sign-up/check-overlap", "UserController@checkOverlapId");

Router::connect();