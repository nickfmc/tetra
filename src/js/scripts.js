/**
 * GutenDevTheme scripts (footer)
 * This file contains any js scripts you want added to the theme's footer. 
 */

// *********************** START CUSTOM JS *********************************

// // grab element for Headroom
// var headroomElement = document.querySelector("#c-page-header");
// console.log(headroomElement);

// // get height of element for Headroom
// var headerHeight = headroomElement.offsetHeight; 
// console.log(headerHeight);

// // construct an instance of Headroom, passing the element
// var headroom = new Headroom(headroomElement, {
//   "offset": headerHeight,
//   "tolerance": 5,
//   "classes": {
//     "initial": "animate__animated",
//     "pinned": "animate__slideInDown",
//     "unpinned": "animate__slideOutUp"
//   }
// });
// headroom.init();

// *********************** END CUSTOM JS *********************************

// Properties Map Initialization
let propertiesMap;
let markers = [];
let infoWindows = [];
let activeInfoWindow = null;
let mapInitialized = false;

// Initialize the Google Map
function initPropertiesMap() {
  console.log("initPropertiesMap function called");
  
  // Prevent double initialization
  if (mapInitialized) {
    console.log("Map already initialized, skipping");
    return;
  }
  
  // Check if the map container exists
  const mapElement = document.getElementById('propertiesMap');
  const singleMapElement = document.getElementById('singlePropertyMap');
  
  if (!mapElement && !singleMapElement) {
    console.log("No map elements found on page");
    return;
  }
  
  // Check if Google Maps API is loaded
  if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
    console.error("Google Maps API not loaded");
    showMapError(mapElement || singleMapElement, "Google Maps API not available. Please check if script blockers are enabled.");
    return;
  }
  
  // Set initialization flag
  mapInitialized = true;
  console.log("Map initialization starting");
  
  // Remove loading indicator if it exists
  const loadingIndicator = document.getElementById('map-loading-indicator');
  if (loadingIndicator) {
    loadingIndicator.style.display = 'none';
  }
  
  try {
    // Initialize the properties map if it exists
    if (mapElement) {
      console.log("Initializing properties list map");
      initPropertiesListMap(mapElement);
    }
    
    // Initialize the single property map if it exists
    if (singleMapElement) {
      console.log("Initializing single property map");
      initSinglePropertyMap(singleMapElement);
    }
    
    console.log("Map initialization complete");
  } catch (error) {
    console.error('Error initializing Google Maps:', error);
    showMapError(mapElement || singleMapElement, error.message);
  }
}

