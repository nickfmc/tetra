# Featured Properties with Google Maps Integration

This feature allows you to showcase featured properties on your website with an interactive Google Maps interface.

## Features

- Custom Post Type for Property management
- Google Maps integration with property markers
- Property archive with map and listing view
- Detailed single property pages
- ACF integration for property details (price, bedrooms, bathrooms, etc.)
- Responsive design for all devices

## Setup Instructions

### 1. Install and Activate Required Plugins

- Advanced Custom Fields PRO (included in your theme's plugins folder)

### 2. Set Up Google Maps API Key

1. Visit [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google Maps JavaScript API 
4. Create an API key with appropriate restrictions
5. In your WordPress admin, navigate to **Appearance → Properties Settings**
6. Enter your Google Maps API key and save changes

### 3. Create a Properties Map Page

1. Create a new page in WordPress
2. Set the template to "Properties Map" from the Page Attributes box
3. Publish the page
4. You can now access your properties map at the page URL

### 4. Adding Properties

1. In your WordPress admin, go to **Featured Properties → Add New**
2. Enter the property title
3. Fill in the property description in the main content area
4. Set property details in the "Property Details" section below the content:
   - Property Address
   - Price
   - Bedrooms
   - Bathrooms
   - Square Footage
   - Additional Features (optional)
   - Property Location on map (drag the pin to the correct location)
5. Add a featured image to represent the property
6. Publish the property

### 5. Customization

You can customize the appearance of your properties by editing the following files:
- `src/scss/components/_properties.scss` - Styling for property cards and maps
- `pg-properties-map.php` - Properties archive page template
- `single-property.php` - Single property page template

## Troubleshooting

### Map Not Displaying

1. Make sure you've entered a valid Google Maps API key in Appearance → Properties Settings
2. Check if your Google Maps API key has the correct permissions (Maps JavaScript API enabled)
3. Verify that you've added at least one property with a valid location

### Need Help?

For further assistance, please contact your theme developer.
