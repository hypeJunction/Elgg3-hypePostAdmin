<?php

namespace hypeJunction\PostAdmin;

use Elgg\HooksRegistrationService\Hook;
use hypeJunction\Attachments\AttachmentsField;
use hypeJunction\Countries\AddressField;
use hypeJunction\Fields\BooleanField;
use hypeJunction\Fields\CustomHtml;
use hypeJunction\Fields\MetaField;
use hypeJunction\Fields\TagsField;

class ConfigureFieldTypes {

	public function __invoke(Hook $hook) {
		$field_types = $hook->getValue() ? : [];

		$field_types[] = [
			'type' => 'text',
			'label' => elgg_echo('post:admin:type:text'),
			'config' => [],
			'adapter' => function ($params) {
				return new MetaField($params);
			}
		];

		$field_types[] = [
			'type' => 'plaintext',
			'label' => elgg_echo('post:admin:type:plaintext'),
			'config' => [],
			'adapter' => function ($params) {
				return new MetaField($params);
			}
		];

		$field_types[] = [
			'type' => 'longtext',
			'label' => elgg_echo('post:admin:type:longtext'),
			'config' => [],
			'adapter' => function ($params) {
				return new MetaField($params);
			}
		];

		$field_types[] = [
			'type' => 'select',
			'label' => elgg_echo('post:admin:type:select'),
			'config' => [
				'has_options' => true,
				'accepts_multiple' => true,
			],
			'adapter' => function ($params) {
				$options = $params['options'];
				$params['options'] = [];
				$params['options_values'] = [];

				foreach ($options as $option) {
					$label = $option['label'];
					$value = $option['value'];

					$params['options_values'][$value] = $label;
				}

				return new MetaField($params);
			},
		];

		$field_types[] = [
			'type' => 'checkboxes',
			'label' => elgg_echo('post:admin:type:checkboxes'),
			'config' => [
				'has_options' => true,
				'accepts_multiple' => true,
			],
			'adapter' => function ($params) {
				if (!$params['multiple']) {
					$params['type'] = 'radio';
				}

				$options = $params['options'];
				$params['options'] = [];

				foreach ($options as $option) {
					$label = $option['label'];
					$value = $option['value'];

					$params['options'][$label] = $value;
				}

				return new MetaField($params);
			},
		];

		$field_types[] = [
			'type' => 'boolean',
			'label' => elgg_echo('post:admin:type:boolean'),
			'config' => [],
			'adapter' => function ($params) {
				$params['type'] = 'checkbox';

				return new BooleanField($params);
			},
		];

		$field_types[] = [
			'type' => 'number',
			'label' => elgg_echo('post:admin:type:number'),
			'config' => [],
			'adapter' => function ($params) {
				return new MetaField($params);
			},
		];

		$field_types[] = [
			'#type' => 'text',
			'type' => 'email',
			'label' => elgg_echo('post:admin:type:email'),
			'config' => [],
			'adapter' => function ($params) {
				return new MetaField($params);
			},
		];

		$field_types[] = [
			'#type' => 'text',
			'type' => 'url',
			'label' => elgg_echo('post:admin:type:url'),
			'config' => [],
			'adapter' => function ($params) {
				return new MetaField($params);
			},
		];

		$field_types[] = [
			'type' => 'date',
			'label' => elgg_echo('post:admin:type:date'),
			'config' => [],
			'adapter' => function ($params) {
				$params['timestamp'] = true;

				return new MetaField($params);
			},
		];

		$field_types[] = [
			'type' => 'time',
			'label' => elgg_echo('post:admin:type:time'),
			'config' => [],
			'adapter' => function ($params) {
				return new MetaField($params);
			},
		];

		$field_types[] = [
			'type' => 'tags',
			'label' => elgg_echo('post:admin:type:tags'),
			'config' => [],
			'adapter' => function ($params) {
				return new TagsField($params);
			},
		];

		if (elgg_is_active_plugin('hypeAttachments')) {
			$field_types[] = [
				'type' => 'attachments',
				'label' => elgg_echo('post:admin:type:attachments'),
				'config' => [
					'accepts_multiple' => true,
				],
				'adapter' => function ($params) {
					return new AttachmentsField($params);
				}
			];
		}

		if (elgg_is_active_plugin('hypeAutocomplete')) {
			$field_types[] = [
				'#type' => 'guids',
				'options' => [
					'type' => 'user',
				],
				'label' => elgg_echo('post:admin:type:users'),
				'config' => [
					'accepts_multiple' => true,
				],
				'adapter' => function ($params) {
					return new MetaField($params);
				}
			];
		}

		if (elgg_is_active_plugin('hypeAutocomplete')) {
			$field_types[] = [
				'#type' => 'guids',
				'options' => [
					'type' => 'group',
				],
				'label' => elgg_echo('post:admin:type:groups'),
				'config' => [
					'accepts_multiple' => true,
				],
				'adapter' => function ($params) {
					return new MetaField($params);
				}
			];
		}

		if (elgg_is_active_plugin('hypeCaptcha')) {
			$field_types[] = [
				'type' => 'captcha',
				'label' => elgg_echo('post:admin:type:captcha'),
				'config' => [],
				'adapter' => function ($params) {
					$params['#html'] = function () use ($params) {
						return elgg_view('input/captcha', $params);
					};

					return new CustomHtml($params);
				}
			];
		}

		if (elgg_is_active_plugin('hypeCountries')) {
			$field_types[] = [
				'type' => 'country',
				'label' => elgg_echo('post:admin:type:country'),
				'config' => [],
				'adapter' => function ($params) {
					return new MetaField($params);
				}
			];

			$field_types[] = [
				'type' => 'address',
				'label' => elgg_echo('post:admin:type:address'),
				'config' => [],
				'adapter' => function ($params) {
					return new AddressField($params);
				}
			];
		}

		return $field_types;
	}
}