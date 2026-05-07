<?php

namespace hypeJunction\PostAdmin;

use Elgg\IntegrationTestCase;

class SetFieldsTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypepostadmin';
	}

	public function up(): void {}

	public function down(): void {}

	private function makeHook($value, $entity, string $type = 'user'): \Elgg\HooksRegistrationService\Hook {
		$hook = $this->getMockBuilder(\Elgg\HooksRegistrationService\Hook::class)
			->disableOriginalConstructor()
			->getMock();
		$hook->method('getValue')->willReturn($value);
		$hook->method('getEntityParam')->willReturn($entity);
		$hook->method('getType')->willReturn($type);

		return $hook;
	}

	public function testReturnsNullWhenEntityIsNotElggEntity(): void {
		$handler = new SetFields();
		$result = $handler($this->makeHook([], null));
		$this->assertNull($result);
	}

	public function testReturnsNullWhenNoSectionsConfigured(): void {
		$handler = new SetFields();
		$user = $this->createUser();
		$fields = $this->getMockBuilder(\hypeJunction\Fields\Collection::class)
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();

		$result = $handler($this->makeHook($fields, $user, 'unique_form_no_config_xyz'));
		$this->assertNull($result);
	}

	public function testAdaptFieldReturnsNullForUnknownType(): void {
		$handler = new SetFields();
		$user = $this->createUser();
		// adaptField triggers the field_types/post hook to populate $field_types,
		// then returns null when no definition matches.
		$result = $handler->adaptField(['type' => '__no_such_type__', 'name' => 'x', 'vars' => []], $user);
		$this->assertNull($result);
	}
}
