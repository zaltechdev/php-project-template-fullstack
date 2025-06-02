<?php

const APP_MODE_PROD				= "production";
const APP_MODE_MAIN				= "maintenance";
const BASE_PATH 				= "/";
const DEFAULT_TIMEZONE 			= "Asia/Jakarta";
const ROOT_DIR 					= __DIR__ . "/../../";
const LOG_DIR					= __DIR__ . "/../../storages/logs/";
const UPLOAD_DIR				= __DIR__ . "/../../storages/uploads/";
const SESSION_DB_DIR 	        = __DIR__ . "/../../storages/session/";
const VIEW_MAIN_PATH      		= __DIR__ . "/../views/main/";
const VIEW_TEMPLATES_PATH 		= __DIR__ . "/../views/templates/";
const VIEW_ERRORS_PATH   		= __DIR__ . "/../views/errors/";

const HTTP_OK                   = 200;
const HTTP_NO_CONTENT           = 204;
const HTTP_BAD_REQUEST          = 400;
const HTTP_UNAUTHORIZED         = 401;
const HTTP_FORBIDDEN            = 403;
const HTTP_NOT_FOUND            = 404;
const HTTP_METHOD_NOT_ALLOWED   = 405;
const HTTP_INTERNAL_ERROR       = 500;
const HTTP_SERVICE_UNAVAILABLE  = 503;