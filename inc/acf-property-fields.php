<?php
/**
 * ACF Fields for Featured Properties
 */

/**
 * Note on Google Maps API Key:
 * The Google Maps API key is automatically passed to ACF from the Properties Settings page.
 * If you're experiencing issues with the map fields in ACF:
 * 1. Make sure you've entered a valid API key in Properties → Settings
 * 2. Ensure the Google Maps JavaScript API and Geocoding API are enabled in your Google Cloud Console
 * 3. Check that your API key has the correct domain restrictions (if any)
 */

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_property_details',
    'title' => 'Property Details',    'fields' => array(
        array(
            'key' => 'field_property_address',
            'label' => 'Property Address',
            'name' => 'property_address',
            'type' => 'text',
            'instructions' => 'Enter the full address of the property for mapping purposes',
            'required' => 1,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
        ),
        array(
            'key' => 'field_property_size',
            'label' => 'Property Size',
            'name' => 'property_size',
            'type' => 'text',
            'instructions' => 'Enter the size of the property (e.g., 2,500 sq ft, 0.5 acres, etc.)',
            'required' => 1,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => 'e.g., 2,500 sq ft',
        ),        array(
            'key' => 'field_property_agents',
            'label' => 'Project Agents',
            'name' => 'property_agents',
            'type' => 'post_object',
            'instructions' => 'Select one or more agents assigned to this project',
            'required' => 0,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array(
                0 => 'staff_type',
            ),
            'taxonomy' => '',
            'allow_null' => 0,
            'multiple' => 1,
            'return_format' => 'object',
            'ui' => 1,
        ),
        array(
            'key' => 'field_property_map',
            'label' => 'Property Location',
            'name' => 'property_location',
            'type' => 'google_map',
            'instructions' => 'Enter the property location on the map (will auto-populate from address above)',
            'required' => 1,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'center_lat' => '40.7128',
            'center_lng' => '-74.0060',
            'zoom' => '14',
            'height' => '400',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'property',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));

endif;
