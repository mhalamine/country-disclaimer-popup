<?php
$lang;

// Add settings menu
function country_popup_menu() {
    add_menu_page('Country Popup Settings', 'Country Popup', 'manage_options', 'country-popup-settings', 'country_popup_settings_page');
}
add_action('admin_menu', 'country_popup_menu');

// Settings page HTML
function country_popup_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Disclaimer Popup Settings', 'country-popup'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('country_popup_settings');
            do_settings_sections('country-popup-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// get current website language
function get_curr_lang() {
    global $lang;

    if ( function_exists('pll_the_languages') ) {
        $lang = pll_current_language();
    } else {
        $lang = substr(get_locale(), 0, 2);
    }
    return $lang;
}
// Register and initialize settings
function country_popup_register_settings() {

    $lang = get_curr_lang();

    register_setting('country_popup_settings', 'country_popup_enable_'.$lang);
    register_setting('country_popup_settings', 'country_popup_title_'.$lang);
    register_setting('country_popup_settings', 'country_popup_text_'.$lang);
    register_setting('country_popup_settings', 'country_list_'.$lang);
    register_setting('country_popup_settings', 'not_ok_country_list_'.$lang);
    register_setting('country_popup_settings', 'redirect_url_'.$lang);
    register_setting('country_popup_settings', 'country_popup_disclaimer_text_'.$lang);

    add_settings_section('country_popup_section', esc_html__('Popup Settings', 'country-popup'), 'country_popup_section_callback', 'country-popup-settings');

    add_settings_field('country_popup_enable_'.$lang, esc_html__('Popup Enable', 'country-popup'), 'country_popup_enable_callback', 'country-popup-settings', 'country_popup_section');
    add_settings_field('country_popup_title_'.$lang, esc_html__('Popup Title', 'country-popup'), 'country_popup_title_callback', 'country-popup-settings', 'country_popup_section');
    add_settings_field('country_popup_text_'.$lang, esc_html__('Popup Text', 'country-popup'), 'country_popup_text_callback', 'country-popup-settings', 'country_popup_section');
    add_settings_field('country_list_'.$lang, esc_html__('List of all Options (Comma Separated)', 'country-popup'), 'country_list_callback', 'country-popup-settings', 'country_popup_section');
    add_settings_field('not_ok_country_list_'.$lang, esc_html__('List of NOT Allowed Options (Comma Separated)', 'country-popup'), 'not_ok_country_list_callback', 'country-popup-settings', 'country_popup_section');
    add_settings_field('redirect_url_'.$lang, esc_html__('Redirect URL', 'country-popup'), 'redirect_url_callback', 'country-popup-settings', 'country_popup_section');
    add_settings_field('country_popup_disclaimer_text_'.$lang, esc_html__('Popup Disclaimer Text', 'country-popup'), 'country_popup_disclaimer_text_callback', 'country-popup-settings', 'country_popup_section');

}
add_action('admin_init', 'country_popup_register_settings');

// Settings fields callbacks
function country_popup_section_callback() {
    global $lang;
    echo esc_html__('Modify settings for the '.$lang.' popup.', 'country-popup');
}

function country_popup_enable_callback() {
    global $lang;
    $value = get_option('country_popup_enable_'.$lang);
    echo '<label for="country_popup_enable">';
    echo '<input type="checkbox" id="country_popup_enable" name="country_popup_enable_'.$lang.'" value="1" '.checked(1, $value, false).'>';
    echo esc_html_e('Enable Feature', 'country-popup');
    echo '</label>';
}

function country_popup_title_callback() {
    global $lang;
    $value = get_option('country_popup_title_'.$lang);
    echo '<input type="text" name="country_popup_title_'.$lang.'" style="width:400px" value="' . esc_attr($value) . '">';
}

function country_popup_text_callback() {
    global $lang;
    $value = get_option('country_popup_text_'.$lang);
    wp_editor($value, 'country_popup_text_'.$lang, array(
        'textarea_name' => 'country_popup_text_'.$lang,
        'textarea_rows' => 5,
    ));
}

function country_list_callback() {
    global $lang;
    $value = get_option('country_list_'.$lang);
    echo '<textarea name="country_list_'.$lang.'" cols="50" rows="5">' . esc_textarea($value) . '</textarea>';
}

function not_ok_country_list_callback() {
    global $lang;
    $value = get_option('not_ok_country_list_'.$lang);
    echo '<textarea name="not_ok_country_list_'.$lang.'" cols="50" rows="5">' . esc_textarea($value) . '</textarea>';
}

function redirect_url_callback() {
    global $lang;
    $value = get_option('redirect_url_'.$lang);
    echo '<input type="text" name="redirect_url_'.$lang.'" style="width:400px" value="' . esc_attr($value) . '">';
}

function country_popup_disclaimer_text_callback() {
    global $lang;
    $value = get_option('country_popup_disclaimer_text_'.$lang);
    wp_editor($value, 'country_popup_disclaimer_text', array(
        'textarea_name' => 'country_popup_disclaimer_text_'.$lang,
        'textarea_rows' => 5,
    ));
}
