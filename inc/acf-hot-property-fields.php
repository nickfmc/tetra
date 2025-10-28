<?php
/**
 * ACF Fields for Hot Property Landing Pages
 * 
 * Based on best practices for real estate sales landing pages:
 * - Hero section with compelling imagery
 * - Property details and features
 * - Agent/contact information  
 * - Social proof (testimonials)
 * - Clear call-to-action
 * - Urgency/scarcity elements
 */

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_hot_property_hero',
    'title' => 'Hero Section',
    'fields' => array(
        array(
            'key' => 'field_hero_headline',
            'label' => 'Headline',
            'name' => 'hero_headline',
            'type' => 'text',
            'instructions' => 'Compelling headline that grabs attention (keep under 60 characters)',
            'required' => 1,
            'wrapper' => array(
                'width' => '70',
            ),
            'placeholder' => 'e.g., Stunning Waterfront Estate - Act Fast!',
        ),
        array(
            'key' => 'field_hero_badge',
            'label' => 'Status Badge',
            'name' => 'hero_badge',
            'type' => 'select',
            'instructions' => 'Creates urgency and highlights exclusivity',
            'choices' => array(
                'new_listing' => 'New Listing',
                'price_reduced' => 'Price Reduced', 
                'exclusive' => 'Exclusive Listing',
                'hot_property' => 'Hot Property',
                'limited_time' => 'Limited Time',
                'coming_soon' => 'Coming Soon',
            ),
            'allow_null' => 1,
            'wrapper' => array(
                'width' => '30',
            ),
        ),
        array(
            'key' => 'field_hero_subheading',
            'label' => 'Subheading',
            'name' => 'hero_subheading',
            'type' => 'textarea',
            'instructions' => 'Supporting text that builds on the headline (2-3 lines max)',
            'rows' => 3,
            'placeholder' => 'Prime location with panoramic views. Only 3 properties available at this exclusive price point.',
        ),
        array(
            'key' => 'field_hero_gallery',
            'label' => 'Hero Image Gallery',
            'name' => 'hero_gallery',
            'type' => 'gallery',
            'instructions' => 'High-quality property images (first image becomes main hero)',
            'required' => 1,
            'min' => 3,
            'max' => 12,
            'preview_size' => 'medium',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'hot_property',
            ),
        ),
    ),
    'menu_order' => 0,
));

acf_add_local_field_group(array(
    'key' => 'group_hot_property_details',
    'title' => 'Property Details',
    'fields' => array(
        array(
            'key' => 'field_property_price',
            'label' => 'Price',
            'name' => 'property_price',
            'type' => 'number',
            'instructions' => 'Property price (leave blank for POA)',
            'wrapper' => array(
                'width' => '33',
            ),
            'placeholder' => '1250000',
        ),
        array(
            'key' => 'field_property_status',
            'label' => 'Availability Status',
            'name' => 'property_status',
            'type' => 'select',
            'instructions' => 'Current availability',
            'required' => 1,
            'choices' => array(
                'available' => 'Available',
                'under_offer' => 'Under Offer',
                'sold' => 'Sold',
            ),
            'wrapper' => array(
                'width' => '33',
            ),
        ),
        array(
            'key' => 'field_property_type',
            'label' => 'Property Type',
            'name' => 'property_type',
            'type' => 'select',
            'choices' => array(
                'residential' => 'Residential',
                'commercial' => 'Commercial',
                'industrial' => 'Industrial',
                'land' => 'Land',
                'investment' => 'Investment',
            ),
            'wrapper' => array(
                'width' => '34',
            ),
        ),
        array(
            'key' => 'field_property_address',
            'label' => 'Address',
            'name' => 'property_address',
            'type' => 'text',
            'instructions' => 'Full property address or general area if privacy needed',
            'required' => 1,
            'wrapper' => array(
                'width' => '50',
            ),
        ),
        array(
            'key' => 'field_property_location_map',
            'label' => 'Location Map',
            'name' => 'property_location',
            'type' => 'google_map',
            'instructions' => 'Pin exact location or approximate area',
            'wrapper' => array(
                'width' => '50',
            ),
            'center_lat' => '40.7128',
            'center_lng' => '-74.0060',
            'zoom' => '14',
        ),
        array(
            'key' => 'field_land_size',
            'label' => 'Land Size',
            'name' => 'land_size',
            'type' => 'text',
            'wrapper' => array(
                'width' => '25',
            ),
            'placeholder' => 'e.g., 0.5 acres',
        ),
        array(
            'key' => 'field_building_size',
            'label' => 'Building Size', 
            'name' => 'building_size',
            'type' => 'text',
            'wrapper' => array(
                'width' => '25',
            ),
            'placeholder' => 'e.g., 2,500 sq ft',
        ),
        array(
            'key' => 'field_bedrooms',
            'label' => 'Bedrooms',
            'name' => 'bedrooms',
            'type' => 'number',
            'wrapper' => array(
                'width' => '25',
            ),
        ),
        array(
            'key' => 'field_bathrooms',
            'label' => 'Bathrooms',
            'name' => 'bathrooms',
            'type' => 'number',
            'step' => 0.5,
            'wrapper' => array(
                'width' => '25',
            ),
        ),
        array(
            'key' => 'field_key_features',
            'label' => 'Key Features',
            'name' => 'key_features',
            'type' => 'repeater',
            'instructions' => 'Bullet points of top selling features (max 8)',
            'max' => 8,
            'layout' => 'table',
            'button_label' => 'Add Feature',
            'sub_fields' => array(
                array(
                    'key' => 'field_feature_text',
                    'label' => 'Feature',
                    'name' => 'feature',
                    'type' => 'text',
                    'placeholder' => 'e.g., Ocean views from every room',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'hot_property',
            ),
        ),
    ),
    'menu_order' => 1,
));

acf_add_local_field_group(array(
    'key' => 'group_hot_property_agents',
    'title' => 'Agent Information',
    'fields' => array(
        array(
            'key' => 'field_primary_agent',
            'label' => 'Primary Agent',
            'name' => 'primary_agent',
            'type' => 'post_object',
            'instructions' => 'Main contact for this property',
            'required' => 1,
            'post_type' => array('staff_type'),
            'return_format' => 'object',
            'wrapper' => array(
                'width' => '50',
            ),
        ),
        array(
            'key' => 'field_secondary_agents',
            'label' => 'Additional Agents',
            'name' => 'secondary_agents',
            'type' => 'post_object',
            'instructions' => 'Additional team members (optional)',
            'post_type' => array('staff_type'),
            'return_format' => 'object',
            'multiple' => 1,
            'wrapper' => array(
                'width' => '50',
            ),
        ),
        array(
            'key' => 'field_contact_cta',
            'label' => 'Contact Call-to-Action',
            'name' => 'contact_cta',
            'type' => 'text',
            'instructions' => 'Compelling CTA text for contact form',
            'default_value' => 'Get Exclusive Access - Contact Us Now',
            'placeholder' => 'e.g., Schedule Private Viewing',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'hot_property',
            ),
        ),
    ),
    'menu_order' => 2,
));

