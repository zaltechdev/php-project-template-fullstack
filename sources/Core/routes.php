<?php

use MyFinance\Controllers\Auth\ForgotController;
use MyFinance\Controllers\Auth\LoginController;
use MyFinance\Controllers\Auth\VerifyController;
use MyFinance\Controllers\Main\DashboardController;
use MyFinance\Controllers\Main\AddBudgetController;

$app->get("/",[LoginController::class,"index"]);
$app->post("/",[LoginController::class,"submit"]);
$app->get("/forgot",[ForgotController::class,"index"]);
$app->post("/forgot",[ForgotController::class,"submit"]);
$app->get("/verify",[VerifyController::class,"index"]);
$app->post("/verify",[VerifyController::class,"submit"]);
$app->get("/dashboard",[DashboardController::class,"index"]);
$app->post("/dashboard",[DashboardController::class,"submit"]);
$app->get("/add-budget",[AddBudgetController::class,"index"]);
$app->post("/add-budget",[AddBudgetController::class,"submit"]);