<?php

namespace hypeJunction\PostAdmin;

use Elgg\IntegrationTestCase;

class BootstrapTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypepostadmin';
	}

	public function up(): void {
		$plugin = \elgg_get_plugin_from_id('hypepostadmin');
		$plugin->getBootstrap()->init();
	}

	public function down(): void {
		\elgg_unregister_plugin_hook_handler('register', 'menu:page', PageMenu::class);
		\elgg_unregister_plugin_hook_handler('field_types', 'post', ConfigureFieldTypes::class);
		\elgg_unregister_plugin_hook_handler('fields', 'all', SetFields::class);
	}

	public function testPluginIsActive(): void {
		$plugin = \elgg_get_plugin_from_id('hypepostadmin');
		$this->assertInstanceOf(\ElggPlugin::class, $plugin);
		$this->assertTrue($plugin->isActive());
	}

	public function testBootstrapClassResolves(): void {
		$plugin = \elgg_get_plugin_from_id('hypepostadmin');
		$bootstrap = $plugin->getBootstrap();
		$this->assertInstanceOf(Bootstrap::class, $bootstrap);
	}

	public function testBootstrapInitRunsWithoutError(): void {
		$plugin = \elgg_get_plugin_from_id('hypepostadmin');
		$bootstrap = $plugin->getBootstrap();
		$bootstrap->load();
		$bootstrap->init();
		$bootstrap->ready();
		$bootstrap->shutdown();
		$this->assertTrue(true);
	}

	public function testSavePostSchemaActionIsRegistered(): void {
		$actions = \_elgg_services()->actions->getAllActions();
		$this->assertArrayHasKey('post/admin/save', $actions);
		$this->assertSame('admin', $actions['post/admin/save']['access']);
	}

	public function testPageMenuHookHandlerExists(): void {
		$this->assertTrue(\_elgg_services()->hooks->hasHandler('register', 'menu:page'));
	}

	public function testFieldTypesHookHandlerExists(): void {
		$this->assertTrue(\_elgg_services()->hooks->hasHandler('field_types', 'post'));
	}

	public function testFieldsHookHandlerExists(): void {
		$this->assertTrue(\_elgg_services()->hooks->hasHandler('fields', 'all'));
	}

	public function testAdminPostAdminViewExists(): void {
		$this->assertTrue(\elgg_view_exists('admin/post/admin'));
	}

	public function testAppCssViewExists(): void {
		$this->assertTrue(\elgg_view_exists('admin/post/admin/app.css'));
	}

	public function testAppJsViewExists(): void {
		$this->assertTrue(\elgg_view_exists('admin/post/admin/app.js'));
	}
}
