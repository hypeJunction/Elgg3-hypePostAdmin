<?php

namespace hypeJunction\PostAdmin;

use Elgg\Event;

/**
 * Builds the admin page menu entries for post admin schemas.
 */
class PageMenu {

	/**
	 * Add menu items for each registered form schema.
	 *
	 * @param Event $event "register", "menu:page" event
	 *
	 * @return void
	 */
	public function __invoke(Event $event) {
		$menu = $event->getValue();

		$menu->add(\ElggMenuItem::factory([
			'name' => 'post_admin',
			'section' => 'configure',
			'href' => false,
			'text' => elgg_echo('post_admin:schemas'),
			'context' => ['admin'],
		]));

		$handlers = $event->elgg()->events->getAllHandlers();

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
