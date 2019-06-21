define(function (require) {

	var Vue = require('elgg/Vue');

	var template = require('text!admin/post/admin/components/Section.html');

	var ItemModel = require('admin/post/admin/models/Item');

	Vue.component('post-admin-section', {
		template: template,
		props: {
			section: {
				type: Object
			},
			fieldTypes: {
				type: Array,
			}
		},
		data: function () {
			return {
				draggableOptions: {
					handle: '.post-admin__handle',
					group: {
						name: 'admin-fields'
					},
					animation: 150
				}
			};
		},
		methods: {
			addItem: function () {
				this.section.items.push(ItemModel());
			},
			deleteItem: function (index) {
				Vue.delete(this.section.items, index);
			}
		}
	});

});