<?php

if(function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_testimonial_slider',
        'title' => 'Testimonial Slider Fields',
        'fields' => array(
            array(
                'key' => 'field_testimonial_slider_repeater',
                'label' => 'Testimonials',
                'name' => 'testimonials',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Testimonial',
                'sub_fields' => array(
                    array(
                        'key' => 'field_testimonial_quote',
                        'label' => 'Testimonial Quote',
                        'name' => 'quote',
                        'type' => 'textarea',
                        'rows' => 3,
                        'placeholder' => 'Enter the testimonial text here...',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_testimonial_photo',
                        'label' => 'Photo',
                        'name' => 'photo',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_testimonial_name',
                        'label' => 'Name',
                        'name' => 'name',
                        'type' => 'text',
                        'placeholder' => 'Person\'s name',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_testimonial_company',
                        'label' => 'Company',
                        'name' => 'company',
                        'type' => 'text',
                        'placeholder' => 'Company or position',
                        'required' => 0,
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
                    'value' => 'acf/testimonial-slider',
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

endif;
