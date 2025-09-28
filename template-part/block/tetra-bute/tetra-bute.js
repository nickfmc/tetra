/**
 * Tetra-Bute Block JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Tetra-Bute block interactions
    const tetraButeBlocks = document.querySelectorAll('.c-tetra-bute-block');
    
    tetraButeBlocks.forEach(function(block) {
        const items = block.querySelectorAll('.c-tetra-bute-item');
        
        items.forEach(function(item) {
            const brandColor = item.dataset.brandColor;
            
            // Apply custom brand color if available
            if (brandColor) {
                const link = item.querySelector('.c-tetra-bute-link');
                if (link) {
                    link.style.background = brandColor;
                }
                
                const overlay = item.querySelector('.c-tetra-bute-staff-overlay');
                if (overlay) {
                    // Create a gradient with the brand color
                    const gradientColor = hexToRgba(brandColor, 0.95);
                    const defaultColor = 'rgba(155, 148, 119, 0.95)';
                    overlay.style.background = `linear-gradient(135deg, ${gradientColor} 0%, ${defaultColor} 100%)`;
                }
            }
        });
    });
});

// Helper function to convert hex to rgba
function hexToRgba(hex, alpha) {
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}