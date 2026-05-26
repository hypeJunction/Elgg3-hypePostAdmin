<?php

namespace hypeJunction\PostAdmin;

use Elgg\IntegrationTestCase;
use Elgg\Menu\MenuItems;

class PageMenuTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypepostadmin';
	}

	private $registeredFieldsHook;

	public function up(): void {
		// Need at least one entry under hooks['fields'] so the handler iterates.
		$this->registeredFieldsHook = function () {
			return null;
		};
		\elgg_register_plugin_hook_handler('fields', 'object:test_form', $this->registeredFieldsHook);
	}

	public function down(): void {
		if ($this->registeredFieldsHook) {
			\elgg_unregister_plugin_hook_handler('fields', 'object:test_form', $this->registeredFieldsHook);
			$this->registeredFieldsHook = null;
		}
	}

	private function makeHook(MenuItems $items): \Elgg\HooksRegistrationService\Hook {
		$hook = $this->getMockBuilder(\Elgg\HooksRegistrationService\Hook::class)
			->disableOriginalConstructor()
			->getMock();
		$hook->method('getValue')->willReturn($items);
		$hook->method('elgg')->willReturn(elgg());

		return $hook;
	}

	public function testAddsParentMenuItem(): void {
		$handler = new PageMenu();
		$items = new MenuItems();

		$handler($this->makeHook($items));

		$found = false;
		foreach ($items as $item) {
			if ($item->getName() === 'post_admin') {
				$found = true;
				break;
			}
		}
		$this->assertTrue($found, 'post_admin parent menu item not added');
	}

	public function testAddsChildMenuItemForEachRegisteredFieldsHook(): void {
		$handler = new PageMenu();
		$items = new MenuItems();

		$handler($this->makeHook($items));

		$childFound = false;
		foreach ($items as $item) {
			if ($item->getName() === 'post_admin:object:test_form') {
				$childFound = true;
				$this->assertSame('post_admin', $item->getParentName());
				$this->assertContains('admin', (array) $item->getContext());
				break;
			}
		}
		$this->assertTrue($childFound, 'Expected child menu item post_admin:object:test_form');
	}

	public function testSkipsAllMetaForm(): void {
		// SetFields registers fields/all — handler should skip the 'all' entry.
		$handler = new PageMenu();
		$items = new MenuItems();

		$handler($this->makeHook($items));

		foreach ($items as $item) {
			$this->assertNotSame('post_admin:all', $item->getName(), '"all" form should be skipped');
		}
	}
}
