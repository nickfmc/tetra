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
      
      // Create marker
      const marker = new google.maps.Marker({
        position: latLng,
        map: propertiesMap,
        title: property.title,
        animation: google.maps.Animation.DROP,
        propertyId: property.id
      });
      
      // Create simplified info window content with just image and overlaid title
      const infoWindowContent = `
        <div class="property-map-infowindow">
          <div class="property-map-infowindow-image-container" style="position: relative; width: 100%; height: 200px; border-radius: 8px; overflow: hidden;">
            <img src="${property.large_image || property.thumbnail}" alt="${property.title}" style="width: 100%; height: 100%; object-fit: cover;">
            <div class="property-map-infowindow-title-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); color: white; padding: 20px 15px 15px; font-size: 1.1rem; font-weight: 600; text-shadow: 0 1px 3px rgba(0,0,0,0.5);">
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
    
    // Keep hover effects for highlighting
    card.addEventListener('mouseenter', function() {
      const propertyId = parseInt(this.dataset.propertyId);
      highlightMarker(propertyId);
    });
    
    card.addEventListener('mouseleave', function() {
      resetMarkers();
    });
  });
}

// Function to center map on specific property and open its info window
function centerMapOnProperty(propertyId) {
  // Find the marker and info window for this property
  const markerIndex = markers.findIndex(marker => marker.propertyId === propertyId);
  
  if (markerIndex !== -1) {
    const marker = markers[markerIndex];
    const infoWindow = infoWindows[markerIndex];
    const propertyCard = document.querySelector(`[data-property-id="${propertyId}"]`);
    
    // Add visual feedback to the clicked card
    if (propertyCard) {
      propertyCard.classList.add('map-centering');
      setTimeout(() => {
        propertyCard.classList.remove('map-centering');
      }, 2000);
    }
    
    // Close any active info window
    if (activeInfoWindow) {
      activeInfoWindow.close();
    }
    
    // Center the map on the marker
    propertiesMap.setCenter(marker.getPosition());
    propertiesMap.setZoom(16); // Zoom in a bit more for better view
    
    // Open the info window
    infoWindow.open(propertiesMap, marker);
    activeInfoWindow = infoWindow;
    
    // Highlight the property card
    highlightPropertyCard(propertyId);
    
    // Add a small bounce animation to the marker
    marker.setAnimation(google.maps.Animation.BOUNCE);
    setTimeout(() => {
      marker.setAnimation(null);
    }, 1500);
  } else {
    console.warn(`Property with ID ${propertyId} not found on map`);
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
