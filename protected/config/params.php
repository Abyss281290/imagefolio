<?php
// application-level parameters that can be accessed
// using Yii::app()->params['noAvatarImage']

return array(
    // displayed in the header section
	//'title' => 'ImageFolio',
    'developerTitle'=>'Net Tech Engineering Ltd.',
    'ajaxLoader' => 'images/ajax-loader.gif',
	
    //'adminEmail'=> 'sleepw@ukr.net', // admin && mail for error pages
    'noreplyEmail' => 'noreply@imagefolio.net', // no-reply address
    'contactEmail' => 'info@imagefolio.net', // contact to
	'agencyRegistrationFromEmail' => 'registration@imagefolio.net', // registration confirm from email
	
    // USERS
    'pathAvatar' => 'images/avatar',
	'fullSizeAvatar' => '600x600',
    'thumbSizeAvatar' => '250x250',
    'chatSizeAvatar' => '20x20',
    'noAvatarImage' => '/images/no_avatar.png',
	
    // CACHE
    'durationCache' => 60*60, // keep the value in cache for at most 30 minutes
	
	'imageStatusOn' => 'images/light_on.png',
    'imageStatusOff' => 'images/light_off.png',
	
	/**
	 * jquery visual editor
	 * @see /extensions/imperavi
	 */
	'imperavi' => array(
		'imagesPath' => 'images/editor'
	)
);