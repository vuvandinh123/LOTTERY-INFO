<?php
/*
Plugin Name: Thống Kê Xổ Số 2
Plugin URI: https://vuvandinh.id.vn
Description: Thống kê xổ số theo tỉnh thành.
Version: 1.1
Author: Vũ Văn Định
Author URI: https://vuvandinh.id.vn
License: GPL2
*/
// Ngăn không cho truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}
// Định nghĩa đường dẫn plugin.
define('LOTTERY_INFO_PATH', plugin_dir_path(__FILE__));
define('LOTTERY_INFO_URL', plugin_dir_url(__FILE__));

require_once LOTTERY_INFO_PATH . 'includes/lottery-enqueue.php';
require_once LOTTERY_INFO_PATH . 'includes/class-lottery-api.php';
require_once LOTTERY_INFO_PATH . 'includes/class-province-handler.php';
// Kích hoạt plugin.
function lottery_info_activate()
{
    // 
}
register_activation_hook(__FILE__, 'lottery_info_activate');

add_action('wp_ajax_lottery_api_call', 'lottery_api_call');
add_action('wp_ajax_nopriv_lottery_api_call', 'lottery_api_call');

function lottery_api_call()
{
    // Kiểm tra nonce để bảo mật
    check_ajax_referer('my_custom_nonce', 'nonce');
    $region = isset($_POST['region']) ? sanitize_text_field($_POST['region']) : 'mien-bac';
    $province = isset($_POST['province']) ? sanitize_text_field($_POST['province']) : '';

    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';
    $lottery = new Lottery_API();
    $payload = $lottery->prepare_response($region, $province, $date);
    wp_send_json_success($payload); // Trả về dữ liệu cho phía client
    wp_die(); // Dừng việc thực thi
}
// Hàm lấy dữ liệu từ API
function lottery_display_provinces($atts)
{
    $atts = shortcode_atts([
        'default' => '',
        'title' => '',
        'province' => '',
        'loto-hidden' => "0",
    ], $atts, 'lottery_info');
    $title = ($atts['title']);
    $default = sanitize_text_field($atts['default']);
    $province = sanitize_text_field($atts['province']);
    $loto_hidden = (int) sanitize_text_field($atts['loto-hidden']);
    if ($default !== 'mien-bac' && $default !== 'mien-nam' && $default !== 'mien-trung' && $default !== 'Vietlott' && $province === '') {
        $default = 'mien-bac';
    }
    $provinces = [];
    if ($default !== 'mien-bac') {
        $provinces = Province_Handler::fetch_provinces($default);
    } else if ($province === '') {
        $provinces = Province_Handler::fetch_provinces_mien_bac();
    }
    $unique_id = uniqid();
    ob_start();
    echo $title . "---------";
    require LOTTERY_INFO_PATH . 'templates/lottery-template.php';
    return ob_get_clean();
}
add_shortcode('lottery_info', 'lottery_display_provinces');

// menu
function lsg_shortcode_generator_page()
{
    include LOTTERY_INFO_PATH . 'templates/lottery-template-admin.php';
}
function lsg_add_admin_menu()
{
    add_menu_page(
        'lottery_info',           // Tên menu item
        'Thống Kê Xổ Số',           // Tên hiển thị
        'manage_options',                // Quyền hạn
        'lottery_info',           // Slug của menu
        'lsg_shortcode_generator_page',  // Hàm callback để hiển thị trang
        'dashicons-admin-generic',       // Icon
        20                               // Thứ tự
    );
}
add_action('admin_menu', 'lsg_add_admin_menu');

