<?php

namespace hypeJunction\PostAdmin\Views;

use Elgg\Exceptions\Http\BadRequestException;
use Elgg\IntegrationTestCase;

class AdminViewTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypepostadmin';
	}

	public function up(): void {}

	public function down(): void {}

	public function testAppCssRendersStyleRules(): void {
		$css = \elgg_view('admin/post/admin/app.css');
		$this->assertIsString($css);
		$this->assertNotEmpty($css);
	}

	public function testAppJsRenders(): void {
		$js = \elgg_view('admin/post/admin/app.js');
		$this->assertIsString($js);
		$this->assertNotEmpty($js);
	}

	public function testAdminViewThrowsBadRequestWithoutFormParam(): void {
		$this->expectException(BadRequestException::class);
		set_input('form', null);
		\elgg_view('admin/post/admin');
	}

	public function testAdminViewRendersWithFormParam(): void {
		set_input('form', 'object:phpunit_test_form');
		$output = \elgg_view('admin/post/admin');
		$this->assertIsString($output);
		$this->assertStringContainsString('post-admin-app', $output);
		set_input('form', null);
	}
}
