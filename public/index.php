<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    // PROPEL config load
    require_once dirname(__DIR__).'/config/propel/generated-conf/config.php';

    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
