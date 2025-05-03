<?php

use MyFinance\Core\Crypto;
use MyFinance\Core\Database;
use MyFinance\Core\Environment;
use MyFinance\Core\Logging;
use MyFinance\Core\Routing;
use MyFinance\Core\Security;
use MyFinance\Core\Session;
use MyFinance\Core\Mailer;

require_once __DIR__ . "/configs.php";
require_once __DIR__ . "/request.php";
require_once __DIR__ . "/response.php";
require_once __DIR__ . "/utilities.php";

new Environment();
new Logging();
new Session();
new Security();
new Crypto();
new Database();
new Mailer();

$app = new Routing();

require_once __DIR__ . "/routes.php";

$app->run();