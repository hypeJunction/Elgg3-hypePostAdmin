<?php

namespace hypeJunction\PostAdmin;

use Elgg\Event;
use Elgg\IntegrationTestCase;

class ConfigureFieldTypesTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypepostadmin';
	}

	public function up(): void {}

	public function down(): void {}

	private function makeEvent($value = null): Event {
		$event = $this->getMockBuilder(Event::class)
			->disableOriginalConstructor()
			->getMock();
		$event->method('getValue')->willReturn($value);

		return $event;
	}

	private function invoke(): array {
		$handler = new ConfigureFieldTypes();

		return $handler($this->makeEvent());
	}

	private function findType(array $types, string $type): ?array {
		foreach ($types as $entry) {
			if (($entry['type'] ?? null) === $type) {
				return $entry;
			}
		}

		return null;
	}

	public function testReturnsArrayOfFieldTypes(): void {
		$types = $this->invoke();
		$this->assertIsArray($types);
		$this->assertNotEmpty($types);
	}

	public function testRegistersBaseFieldTypes(): void {
		$types = $this->invoke();
		$names = array_filter(array_column($types, 'type'));

		foreach (['text', 'plaintext', 'longtext', 'select', 'checkboxes', 'boolean', 'number', 'email', 'url', 'date', 'time', 'tags'] as $expected) {
			$this->assertContains($expected, $names, "Missing field type: $expected");
		}
	}

	public function testEachFieldTypeHasLabel(): void {
		foreach ($this->invoke() as $entry) {
			$this->assertArrayHasKey('label', $entry);
			$this->assertIsString($entry['label']);
		}
	}

	public function testEachFieldTypeHasCallableAdapter(): void {
		foreach ($this->invoke() as $entry) {
			$this->assertArrayHasKey('adapter', $entry);
			$this->assertIsCallable($entry['adapter']);
		}
	}

	public function testSelectAcceptsMultipleOptions(): void {
		$select = $this->findType($this->invoke(), 'select');
		$this->assertNotNull($select);
		$this->assertTrue($select['config']['has_options']);
		$this->assertTrue($select['config']['accepts_multiple']);
	}

	public function testCheckboxesAcceptsMultipleOptions(): void {
		$cb = $this->findType($this->invoke(), 'checkboxes');
		$this->assertNotNull($cb);
		$this->assertTrue($cb['config']['has_options']);
		$this->assertTrue($cb['config']['accepts_multiple']);
	}

	public function testOptionalPluginTypesAreOmittedWhenInactive(): void {
		$names = array_filter(array_column($this->invoke(), 'type'));
		$this->assertNotContains('attachments', $names);
		$this->assertNotContains('captcha', $names);
		$this->assertNotContains('country', $names);
		$this->assertNotContains('address', $names);
	}

	public function testPreservesExistingFieldTypesFromEventValue(): void {
		$handler = new ConfigureFieldTypes();
		$existing = [['type' => 'pre-existing', 'label' => 'Pre', 'config' => [], 'adapter' => fn() => null]];

		$result = $handler($this->makeEvent($existing));
		$this->assertSame('pre-existing', $result[0]['type']);
		$this->assertGreaterThan(1, count($result));
	}
}
