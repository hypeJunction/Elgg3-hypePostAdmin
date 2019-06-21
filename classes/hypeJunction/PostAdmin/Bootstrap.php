<?php

namespace hypeJunction\PostAdmin;

use Elgg\PluginBootstrap;

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
		elgg_register_plugin_hook_handler('register', 'menu:page', PageMenu::class);

		elgg_register_plugin_hook_handler('field_types', 'post', ConfigureFieldTypes::class);
		elgg_register_plugin_hook_handler('fields', 'all', SetFields::class);

		elgg_register_css('post-admin-app', elgg_get_simplecache_url('admin/post/admin/app.css'));
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