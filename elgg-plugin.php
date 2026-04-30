<?php

return [
	'plugin' => [
		'version' => '4.0.0',
	],
	'bootstrap' => \hypeJunction\PostAdmin\Bootstrap::class,

	'actions' => [
		'post/admin/save' => [
			'controller' => \hypeJunction\PostAdmin\SavePostSchema::class,
			'access' => 'admin',
		]
	],
];
