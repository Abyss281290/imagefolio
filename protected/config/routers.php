<?php
return array(
    'urlFormat' => 'path',
    'showScriptName' => false,
    'rules' => array(
        'gii' => 'gii',
        'gii/<controller:\w+>' => 'gii/<controller>',
        'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',
		
		'terms' => 'site/page/view/terms',
		'privacy' => 'site/page/view/privacy',
		'tour' => 'site/page/view/tour',
		'about' => 'site/page/view/about',
		'contact' => 'site/contact',
		
		array('class' => 'agency.components.AgenciesUrlRule'),
		
        '<controller:\w+>/<id:\d+>' => '<controller>/view',
        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        '<controller:\w+>' => '<controller>/index'
    ),
);