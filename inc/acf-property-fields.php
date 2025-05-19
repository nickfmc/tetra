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
    'title' => 'Property Details',
    'fields' => array(
        array(
            'key' => 'field_property_address',
            'label' => 'Property Address',
            'name' => 'property_address',
            'type' => 'text',
            'instructions' => 'Enter the full address of the property',
            'required' => 1,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
        ),
        array(
            'key' => 'field_property_price',
            'label' => 'Price',
            'name' => 'property_price',
            'type' => 'number',
            'instructions' => 'Enter the property price',
            'required' => 1,
            'wrapper' => array(
                'width' => '33',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'min' => '',
            'max' => '',
            'placeholder' => '',
            'step' => '',
            'prepend' => '$',
        ),
        array(
            'key' => 'field_property_bedrooms',
            'label' => 'Bedrooms',
            'name' => 'property_bedrooms',
            'type' => 'number',
            'instructions' => 'Number of bedrooms',
            'required' => 1,
            'wrapper' => array(
                'width' => '33',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'min' => 0,
            'max' => '',
            'placeholder' => '',
            'step' => '',
        ),
        array(
            'key' => 'field_property_bathrooms',
            'label' => 'Bathrooms',
            'name' => 'property_bathrooms',
            'type' => 'number',
            'instructions' => 'Number of bathrooms',
            'required' => 1,
            'wrapper' => array(
                'width' => '33',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'min' => 0,
            'max' => '',
            'placeholder' => '',
            'step' => '0.5',
        ),
        array(
            'key' => 'field_property_sqft',
            'label' => 'Square Footage',
            'name' => 'property_sqft',
            'type' => 'number',
            'instructions' => 'Square footage of the property',
            'required' => 0,
            'wrapper' => array(
                'width' => '50',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'min' => 0,
            'max' => '',
            'placeholder' => '',
            'step' => '',
            'append' => 'sq ft',
        ),
        array(
            'key' => 'field_property_features',
            'label' => 'Additional Features',
            'name' => 'property_features',
            'type' => 'repeater',
            'instructions' => 'Add additional features of the property',
            'required' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => 'Add Feature',
            'sub_fields' => array(
                array(
                    'key' => 'field_property_feature_name',
                    'label' => 'Feature',
                    'name' => 'feature',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 1,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                ),
            ),
        ),
        array(
            'key' => 'field_property_map',
            'label' => 'Property Location',
            'name' => 'property_location',
            'type' => 'google_map',
            'instructions' => 'Enter the property location on the map',
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
