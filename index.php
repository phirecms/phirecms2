<?php
/**
 * Phire CMS (http://www.phirecms.org/)
 *
 * @link       https://github.com/phirecms/phirecms
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 */

require_once __DIR__ . '/config.php';

// Require autoloader
$autoloader = require __DIR__ . APP_PATH . '/vendor/autoload.php';

// Create main app object, register the app module and run the app
try {
    $app = new Pop\Application($autoloader, include __DIR__ . APP_PATH . '/config/application.php');
    $app->register('phire', new Phire\Module($app));
    $app->run();
} catch (\Exception $exception) {
    $app = new Phire\Module();
    $app->error($exception);
}
