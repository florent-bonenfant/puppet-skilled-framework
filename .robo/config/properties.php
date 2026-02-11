<?php

$unix_username = exec('whoami');
$git_name      = exec('git config user.name');
$git_email     = exec('git config user.email');
$project_slug  = 'guinot_extranet';

return [
    // Local Config
    'local' => [
        'GIT_PATH' => [
            'question' => 'Path to git',
            'default' => '/usr/bin/git',
        ],
        'NPM_PATH' => [
            'question' => 'Path to npm',
            'default' => '/usr/bin/npm',
        ],
        'BOWER_PATH' => [
            'question' => 'Path to bower',
            'default' => '/usr/bin/bower',
        ],
        'GULP_PATH' => [
            'question' => 'Path to gulp',
            'default' => '/usr/bin/gulp',
        ],

        /**
         * USER
         */
        'DEVELOPER_MAIL' => [
            'question' => 'Developer email',
            'default'  => $git_email,
        ],

        'DEVELOPER_NAME' => [
           'question' => 'Developer name',
           'default'  => $git_name,
        ],
    ],

    // Project constante
    'settings' => [
        'PROJECT_NAME' => $project_slug,
        'SEEDS_FOLDER' => 'seeds',
        'EMAIL_STORE' => 'false',
    ],

    // Project configuration
    'config' => [
        /**
         * DATABASE
         */
        'DB_NAME' => [
            'question' => 'Database name',
            'default' => $project_slug,
        ],
        'DB_USER' => [
            'question' => 'Database username',
            'default' => 'username',
        ],
        'DB_PASSWORD' => [
            'question' => 'Database password',
            'default' => 'password',
        ],
        'DB_HOST' => [
            'question' => 'Database host',
            'default' => 'localhost',
        ],
        'DB_PORT' => [
            'question' => 'Database port',
            'default' => 3306
        ],

        /**
         * CI CONF
         */
        'ENVIRONEMENT' => [
            'question' => 'Environment',
            'choices' => ['development', 'testing', 'production'],
            'default' => 'development'
        ],
        'WEB_SCHEME' => [
            'question' => 'Site scheme',
            'choices' => ['http', 'https'],
            'default' => 'http',
        ],
        'WEB_HOST' => [
            'question' => 'Site host',
            'default' => 'localhost',
        ],
        'WEB_PATH' => [
            'question' => 'Site base path',
            'default' => '/'.$project_slug.'_back/public',
            'empty' => true,
        ],
        'COOKIE_SECURE' => [
            'question' => 'Cookie will only be set if a secure HTTPS connection exists. ',
            'choices' => ['false', 'true'],
            'default' => 'false',
        ],

        /**
         * Email Config
         */

         'EMAIL_PROTOCOL' => [
             'question' => 'Email protocol',
             'choices' => ['mail', 'sendmail', 'smtp'],
             'default' => 'mail',
         ],
         'EMAIL_HOST' => [
             'question' => 'Email server address',
             'default' => '',
             'empty' => true,
         ],
         'SMTP_USER' => [
             'question' => 'SMTP user',
             'default' => '',
             'empty' => true,
         ],
         'SMTP_PASSWORD' => [
             'question' => 'SMTP password',
             'default' => '',
             'empty' => true,
         ],
         'SMTP_CRYPTO' => [
             'question' => 'Email crypto ("tls", "ssl" or leave blank)',
             'default' => '',
             'empty' => true,
         ],
         'EMAIL_PORT' => [
             'question' => 'Email server port',
             'default' => '25',
         ],
         'EMAIL_INTERCEPTION' => [
             'question' => 'Email interception',
             'default' => $git_email,
             'empty' => true,
         ],

        /**
         * Data import and export Config
         */

         'DATA_PATH' => [
             'question' => 'Data path',
             'default' => 'data',
         ],
         'DATA_IMPORT_PATH' => [
             'question' => 'Data import path',
             'default' => 'util/eOne/import',
         ],
         'DATA_EXPORT_PATH' => [
             'question' => 'Data export path',
             'default' => 'util/eOne/export',
         ],
         'LOG_IMPORT_PATH' => [
             'question' => 'Import logs path',
             'default' => 'util/log/import',
         ],

        /**
         * FRONT APPLICATION CONF
         */
        'FRONT_WEB_SCHEME' => [
            'question' => 'Front-end site scheme',
            'choices' => ['http', 'https'],
            'default' => 'http',
        ],
        'FRONT_WEB_HOST' => [
            'question' => 'Front-end site host',
            'default' => 'localhost',
        ],
        'FRONT_WEB_PATH' => [
            'question' => 'Front-end site base path',
            'default' => '/'.$project_slug.'_front',
            'empty' => true,
        ],

        /**
         * Stripe
         */
        'STRIPE_SECRET_KEY_GUINOT' => [
            'question' => 'Stripe secret key for Guinot',
            'default' => '',
            'empty' => true,
        ],
        'STRIPE_SECRET_KEY_MARY_COHR' => [
            'question' => 'Stripe secret key for Mary-cohr',
            'default' => '',
            'empty' => true,
        ],
    ]
];
