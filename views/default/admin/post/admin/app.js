define(function(require) {
	var Vue = require('elgg/Vue');

	require('elgg/components/Draggable');
	require('elgg/components/Icon');
	require('elgg/components/InputText');
	require('elgg/components/InputSelect');
	require('elgg/components/InputRadio');
	require('elgg/components/InputGuids');
	require('elgg/components/InputContentEditable');
	require('elgg/components/Button');

	require('admin/post/admin/components/App');
	require('admin/post/admin/components/Section');
	require('admin/post/admin/components/Item');
	require('admin/post/admin/components/Form');

	var vm = new Vue({
		el: '#post-admin-app'
	});

	return vm;
});