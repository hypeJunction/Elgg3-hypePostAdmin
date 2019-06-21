<?php

return [
	'bootstrap' => \hypeJunction\PostAdmin\Bootstrap::class,

	'actions' => [
		'post/admin/save' => [
			'controller' => \hypeJunction\PostAdmin\SavePostSchema::class,
			'access' => 'admin',
		]
	],
];
