<?php
/**
 * Phire CMS (http://www.phirecms.org/)
 *
 * @link       https://github.com/phirecms/phirecms
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2017 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Phire\Event;

use Pop\Application;
use Pop\Http\Response;

/**
 * Session event class
 *
 * @category   Phire
 * @package    Phire
 * @link       https://github.com/phirecms/phirecms
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2017 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 * @version    3.0.0
 */
class Db
{

    /**
     * Check if the DB is installed
     *
     * @param  Application $application
     * @return void
     */
    public static function check(Application $application)
    {
        if (!$application->services()->isAvailable('database') &&
            (isset($_SERVER['REQUEST_URI']) &&
                (substr($_SERVER['REQUEST_URI'], 0, strlen(BASE_PATH . APP_URI . '/install')) != BASE_PATH . APP_URI . '/install'))
        ) {
            Response::redirect(BASE_PATH . APP_URI . '/install');
            exit();
        }
    }

}