<?php

namespace hypeJunction\PostAdmin;

use Elgg\Event;
use Elgg\IntegrationTestCase;
use Elgg\Menu\MenuItems;

class PageMenuTest extends IntegrationTestCase {

	public function getPluginID(): string {
		return 'hypepostadmin';
	}

	private $registeredFieldsHandler;

	public function up(): void {
		$this->registeredFieldsHandler = function () {
			return null;
		};
		elgg_register_event_handler('fields', 'object:test_form', $this->registeredFieldsHandler);
	}

	public function down(): void {
		if ($this->registeredFieldsHandler) {
			elgg_unregister_event_handler('fields', 'object:test_form', $this->registeredFieldsHandler);
			$this->registeredFieldsHandler = null;
		}
	}

	private function makeEvent(MenuItems $items): Event {
		$event = $this->getMockBuilder(Event::class)
			->disableOriginalConstructor()
			->getMock();
		$event->method('getValue')->willReturn($items);
		$event->method('elgg')->willReturn(elgg());

		return $event;
	}

	public function testAddsParentMenuItem(): void {
		$handler = new PageMenu();
		$items = new MenuItems();

		$handler($this->makeEvent($items));

		$found = false;
		foreach ($items as $item) {
			if ($item->getName() === 'post_admin') {
				$found = true;
				break;
			}
		}
		$this->assertTrue($found, 'post_admin parent menu item not added');
	}

	public function testAddsChildMenuItemForEachRegisteredFieldsHandler(): void {
		$handler = new PageMenu();
		$items = new MenuItems();

		$handler($this->makeEvent($items));

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
		$handler = new PageMenu();
		$items = new MenuItems();

		$handler($this->makeEvent($items));

		foreach ($items as $item) {
			$this->assertNotSame('post_admin:all', $item->getName(), '"all" form should be skipped');
		}
	}
}