acf_add_local_field_group(array(
    'key' => 'group_hot_property_social_proof',
    'title' => 'Social Proof & Testimonials',
    'fields' => array(
        array(
            'key' => 'field_testimonials',
            'label' => 'Client Testimonials',
            'name' => 'testimonials',
            'type' => 'repeater',
            'instructions' => 'Authentic client testimonials (2-4 recommended)',
            'max' => 4,
            'layout' => 'row',
            'button_label' => 'Add Testimonial',
            'sub_fields' => array(
                array(
                    'key' => 'field_testimonial_text',
                    'label' => 'Testimonial',
                    'name' => 'testimonial',
                    'type' => 'textarea',
                    'rows' => 3,
                    'wrapper' => array(
                        'width' => '60',
                    ),
                ),
                array(
                    'key' => 'field_client_name',
                    'label' => 'Client Name',
                    'name' => 'client_name',
                    'type' => 'text',
                    'wrapper' => array(
                        'width' => '20',
                    ),
                ),
                array(
                    'key' => 'field_client_photo',
                    'label' => 'Client Photo',
                    'name' => 'client_photo',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                    'wrapper' => array(
                        'width' => '20',
                    ),
                ),
            ),
        ),
        array(
            'key' => 'field_recent_sales',
            'label' => 'Recent Sales Stats',
            'name' => 'recent_sales',
            'type' => 'group',
            'instructions' => 'Display recent performance to build credibility',
            'layout' => 'block',
            'sub_fields' => array(
                array(
                    'key' => 'field_sales_count',
                    'label' => 'Recent Sales Count',
                    'name' => 'sales_count',
                    'type' => 'number',
                    'wrapper' => array(
                        'width' => '33',
                    ),
                    'placeholder' => '27',
                ),
                array(
                    'key' => 'field_sales_period',
                    'label' => 'Time Period',
                    'name' => 'sales_period',
                    'type' => 'text',
                    'wrapper' => array(
                        'width' => '33',
                    ),
                    'placeholder' => 'last 12 months',
                ),
                array(
                    'key' => 'field_avg_days_market',
                    'label' => 'Average Days on Market',
                    'name' => 'avg_days_market',
                    'type' => 'number',
                    'wrapper' => array(
                        'width' => '34',
                    ),
                    'placeholder' => '18',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'hot_property',
            ),
        ),
    ),
    'menu_order' => 3,
));

acf_add_local_field_group(array(
    'key' => 'group_hot_property_conversion',
    'title' => 'Conversion Settings',
    'fields' => array(
        array(
            'key' => 'field_urgency_message',
            'label' => 'Urgency Message',
            'name' => 'urgency_message',
            'type' => 'text',
            'instructions' => 'Creates scarcity (optional but effective)',
            'placeholder' => 'e.g., Only 2 similar properties available in this area',
        ),
        array(
            'key' => 'field_form_fields',
            'label' => 'Contact Form Fields',
            'name' => 'form_fields',
            'type' => 'checkbox',
            'instructions' => 'Select required form fields (fewer fields = higher conversion)',
            'choices' => array(
                'name' => 'Name (required)',
                'email' => 'Email (required)', 
                'phone' => 'Phone Number',
                'message' => 'Message/Inquiry',
                'viewing_time' => 'Preferred Viewing Time',
                'financing' => 'Financing Pre-approval Status',
            ),
            'default_value' => array('name', 'email', 'phone'),
            'layout' => 'vertical',
        ),
        array(
            'key' => 'field_thank_you_message',
            'label' => 'Thank You Message',
            'name' => 'thank_you_message',
            'type' => 'textarea',
            'instructions' => 'Message shown after form submission',
            'default_value' => 'Thank you for your interest! We\'ll contact you within 24 hours to arrange a private viewing.',
            'rows' => 3,
        ),
        array(
            'key' => 'field_redirect_url',
            'label' => 'Redirect URL (Optional)',
            'name' => 'redirect_url',
            'type' => 'url',
            'instructions' => 'Redirect to custom thank you page instead of showing message',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'hot_property',
            ),
        ),
    ),
    'menu_order' => 4,
));

endif;