<?php
return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    'admin' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Admin',
        'children' => array(
            'guest',
            'user',
        ),
        'bizRule' => null,
        'data' => null
    ),
	'agency' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Agency',
        'children' => array(
            'guest',
            'user',
        ),
        'bizRule' => null,
        'data' => null
    ),
	'booker' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Booker',
        'children' => array(
            'guest',
            'user',
        ),
        'bizRule' => null,
        'data' => null
    ),
);