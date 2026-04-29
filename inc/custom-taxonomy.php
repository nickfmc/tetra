<?php
/**
 * GutenDev Custom Taxonomy Registration Party
 * REMBEMBER -> Uncomment / add this file to functions.php
 */


// register ###REPLACE_ME### custom taxonomy
 add_action( 'init', 'gdt_project_type_reg', 0 );

// create taxonomy, for the post type(s) you connect it to below
function gdt_project_type_reg() {
  // Add new taxonomy, make it hierarchical (like categories)
  $singular = 'Project Type';
  $plural = 'Project Types';
  $labels = array(
    'name'              => "$plural",
    'singular_name'     => "$singular",
    'search_items'      => "$plural",
    'all_items'         => "$plural",
    'parent_item'       => "Parent $singular",
    'parent_item_colon' => "Parent $singular",
    'edit_item'         => "Edit $singular",
    'update_item'       => "Update $singular",
    'add_new_item'      => "Add New $singular",
    'new_item_name'     => "New $singular Name",
    'menu_name'         => "$plural"
  );
  $args = array(
    'public'            => false,
    'show_in_rest'      => true,
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => false  /* true or use custom slug => array( 'slug' => 'custom-tag-slug', 'with_front' => false  ) */
  );
  register_taxonomy( 'project_type_tax', array( 'property' ), $args );
}

// register Province custom taxonomy for tetra_bute post type
add_action( 'init', 'gdt_province_reg', 0 );

// create Province taxonomy for tetra_bute post type
function gdt_province_reg() {
  // Add new taxonomy, make it hierarchical (like categories)
  $singular = 'Province';
  $plural = 'Provinces';
  $labels = array(
    'name'              => "$plural",
    'singular_name'     => "$singular",
    'search_items'      => "Search $plural",
    'all_items'         => "All $plural",
    'parent_item'       => "Parent $singular",
    'parent_item_colon' => "Parent $singular:",
    'edit_item'         => "Edit $singular",
    'update_item'       => "Update $singular",
    'add_new_item'      => "Add New $singular",
    'new_item_name'     => "New $singular Name",
    'menu_name'         => "$plural"
  );
  $args = array(
    'public'            => true,
    'show_in_rest'      => true,
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'province', 'with_front' => false )
  );
  register_taxonomy( 'province', array( 'tetra_bute' ), $args );
}

// Add custom fields to province taxonomy
add_action( 'province_add_form_fields', 'province_add_form_fields_callback' );
// Re-enabling with explicit parameters - this showed the fields briefly
add_action( 'province_edit_form_fields', 'province_edit_form_fields_callback', 10, 2 );
add_action( 'edited_province', 'save_province_custom_fields' );
add_action( 'create_province', 'save_province_custom_fields' );

function province_add_form_fields_callback( $taxonomy ) {
    echo '<div class="form-field">
        <label for="tag-svg-media">Custom SVG</label>
        <div id="svg-media-wrapper">
            <input type="hidden" name="svg_media_id" id="tag-svg-media-id" value="" />
            <button type="button" class="button" id="upload-svg-button">Select SVG from Media Library</button>
            <button type="button" class="button" id="remove-svg-button" style="display:none;">Remove SVG</button>
            <div id="svg-preview" style="margin-top: 10px; display: none;">
                <img id="svg-preview-img" src="" alt="SVG Preview" style="max-width: 100px; max-height: 100px;" />
                <p id="svg-filename"></p>
            </div>
        </div>
        <p>Upload or select a custom SVG file for this province</p>
    </div>';
    
    echo '<div class="form-field">
        <label for="tag-svg-color">SVG Color</label>
        <input name="svg_color" id="tag-svg-color" type="color" value="#3498db" />
        <p>Choose the color for the SVG shape (will be applied as fill color)</p>
    </div>';
    
    echo '<div class="form-field">
        <label for="tag-tooltip-text">Tooltip Text</label>
        <input name="tooltip_text" id="tag-tooltip-text" type="text" value="" placeholder="Enter custom tooltip text" />
        <p>Custom text to display in tooltip on hover (leave empty to use province name)</p>
    </div>';
}

function province_edit_form_fields_callback( $term, $taxonomy ) {
    $svg_media_id = get_term_meta( $term->term_id, 'svg_media_id', true );
    $svg_color = get_term_meta( $term->term_id, 'svg_color', true );
    $tooltip_text = get_term_meta( $term->term_id, 'tooltip_text', true );
    
    if (empty($svg_color)) {
        $svg_color = '#3498db';
    }
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="tag-svg-media-id">Custom SVG ID</label>
        </th>
        <td>
            <input name="svg_media_id" id="tag-svg-media-id" type="text" value="<?php echo esc_attr($svg_media_id); ?>" />
            <p class="description">Enter media library ID for SVG file (temporary simple version)</p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="tag-svg-color">SVG Color</label>
        </th>
        <td>
            <input name="svg_color" id="tag-svg-color" type="color" value="<?php echo esc_attr($svg_color); ?>" />
            <p class="description">Choose the color for the SVG shape</p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="tag-tooltip-text">Tooltip Text</label>
        </th>
        <td>
            <input name="tooltip_text" id="tag-tooltip-text" type="text" value="<?php echo esc_attr($tooltip_text); ?>" placeholder="Enter custom tooltip text" />
            <p class="description">Custom text to display in tooltip on hover (leave empty to use province name)</p>
        </td>
    </tr>
    <?php
}

function save_province_custom_fields( $term_id ) {
    if ( isset( $_POST['svg_media_id'] ) ) {
        update_term_meta( $term_id, 'svg_media_id', absint( $_POST['svg_media_id'] ) );
    }
    if ( isset( $_POST['svg_color'] ) ) {
        update_term_meta( $term_id, 'svg_color', sanitize_hex_color( $_POST['svg_color'] ) );
    }
    if ( isset( $_POST['tooltip_text'] ) ) {
        update_term_meta( $term_id, 'tooltip_text', sanitize_text_field( $_POST['tooltip_text'] ) );
    }
}

/**
 * Helper function to get and process custom SVG content
 */
function get_province_custom_svg( $province_id ) {
    // Re-enabled after debugging
    
    if (!$province_id) {
        return false;
    }
    
    $svg_media_id = get_term_meta($province_id, 'svg_media_id', true);
    
    if (!$svg_media_id || !is_numeric($svg_media_id)) {
        return false;
    }
    
    $svg_path = get_attached_file($svg_media_id);
    
    if (!$svg_path || !file_exists($svg_path)) {
        return false;
    }
    
    $svg_content = @file_get_contents($svg_path);
    
    if (!$svg_content || empty($svg_content)) {
        return false;
    }
    
    // Add class and ensure it uses currentColor for styling
    $svg_content = str_replace('<svg', '<svg class="c-province-svg"', $svg_content);
    
    // Replace any existing fill colors with currentColor for consistent styling
    $svg_content = preg_replace('/fill="[^"]*"/', 'fill="currentColor"', $svg_content);
    $svg_content = preg_replace('/fill:[^;]*;/', 'fill: currentColor;', $svg_content);
    
    return $svg_content;
}


?>
