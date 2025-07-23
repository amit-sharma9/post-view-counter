<?php
/*
Plugin Name: Post View Counter
Description: Counts and displays how many times each post has been viewed, with Astra‑specific hook and fallback ,with an admin settings page.
Version:     1.1
Author:      Amit Sharma
Text Domain: post-view-counter
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}


/** ➊ Register & sanitize settings */
function pvc_register_settings() {
    register_setting('pvc_options_group', 'pvc_options', 'pvc_sanitize_options');
}
add_action('admin_init', 'pvc_register_settings');

function pvc_sanitize_options($input) {
    return [
        'enabled' => !empty($input['enabled']),
        'label'   => sanitize_text_field($input['label']),
    ];
}


/** ➋ Add Settings page */
function pvc_add_settings_page() {
    add_options_page(
        'Post View Counter Settings',
        'Post View Counter',
        'manage_options',
        'pvc-settings',
        'pvc_render_settings_page'
    );
}
add_action('admin_menu', 'pvc_add_settings_page');


/** ➌ Render Settings form */
function pvc_render_settings_page() {
    $opts = get_option('pvc_options', [
        'enabled' => true,
        'label'   => '👁️ Views: %d'
    ]);
    ?>
    <div class="wrap">
      <h1>Post View Counter Settings</h1>
      <form method="post" action="options.php">
        <?php settings_fields('pvc_options_group'); ?>
        <table class="form-table">
          <tr valign="top">
            <th scope="row">Enable Counter</th>
            <td>
              <input type="checkbox"
                     name="pvc_options[enabled]"
                     value="1"
                     <?php checked($opts['enabled'], true); ?>>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">Label Format</th>
            <td>
              <input type="text"
                     name="pvc_options[label]"
                     value="<?php echo esc_attr($opts['label']); ?>"
                     class="regular-text">
              <p class="description">Use <code>%d</code> where the view number appears.</p>
            </td>
          </tr>
        </table>
        <?php submit_button(); ?>
      </form>
    </div>
    <?php
}


/** ➍ Increment view count on each single post load */
function pvc_increment_post_views() {
    $opts = get_option('pvc_options');
    if ( empty($opts['enabled']) || ! is_singular('post') ) {
        return;
    }
    global $post;
    if ( empty($post->ID) ) {
        return;
    }
    $post_id = $post->ID;
    $views   = (int) get_post_meta($post_id, 'post_views', true);
    update_post_meta($post_id, 'post_views', $views + 1);
}
add_action('wp', 'pvc_increment_post_views');


/** ➎ Helper to get the views HTML */
function pvc_get_views_html() {
    global $post;
    $opts = get_option('pvc_options');
    $views = (int) get_post_meta($post->ID, 'post_views', true);
    return '<p style="color:gray; font-size:14px; margin-bottom:10px;">'
         . sprintf(esc_html($opts['label']), $views)
         . '</p>';
}


/** ➏ Astra‑specific display hook */
function pvc_astra_display() {
    $opts = get_option('pvc_options');
    if ( ! empty($opts['enabled']) && is_singular('post') && wp_get_theme()->get('Name') === 'Astra' ) {
        echo pvc_get_views_html();
    }
}
add_action('astra_entry_content_before', 'pvc_astra_display');


/** ➐ Fallback for other themes */
function pvc_fallback_display($content) {
    $opts = get_option('pvc_options');
    if ( ! empty($opts['enabled']) && is_singular('post') && wp_get_theme()->get('Name') !== 'Astra' ) {
        return pvc_get_views_html() . $content;
    }
    return $content;
}
add_filter('the_content', 'pvc_fallback_display');
