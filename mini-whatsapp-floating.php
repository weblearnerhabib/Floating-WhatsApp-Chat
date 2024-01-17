<?php
/**
 * Plugin Name: Mini Whatsapp Floating
 * Description: WhatsApp Floating Button in WordPress
 * Plugin URI: https://github.com/weblearnerhabib
 * Author: Freelancer Habib
 * Author URI: https://freelancer.com/u/csehabiburr183
 * Version: 1.0
 */

// Enqueue styles
function fwab_enqueue_styles() {
    wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
    wp_enqueue_style('fwab-style', plugins_url('callwhatsapp.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'fwab_enqueue_styles');


// Enqueue styles for admin pages
function fwab_enqueue_admin_styles() {
    wp_enqueue_style('fwab-admin-style', plugins_url('callwhatsappadmin.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'fwab_enqueue_admin_styles');


// Add floating WhatsApp button
function fwab_add_whatsapp_button() {
    $whatsapp_number = get_option('fwab_whatsapp_number');
    ?>
    <div class="floating_btn">
        <a target="_blank" href="https://wa.me/<?php echo esc_attr($whatsapp_number); ?>">
            <div class="contact_icon">
                <i class="fa fa-whatsapp my-float"></i>
            </div>
        </a>
        <p class="text_icon">Talk to us?</p>
    </div>
    <?php
}

// Add floating WhatsApp button to the footer
function fwab_output_whatsapp_button() {
    echo '<div class="fwab-whatsapp-button-wrapper">';
    fwab_add_whatsapp_button();
    echo '</div>';
}
add_action('wp_footer', 'fwab_output_whatsapp_button');

// Add action hook for adding WhatsApp number
function fwab_add_number_action() {
    if (isset($_POST['fwab_whatsapp_number'])) {
        update_option('fwab_whatsapp_number', sanitize_text_field($_POST['fwab_whatsapp_number']));
    }
    wp_redirect(admin_url('admin.php?page=fwab-settings'));
    exit;
}
add_action('admin_post_fwab_add_number', 'fwab_add_number_action');

// Add admin menu
function fwab_add_admin_menu() {
    add_menu_page('WhatsApp Settings', 'Add WhatsApp', 'manage_options', 'fwab-settings', 'fwab_render_admin_settings', 'dashicons-whatsapp');
}
add_action('admin_menu', 'fwab_add_admin_menu');

// Render admin settings page
function fwab_render_admin_settings() {
    ?>
    <div id="habib-apps">
        <div class="whats-wrap">
            <h1>WhatsApp Settings</h1>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('fwab_add_number'); ?>
                <label for="fwab_whatsapp_number" id="adwapp">Add WhatsApp Number Below:</label>
                <input id="whatsinput" type="text" name="fwab_whatsapp_number" value="<?php echo esc_attr(get_option('fwab_whatsapp_number')); ?>"/>
                <br><br>
                <input type="hidden" name="action" value="fwab_add_number">
                <input type="submit" value="Save" class="custom-whatsapp-btn">
            </form>
        </div>

        <div id="dev-section">
            <div class="developer-info">
                <h2> Hire Me for Work </h2>
                <h1> Habib </h1>
                <a href="https://freelancer.com/u/csehabiburr183" target="_blank" class="hirebtn">
                    <img src="<?php echo plugins_url('assets/Freelancer.png', __FILE__); ?>">
                </a>
            </div>

            <div class="dev-photo">
                <img src="<?php echo plugins_url('assets/AdnanHabib.png', __FILE__); ?>">
            </div>
        </div>
        
    </div>
    <!-- Entire Admin Box -->
    <?php
}