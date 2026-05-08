<?php

return [
	'plugin' => [
		'version' => '5.0.0',
	],
	'bootstrap' => \hypeJunction\PostAdmin\Bootstrap::class,

	'actions' => [
		'post/admin/save' => [
			'controller' => \hypeJunction\PostAdmin\SavePostSchema::class,
			'access' => 'admin',
		]
	],

	'events' => [
		'register' => [
			'menu:page' => [\hypeJunction\PostAdmin\PageMenu::class => []],
		],
		'field_types' => [
			'post' => [\hypeJunction\PostAdmin\ConfigureFieldTypes::class => []],
		],
		'fields' => [
			'all' => [\hypeJunction\PostAdmin\SetFields::class => []],
		],
	],
];
