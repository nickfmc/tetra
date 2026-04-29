/**
 * Tetra-Bute Block JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Tetra-Bute block interactions
    const tetraButeBlocks = document.querySelectorAll('.c-tetra-bute-block');
    
    tetraButeBlocks.forEach(function(block) {
        initializeTetraButeBlock(block);
    });
});

function initializeTetraButeBlock(block) {
    const items = block.querySelectorAll('.c-tetra-bute-item');
    const filters = block.querySelectorAll('.c-province-filter');
    const grid = block.querySelector('.c-tetra-bute-grid');
    
    // Initialize tooltips
    initTooltips(filters);
    
    // Wait for images and content to load before initializing masonry
    Promise.all([
        ...Array.from(items).map(item => {
            const img = item.querySelector('img');
            if (img && !img.complete) {
                return new Promise(resolve => {
                    img.onload = resolve;
                    img.onerror = resolve;
                });
            }
            return Promise.resolve();
        })
    ]).then(() => {
        // The masonry layout is handled by scripts.js - no need to call it here
    });
    
    // Initialize filtering
    initProvinceFiltering(filters, items, grid);
    
    // Apply custom brand colors
    items.forEach(function(item) {
        const brandColor = item.dataset.brandColor;
        
        if (brandColor) {
            const link = item.querySelector('.c-tetra-bute-link');
            if (link) {
                link.style.background = brandColor;
            }
        }
    });
    
    // Resize handling is already managed by scripts.js
}

function initProvinceFiltering(filters, items, grid) {
    if (!filters.length) return;
    
    const clearFiltersContainer = grid.parentElement.querySelector('.c-clear-filters-container');
    const clearFiltersBtn = clearFiltersContainer?.querySelector('.c-clear-filters');
    
    filters.forEach(function(filter) {
        filter.addEventListener('click', function() {
            const selectedProvince = this.dataset.province;
            
            // Update active filter
            filters.forEach(f => f.classList.remove('active'));
            this.classList.add('active');
            
            // Show clear filters button
            if (clearFiltersContainer) {
                clearFiltersContainer.style.display = 'flex';
                setTimeout(() => clearFiltersContainer.classList.add('show'), 10);
            }
            
            // Filter items
            filterItemsByProvince(items, selectedProvince, grid);
        });
    });
    
    // Handle clear filters button
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function() {
            // Remove active state from all filters
            filters.forEach(f => f.classList.remove('active'));
            
            // Hide clear filters button
            clearFiltersContainer.classList.remove('show');
            setTimeout(() => {
                clearFiltersContainer.style.display = 'none';
            }, 300);
            
            // Show all items
            filterItemsByProvince(items, 'all', grid);
        });
    }
}

function filterItemsByProvince(items, selectedProvince, grid) {
    let visibleCount = 0;
    
    // Hide/show items based on province filter
    items.forEach(function(item) {
        const itemProvinces = item.dataset.provinces ? item.dataset.provinces.split(',') : [];
        const shouldShow = selectedProvince === 'all' || itemProvinces.includes(selectedProvince);
        
        // Remove all filter classes first
        item.classList.remove('filtered-out', 'filtered-in', 'filter-animate-in');
        
        if (shouldShow) {
            item.classList.add('filtered-in');
            visibleCount++;
        } else {
            item.classList.add('filtered-out');
        }
    });
    
    // Reset positioning styles before calling masonry
    items.forEach(function(item) {
        item.style.position = '';
        item.style.transform = '';
        item.style.width = '';
        item.style.left = '';
        item.style.top = '';
        item.style.marginBottom = '';
    });
    
    // Force reflow after clearing styles
    grid.offsetHeight;
    
    // Get visible items for animation
    const visibleItems = Array.from(items).filter(item => 
        !item.classList.contains('filtered-out')
    );
    
    // Recalculate masonry layout with filtered items
    setTimeout(function() {
        // Call the main masonry layout function from scripts.js
        if (window.layoutMasonry && typeof window.layoutMasonry === 'function') {
            window.layoutMasonry();
        }
        
        // Add staggered animations after layout is set
        setTimeout(function() {
            visibleItems.forEach(function(item, index) {
                if (item.classList.contains('filtered-in')) {
                    setTimeout(function() {
                        item.classList.add('filter-animate-in');
                    }, index * 30);
                }
            });
        }, 100);
    }, 50);
    
    // Show/hide "no results" message
    showNoResultsMessage(grid.parentElement, visibleCount === 0, selectedProvince);
}

function showNoResultsMessage(container, show, province) {
    const existingMessage = container.querySelector('.c-no-results');
    
    if (show) {
        if (!existingMessage) {
            const message = document.createElement('div');
            message.className = 'c-no-results';
            message.innerHTML = `
                <div class="c-no-results-content">
                    <h3>No Results Found</h3>
                    <p>No Tetra-Butes found for the selected province. Try selecting a different province or "All Provinces".</p>
                </div>
            `;
            container.appendChild(message);
        }
    } else if (existingMessage) {
        existingMessage.remove();
    }
}

// Helper function to convert hex to rgba
function hexToRgba(hex, alpha) {
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}

// Intersection Observer for performance (optional enhancement)
function setupIntersectionObserver() {
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '50px'
        });

        document.querySelectorAll('.c-tetra-bute-item').forEach((item) => {
            observer.observe(item);
        });
    }
}

// Initialize tooltips with centralized display
function initTooltips(filters) {
    const tooltipDisplay = document.querySelector('.c-province-tooltip-text');
    
    if (!tooltipDisplay) return;
    
    filters.forEach(function(filter) {
        const tooltipText = filter.dataset.tooltip;
        
        if (tooltipText) {
            // Show tooltip on hover
            filter.addEventListener('mouseenter', function() {
                tooltipDisplay.textContent = tooltipText;
                tooltipDisplay.classList.add('show');
            });
            
            // Hide tooltip on mouse leave
            filter.addEventListener('mouseleave', function() {
                tooltipDisplay.classList.remove('show');
            });
        }
    });
}