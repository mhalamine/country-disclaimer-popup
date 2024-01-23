<?php
$lang;

// Add settings menu
function disclaimer_multilang_popup_menu() {
    add_menu_page('Disclaimer Multilang Popup Settings', 'Disclaimer Multilang Popup', 'manage_options', 'disclaimer-multilang-popup-settings', 'disclaimer_multilang_popup_settings_page');
}
add_action('admin_menu', 'disclaimer_multilang_popup_menu');

// Settings page HTML
function disclaimer_multilang_popup_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Disclaimer Popup Settings', 'disclaimer-multilang-popup'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('disclaimer_multilang_popup_settings');
            do_settings_sections('disclaimer-multilang-popup-settings');
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
function disclaimer_multilang_popup_register_settings() {

    $lang = get_curr_lang();

    register_setting('disclaimer_multilang_popup_settings', 'disclaimer_multilang_popup_enable_'.$lang);
    register_setting('disclaimer_multilang_popup_settings', 'disclaimer_multilang_popup_title_'.$lang);
    register_setting('disclaimer_multilang_popup_settings', 'disclaimer_multilang_popup_text_'.$lang);
    register_setting('disclaimer_multilang_popup_settings', 'country_list_'.$lang);
    register_setting('disclaimer_multilang_popup_settings', 'not_allowed_country_list_'.$lang);
    register_setting('disclaimer_multilang_popup_settings', 'redirect_url_'.$lang);
    register_setting('disclaimer_multilang_popup_settings', 'disclaimer_multilang_popup_disclaimer_text_'.$lang);

    add_settings_section('disclaimer_multilang_popup_section', esc_html__('Popup Settings', 'disclaimer-multilang-popup'), 'disclaimer_multilang_popup_section_callback', 'disclaimer-multilang-popup-settings');

    add_settings_field('disclaimer_multilang_popup_enable_'.$lang, esc_html__('Popup Enable', 'disclaimer-multilang-popup'), 'disclaimer_multilang_popup_enable_callback', 'disclaimer-multilang-popup-settings', 'disclaimer_multilang_popup_section');
    add_settings_field('disclaimer_multilang_popup_title_'.$lang, esc_html__('Popup Title', 'disclaimer-multilang-popup'), 'disclaimer_multilang_popup_title_callback', 'disclaimer-multilang-popup-settings', 'disclaimer_multilang_popup_section');
    add_settings_field('disclaimer_multilang_popup_text_'.$lang, esc_html__('Popup Text', 'disclaimer-multilang-popup'), 'disclaimer_multilang_popup_text_callback', 'disclaimer-multilang-popup-settings', 'disclaimer_multilang_popup_section');
    add_settings_field('country_list_'.$lang, esc_html__('List of all Options (Comma Separated)', 'disclaimer-multilang-popup'), 'country_list_callback', 'disclaimer-multilang-popup-settings', 'disclaimer_multilang_popup_section');
    add_settings_field('not_allowed_country_list_'.$lang, esc_html__('List of NOT Allowed Options (Comma Separated)', 'disclaimer-multilang-popup'), 'not_allowed_country_list_callback', 'disclaimer-multilang-popup-settings', 'disclaimer_multilang_popup_section');
    add_settings_field('redirect_url_'.$lang, esc_html__('Redirect URL', 'disclaimer-multilang-popup'), 'redirect_url_callback', 'disclaimer-multilang-popup-settings', 'disclaimer_multilang_popup_section');
    add_settings_field('disclaimer_multilang_popup_disclaimer_text_'.$lang, esc_html__('Popup Disclaimer Text', 'disclaimer-multilang-popup'), 'disclaimer_multilang_popup_disclaimer_text_callback', 'disclaimer-multilang-popup-settings', 'disclaimer_multilang_popup_section');

}
add_action('admin_init', 'disclaimer_multilang_popup_register_settings');

// Settings fields callbacks
function disclaimer_multilang_popup_section_callback() {
    global $lang;
    echo esc_html__('Modify settings for the '.$lang.' popup.', 'disclaimer-multilang-popup');
}

function disclaimer_multilang_popup_enable_callback() {
    global $lang;
    $value = get_option('disclaimer_multilang_popup_enable_'.$lang);
    echo '<label for="disclaimer_multilang_popup_enable">';
    echo '<input type="checkbox" id="disclaimer_multilang_popup_enable" name="disclaimer_multilang_popup_enable_'.$lang.'" value="1" '.checked(1, $value, false).'>';
    echo esc_html_e('Enable Feature', 'disclaimer-multilang-popup');
    echo '</label>';
}

function disclaimer_multilang_popup_title_callback() {
    global $lang;
    $value = get_option('disclaimer_multilang_popup_title_'.$lang);
    echo '<input type="text" name="disclaimer_multilang_popup_title_'.$lang.'" style="width:400px" value="' . esc_attr($value) . '">';
}

function disclaimer_multilang_popup_text_callback() {
    global $lang;
    $value = get_option('disclaimer_multilang_popup_text_'.$lang);
    wp_editor($value, 'disclaimer_multilang_popup_text_'.$lang, array(
        'textarea_name' => 'disclaimer_multilang_popup_text_'.$lang,
        'textarea_rows' => 5,
    ));
}

function country_list_callback() {
    global $lang;
    $value = get_option('country_list_'.$lang);
    echo '<textarea name="country_list_'.$lang.'" cols="50" rows="5">' . esc_textarea($value) . '</textarea>';
}

function not_allowed_country_list_callback() {
    global $lang;
    $value = get_option('not_allowed_country_list_'.$lang);
    echo '<textarea name="not_allowed_country_list_'.$lang.'" cols="50" rows="5">' . esc_textarea($value) . '</textarea>';
}

function redirect_url_callback() {
    global $lang;
    $value = get_option('redirect_url_'.$lang);
    echo '<input type="text" name="redirect_url_'.$lang.'" style="width:400px" value="' . esc_attr($value) . '">';
}

function disclaimer_multilang_popup_disclaimer_text_callback() {
    global $lang;
    $value = get_option('disclaimer_multilang_popup_disclaimer_text_'.$lang);
    wp_editor($value, 'disclaimer_multilang_popup_disclaimer_text', array(
        'textarea_name' => 'disclaimer_multilang_popup_disclaimer_text_'.$lang,
        'textarea_rows' => 5,
    ));
}
