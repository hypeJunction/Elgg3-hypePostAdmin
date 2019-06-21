<?php

namespace hypeJunction\PostAdmin;

use Elgg\HooksRegistrationService\Hook;

class PageMenu {
	public function __invoke(Hook $hook) {
		$menu = $hook->getValue();
		/* @var $menu \Elgg\Menu\MenuItems */

		$menu->add(\ElggMenuItem::factory([
			'name' => 'post_admin',
			'section' => 'configure',
			'href' => false,
			'text' => elgg_echo("post_admin:schemas"),
			'context' => ['admin'],
		]));

		$handlers = $hook->elgg()->hooks->getAllHandlers();

		$forms = array_keys($handlers['fields']);

		foreach ($forms as $form) {
			if (in_array($form, ['all'])) {
				continue;
			}

			$menu->add(\ElggMenuItem::factory([
				'name' => "post_admin:$form",
				'section' => 'configure',
				'href' => elgg_http_add_url_query_elements('admin/post/admin', [
					'form' => $form
				]),
				'text' => elgg_echo("item:{$form}"),
				'parent_name' => 'post_admin',
				'context' => ['admin'],
			]));
		}
	}
}