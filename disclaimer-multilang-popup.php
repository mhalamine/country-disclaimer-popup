<?php
/**
 * @link              https://alamine.me/
 * @since             1.0.1
 * @package           Disclaimer_Multilang_Popup
 * @wordpress-plugin
 * Plugin Name: Disclaimer Multilang Popup Plugin
 * Plugin URI:        https://alamine.me/plugins/disclaimer-multilang-popup-plugin/
 * Description: Displays a popup on the homepage for selecting a country. Based on the selection the user is either granted access or redirected to a custom url
 * Version: 1.0.1
 * Author: Mohamed Al Amine
 * Author URI: https://alamine.me/
 * Text Domain: disclaimer-multilang-popup
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DISCLAIMER-MULTILANG-POPUP', '1.0.1' );

// Setting page
include("settings.php");

// Enqueue necessary scripts and styles for the popup.
function disclaimer_multilang_popup_enqueue_scripts() {
    $lang = get_curr_lang();

    wp_enqueue_style('disclaimer-multilang-popup-css', plugin_dir_url(__FILE__) . 'css/disclaimer-multilang-popup.css');
    wp_enqueue_script('disclaimer-multilang-popup-js', plugin_dir_url(__FILE__) . 'js/disclaimer-multilang-popup.js', array('jquery'), '', true);

    // Define variables to pass to JavaScript
    $not_allowed_countries = explode(',', get_option('not_allowed_country_list_'.$lang));

    $redirect_url = get_option('redirect_url_'.$lang);

    // Localize the script with data
    wp_localize_script('disclaimer-multilang-popup-js', 'disclaimerMultilangPopupParams', array(
        'notAllowedCountries' => $not_allowed_countries,
        'redirectURL' => $redirect_url,
    ));
}

// Create the function to display the popup on the homepage.
function disclaimer_multilang_popup_display() {
    $lang = get_curr_lang();
    $popup_enabled = get_option('disclaimer_multilang_popup_enable_'.$lang);

    if (is_front_page() && $popup_enabled) {
        // Get plugin settings
        $popup_title = get_option('disclaimer_multilang_popup_title_'.$lang);
        $popup_text = get_option('disclaimer_multilang_popup_text_'.$lang);
        $countries = explode(',', get_option('country_list_'.$lang));
        $not_allowed_countries = explode(',', get_option('not_allowed_countries'.$lang));
        $redirect_url = get_option('redirect_url_'.$lang);
        $popup_disclaimer_text = get_option('disclaimer_multilang_popup_disclaimer_text_'.$lang);

        // define allowed tags
        $allowed_tags = array(
            'a' => array(
                'href' => array(),
                'title' => array()
            ),
            'br' => array(),
            'p' => array(),
            'strong' => array()
            // Add more allowed tags and their attributes as needed
        );

        // Display popup HTML
        echo '<div class="popup-container">';
        echo '<div id="disclaimer-multilang-popup" class="disclaimer-multilang-popup">';
        echo '<h2>' . esc_html($popup_title) . '</h2>';
        echo '<p>' . wp_kses(wpautop($popup_text), $allowed_tags) . '</p>';
        echo '<form id="disclaimer-multilang-popup-form" action="" method="post">';
        echo '<select id="country-dropdown" name="selected_country">';
        echo '<option value="-">'. esc_attr(__('Select country', 'disclaimer-multilang-popup')) .'</option>';
        // Populate dropdown with countries
        foreach ($countries as $country) {
            echo '<option value="' . esc_attr($country) . '">' . esc_html($country) . '</option>';
        }
        
        echo '</select>';
        echo '<input type="submit" name="submit_country" value="'. esc_attr(__('Submit', 'disclaimer-multilang-popup')) .'">';
        echo '</form>';
        echo '</div>';

        // Display disclaimar popup
        echo '<div id="disclaimer-popup" class="disclaimer-popup">';
        echo '<div class="disclaimer_text">' . wp_kses(wpautop($popup_disclaimer_text), $allowed_tags) . '</div>';
        echo '<div class="disclaimer-buttons">';
        echo '<button id="agree-button">'.esc_attr(__('Agree', 'disclaimer-multilang-popup')).'</button>';
        echo '<button id="disagree-button" class="disagree">'.esc_attr(__('Disagree', 'disclaimer-multilang-popup')).'</button>';
        echo '</div>';
        echo '</div>';

        echo '</div>';

        // Include JavaScript for handling the form submission and redirect
        wp_enqueue_script('disclaimer-multilang-popup-handle', plugin_dir_url(__FILE__) . 'js/disclaimer-multilang-popup-handle.js', array('jquery'), '', true);
    }
}

// Load the translation files
function load_my_plugin_textdomain() {
    load_plugin_textdomain('disclaimer-multilang-popup', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('init', 'load_my_plugin_textdomain');

// Plugin initialization
function disclaimer_multilang_popup_init() {
    // Add scripts and styles
    add_action('wp_enqueue_scripts', 'disclaimer_multilang_popup_enqueue_scripts');
    // Display popup on homepage
    add_action('wp_footer', 'disclaimer_multilang_popup_display');

   
}
add_action('init', 'disclaimer_multilang_popup_init');

