define(function (require) {

	var elgg = require('elgg');
	var Vue = require('elgg/Vue');

	var template = require('text!admin/post/admin/components/Form.html');

	Vue.component('post-admin-form', {
		template: template,
		props: {
			item: {
				type: Object
			},
			fieldTypes: {
				type: Array,
			}
		},
		data: function () {
			return {
				confProps: [
					'is_create_field',
					'is_edit_field',
					'is_profile_field',
					'is_admin_field',
					'is_editable',
					'is_export_field',
					'is_searchable',
				],
			};
		},

		computed: {
			fieldType: function () {
				var item = this.item;

				return this.fieldTypes.find(function (e) {
					return e.type === item.type;
				});
			},

			extension: function () {
				var view = 'post-admin-field-' + this.item.type;

				if (Vue.options.components[view]) {
					return view;
				}

				return 'div';
			}
		},

		methods: {
			addOption: function () {
				this.item.options.push({
					label: null,
					value: null,
				});
			},

			addVar: function () {
				this.item.vars.push({
					name: null,
					value: null,
				});
			}
		}
	});
});