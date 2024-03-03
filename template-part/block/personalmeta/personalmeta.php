<?php

/**
 * personalmeta Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'personalmeta-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'personalmeta';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
} 
if( $is_preview ) {
    $className .= ' is-admin';
}

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php if( get_field('email_address') ) { echo '<div><a href="mailto:' . get_field('email_address') . '"><span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M1.75 3h20.5c.966 0 1.75.784 1.75 1.75v14a1.75 1.75 0 0 1-1.75 1.75H1.75A1.75 1.75 0 0 1 0 18.75v-14C0 3.784.784 3 1.75 3ZM1.5 7.412V18.75c0 .138.112.25.25.25h20.5a.25.25 0 0 0 .25-.25V7.412l-9.52 6.433c-.592.4-1.368.4-1.96 0Zm0-2.662v.852l10.36 7a.25.25 0 0 0 .28 0l10.36-7V4.75a.25.25 0 0 0-.25-.25H1.75a.25.25 0 0 0-.25.25Z"/></svg> Email  </span></a></div>'; }?>
    <?php if( get_field('vcard') ) { echo '<div ><a href="' . get_field('vcard') . '"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 2048 1536"><path fill="currentColor" d="M1024 1003q0 64-37 106.5t-91 42.5H384q-54 0-91-42.5T256 1003t9-117.5t29.5-103t60.5-78t97-28.5q6 4 30 18t37.5 21.5T555 733t43 14.5t42 4.5t42-4.5t43-14.5t35.5-17.5T798 694t30-18q57 0 97 28.5t60.5 78t29.5 103t9 117.5zM867 483q0 94-66.5 160.5T640 710t-160.5-66.5T413 483t66.5-160.5T640 256t160.5 66.5T867 483zm925 445v64q0 14-9 23t-23 9h-576q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h576q14 0 23 9t9 23zm0-252v56q0 15-10.5 25.5T1756 768h-568q-15 0-25.5-10.5T1152 732v-56q0-15 10.5-25.5T1188 640h568q15 0 25.5 10.5T1792 676zm0-260v64q0 14-9 23t-23 9h-576q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h576q14 0 23 9t9 23zm128 960V160q0-13-9.5-22.5T1888 128H160q-13 0-22.5 9.5T128 160v1216q0 13 9.5 22.5t22.5 9.5h352v-96q0-14 9-23t23-9h64q14 0 23 9t9 23v96h768v-96q0-14 9-23t23-9h64q14 0 23 9t9 23v96h352q13 0 22.5-9.5t9.5-22.5zm128-1216v1216q0 66-47 113t-113 47H160q-66 0-113-47T0 1376V160Q0 94 47 47T160 0h1728q66 0 113 47t47 113z"/></svg><span>Download V-Card</span></span></a></div>'; }?>        
    <?php if( get_field('linkedin_address') ) { echo '<div><a target="_blank" href="' . get_field('linkedin_address') . '"><span><svg style="position:relative; top:-2px;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M6.94 5a2 2 0 1 1-4-.002a2 2 0 0 1 4 .002ZM7 8.48H3V21h4V8.48Zm6.32 0H9.34V21h3.94v-6.57c0-3.66 4.77-4 4.77 0V21H22v-7.93c0-6.17-7.06-5.94-8.72-2.91l.04-1.68Z"/></svg> LinkedIn</span></a></div>'; }?>
    <?php if( get_field('phone_number') ) { echo '<div ><a onclick="event.preventDefault();" href="#"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 256"><path fill="currentColor" d="m221.59 160.3l-47.24-21.17a14 14 0 0 0-13.28 1.22a4.81 4.81 0 0 0-.56.42l-24.69 21a1.88 1.88 0 0 1-1.68.06c-15.87-7.66-32.31-24-40-39.65a1.91 1.91 0 0 1 0-1.68l21.07-25a6.13 6.13 0 0 0 .42-.58a14 14 0 0 0 1.12-13.27L95.73 34.49a14 14 0 0 0-14.56-8.38A54.24 54.24 0 0 0 34 80c0 78.3 63.7 142 142 142a54.25 54.25 0 0 0 53.89-47.17a14 14 0 0 0-8.3-14.53ZM176 210c-71.68 0-130-58.32-130-130a42.23 42.23 0 0 1 36.67-42h.23a2 2 0 0 1 1.84 1.31l21.1 47.11a2 2 0 0 1 0 1.67l-21.11 25.06a4.73 4.73 0 0 0-.43.57a14 14 0 0 0-.91 13.73c8.87 18.16 27.17 36.32 45.53 45.19a14 14 0 0 0 13.77-1c.19-.13.38-.27.56-.42l24.68-21a1.92 1.92 0 0 1 1.6-.1l47.25 21.17a2 2 0 0 1 1.21 2A42.24 42.24 0 0 1 176 210Z"/></svg><span onclick="showNumber(this)" id="phone-number" data-number="' . get_field('phone_number') . '">Phone Number</span></span></a></div>'; }?>        

<script>
function showNumber(element) {
    // When the element is clicked, the phone number is inserted into the text
    element.textContent = element.dataset.number;
}
</script>

</div>
