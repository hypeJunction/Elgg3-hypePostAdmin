<?php

namespace hypeJunction\PostAdmin;

use Elgg\IntegrationTestCase;

class BootstrapTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypepostadmin';
	}

	public function up(): void {}

	public function down(): void {}

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

	public function testSavePostSchemaActionIsRegistered(): void {
		$actions = \_elgg_services()->actions->getAllActions();
		$this->assertArrayHasKey('post/admin/save', $actions);
		$this->assertSame('admin', $actions['post/admin/save']['access']);
	}

	public function testPageMenuEventHandlerExists(): void {
		$this->assertTrue(\_elgg_services()->events->hasHandler('register', 'menu:page'));
	}

	public function testFieldTypesEventHandlerExists(): void {
		$this->assertTrue(\_elgg_services()->events->hasHandler('field_types', 'post'));
	}

	public function testFieldsEventHandlerExists(): void {
		$this->assertTrue(\_elgg_services()->events->hasHandler('fields', 'all'));
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
