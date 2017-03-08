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
 * Phire CMS Configuration File
 */
return [
    'routes'    => include 'routes/web.php',
    'resources' => include 'resources.php',
    'forms'     => include 'forms.php',
    'database'  => [
        'adapter'  => DB_ADAPTER,
        'database' => DB_NAME,
        'username' => DB_USER,
        'password' => DB_PASS,
        'host'     => DB_HOST,
        'type'     => DB_TYPE
    ],
    'services'  => [
        'session' => 'Pop\Session\Session::getInstance',
        'acl'     => 'Pop\Acl\Acl',
        'mailer'  => [
            'call' => function() {
                return new \Pop\Mail\Mailer(new \Pop\Mail\Transport\Sendmail());
            }
        ],
        'nav.top' => [
            'call'   => 'Pop\Nav\Nav',
            'params' => [
                'tree' => include 'nav/top.php',
                'config' => [
                    'baseUrl' => BASE_PATH . APP_URI,
                    'top'     => [
                        'id'    => 'phire-nav',
                        'node'  => 'ul',
                        'class' => 'nav navbar-nav'
                    ],
                    'parent' => [
                        'node' => 'ul'
                    ],
                    'child'  => [
                        'node' => 'li'
                    ],
                    'indent' => '    '
                ]
            ]
        ],
        'nav.fluid' => [
            'call'   => 'Pop\Nav\Nav',
            'params' => [
                'tree' => include 'nav/fluid.php',
                'config' => [
                    'baseUrl' => BASE_PATH . APP_URI,
                    'top'     => [
                        'id'    => 'phire-fluid-nav',
                        'node'  => 'ul',
                        'class' => 'nav nav-sidebar'
                    ],
                    'parent' => [
                        'node' => 'ul'
                    ],
                    'child'  => [
                        'node' => 'li'
                    ],
                    'indent' => '    '
                ]
            ]
        ],
        'nav.static' => [
            'call'   => 'Pop\Nav\Nav',
            'params' => [
                'tree' => include 'nav/static.php',
                'config' => [
                    'baseUrl' => BASE_PATH . APP_URI,
                    'top'     => [
                        'id'    => 'phire-static-nav',
                        'node'  => 'ul'
                    ],
                    'parent' => [
                        'node' => 'ul'
                    ],
                    'child'  => [
                        'node' => 'li'
                    ],
                    'indent' => '    '
                ]
            ]
        ]
    ],
    'application_title' => 'Phire CMS',
    'pagination'        => 25,
    'multiple_sessions' => true,
    'login_attempts'    => 0
];