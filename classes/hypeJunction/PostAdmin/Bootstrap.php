<?php

namespace hypeJunction\PostAdmin;

use Elgg\PluginBootstrap;

/**
 * Bootstrap class.
 */
class Bootstrap extends PluginBootstrap {

	/**
	 * {@inheritdoc}
	 */
	public function load() {
	}

	/**
	 * {@inheritdoc}
	 */
	public function boot() {
	}

	/**
	 * {@inheritdoc}
	 */
	public function init() {
		\elgg_register_plugin_hook_handler('register', 'menu:page', PageMenu::class);

		\elgg_register_plugin_hook_handler('field_types', 'post', ConfigureFieldTypes::class);
		\elgg_register_plugin_hook_handler('fields', 'all', SetFields::class);

		// (4.x) elgg_register_css removed. The simplecache view
		// admin/post/admin/app.css is loaded directly from the admin
		// page template via elgg_require_css('admin/post/admin/app').
	}

	/**
	 * {@inheritdoc}
	 */
	public function ready() {
	}

	/**
	 * {@inheritdoc}
	 */
	public function shutdown() {
	}

	/**
	 * {@inheritdoc}
	 */
	public function activate() {
	}

	/**
	 * {@inheritdoc}
	 */
	public function deactivate() {
	}

	/**
	 * {@inheritdoc}
	 */
	public function upgrade() {
	}
}
