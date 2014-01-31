<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'ImageFolio',

    //'sourceLanguage'    => 'en',
	'language' => 'en',
	'theme' => 'imagefolio',

	// preloading 'log' component
	//'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.*',
		'application.helpers.*',
		
		'application.modules.content.models.*',
		'application.modules.content.helpers.*'
	),
	
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'gallery'=>array(
			'scopeSizes'=>array(
				'models'=>array(
					'small' => array(75,100,95),
					'medium' => array(130,170,90),
					'large' => array(400,520,95),
				)
			),
			'backendThumbsSize'=>'small'
		),
		'videos',
		'agency',
		'content'=>array(
			'title'=>'Pages'
		),
    ),

	// application components
	'components'=>array(
		'format'=>array(
			'class'=>'Formatter'
		),
        'authManager' => array(
            'class' => 'AuthManager',
            'defaultRoles' => array('guest'),
        ),
		'user'=>array(
			'allowAutoLogin'=>true, // enable cookie-based authentication
			'autoRenewCookie'=>true,
            'class' => 'WebUser', // переопределили класс для юзеров component.webuser
		),
        'urlManager' => require(dirname(__FILE__) . '/routers.php'),
        'db' => require(dirname(__FILE__) . '/database.php'),
		'errorHandler'=>array(
            'errorAction'=>'site/error', // use 'site/error' action to display errors
        ),
        'cache'=>array(
            'class'=>'system.caching.CFileCache',
//            'cachePath'=>'/var/www/cache/',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info, error, warning',
                    'categories' => 'command.*',
                ),
                array(
                    'class' => 'CEmailLogRoute',
                    'levels' => 'info, error, warning',
                    'categories' => 'command.*',
                ),
                array(
                    'class' => 'CWebLogRoute',
                    'levels' => 'trace',
                    'filter' => array(
                        'class' => 'CLogFilter',
                        'logVars' => array('_GET', '_POST', '_FILES', '_SESSION', '_COOKIES'),
                    ),
                ),
                array(
                    'class' => 'CProfileLogRoute',
                    'categories' => 'system.db.*, system.db_auth.*',
                    'levels' => 'trace',
                ),

            ),
        ),
		'image'=>array(
			'class'=>'application.extensions.image.CImageComponent',
			'driver'=>'GD'
		),
		'config' => array(
			'class' => 'ext.EConfig.EConfig',
		),
	),
    // application-level parameters
    'params' => require(dirname(__FILE__) . '/params.php'),
);