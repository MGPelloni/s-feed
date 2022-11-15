<?php
/**
 * Creates an option page.
 */
function sfeed_custom_admin_menu() {
    add_menu_page('S-Feed', 'S-Feed', 'manage_options', 's-feed', 'sfeed_options_page', 'dashicons-camera', 58);
}

/**
 * Callback function for the options page.
 */
function sfeed_options_page() {
    require_once(SFEED_PLUGIN_PATH . 'src/templates/admin.php');
}

/**
 * Enqueuing styles and scripts.
 */
function sfeed_styles_and_scripts() {
    // Styles
    wp_register_style( 's-feed', SFEED_PLUGIN_URL . 'dist/s-feed.min.css', [], filemtime(SFEED_PLUGIN_PATH . 'dist/s-feed.min.css') );
    wp_enqueue_style( 's-feed' );
  
    // Scripts
    wp_register_script( 's-feed', SFEED_PLUGIN_URL . 'dist/s-feed.min.js', [], filemtime(SFEED_PLUGIN_PATH . 'dist/s-feed.min.js'), true );
    
    $localize_data = [
      'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
      'nonce' => wp_create_nonce('sfeed-nonce') // AJAX Nonce
    ];
  
    wp_localize_script( 's-feed', 'sfeed', $localize_data);
    wp_enqueue_script( 's-feed' );
}
