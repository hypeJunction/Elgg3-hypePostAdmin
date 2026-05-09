import Vue from 'elgg/Vue';

import 'elgg/components/Draggable';
import 'elgg/components/Icon';
import 'elgg/components/InputText';
import 'elgg/components/InputSelect';
import 'elgg/components/InputRadio';
import 'elgg/components/InputGuids';
import 'elgg/components/InputContentEditable';
import 'elgg/components/Button';

import 'admin/post/admin/components/App';
import 'admin/post/admin/components/Section';
import 'admin/post/admin/components/Item';
import 'admin/post/admin/components/Form';

const vm = new Vue({
	el: '#post-admin-app'
});

export default vm;