// Initialize the map for the properties listing page
function initPropertiesListMap(mapElement) {
  // Initialize the map
  propertiesMap = new google.maps.Map(mapElement, {
    center: { lat: 40.7128, lng: -74.0060 }, // Default to NYC
    zoom: 12,
    mapTypeControl: true,
    fullscreenControl: true,
    streetViewControl: true,
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

  // Add markers for each property
  if (typeof propertyMapData !== 'undefined' && propertyMapData.length > 0) {
    // Bounds to fit all properties
    const bounds = new google.maps.LatLngBounds();
    
    // Create markers for each property
    propertyMapData.forEach(property => {
      // Skip invalid locations
      if (!property.lat || !property.lng) {
        console.warn(`Property ${property.id} has invalid coordinates`);
        return;
      }
      
      const latLng = new google.maps.LatLng(property.lat, property.lng);
      bounds.extend(latLng);
      
      // Determine icon color based on property type slug
      let iconColor = '#A8B6A5'; // Default color
      
      // Check the project type slug for more reliable matching
      if (property.projectTypeSlug) {
        if (property.projectTypeSlug === 'sold') {
          iconColor = '#657962'; // Green for sold properties
        } else if (property.projectTypeSlug === 'agency-leased') {
          iconColor = '#6c486e'; // Purple for agency-leased properties
        }
      }
      
      // Create custom marker icon with dynamic color
      const customIcon = {
        url: 'data:image/svg+xml;base64,' + btoa(`
          <svg xmlns="http://www.w3.org/2000/svg" width="72" height="56" viewBox="0 0 72 56" fill="none">
            <path d="M1.97137 15.9937H19.7292C21.3986 15.9937 22.7528 17.3356 22.7528 18.9947V54.0657C22.7528 55.72 23.7919 56.2031 25.0723 55.1393L38.8855 43.6962C40.1659 42.6324 41.1902 40.4316 41.1902 38.7725V3.7015C41.1902 2.04726 39.836 0.700439 38.1616 0.700439H20.4235C18.7541 0.700439 16.3608 1.55928 15.0755 2.62307L1.26716 14.0662C-0.0132113 15.1299 0.301957 15.9888 1.97137 15.9888M70.2941 0.700439C71.9635 0.700439 72.2787 1.55928 70.9983 2.62307L57.1801 14.0662C55.8997 15.1299 53.5064 15.9888 51.8321 15.9888H47.1193V3.7015C47.1193 2.04726 48.4736 0.700439 50.143 0.700439H70.2842H70.2941Z" fill="${iconColor}"/>
          </svg>
        `),
        scaledSize: new google.maps.Size(36, 28), // Scale to half size for better map visibility
        anchor: new google.maps.Point(18, 28), // Anchor point at bottom center
        origin: new google.maps.Point(0, 0)
      };

      // Create marker
      const marker = new google.maps.Marker({
        position: latLng,
        map: propertiesMap,
        title: property.title,
        animation: google.maps.Animation.DROP,
        propertyId: property.id,
        icon: customIcon
      });
      
      // Create simplified info window content with just image and overlaid title
      const infoWindowContent = `
        <div class="property-map-infowindow">
          <div class="property-map-infowindow-image-container" style="position: relative; width: 100%; height: 250px; border-radius: 8px; overflow: hidden;">
            <img src="${property.large_image || property.thumbnail}" alt="${property.title}" style="width: 100%; height: 100%; object-fit: cover;">
            <div class="property-map-infowindow-title-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: 20px 15px 15px; font-size: 14px; font-weight: 600; text-shadow: 0 1px 3px rgba(0,0,0,0.5);">
              ${property.title}
            </div>
          </div>
        </div>
      `;
      
      // Create info window
      const infoWindow = new google.maps.InfoWindow({
        content: infoWindowContent,
        maxWidth: 350
      });
      
      // Store markers and info windows
      markers.push(marker);
      infoWindows.push(infoWindow);
      
      // Add click event to marker
      marker.addListener('click', function() {
        // Close active info window
        if (activeInfoWindow) {
          activeInfoWindow.close();
        }
        
        // Open this info window
        infoWindow.open(propertiesMap, marker);
        activeInfoWindow = infoWindow;
        
        // Highlight the corresponding property card
        highlightPropertyCard(property.id);
      });
      
      // Remove highlighting when info window is closed
      infoWindow.addListener('closeclick', function() {
        clearPropertyCardHighlights();
      });
    });
    
    // Fit map to bounds if we have valid markers
    if (markers.length > 0) {
      propertiesMap.fitBounds(bounds);
      
      // If only one property, zoom out a bit
      if (markers.length === 1) {
        google.maps.event.addListenerOnce(propertiesMap, 'bounds_changed', function() {
          propertiesMap.setZoom(15);
        });
      }
    } else {
      console.warn('No valid property markers to display');
    }
    
    // Clear highlights when clicking elsewhere on the map
    propertiesMap.addListener('click', function() {
      if (activeInfoWindow) {
        activeInfoWindow.close();
        activeInfoWindow = null;
      }
      clearPropertyCardHighlights();
    });
  }
  
  // Add click event to property cards to center map and open info window
  const propertyCards = document.querySelectorAll('.c-property-card');
  propertyCards.forEach(card => {
    // Add click handlers for image and title
    const imageLink = card.querySelector('.c-property-card-img-link');
    const titleLink = card.querySelector('.c-property-card-title-link');
    
    if (imageLink) {
      imageLink.addEventListener('click', function() {
        const propertyId = parseInt(this.dataset.propertyId);
        console.log('Image clicked for property:', propertyId);
        centerMapOnProperty(propertyId);
      });
    }
    
    if (titleLink) {
      titleLink.addEventListener('click', function() {
        const propertyId = parseInt(this.dataset.propertyId);
        console.log('Title clicked for property:', propertyId);
        centerMapOnProperty(propertyId);
      });
    }
    
    // Add click handler for "View on Map" button
    const viewOnMapButton = card.querySelector('.c-view-on-map-button');
    if (viewOnMapButton) {
      viewOnMapButton.addEventListener('click', function() {
        const propertyId = parseInt(this.dataset.propertyId);
        console.log('View on Map button clicked for property:', propertyId);
        centerMapOnProperty(propertyId);
      });
    }
    
    // Keep hover effects for highlighting
    card.addEventListener('mouseenter', function() {
      const propertyId = parseInt(this.dataset.propertyId);
      highlightMarker(propertyId);
    });
    
    card.addEventListener('mouseleave', function() {
      resetMarkers();
    });
  });
  
  // Add event handler for "Show All Properties" button
  const showAllButton = document.querySelector('.c-show-all-properties-button');
  if (showAllButton) {
    showAllButton.addEventListener('click', function() {
      console.log('Show All Properties button clicked');
      showAllPropertiesInView();
    });
  }
  
  // Add event handlers for filter dropdowns
  const agentFilter = document.getElementById('agentFilter');
  const projectTypeFilter = document.getElementById('projectTypeFilter');
  
  if (agentFilter) {
    agentFilter.addEventListener('change', function() {
      console.log('Agent filter changed:', this.value);
      applyFilters();
    });
  }
  
  if (projectTypeFilter) {
    projectTypeFilter.addEventListener('change', function() {
      console.log('Project type filter changed:', this.value);
      applyFilters();
    });
  }
}

// Function to apply filters to map markers and property cards
function applyFilters() {
  if (!propertiesMap || markers.length === 0) {
    console.warn('No map or markers available for filtering');
    return;
  }
  
  const agentFilter = document.getElementById('agentFilter');
  const projectTypeFilter = document.getElementById('projectTypeFilter');
  
  const selectedAgent = agentFilter ? agentFilter.value : '';
  const selectedProjectType = projectTypeFilter ? projectTypeFilter.value : '';
  
  console.log('Applying filters - Agent:', selectedAgent, 'Project Type:', selectedProjectType);
  
  // Close any active info window
  if (activeInfoWindow) {
    activeInfoWindow.close();
    activeInfoWindow = null;
  }
  
  // Clear property card highlights
  clearPropertyCardHighlights();
  
  let visibleMarkers = [];
  let visiblePropertyIds = [];
  
  // Filter markers and collect visible property IDs
  markers.forEach((marker, index) => {
    const property = propertyMapData[index];
    let shouldShow = true;
    
    // Check agent filter
    if (selectedAgent && selectedAgent !== '') {
      const agentId = parseInt(selectedAgent);
      if (!property.agentIds || !property.agentIds.includes(agentId)) {
        shouldShow = false;
      }
    }
    
    // Check project type filter
    if (selectedProjectType && selectedProjectType !== '') {
      const projectTypeId = parseInt(selectedProjectType);
      if (!property.projectTypeId || property.projectTypeId !== projectTypeId) {
        shouldShow = false;
      }
    }
    
    // Show/hide marker
    marker.setVisible(shouldShow);
    
    if (shouldShow) {
      visibleMarkers.push(marker);
      visiblePropertyIds.push(property.id);
    }
  });
  
  // Show/hide property cards
  const propertyCards = document.querySelectorAll('.c-property-card');
  propertyCards.forEach(card => {
    const propertyId = parseInt(card.dataset.propertyId);
    if (visiblePropertyIds.includes(propertyId)) {
      card.style.display = 'flex';
    } else {
      card.style.display = 'none';
    }
  });
  
  // Adjust map bounds to show visible markers
  if (visibleMarkers.length > 0) {
    const bounds = new google.maps.LatLngBounds();
    visibleMarkers.forEach(marker => {
      bounds.extend(marker.getPosition());
    });
    
    propertiesMap.fitBounds(bounds);
    
    // If only one property, zoom out a bit more
    if (visibleMarkers.length === 1) {
      google.maps.event.addListenerOnce(propertiesMap, 'bounds_changed', function() {
        propertiesMap.setZoom(15);
      });
    }
  } else {
    // No properties match the filter, show a message or reset view
    console.log('No properties match the current filters');
  }
  
  console.log(`Filtered results: ${visibleMarkers.length} properties visible`);
}

// Function to reset all filters
function resetFilters() {
  const agentFilter = document.getElementById('agentFilter');
  const projectTypeFilter = document.getElementById('projectTypeFilter');
  
  if (agentFilter) agentFilter.value = '';
  if (projectTypeFilter) projectTypeFilter.value = '';
  
  // Show all markers and property cards
  markers.forEach(marker => {
    marker.setVisible(true);
  });
  
  const propertyCards = document.querySelectorAll('.c-property-card');
  propertyCards.forEach(card => {
    card.style.display = 'flex';
  });
  
  // Reset map view to show all properties
  fitMapToAllProperties();
  
  console.log('All filters reset');
}

// Function to show all properties in view (called by "Show All Properties" button)
function showAllPropertiesInView() {
  if (!propertiesMap || markers.length === 0) {
    console.warn('No map or markers available');
    return;
  }
  
  console.log('Showing all properties in view');
  
  // Close any active info window
  if (activeInfoWindow) {
    activeInfoWindow.close();
    activeInfoWindow = null;
  }
  
  // Clear property card highlights
  clearPropertyCardHighlights();
  
  // Reset filters to show all properties
  const agentFilter = document.getElementById('agentFilter');
  const projectTypeFilter = document.getElementById('projectTypeFilter');
  
  if (agentFilter) agentFilter.value = '';
  if (projectTypeFilter) projectTypeFilter.value = '';
  
  // Show all markers
  markers.forEach(marker => {
    marker.setVisible(true);
  });
  
  // Show all property cards
  const propertyCards = document.querySelectorAll('.c-property-card');
  propertyCards.forEach(card => {
    card.style.display = 'flex';
  });
  
  // Fit map bounds to show all properties
  fitMapToAllProperties();
  
  console.log('All properties are now visible');
}

// Helper function to fit map bounds to all properties
function fitMapToAllProperties() {
  if (!propertiesMap || markers.length === 0) {
    console.warn('No map or markers available for bounds fitting');
    return;
  }
  
  const bounds = new google.maps.LatLngBounds();
  
  // Add all marker positions to bounds
  markers.forEach(marker => {
    if (marker.getVisible()) {
      bounds.extend(marker.getPosition());
    }
  });
  
  // Fit the map to the bounds
  propertiesMap.fitBounds(bounds);
  
  // If only one property, zoom out a bit more for better context
  const visibleMarkers = markers.filter(marker => marker.getVisible());
  if (visibleMarkers.length === 1) {
    google.maps.event.addListenerOnce(propertiesMap, 'bounds_changed', function() {
      propertiesMap.setZoom(15);
    });
  }
}

// Initialize the map for a single property page
function initSinglePropertyMap(mapElement) {
  // Get location data from the element's data attributes
  const lat = parseFloat(mapElement.dataset.lat);
  const lng = parseFloat(mapElement.dataset.lng);
  const address = mapElement.dataset.address;
  const title = mapElement.dataset.title;
  
  // Validate coordinates
  if (isNaN(lat) || isNaN(lng)) {
    console.error('Invalid coordinates for single property map');
    mapElement.innerHTML = '<div style="padding: 20px; background: #f8d7da; color: #721c24; text-align: center;">' +
                          '<p><strong>Error</strong>: Invalid location coordinates</p></div>';
    return;
  }
  
  // Initialize the map
  const singlePropertyMap = new google.maps.Map(mapElement, {
    center: { lat: lat, lng: lng },
    zoom: 15,
    mapTypeControl: true,
    fullscreenControl: true,
    streetViewControl: true,
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

// Center map on a specific property and open its info window
function centerMapOnProperty(propertyId) {
  if (!propertiesMap || markers.length === 0) {
    console.warn('No map or markers available for centering');
    return;
  }
  
  console.log('Centering map on property:', propertyId);
  
  // Find the marker for this property
  let targetMarker = null;
  let targetInfoWindow = null;
  
  markers.forEach((marker, index) => {
    if (marker.propertyId === propertyId) {
      targetMarker = marker;
      targetInfoWindow = infoWindows[index];
    }
  });
  
  if (targetMarker && targetInfoWindow) {
    // Close any active info window
    if (activeInfoWindow) {
      activeInfoWindow.close();
    }
    
    // Center the map on the property
    propertiesMap.setCenter(targetMarker.getPosition());
    propertiesMap.setZoom(16);
    
    // Add a brief visual feedback on the property card
    const propertyCard = document.querySelector(`.c-property-card[data-property-id="${propertyId}"]`);
    if (propertyCard) {
      propertyCard.classList.add('map-centering');
      setTimeout(() => {
        propertyCard.classList.remove('map-centering');
      }, 1000);
    }
    
    // Open the info window for this property
    setTimeout(() => {
      targetInfoWindow.open(propertiesMap, targetMarker);
      activeInfoWindow = targetInfoWindow;
      
      // Highlight the property card
      highlightPropertyCard(propertyId);
    }, 300); // Small delay to allow map centering animation
    
    console.log('Map centered on property:', propertyId);
  } else {
    console.warn('Could not find marker for property:', propertyId);
  }
}

// Highlight a marker when hovering over a property card
function highlightMarker(propertyId) {
  markers.forEach((marker, index) => {
    if (marker.propertyId === propertyId) {
      marker.setAnimation(google.maps.Animation.BOUNCE);
      setTimeout(() => {
        marker.setAnimation(null);
      }, 750);
    }
  });
}

// Reset all markers to default state
function resetMarkers() {
  markers.forEach(marker => {
    marker.setAnimation(null);
  });
}

// Highlight a property card when clicking on a marker
function highlightPropertyCard(propertyId) {
  const propertyCards = document.querySelectorAll('.c-property-card');
  propertyCards.forEach(card => {
    card.classList.remove('active');
    if (parseInt(card.dataset.propertyId) === propertyId) {
      card.classList.add('active'); 
      // Scroll to the card
      card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  });
}

// Clear all property card highlights
function clearPropertyCardHighlights() {
  const propertyCards = document.querySelectorAll('.c-property-card');
  propertyCards.forEach(card => {
    card.classList.remove('active');
  });
}

// Helper function to show map errors
function showMapError(container, message) {
  if (!container) return;
  
  console.error(message);
  
  container.innerHTML = '<div style="padding: 20px; background: #f8d7da; color: #721c24; text-align: center;">' +
    '<p><strong>Google Maps Error</strong></p>' +
    '<p>' + message + '</p>' +
    '<p>Try refreshing the page or check the browser console for more details.</p>' +
    '</div>';
    
  // Remove loading indicator if it exists
  const loadingIndicator = document.getElementById('map-loading-indicator');
  if (loadingIndicator) {
    loadingIndicator.style.display = 'none';
  }
}

// *********************** START CUSTOM JQUERY DOC READY SCRIPTS *******************************
jQuery( document ).ready(function( $ ) {

   // get Template URL
   var templateUrl = object_name.templateUrl;
   
   // Initialize Properties Map if on the properties page
   if (document.getElementById('propertiesMap') || document.getElementById('singlePropertyMap')) {
     console.log("Map container found on page");
     // Initialize the map - will check for Google Maps API internally
     initPropertiesMap();
   }

   $('#mobile-nav').hcOffcanvasNav({
    disableAt: 1024, 
    width: 580,
    customToggle: $('.toggle'),
     pushContent: '.menu-slide',
    levelTitles: true,
    position: 'right',
    levelOpen: 'expand',
    navTitle: $('<div class="c-mobile-menu-header"><a href="/"><img src="'+ templateUrl + '/img/tetra_logo_mobile.svg"></a></div>'),
    levelTitleAsBack: true
  });

  //Leadership POPUPS
  $('.c-staff-member-grid').each(function() { // the containers for all your galleries
    $(this).magnificPopup({
        delegate: '.popup-modal', // the selector for gallery item
        type: 'inline',
        modal: true,
        fixedContentPos: true,
        overflowY: 'scroll',
        closeBtnInside:true,
        gallery: {
          enabled:true
        }
    });
    $(document).on('click', '.popup-modal-dismiss', function (e) {
      e.preventDefault();
      $.magnificPopup.close(); 
    });
});
//END Leadership POPUPS

  // modal menu init ----------------------------------
  // var modal_menu = jQuery("#c-modal-nav-button").animatedModal({
  //   modalTarget: 'modal-navigation',
  //   animatedIn: 'slideInDown',
  //   animatedOut: 'slideOutUp',
  //   animationDuration: '0.40s',
  //   color: '#dedede',
  //   afterClose: function() {
  //     $( 'body, html' ).css({ 'overflow': '' });
  //   }
  // });

  // // get last and current hash + update on hash change
  // var currentHash = function() {
  //   return location.hash.replace(/^#/, '')
  // }
  // var last_hash
  // var hash = currentHash()
  // $(window).bind('hashchange', function(event) {
  //   last_hash = hash;
  //   hash = currentHash();
  // });

  // enable back/foward to close/open modal --------------------------
  // $("#c-modal-nav-button").on('click', function(){ window.location.href = ensureHash("#menu"); });
  // function ensureHash(newHash) {
  //   if (window.location.hash) {
  //     return window.location.href.substring(0, window.location.href.lastIndexOf(window.location.hash)) + newHash;
  //   }
  //   return window.location.hash + newHash;
  // }
  // // if back button is pressed, close the modal
  // $(window).on('hashchange', function (event) {
  //   if (last_hash == 'menu' && hash == '') {
  //     modal_menu.close();
  //     history.replaceState('', document.title, window.location.pathname);
  //   } // if forward button, open the modal
  //   else if (window.location.hash == "#menu"){
  //     modal_menu.open();
  //   }
  // });

  // // if close button is clicked, clear the #menu hash added above
  // $('.close-modal-navigation').on('click', function (e) {
  //   history.replaceState('', document.title, window.location.pathname);
  // });

  // // close modal menu if esc key is used ------------------------
  // $(document).keyup(function(ev){
  //   if(ev.keyCode == 27 && hash == 'menu') {
  //     window.history.back();
  //   }
  // });


  // Magnific as menu popup
  // MENU POPUP
  // $('#c-modal-nav-button').magnificPopup({
  //   type: 'inline',
  //   removalDelay: 700, //delay removal by X to allow out-animation
  //   showCloseBtn: false,
  //   closeOnBgClick: false,
  //   autoFocusLast: false,
  //   fixedContentPos: false, 
  //   fixedContentPos: true,
  //   callbacks: {
  //     beforeOpen: function() {
  //        this.st.mainClass = 'mfp-move-from-side menu-popup';
  //        $('body').addClass('mfp-active');
  //     },
  //     open: function() { 
  //       $('#close-modal, .close-modal-navigation').on('click',function(event){
  //         event.preventDefault();
  //         $.magnificPopup.close(); 
  //       }); 
  //   },
  //   beforeClose: function() {
  //   $('body').removeClass('mfp-active');
  // }
  //   },
  //   midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
  // });

});
// *********************** END CUSTOM JQUERY DOC READY SCRIPTS *********************************
