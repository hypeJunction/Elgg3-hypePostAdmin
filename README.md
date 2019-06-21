hypePostAdmin
=============

Interactive form builder for managing post schema 

This plugin provides an admin interface to extend forms created with hypePost. Dependening on the plugins you have installed, it will provide a set of input fields to choose from, including:

 - Text
 - Plaintext
 - WYSIWYG
 - Dropdown / Select
 - Checkboxes / Radios
 - Boolean / Toggle
 - Number
 - Email
 - URL
 - Tags
 - Date
 - Time (hypeTime)
 - User Picker (hypeAutocomplete)
 - Group Picker (hypeAutocomplete)
 - File Attachments (hypeAttachments)
 - Captcha (hypeCaptcha)
 - Country (hypeCountries)
 - Address (hypeCountries)
 
 
 ## Registering new field type
 
 You can register custom field types. See hypePost to understand how field adapters work.
 
 ```php
 elgg_register_plugin_hook_handler('field_types', 'post', function(Hook $hook) {
    $fields = $hook->getValue();
    
    $fields[] = [
        'type' => 'postal_code', // corresponds to input/postal_code view
        'config' => [],
        'adapter' => function($params, $entity) {
            return new MetaField($params);
        },
    ];
    
    return $fields;
 });
 ```
 
 
 