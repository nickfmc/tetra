<?php
/**
 * Single Hot Property Landing Page Template
 * 
 * Optimized for conversions based on real estate landing page best practices
 * Standalone page without header/footer for focused conversion
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php while (have_posts()) : the_post(); ?>

<div class="c-hot-property-landing">
    
    <?php
    // Get all ACF fields
    $hero_headline = get_field('hero_headline');
    $hero_badge = get_field('hero_badge');
    $hero_subheading = get_field('hero_subheading');
    $hero_gallery = get_field('hero_gallery');
    $property_price = get_field('property_price');
    $property_status = get_field('property_status');
    $property_address = get_field('property_address');
    $land_size = get_field('land_size');
    $building_size = get_field('building_size');
    $bedrooms = get_field('bedrooms');
    $bathrooms = get_field('bathrooms');
    $key_features = get_field('key_features');
    $primary_agent = get_field('primary_agent');
    $contact_cta = get_field('contact_cta');
    $urgency_message = get_field('urgency_message');
    $testimonials = get_field('testimonials');
    ?>
    
    <!-- Hero Section -->
    <section class="c-hp-hero">
        <?php if ($hero_gallery && !empty($hero_gallery)) : ?>
            <div class="c-hp-hero-bg">
                <img src="<?php echo esc_url($hero_gallery[0]['sizes']['large']); ?>" alt="<?php echo esc_attr($hero_gallery[0]['alt']); ?>">
            </div>
        <?php endif; ?>
        
        <div class="c-hp-logo">
            <img src="<?php echo get_template_directory_uri(); ?>/img/tetra_logo_white.svg" alt="Tetra Real Estate" />
        </div>
        
        <div class="c-hp-hero-content">
            <?php if ($hero_badge) : ?>
                <div class="c-hp-badge"><?php echo esc_html(str_replace('_', ' ', $hero_badge)); ?></div>
            <?php endif; ?>
            
            <h1 class="c-hp-headline"><?php echo $hero_headline ? esc_html($hero_headline) : get_the_title(); ?></h1>
            
            <?php if ($hero_subheading) : ?>
                <p class="c-hp-subheading"><?php echo esc_html($hero_subheading); ?></p>
            <?php endif; ?>
            
            <a href="#contact" class="c-hp-cta-button">
                <?php echo $contact_cta ? esc_html($contact_cta) : 'Get Exclusive Access'; ?>
            </a>
        </div>
    </section>
    
    <!-- Property Details -->
    <section class="c-hp-details">
        <div class="c-hp-container">
            <div class="c-hp-details-grid">
                
                <!-- Gallery -->
                <div class="c-hp-gallery">
                    <?php if ($hero_gallery && count($hero_gallery) > 1) : ?>
                        <img src="<?php echo esc_url($hero_gallery[1]['sizes']['large']); ?>" 
                             alt="<?php echo esc_attr($hero_gallery[1]['alt']); ?>" 
                             class="c-hp-main-image" 
                             id="mainImage">
                        
                        <div class="c-hp-thumbnails">
                            <?php foreach ($hero_gallery as $index => $image) : ?>
                                <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" 
                                     alt="<?php echo esc_attr($image['alt']); ?>"
                                     class="c-hp-thumbnail <?php echo $index === 1 ? 'active' : ''; ?>"
                                     onclick="changeMainImage('<?php echo esc_url($image['sizes']['large']); ?>', this)">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Property Info -->
                <div class="c-hp-info">
                    <div class="c-hp-price">
                        <?php echo $property_price ? '$' . number_format($property_price) : 'POA'; ?>
                    </div>
                    
                    <div class="c-hp-status <?php echo esc_attr($property_status); ?>">
                        <?php echo esc_html(ucwords(str_replace('_', ' ', $property_status))); ?>
                    </div>
                    
                    <?php if ($property_address) : ?>
                        <p><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($property_address); ?></p>
                    <?php endif; ?>
                    
                    <div class="c-hp-specs">
                        <?php if ($land_size) : ?>
                            <div class="c-hp-spec">
                                <i class="fas fa-mountain"></i>
                                <span>Land: <?php echo esc_html($land_size); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($building_size) : ?>
                            <div class="c-hp-spec">
                                <i class="fas fa-building"></i>
                                <span>Building: <?php echo esc_html($building_size); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($bedrooms) : ?>
                            <div class="c-hp-spec">
                                <i class="fas fa-bed"></i>
                                <span><?php echo esc_html($bedrooms); ?> Bedroom<?php echo $bedrooms > 1 ? 's' : ''; ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($bathrooms) : ?>
                            <div class="c-hp-spec">
                                <i class="fas fa-bath"></i>
                                <span><?php echo esc_html($bathrooms); ?> Bathroom<?php echo $bathrooms > 1 ? 's' : ''; ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($key_features) : ?>
                        <div class="c-hp-features">
                            <h3>Key Features</h3>
                            <ul>
                                <?php foreach ($key_features as $feature) : ?>
                                    <li><?php echo esc_html($feature['feature']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <a href="#contact" class="c-hp-cta-button">Contact Agent Now</a>
                </div>
                
            </div>
            
            <!-- Property Description -->
            <div class="c-hp-description">
                <?php the_content(); ?>
            </div>
        </div>
    </section>
    
    <!-- Agent Section -->
    <?php if ($primary_agent) : ?>
        <section class="c-hp-agent">
            <div class="c-hp-container">
                <h2>Listing Agent</h2>
                <div class="c-hp-agent-card">
                    <?php if (has_post_thumbnail($primary_agent->ID)) : ?>
                        <?php echo get_the_post_thumbnail($primary_agent->ID, 'medium', array('class' => 'c-hp-agent-photo')); ?>
                    <?php endif; ?>
                    
                    <h3><?php echo get_the_title($primary_agent->ID); ?></h3>
                    
                    <?php 
                    $agent_position = get_field('position', $primary_agent->ID);
                    if ($agent_position) : ?>
                        <p><?php echo esc_html($agent_position); ?></p>
                    <?php endif; ?>
                    
                    <?php 
                    $agent_phone = get_field('phone_number', $primary_agent->ID);
                    $agent_email = get_field('email_address', $primary_agent->ID);
                    ?>
                    
                    <?php if ($agent_phone) : ?>
                        <p><i class="fas fa-phone"></i> <a href="tel:<?php echo esc_attr($agent_phone); ?>"><?php echo esc_html($agent_phone); ?></a></p>
                    <?php endif; ?>
                    
                    <?php if ($agent_email) : ?>
                        <p><i class="fas fa-envelope"></i> <a href="mailto:<?php echo esc_attr($agent_email); ?>"><?php echo esc_html($agent_email); ?></a></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Testimonials -->
    <?php if ($testimonials) : ?>
        <section class="c-hp-testimonials">
            <div class="c-hp-container">
                <h2 style="text-align: center; margin-bottom: 50px;">What Our Clients Say</h2>
                <div class="c-hp-testimonial-grid">
                    <?php foreach ($testimonials as $testimonial) : ?>
                        <div class="c-hp-testimonial">
                            <p class="c-hp-testimonial-text">"<?php echo esc_html($testimonial['testimonial']); ?>"</p>
                            <div class="c-hp-testimonial-author">
                                <?php if ($testimonial['client_photo']) : ?>
                                    <img src="<?php echo esc_url($testimonial['client_photo']['sizes']['thumbnail']); ?>" 
                                         alt="<?php echo esc_attr($testimonial['client_name']); ?>" 
                                         class="c-hp-testimonial-photo">
                                <?php endif; ?>
                                <strong><?php echo esc_html($testimonial['client_name']); ?></strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Contact Form -->
    <section class="c-hp-contact" id="contact">
        <div class="c-hp-container">
            <h2><?php echo $contact_cta ? esc_html($contact_cta) : 'Contact Us Now'; ?></h2>
            <p>Don't miss out on this exceptional opportunity</p>
            
            <form class="c-hp-contact-form" method="post" action="">
                <?php wp_nonce_field('hot_property_contact', 'hot_property_nonce'); ?>
                <input type="hidden" name="property_id" value="<?php echo get_the_ID(); ?>">
                
                <?php if ($urgency_message) : ?>
                    <div class="c-hp-urgency">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo esc_html($urgency_message); ?>
                    </div>
                <?php endif; ?>
                
                <div class="c-hp-form-group">
                    <label for="contact_name">Name *</label>
                    <input type="text" id="contact_name" name="contact_name" required>
                </div>
                
                <div class="c-hp-form-group">
                    <label for="contact_email">Email *</label>
                    <input type="email" id="contact_email" name="contact_email" required>
                </div>
                
                <div class="c-hp-form-group">
                    <label for="contact_phone">Phone Number</label>
                    <input type="tel" id="contact_phone" name="contact_phone">
                </div>
                
                <div class="c-hp-form-group">
                    <label for="contact_message">Message</label>
                    <textarea id="contact_message" name="contact_message" rows="4" placeholder="I'm interested in this property..."></textarea>
                </div>
                
                <button type="submit" name="submit_contact" class="c-hp-submit-btn">
                    Send Inquiry
                </button>
            </form>
        </div>
    </section>
    
</div>

<script>
function changeMainImage(src, thumb) {
    document.getElementById('mainImage').src = src;
    
    // Update active thumbnail
    document.querySelectorAll('.c-hp-thumbnail').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
}

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>

<?php endwhile; ?>

<?php
// Handle form submission
if (isset($_POST['submit_contact']) && wp_verify_nonce($_POST['hot_property_nonce'], 'hot_property_contact')) {
    $property_id = intval($_POST['property_id']);
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $phone = sanitize_text_field($_POST['contact_phone']);
    $message = sanitize_textarea_field($_POST['contact_message']);
    
    // Track lead
    $leads = get_post_meta($property_id, '_hot_property_leads', true);
    $leads = $leads ? intval($leads) + 1 : 1;
    update_post_meta($property_id, '_hot_property_leads', $leads);
    
    // Send email to agent
    $primary_agent = get_field('primary_agent', $property_id);
    if ($primary_agent) {
        $agent_email = get_field('email_address', $primary_agent->ID);
        if ($agent_email) {
            $subject = 'New Lead: ' . get_the_title($property_id);
            $body = "New inquiry for: " . get_the_title($property_id) . "\n\n";
            $body .= "Name: $name\n";
            $body .= "Email: $email\n";
            $body .= "Phone: $phone\n";
            $body .= "Message: $message\n\n";
            $body .= "Property URL: " . get_permalink($property_id);
            
            wp_mail($agent_email, $subject, $body);
        }
    }
    
    echo '<script>alert("Thank you! We\'ll contact you within 24 hours."); window.location.href = window.location.href;</script>';
}
?>

<?php wp_footer(); ?>
</body>
</html>