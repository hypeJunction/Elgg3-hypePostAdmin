<?php

$form = get_input('form');

if (!$form) {
	throw new \Elgg\Exceptions\Http\BadRequestException();
}

echo elgg_format_element('h2', [], elgg_echo("item:$form"));

$default_data = [
	[
		'name' => 'content',
		'items' => [],
	],
	[
		'name' => 'sidebar',
		'items' => [],
	],
];

$data = elgg_get_config("form:$form") ?: $default_data;

$field_types = elgg_trigger_event('field_types', 'post', []);

$loader = elgg_format_element('div', [
	'class' => 'elgg-ajax-loader',
]);

echo elgg_format_element('post-admin-app', [
	'id' => 'post-admin-app',
	':section-data' => json_encode(array_values($data), JSON_OBJECT_AS_ARRAY),
	':field-types' => json_encode(array_values($field_types), JSON_OBJECT_AS_ARRAY),
	'form-name' => $form,
], $loader);

elgg_import_esm('admin/post/admin/app');


