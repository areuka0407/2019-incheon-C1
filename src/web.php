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

Router::get("/logout", "UserController@logout", "user");
Router::post("/sign-in", "UserController@signIn", "guest");
Router::post("/sign-up", "UserController@signUp", "guest");

Router::get("/sign-up/captcha", "UserController@captchaImage");
Router::post("/sign-up/check-captcha", "UserController@checkCaptcha");
Router::post("/sign-up/check-overlap", "UserController@checkOverlapId");

/**
 * Reservation
 */

Router::get("/reservation/placement", "ReservationController@placementPage");
Router::post("/reservation/placement", "ReservationController@addPlaceReservation", "user");

Router::get("/reservation/transportation", "ReservationController@transportPage");
Router::post("/reservation/transportation", "ReservationController@addTransportReservation", "user");

/**
 * Admin
 */
Router::get("/admin/venue", "AdminController@venuePage", "admin");
Router::get("/admin/venue-manager", "AdminController@venueManagerPage", "admin");
Router::get("/admin/transportation", "AdminController@transportPage", "admin");
Router::get("/admin/transportation-manager", "AdminController@transportManagerPage", "admin");


Router::connect();