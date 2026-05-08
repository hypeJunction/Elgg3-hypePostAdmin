<?php

namespace hypeJunction\PostAdmin;

use Elgg\Event;
use hypeJunction\Fields\Collection;
use hypeJunction\Fields\Field;

class SetFields {

	protected $field_types;

	public function __invoke(Event $event) {

		$entity = $event->getEntityParam();

		if (!$entity instanceof \ElggEntity) {
			return null;
		}

		$fields = $event->getValue();

		$form = $event->getType();
		$sections = elgg_get_config("form:$form");

		if (empty($sections)) {
			return null;
		}

		foreach ($sections as $section) {
			$section_name = $section['name'];
			$section_items = $section['items'];
			$i = 0;

			foreach ($section_items as $item) {
				$item['section'] = $section_name;
				$item['priority'] = 600 + $i;

				$name = $item['name'];
				$field = $this->adaptField($item, $entity);

				if ($name && $field instanceof Field) {
					$fields->add($item['name'], $field);
				}

				$i++;
			}
		}

		return $fields;
	}

	public function adaptField($field, $entity) {
		if (!$this->field_types) {
			$this->field_types = elgg_trigger_event_results('field_types', 'post', [], []);
		}

		$type = $field['type'] ?: 'text';

		foreach ($this->field_types as $definition) {
			if ($definition['type'] === $type) {
				$vars = $field['vars'];
				unset($field['vars']);

				$params = $field;

				foreach ($vars as $var) {
					$name = $var['name'];
					$value = $var['value'];

					$params[$name] = $value;
				}

				foreach (['#label', '#help', 'placeholder'] as $prop) {
					if (!$params[$prop]) {
						unset($params[$prop]);
					}
				}

				return call_user_func($definition['adapter'], $params, $entity);
			}
		}

		return null;
	}
}
