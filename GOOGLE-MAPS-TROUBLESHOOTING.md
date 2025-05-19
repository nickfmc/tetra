# Google Maps Troubleshooting Guide

If you're experiencing issues with the Google Maps integration on your properties feature, follow this guide to resolve common problems.

## Common Issues and Solutions

### Map Not Displaying At All

1. **Verify API Key is Entered**
   - Go to Properties → Settings
   - Check that you've entered your Google Maps API key
   - Use the "Test API Key" button to verify it works

2. **Check for JavaScript Errors**
   - Open your browser's developer console (F12 in most browsers)
   - Look for any error messages related to Google Maps

3. **Verify API Key Restrictions**
   - In Google Cloud Console, check your API key's restrictions
   - For development, consider creating a test key with no restrictions
   - For production, your API key should allow:
     - Maps JavaScript API
     - Your website's domain as an allowed referrer

4. **Password-Protected Sites**
   - If your site has server-level password protection (.htaccess), Google Maps might be blocked
   - Solutions:
     - Temporarily disable password protection during development
     - Add your local/staging domain to allowed referrers in Google Cloud Console
     - Create a separate API key for development with no restrictions

### Map Shows "For Development Purposes Only" Watermark

1. **Billing Not Enabled**
   - You need to enable billing on your Google Cloud account
   - Go to the Google Cloud Console → Billing
   - Set up a billing account (Google provides a free credit allowance)

2. **API Key Issues**
   - Create a new API key and restrict it to Maps JavaScript API only
   - Set appropriate referrer restrictions (your domain)

### Map Shows But Markers Don't Appear

1. **Check Property Locations**
   - Verify each property has valid latitude and longitude coordinates
   - Add the `?debug=1` parameter to your properties page URL (when logged in as admin)
   - This will show which properties have valid locations

2. **Verify JavaScript Console**
   - Check for any error messages in your browser's developer console

### Security Best Practices

1. **Restrict Your API Key**
   - In Google Cloud Console, set up API restrictions:
     - Only enable the Maps JavaScript API
     - Restrict to your website's domains
     - Consider IP restrictions for additional security

2. **Monitor Usage**
   - Set up quotas and alerts in Google Cloud Console
   - This prevents unexpected billing if your key is compromised

## Testing Your Setup

When logged in as an administrator, you can add `?debug=1` to your properties page URL to see:
- API key status
- Maps API loading status
- Property data validation
- Browser information

Example: `https://yoursite.com/properties/?debug=1`

## Still Having Issues?

If you've tried the solutions above and are still experiencing problems:

1. Try a completely unrestricted API key temporarily (for testing only)
2. Check if your theme or other plugins might be conflicting
3. Verify that your server isn't blocking API requests
4. Check if your site uses Content Security Policy (CSP) headers that might be blocking Google Maps

For more information on Google Maps API, visit the [official documentation](https://developers.google.com/maps/documentation/javascript/overview).
