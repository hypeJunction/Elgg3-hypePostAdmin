define(function (require) {

	var Vue = require('elgg/Vue');

	var template = require('text!admin/post/admin/components/Item.html');

	Vue.component('post-admin-item', {
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
				isEditing: false,
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
			deleteItem: function () {
				this.$emit('delete');
			},

			toggleForm: function () {
				this.isEditing = this.isEditing ? false : true;
			}
		},
		computed: {
			fieldTypeOptions: function () {
				return this.fieldTypes.map(function (e) {
					return {
						value: e.type,
						label: e.label,
					}
				});
			}
		},
		watch: {
			item: {
				deep: true,
				handler: function () {
					this.item.name = this.item.name.toString()
						.replace(/([A-Z])/g, ' $1')
						.trim()
						.toLowerCase()
						.replace(/[ -]/g, '_')
				}
			}
		}
	});

});