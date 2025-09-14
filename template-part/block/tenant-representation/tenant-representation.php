<?php

/**
 * Tenant Representation Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Enqueue block specific CSS
wp_enqueue_style('tenant-representation', get_stylesheet_directory_uri() . '/template-part/block/tenant-representation/tenant-representation.css', array(), '1.0.0');

// Create id attribute allowing for custom "anchor" value.
$id = 'tenant-representation-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'c-tenant-representation';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

// Get tenant data
$tenants = get_field('tenants');

// Check if tenants exist
if(!$tenants && $is_preview) {
    echo '<div style="padding: 20px; background: #f0f0f0; text-align: center;">Add tenants in the block settings</div>';
    return;
}

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="c-tenant-representation__container">
        <?php if($tenants): ?>
            <h3 class="c-tenant-representation__title">Current Tenant Representation</h3>
            <p class="c-tenant-representation__subtitle"></p>
            
            <div class="c-tenant-representation__list">
                <?php foreach($tenants as $index => $tenant): ?>
                    <div class="c-tenant-representation__item" data-tenant="<?php echo $index; ?>">
                        <button class="c-tenant-representation__trigger" type="button" aria-expanded="false">
                            <span class="tenant-name"><?php echo esc_html($tenant['tenant_name']); ?></span>
                            <span class="tenant-arrow">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </button>
                        
                        <div class="c-tenant-representation__details">
                            <div class="tenant-details__content">
                                <!-- Top Section: Logo and Info -->
                                <div class="tenant-details__header">
                                    <?php if($tenant['tenant_logo']): ?>
                                        <div class="tenant-details__logo">
                                            <img src="<?php echo esc_url($tenant['tenant_logo']['url']); ?>" 
                                                 alt="<?php echo esc_attr($tenant['tenant_name']); ?> Logo"
                                                 class="tenant-logo">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="tenant-details__info">
                                        <div class="tenant-info__item">
                                            <h4 class="tenant-info__label">Size Requirement:</h4>
                                            <p class="tenant-info__value"><?php echo esc_html($tenant['size_requirement']); ?></p>
                                        </div>
                                        
                                        <div class="tenant-info__item">
                                            <h4 class="tenant-info__label">Market Requirement:</h4>
                                            <p class="tenant-info__value"><?php echo esc_html($tenant['market_requirement']); ?></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Bottom Section: Broker Contacts -->
                                <?php if($tenant['broker_contact']): 
                                    $brokers = is_array($tenant['broker_contact']) ? $tenant['broker_contact'] : array($tenant['broker_contact']);
                                ?>
                                    <div class="tenant-details__brokers">
                                        <h4 class="brokers-section__title">
                                            <?php echo count($brokers) > 1 ? 'Broker Contacts:' : 'Broker Contact:'; ?>
                                        </h4>
                                        <div class="brokers-grid">
                                            <?php foreach($brokers as $broker): 
                                                $broker_id = $broker->ID;
                                            ?>
                                                <div class="broker-contact__card">
                                                    <div class="broker-card__header">
                                                        <?php if(has_post_thumbnail($broker_id)): ?>
                                                            <div class="broker-photo">
                                                                <?php echo get_the_post_thumbnail($broker_id, 'thumbnail', array('class' => 'broker-avatar')); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <div class="broker-basic-info">
                                                            <h5 class="broker-name"><?php echo get_the_title($broker_id); ?></h5>
                                                            <?php if(get_field('position', $broker_id)): ?>
                                                                <p class="broker-position"><?php echo get_field('position', $broker_id); ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="broker-contact__details personalmeta">
                                                        <?php if(get_field('email_address', $broker_id)): ?>
                                                            <div class="broker-contact__item">
                                                                <a href="mailto:<?php echo get_field('email_address', $broker_id); ?>" class="broker-email">
                                                                    <span> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                                        <polyline points="22,6 12,13 2,6"></polyline>
                                                                    </svg>
                                                                   Email</span>
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if(get_field('phone_number', $broker_id)): ?>
                                                            <div class="broker-contact__item">
                                                                <a href="tel:<?php echo get_field('phone_number', $broker_id); ?>" class="broker-phone">
                                                                    <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                                                    </svg>
                                                                    Phone</span>
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if(get_field('linkedin_address', $broker_id)): ?>
                                                            <div class="broker-contact__item">
                                                                <a href="<?php echo get_field('linkedin_address', $broker_id); ?>" target="_blank" class="broker-linkedin">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                                        <path d="M6.94 5a2 2 0 1 1-4-.002a2 2 0 0 1 4 .002ZM7 8.48H3V21h4V8.48Zm6.32 0H9.34V21h3.94v-6.57c0-3.66 4.77-4 4.77 0V21H22v-7.93c0-6.17-7.06-5.94-8.72-2.91l.04-1.68Z"/>
                                                                    </svg>
                                                                    LinkedIn
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tenantBlock = document.getElementById('<?php echo esc_attr($id); ?>');
    if (!tenantBlock) return;
    
    const triggers = tenantBlock.querySelectorAll('.c-tenant-representation__trigger');
    
    // Add smooth scroll behavior
    const addSmoothScroll = (element) => {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    };
    
    // Enhanced interaction with smooth animations
    triggers.forEach((trigger, index) => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            
            const item = this.closest('.c-tenant-representation__item');
            const details = item.querySelector('.c-tenant-representation__details');
            const arrow = this.querySelector('.tenant-arrow');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // Add loading state
            tenantBlock.classList.add('loading');
            
            // Close all other items with smooth animation
            triggers.forEach((otherTrigger, otherIndex) => {
                if (otherTrigger !== trigger) {
                    const otherItem = otherTrigger.closest('.c-tenant-representation__item');
                    const otherArrow = otherTrigger.querySelector('.tenant-arrow');
                    
                    if (otherTrigger.getAttribute('aria-expanded') === 'true') {
                        otherTrigger.setAttribute('aria-expanded', 'false');
                        otherItem.classList.remove('active');
                        otherArrow.style.transform = 'rotate(0deg)';
                    }
                }
            });
            
            // Toggle current item with enhanced animation
            setTimeout(() => {
                if (isExpanded) {
                    // Collapse
                    this.setAttribute('aria-expanded', 'false');
                    item.classList.remove('active');
                    arrow.style.transform = 'rotate(0deg)';
                    
                    // Remove loading state after animation
                    setTimeout(() => {
                        tenantBlock.classList.remove('loading');
                    }, 400);
                } else {
                    // Expand
                    this.setAttribute('aria-expanded', 'true');
                    item.classList.add('active');
                    arrow.style.transform = 'rotate(180deg)';
                    
                    // Remove loading state and smooth scroll after animation
                    setTimeout(() => {
                        tenantBlock.classList.remove('loading');
                        
                        // Smooth scroll to show expanded content
                        if (window.innerWidth > 768) {
                            addSmoothScroll(item);
                        }
                    }, 400);
                }
            }, isExpanded ? 0 : 100);
        });
        
        // Enhanced keyboard navigation
        trigger.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
            
            // Arrow key navigation
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                const nextTrigger = triggers[index + 1];
                if (nextTrigger) {
                    nextTrigger.focus();
                    addSmoothScroll(nextTrigger);
                }
            }
            
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                const prevTrigger = triggers[index - 1];
                if (prevTrigger) {
                    prevTrigger.focus();
                    addSmoothScroll(prevTrigger);
                }
            }
        });
        
        // Add hover effects for better UX
        // trigger.addEventListener('mouseenter', function() {
        //     if (!this.classList.contains('active')) {
        //         this.style.transform = 'translateX(8px)';
        //     }
        // });
        
        // trigger.addEventListener('mouseleave', function() {
        //     if (!this.classList.contains('active')) {
        //         this.style.transform = 'translateX(0)';
        //     }
        // });
    });
    
    // Add intersection observer for smooth entrance animations
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        // Observe each tenant item for entrance animation
        triggers.forEach(trigger => {
            const item = trigger.closest('.c-tenant-representation__item');
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(item);
        });
    }
    
    // Add escape key to close expanded items
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const expandedTrigger = tenantBlock.querySelector('.c-tenant-representation__trigger[aria-expanded="true"]');
            if (expandedTrigger) {
                expandedTrigger.click();
                expandedTrigger.focus();
            }
        }
    });
    
    // Add click outside to close
    document.addEventListener('click', function(e) {
        if (!tenantBlock.contains(e.target)) {
            const expandedTrigger = tenantBlock.querySelector('.c-tenant-representation__trigger[aria-expanded="true"]');
            if (expandedTrigger) {
                expandedTrigger.click();
            }
        }
    });
    
    // Add ARIA live region for screen readers
    const liveRegion = document.createElement('div');
    liveRegion.setAttribute('aria-live', 'polite');
    liveRegion.setAttribute('aria-atomic', 'true');
    liveRegion.style.position = 'absolute';
    liveRegion.style.left = '-10000px';
    liveRegion.style.width = '1px';
    liveRegion.style.height = '1px';
    liveRegion.style.overflow = 'hidden';
    tenantBlock.appendChild(liveRegion);
    
    // Update live region when items expand/collapse
    triggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const tenantName = this.querySelector('.tenant-name').textContent;
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            setTimeout(() => {
                liveRegion.textContent = isExpanded ? 
                    `${tenantName} details collapsed` : 
                    `${tenantName} details expanded`;
            }, 100);
        });
    });
});
</script>
