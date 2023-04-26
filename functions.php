<?php

function menu_campaign()
{
    add_menu_page('activeCampaign', 'Active Campaign', '', 'setting_apps', 'submenuiklan', 'dashicons-store');
    add_submenu_page('setting_apps', 'Beranda', 'List Campaign', 'manage_options', 'beranda', 'beranda');
    add_submenu_page('setting_apps', 'Setting', 'Setting', 'manage_options', 'seeting_api', 'seeting_api');
}

function beranda()
{
    include(plugin_dir_path(__FILE__) . 'beranda.php');
}
function seeting_api()
{
    include(plugin_dir_path(__FILE__) . 'setting.php');
}

add_action('admin_menu', 'menu_campaign');

function activecampaign()
{
    $url = get_settings('siteurl');
    $urlcss = $url . '/wp-content/plugins/activecampaign/main.css';
    $urljs = $url . '/wp-content/plugins/activecampaign/main.js';
    echo '<link rel="stylesheet" type="text/css" href="' . $urlcss . '" />';
    echo '<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />';
    echo '<link rel="stylesheet" type="text/css" href="' . $url . '/wp-content/plugins/activecampaign/fontawesome/css/all.min.css" />';
    echo '<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">';
    echo '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />';
    echo '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
    // DATA TABLES
    echo '<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>';
    echo '<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>';
    echo '<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>';
    echo '<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>';

    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"></script>';
    echo '<script src="https://js.pusher.com/6.0/pusher.min.js"></script>';
    echo '<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>';
    echo '<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>';
    echo '<script src="' . $urljs . '"></script>';
}
add_action('admin_head', 'activecampaign');


function code_activeCampaign($atts, $content = null)
{
    $defaults = array(
        'post_id' => '',
    );
    // Confirm that $post_id is an integer.
    if (!empty($atts['post_id']))  $atts['post_id'];
    // ----
    // Now you can use $atts['post_id'] - it will contain
    // the integer value of the post_id set in the shortcode, or
    // 0 if nothing is set in the shortcode.
    // ----
    global $content;
    ob_start();
    include ABSPATH . "wp-content/plugins/activecampaign/form.php";
    $output = ob_get_clean();
    return $output;
}
add_shortcode('code_activeCampaign', 'code_activeCampaign');
