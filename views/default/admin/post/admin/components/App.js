define(function (require) {

	var Ajax = require('elgg/Ajax');
	var Vue = require('elgg/Vue');

	var template = require('text!admin/post/admin/components/App.html');

	Vue.component('post-admin-app', {
		template: template,
		props: {
			formName: {
				type: String
			},
			sectionData: {
				type: Array
			},
			fieldTypes: {
				type: Array,
			}
		},
		data: function () {
			return {
				sections: this.sectionData,
				loading: false
			};
		},
		methods: {
			addSection: function () {
				this.sections.push({
					name: 'custom' + this.sections.length,
					items: []
				});
			},
			save: function () {
				var ajax = new Ajax();

				this.loading = true;

				ajax.action('post/admin/save', {
					data: {
						name: this.formName,
						sections: JSON.stringify(this.sections)
					}
				}).done(function () {
					this.loading = false;
				}).fail(function () {
					this.loading = false;
				});
			}
		}
	});

});