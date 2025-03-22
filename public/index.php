<?php

use App\Kernel;
echo $PLATFORM_VARIABLES | base64 --decode | jq
require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
