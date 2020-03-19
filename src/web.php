<?php

use App\Router;

/**
 * Main
 */

Router::get("/", "MainController@indexPage");
Router::post("/ajax-list/{table}", "MainController@ajaxByList");
Router::post("/ajax-item/{table}/{id}", "MainController@ajaxByItem");

/**
 * User
 */

Router::get("/logout", "UserController@logout");
Router::post("/sign-in", "UserController@signIn");
Router::post("/sign-up", "UserController@signUp");

Router::get("/sign-up/captcha", "UserController@captchaImage");
Router::post("/sign-up/check-captcha", "UserController@checkCaptcha");
Router::post("/sign-up/check-overlap", "UserController@checkOverlapId");

/**
 * Reservation
 */

Router::get("/reservation/placement", "ReservationController@placementPage");
Router::post("/reservation/placement", "ReservationController@addPlaceReservation");

Router::get("/reservation/transportation", "ReservationController@transportPage");


Router::connect();