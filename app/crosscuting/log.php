<?php

namespace app\crosscuting;

// Carregar o autoloader do composer
require "../../vendor/autoload.php";

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log
{
    static function debug(string $texto)
    {
        if (LOGDEBUGFLAG) {
            $logger = new Logger('main');
            $logger->pushHandler(new StreamHandler("../logs/" . "debug-" . date("Y-m-d") . ".log", Logger::DEBUG));

            $logger->debug($texto);
        }
    }

    static function info(string $texto)
    {
        if (LOGINFOFLAG) {
            $logger = new Logger('main');
            $logger->pushHandler(new StreamHandler("../logs/" . "info-" . date("yyyy-mm-dd") . ".log", Logger::INFO));

            $logger->info($texto);
        }
    }

    static function error($error)
    {
        $logger = new Logger('main');
        $logger->pushHandler(new StreamHandler("../logs/" . "error-" . date("yyyy-mm-dd") . ".log", Logger::ERROR));

        $logger->error($error);
    }
}
