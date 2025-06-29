<?php

if(function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_tenant_representation',
        'title' => 'Tenant Representation Fields',
        'fields' => array(
            array(
                'key' => 'field_tenant_representation_repeater',
                'label' => 'Tenants',
                'name' => 'tenants',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Tenant',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tenant_name',
                        'label' => 'Tenant Name',
                        'name' => 'tenant_name',
                        'type' => 'text',
                        'placeholder' => 'Enter tenant company name',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_tenant_logo',
                        'label' => 'Tenant Logo',
                        'name' => 'tenant_logo',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'instructions' => 'Optional: Upload the tenant\'s logo',
                    ),
                    array(
                        'key' => 'field_size_requirement',
                        'label' => 'Size Requirement',
                        'name' => 'size_requirement',
                        'type' => 'text',
                        'placeholder' => 'e.g., 5,000 - 10,000 sq ft',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_market_requirement',
                        'label' => 'Market Requirement',
                        'name' => 'market_requirement',
                        'type' => 'text',
                        'placeholder' => 'e.g., Manhattan, Brooklyn, Queens',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_broker_contact',
                        'label' => 'Broker Contacts',
                        'name' => 'broker_contact',
                        'type' => 'post_object',
                        'instructions' => 'Select one or more brokers/agents handling this tenant',
                        'required' => 1,
                        'post_type' => array(
                            0 => 'staff_type',
                        ),
                        'taxonomy' => '',
                        'allow_null' => 0,
                        'multiple' => 1,
                        'return_format' => 'object',
                        'ui' => 1,
                    ),
                ),
                'min' => 1,
                'max' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/tenant-representation',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
    ));

else:
    // Debug: ACF not available
    error_log('ACF function acf_add_local_field_group not found for tenant-representation block');
endif;
