<?php

namespace hypeJunction\PostAdmin;

use Elgg\Event;
use Elgg\IntegrationTestCase;

class SetFieldsTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypepostadmin';
	}

	public function up(): void {}

	public function down(): void {}

	private function makeEvent($value, $entity, string $type = 'user'): Event {
		$event = $this->getMockBuilder(Event::class)
			->disableOriginalConstructor()
			->getMock();
		$event->method('getValue')->willReturn($value);
		$event->method('getEntityParam')->willReturn($entity);
		$event->method('getType')->willReturn($type);

		return $event;
	}

	public function testReturnsNullWhenEntityIsNotElggEntity(): void {
		$handler = new SetFields();
		$result = $handler($this->makeEvent([], null));
		$this->assertNull($result);
	}

	public function testReturnsNullWhenNoSectionsConfigured(): void {
		$handler = new SetFields();
		$user = $this->createUser();
		$fields = $this->getMockBuilder(\hypeJunction\Fields\Collection::class)
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();

		$result = $handler($this->makeEvent($fields, $user, 'unique_form_no_config_xyz'));
		$this->assertNull($result);
	}

	public function testAdaptFieldReturnsNullForUnknownType(): void {
		$handler = new SetFields();
		$user = $this->createUser();
		$result = $handler->adaptField(['type' => '__no_such_type__', 'name' => 'x', 'vars' => []], $user);
		$this->assertNull($result);
	}
}
