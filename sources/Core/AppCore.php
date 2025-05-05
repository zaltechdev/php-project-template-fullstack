<?php

use App\Core\Crypto;
use App\Core\Database;
use App\Core\Environment;
use App\Core\Logging;
use App\Core\Routing;
use App\Core\Security;
use App\Core\Session;
use App\Core\Mailer;

require_once __DIR__ . "/configs.php";
require_once __DIR__ . "/request.php";
require_once __DIR__ . "/response.php";
require_once __DIR__ . "/utilities.php";

new Environment();
new Logging();
new Database();
new Session();
new Security();
new Crypto();
new Mailer();

$App = new Routing();

require_once __DIR__ . "/routes.php";

$App->run();