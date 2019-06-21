<?php

namespace hypeJunction\PostAdmin;

use Elgg\Hook;
use hypeJunction\Fields\Collection;
use hypeJunction\Fields\Field;

class SetFields {

	protected $field_types;

	/**
	 * Setup group fields
	 *
	 * @param Hook $hook Hook
	 *
	 * @return array|null
	 * @throws \InvalidParameterException
	 */
	public function __invoke(Hook $hook) {

		$entity = $hook->getEntityParam();

		if (!$entity instanceof \ElggEntity) {
			return null;
		}

		$fields = $hook->getValue();
		/* @var $fields Collection */

		$form = $hook->getType();
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

	/**
	 * Adapt field definition to a field declaration
	 *
	 * @param array $field
	 * @param $entity
	 *
	 * @return Field|null
	 */
	public function adaptField($field, $entity) {
		if (!$this->field_types) {
			$this->field_types = elgg_trigger_plugin_hook('field_types', 'post', [], []);
		}

		$type = $field['type'] ? : 'text';

		foreach ($this->field_types as $definition) {
			if ($definition['type'] === $type) {
				$vars = $field['vars'];
				unset($field_vars);

				$params = array_merge($vars, $field);

				foreach (['#label', '#help', 'placeholder'] as $prop) {
					if (!$params[$prop]) {
						// Let the API use translation keys
						unset($params[$prop]);
					}
				}

				return call_user_func($definition['adapter'], $params, $entity);
			}
		}

		return null;
	}
}