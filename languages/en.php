<?php

return [
	'admin:post' => 'Posts',
	'admin:post:admin' => 'Manage Form Fields',

	'post_admin:schemas' => 'Form Fields',

	'post:admin:add_section' => 'Add Section',
	'post:admin:add_item' => 'Add Field',

	'post:admin:is_create_field' => 'Show on Add form',
	'post:admin:is_edit_field' => 'Show on Edit form',
	'post:admin:is_admin_field' => 'Admin-only field',
	'post:admin:is_editable' => 'Allow subsequent edits',
	'post:admin:is_profile_field' => 'Show output on profile',
	'post:admin:is_export_field' => 'Add output to export',
	'post:admin:is_searchable' => 'Add field to search form',

	'post:admin:name' => 'Metadata Name',
	'post:admin:type' => 'Field Type',
	'post:admin:required' => 'Required Field',
	'post:admin:multiple' => 'Allow Multiple Values',
	'post:admin:label' => 'Field Label',
	'post:admin:label:help' => 'Leave empty to add translations via languages files (field:<entity_type>:<entity_subtype>:<field_name>)',
	'post:admin:placeholder' => 'Field Placeholder',
	'post:admin:placeholder:help' => 'Leave empty to add translations via languages files (field:<entity_type>:<entity_subtype>:<field_name>:help)',
	'post:admin:help' => 'Help Text',
	'post:admin:help:help' => 'Leave empty to add translations via languages files (field:<entity_type>:<entity_subtype>:<field_name>:placeholder)',
	'post:admin:width' => 'Field Width',
	'post:admin:width:help' => 'Field span in a 6-column grid',

	'post:admin:type:text' => 'Text',
	'post:admin:type:plaintext' => 'Plaintext',
	'post:admin:type:longtext' => 'WYSIWYG',
	'post:admin:type:select' => 'Dropdown/Select',
	'post:admin:type:checkboxes' => 'Checkboxes / Radios',
	'post:admin:type:boolean' => 'Boolean / Toggle',
	'post:admin:type:number' => 'Number',
	'post:admin:type:email' => 'Email',
	'post:admin:type:url' => 'URL',
	'post:admin:type:date' => 'Date',
	'post:admin:type:time' => 'Time',
	'post:admin:type:tags' => 'Tags',
	'post:admin:type:users' => 'User Picker',
	'post:admin:type:groups' => 'Group Picker',
	'post:admin:type:attachments' => 'File Attachment',
	'post:admin:type:captcha' => 'Captcha',
	'post:admin:type:country' => 'Country',
	'post:admin:type:address' => 'Address',

	'post:admin:field_options' => 'Field Options',
	'post:admin:option_value' => 'Option Value',
	'post:admin:option_label' => 'Option Label',
	'post:admin:add_option' => 'Add Option',

	'post:admin:field_vars' => 'Field $vars',
	'post:admin:field_vars:help' => 'You can pass additional $vars to the underlying field/input views. For example, you could set checkbox to use switch=1, or set maxlength=10 on a text input',
	'post:admin:var_value' => 'Var Value',
	'post:admin:var_name' => 'Var Name',
	'post:admin:add_var' => 'Add Var',

	'post:admin:save:success' => 'Form field have been successfully saved',
];