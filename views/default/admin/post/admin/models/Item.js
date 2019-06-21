define(function (require) {
	return function () {
		return {
			type: 'text',
			name: '',
			'#label': '',
			'#help': '',
			'placeholder': '',
			is_create_field: true,
			is_edit_field: true,
			is_profile_field: true,
			is_admin_field: false,
			is_editable: true,
			is_export_field: false,
			is_search_field: false,
			width: 6,
			options: [],
			vars: [],
		};
	};
});