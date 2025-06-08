<?php
/**
 * Template for displaying single property
 *
 * This template will display a single property with all its details
 */

get_header(); 
?>

<div class="c-single-property-container">
    <div class="container">        <?php while ( have_posts() ) : the_post();            // Get ACF fields
            $address = get_field('property_address');
            $size = get_field('property_size');
            $agents = get_field('property_agents');
            $location = get_field('property_location');
            
            // Get property type taxonomy
            $property_types = get_the_terms(get_the_ID(), 'project_type_tax');
            $property_type_class = '';
            $property_type_name = '';
            
            if ($property_types && !is_wp_error($property_types)) {
                $property_type = $property_types[0]; // Get first term
                $property_type_name = $property_type->name;
                $property_type_class = sanitize_html_class(strtolower($property_type->slug));
            }
        ?>
            <div class="c-single-property">                <div class="c-single-property-header">
                    <div class="c-single-property-title-section">
                        <h1 class="c-single-property-title"><?php the_title(); ?></h1>
                        <?php if ($property_type_name) : ?>
                            <div class="c-property-taxonomy-ribbon <?php echo $property_type_class; ?>" style="position: relative; display: inline-block; margin-bottom: 10px;">
                                <?php echo $property_type_name; ?>
                            </div>
                        <?php endif; ?>
                        <p class="c-single-property-address"><?php echo $address; ?></p>
                    </div>
                </div>
                
                <div class="c-single-property-gallery">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="c-single-property-featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php 
                    // If you have additional property images, you can add a gallery here
                    // This is assuming you might add a gallery field later
                    ?>
                </div>
                
                <div class="c-single-property-content">                    <div class="c-single-property-details">
                        <h2 class="c-single-property-section-title">Property Details</h2>
                        <div class="c-single-property-details-grid">
                            <?php if ($size) : ?>
                                <div class="c-single-property-detail-item">
                                    <div class="c-single-property-detail-icon">
                                        <i class="fas fa-vector-square"></i>
                                    </div>
                                    <div class="c-single-property-detail-content">
                                        <h3 class="c-single-property-detail-title">Property Size</h3>
                                        <p class="c-single-property-detail-value"><?php echo $size; ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                              <?php if ($agents && !empty($agents)) : ?>
                                <div class="c-single-property-detail-item">
                                    <div class="c-single-property-detail-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="c-single-property-detail-content">
                                        <h3 class="c-single-property-detail-title">Project Agents</h3>
                                        <div class="c-property-agents-list">
                                            <?php foreach ($agents as $agent) : ?>
                                                <a href="<?php echo get_permalink($agent->ID); ?>" class="c-agent-link" title="<?php echo esc_attr(get_the_title($agent->ID)); ?>">
                                                    <?php if (has_post_thumbnail($agent->ID)) : ?>
                                                        <?php echo get_the_post_thumbnail($agent->ID, 'thumbnail', array('class' => 'c-agent-avatar')); ?>
                                                    <?php else : ?>
                                                        <div class="c-agent-avatar-placeholder">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <span class="c-agent-name"><?php echo get_the_title($agent->ID); ?></span>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($location) : ?>
                                <div class="c-single-property-detail-item">
                                    <div class="c-single-property-detail-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="c-single-property-detail-content">
                                        <h3 class="c-single-property-detail-title">Location</h3>
                                        <p class="c-single-property-detail-value"><?php echo $address; ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                      <div class="c-single-property-description">
                        <h2 class="c-single-property-section-title">Description</h2>
                        <div class="c-single-property-description-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    
                    <?php if ($location) : ?>
                        <div class="c-single-property-map">
                            <h2 class="c-single-property-section-title">Location</h2>
                            <div id="singlePropertyMap" class="c-single-property-map-container" 
                                 data-lat="<?php echo $location['lat']; ?>" 
                                 data-lng="<?php echo $location['lng']; ?>" 
                                 data-address="<?php echo esc_attr($address); ?>"
                                 data-title="<?php echo esc_attr(get_the_title()); ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="c-single-property-contact">
                    <h2 class="c-single-property-section-title">Interested in this property?</h2>
                    <p>Contact us today to schedule a viewing or to learn more about this property.</p>
                    <a href="/contact" class="c-single-property-contact-button">Contact Us</a>
                </div>
                
                <div class="c-single-property-related">
                    <h2 class="c-single-property-section-title">Similar Properties</h2>
                    <?php
                    // Related properties query
                    $args = array(
                        'post_type' => 'property',
                        'posts_per_page' => 3,
                        'post__not_in' => array(get_the_ID()), // Exclude current property
                        'orderby' => 'rand', // Random order for variety
                    );
                    $related_query = new WP_Query($args);
                    
                    if ($related_query->have_posts()) : ?>
                        <div class="c-properties-grid c-related-properties-grid">                        <?php while ($related_query->have_posts()) : $related_query->the_post(); 
                            // Get ACF fields for related property
                            $rel_address = get_field('property_address');
                            $rel_size = get_field('property_size');
                            $rel_agents = get_field('property_agents');
                            
                            // Get property type taxonomy for related property
                            $rel_property_types = get_the_terms(get_the_ID(), 'project_type_tax');
                            $rel_property_type_class = '';
                            $rel_property_type_name = '';
                            
                            if ($rel_property_types && !is_wp_error($rel_property_types)) {
                                $rel_property_type = $rel_property_types[0]; // Get first term
                                $rel_property_type_name = $rel_property_type->name;
                                $rel_property_type_class = sanitize_html_class(strtolower($rel_property_type->slug));
                            }
                        ?>
                            <div class="c-property-card">
                                <?php if ($rel_property_type_name) : ?>
                                    <div class="c-property-taxonomy-ribbon <?php echo $rel_property_type_class; ?>">
                                        <?php echo $rel_property_type_name; ?>
                                    </div>
                                <?php endif; ?>
                                  <a href="<?php the_permalink(); ?>" class="c-property-card-link c-property-card-img-link">
                                    <div class="c-property-card-image">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('medium_large'); ?>
                                        <?php else : ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/img/property-placeholder.jpg" alt="Property Image">
                                        <?php endif; ?>
                                    </div>
                                </a>
                                
                                <div class="c-property-card-content">
                                    <a href="<?php the_permalink(); ?>" class="c-property-card-title-link">
                                        <h3 class="c-property-card-title"><?php the_title(); ?></h3>
                                    </a>
                                    <p class="c-property-card-address"><?php echo $rel_address; ?></p>
                                    
                                    <div class="c-property-card-details">
                                        <?php if ($rel_size) : ?>
                                            <span class="c-property-detail"><i class="fas fa-vector-square"></i> <?php echo $rel_size; ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if ($rel_agents && !empty($rel_agents)) : ?>
                                            <div class="c-property-agents">
                                                <span class="c-property-detail">
                                                    <i class="fas fa-user"></i> Agents:
                                                </span>
                                                <div class="c-property-agents-list">
                                                    <?php foreach ($rel_agents as $agent) : ?>
                                                        <a href="<?php echo get_permalink($agent->ID); ?>" class="c-agent-link" title="<?php echo esc_attr(get_the_title($agent->ID)); ?>">
                                                            <?php if (has_post_thumbnail($agent->ID)) : ?>
                                                                <?php echo get_the_post_thumbnail($agent->ID, 'thumbnail', array('class' => 'c-agent-avatar')); ?>
                                                            <?php else : ?>
                                                                <div class="c-agent-avatar-placeholder">
                                                                    <i class="fas fa-user"></i>
                                                                </div>
                                                            <?php endif; ?>
                                                            <span class="c-agent-name"><?php echo get_the_title($agent->ID); ?></span>
                                                        </a>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        </div>
                    <?php else : ?>
                        <p>No similar properties found.</p>
                    <?php endif; 
                    wp_reset_postdata(); ?>
                </div>
            </div>
              <?php if ($location) : ?>
            <script>
            // Function to initialize the single property map
            function initPropertiesMap() {
                // Single property map initialization
                if (document.getElementById('singlePropertyMap')) {
                    const mapElement = document.getElementById('singlePropertyMap');
                    const lat = parseFloat(mapElement.dataset.lat);
                    const lng = parseFloat(mapElement.dataset.lng);
                    const address = mapElement.dataset.address;
                    const title = mapElement.dataset.title;
                    
                    // Initialize the map
                    const singlePropertyMap = new google.maps.Map(mapElement, {
                        center: { lat: lat, lng: lng },
                        zoom: 15,
                        styles: [
                          {
                            "featureType": "administrative",
                            "elementType": "labels.text.fill",
                            "stylers": [{"color": "#444444"}]
                          },
                          {
                            "featureType": "landscape",
                            "elementType": "all",
                            "stylers": [{"color": "#f2f2f2"}]
                          },
                          {
                            "featureType": "poi",
                            "elementType": "all",
                            "stylers": [{"visibility": "off"}]
                          },
                          {
                            "featureType": "road",
                            "elementType": "all",
                            "stylers": [{"saturation": -100}, {"lightness": 45}]
                          },
                          {
                            "featureType": "road.highway",
                            "elementType": "all",
                            "stylers": [{"visibility": "simplified"}]
                          },
                          {
                            "featureType": "road.arterial",
                            "elementType": "labels.icon",
                            "stylers": [{"visibility": "off"}]
                          },
                          {
                            "featureType": "transit",
                            "elementType": "all",
                            "stylers": [{"visibility": "off"}]
                          },
                          {
                            "featureType": "water",
                            "elementType": "all",
                            "stylers": [{"color": "#4a90e2"}, {"visibility": "on"}]
                          }
                        ]
                    });
                    
                    // Add marker
                    const marker = new google.maps.Marker({
                        position: { lat: lat, lng: lng },
                        map: singlePropertyMap,
                        title: title,
                        animation: google.maps.Animation.DROP
                    });
                    
                    // Add info window
                    const infoWindow = new google.maps.InfoWindow({
                        content: `<div class="property-map-infowindow">
                                     <h3 class="property-map-infowindow-title">${title}</h3>
                                     <p class="property-map-infowindow-address">${address}</p>
                                  </div>`
                    });
                    
                    // Open info window when clicking on marker
                    marker.addListener('click', function() {
                        infoWindow.open(singlePropertyMap, marker);
                    });
                    
                    // Open info window by default
                    infoWindow.open(singlePropertyMap, marker);
                }
            }
            </script>
            <?php endif; ?>
            
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
