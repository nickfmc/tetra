<?php

/**
 * Testimonial Slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Enqueue block specific CSS
wp_enqueue_style('testimonial-slider', get_stylesheet_directory_uri() . '/template-part/block/testimonial-slider/testimonial-slider.css', array(), '1.0.0');

// Create id attribute allowing for custom "anchor" value.
$id = 'testimonial-slider-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'testimonial-slider';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

// Get testimonial slides
$testimonials = get_field('testimonials');

// Check if testimonials exist
if(!$testimonials && $is_preview) {
    echo '<div style="padding: 20px; background: #f0f0f0; text-align: center;">Add testimonials in the block settings</div>';
    return;
}

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="testimonial-slider__container">
        <div class="testimonial-slider__track">
            <?php if($testimonials): ?>
                <?php foreach($testimonials as $index => $testimonial): ?>
                    <div class="testimonial-slider__slide<?php echo ($index === 0) ? ' active' : ''; ?>" data-slide="<?php echo $index; ?>">
                        <div class="testimonial-slider__inner">
                            <div class="testimonial-slider__author">
                                <div class="testimonial-slider__author-photo">
                                    <?php if($testimonial['photo']): ?>
                                        <img src="<?php echo esc_url($testimonial['photo']['url']); ?>" alt="<?php echo esc_attr($testimonial['name']); ?>">
                                    <?php endif; ?>
                                </div>
                               
                            </div>
                            <div class="testimonial-slider_content">
                                <div class="testimonial-slider__stars">
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                </div>
                                <div class="testimonial-slider__quote">
                                    "<?php echo esc_html($testimonial['quote']); ?>"
                                </div>
                                 <div class="testimonial-slider__author-info">
                                        <div class="testimonial-slider__author-name"><?php echo esc_html($testimonial['name']); ?></div>
                                        <div class="testimonial-slider__author-company"><?php echo esc_html($testimonial['company']); ?></div>
                                    </div>
                            </div>

                          
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Navigation Controls -->
        <div class="testimonial-slider__nav">
            <button class="testimonial-slider__prev" aria-label="Previous testimonial">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button class="testimonial-slider__next" aria-label="Next testimonial">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('<?php echo esc_attr($id); ?>');
    if(!slider) return;
    
    const slides = slider.querySelectorAll('.testimonial-slider__slide');
    const prevBtn = slider.querySelector('.testimonial-slider__prev');
    const nextBtn = slider.querySelector('.testimonial-slider__next');
    let currentSlide = 0;
    const totalSlides = slides.length;
    
    function goToSlide(index) {
        // Ensure index is within bounds
        if(index < 0) index = totalSlides - 1;
        if(index >= totalSlides) index = 0;
        
        // Remove active class from current slide
        slides[currentSlide].classList.remove('active');
        slides[currentSlide].classList.remove('exiting');
        
        // Add exiting class to create blur effect during transition
        slides[currentSlide].classList.add('exiting');
        
        // Set new current slide
        currentSlide = index;
        
        // Add active class to new current slide after a small delay for animation
        setTimeout(() => {
            slides[currentSlide].classList.add('active');
            for(let i = 0; i < totalSlides; i++) {
                if(i !== currentSlide) {
                    slides[i].classList.remove('active', 'exiting');
                }
            }
        }, 300); // Match this with CSS transition time
    }
    
    // Event listeners for prev/next buttons
    if(prevBtn) {
        prevBtn.addEventListener('click', function() {
            goToSlide(currentSlide - 1);
        });
    }
    
    if(nextBtn) {
        nextBtn.addEventListener('click', function() {
            goToSlide(currentSlide + 1);
        });
    }
    
    // Auto rotation (optional)
    let autoRotate = setInterval(() => {
        goToSlide(currentSlide + 1);
    }, 5000);
    
    // Pause auto rotation on hover
    slider.addEventListener('mouseenter', () => {
        clearInterval(autoRotate);
    });
    
    slider.addEventListener('mouseleave', () => {
        autoRotate = setInterval(() => {
            goToSlide(currentSlide + 1);
        }, 5000);
    });
});
</script>
