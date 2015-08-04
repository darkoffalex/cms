<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'D.W.CMS 2.0',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.models.orm.*',
        'application.models.orm.ex.*',
        'application.components.*',
        'application.helpers.*',
        'application.extensions.*',
        'application.module.*'
    ),

    'modules'=>array(

        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'1234',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),

        'admin'

    ),

    // application components
    'components'=>array(
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),

        'urlManager'=>array(
            'class' => 'application.components.UrlManager',
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'rules'=>array(

                /**
                 * Routes for Yii generator module
                 */
                'gii'=>'gii',
                'gii/<controller:\w+>'=>'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',

                /**
                 * Routes for admin module
                 */

                '<language:\w{2}>/admin' => 'admin/main/index',
//                '<language:\w{2}>/admin/*' => 'admin/main/index',
                '<language:\w{2}>/admin/<controller:\w+>'=>'admin/<controller>/index',
                '<language:\w{2}>/admin/<controller:\w+>/<id:\d+>'=>'admin/<controller>/view',
                '<language:\w{2}>/admin/<controller:\w+>/<action:\w+>/<id:\d+>/*'=>'admin/<controller>/<action>',
                '<language:\w{2}>/admin/<controller:\w+>/<action:\w+>/*'=>'admin/<controller>/<action>',

                'admin/' => 'admin/main/index',

                /**
                 * Basic site routes
                 */
                '<language:\w{2}>' => 'main/index',
                '<language:\w{2}>/<controller:\w+>'=>'<controller>/index',
                '<language:\w{2}>/<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<language:\w{2}>/<controller:\w+>/<action:\w+>/<id:\d+>/<title:\w+>'=>'<controller>/<action>',
                '<language:\w{2}>/<controller:\w+>/<action:\w+>/<id:\d+>/*'=>'<controller>/<action>',
                '<language:\w{2}>/<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',

                '/' => 'main/index',
            ),
        ),

        'db'=>array(
            'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/cms.db',
            'class'=>'CDbConnection'
        ),

        // uncomment the following to use a MySQL database
        /*
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=testdrive',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ),
        */



        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),

        /*
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),

                array(
                    'class'=>'CProfileLogRoute',
                    'levels'=>'profile',
                    'enabled'=>true,
                ),

				array(
					'class'=>'CWebLogRoute',
				),
			),
		),
        */

    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'sourceLanguage' => 'en',
        'defaultLanguage' => 'en',
        'defaultAdminLanguage' => 'en'
    ),
);