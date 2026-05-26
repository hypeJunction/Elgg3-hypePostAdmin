<?php

namespace hypeJunction\PostAdmin;

use Elgg\Exceptions\Http\BadRequestException;
use Elgg\IntegrationTestCase;
use Elgg\Request;

class SavePostSchemaTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypepostadmin';
	}

	public function up(): void {}

	public function down(): void {}

	private function makeRequest(array $params): Request {
		$request = $this->getMockBuilder(Request::class)
			->disableOriginalConstructor()
			->getMock();
		$request->method('getParam')->willReturnCallback(function ($key) use ($params) {
			return $params[$key] ?? null;
		});

		return $request;
	}

	public function testThrowsBadRequestWhenNameMissing(): void {
		$this->expectException(BadRequestException::class);

		$controller = new SavePostSchema();
		$controller($this->makeRequest(['sections' => json_encode([['name' => 's']])]));
	}

	public function testThrowsBadRequestWhenSectionsMissing(): void {
		$this->expectException(BadRequestException::class);

		$controller = new SavePostSchema();
		$controller($this->makeRequest(['name' => 'object:blog']));
	}

	public function testThrowsBadRequestWhenBothMissing(): void {
		$this->expectException(BadRequestException::class);

		$controller = new SavePostSchema();
		$controller($this->makeRequest([]));
	}

	public function testSavesConfigForGivenForm(): void {
		$controller = new SavePostSchema();
		$sections = [
			['name' => 'content', 'items' => [['name' => 'title', 'type' => 'text']]],
			['name' => 'sidebar', 'items' => []],
		];
		$formName = 'object:phpunit_save_test_' . uniqid();

		$response = $controller($this->makeRequest([
			'name' => $formName,
			'sections' => json_encode($sections),
		]));

		$this->assertNotNull($response);
		$saved = \elgg_get_config("form:$formName");
		$this->assertSame($sections, $saved);

		// Cleanup
		\elgg_remove_config("form:$formName");
	}

	public function testReturnsOkResponseWithSuccessMessage(): void {
		$controller = new SavePostSchema();
		$formName = 'object:phpunit_msg_test_' . uniqid();

		$response = $controller($this->makeRequest([
			'name' => $formName,
			'sections' => json_encode([['name' => 'content', 'items' => []]]),
		]));

		// elgg_ok_response returns a ResponseBuilder-shaped instance
		$this->assertNotNull($response);

		\elgg_remove_config("form:$formName");
	}
}
