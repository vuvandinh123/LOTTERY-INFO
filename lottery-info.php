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
    // Tạo bảng để lưu các tỉnh thành khi kích hoạt plugin.
    // Province_Handler::create_province_table();
    // Province_Handler::fetch_and_store_provinces();
}
register_activation_hook(__FILE__, 'lottery_info_activate');

add_action('wp_ajax_lottery_api_call', 'lottery_api_call');
add_action('wp_ajax_nopriv_lottery_api_call', 'lottery_api_call');

function lottery_api_call()
{
    // Kiểm tra nonce để bảo mật
    check_ajax_referer('my_custom_nonce', 'nonce');
    $region = isset($_POST['region']) ? sanitize_text_field($_POST['region']) : 'mien-bac'; // Mặc định là 'mien-bac'
    $province = isset($_POST['province']) ? sanitize_text_field($_POST['province']) : '';

    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';

    $payload = Lottery_API::prepare_response($region, $province, $date);
    wp_send_json_success($payload); // Trả về dữ liệu cho phía client
    wp_die(); // Dừng việc thực thi
}
// Hàm lấy dữ liệu từ API
function lottery_display_provinces($atts)
{
    $atts = shortcode_atts([
        'default' => 'mien-bac',
        'title' => 'Kết quả xổ số truyền thống',
        'loto_hidden' => 0,
        'limit' => 3,
    ], $atts, 'lottery_info');
    $title = sanitize_text_field($atts['title']);
    $default = sanitize_text_field($atts['default']);
    $loto_hidden = (int) sanitize_text_field($atts['loto_hidden']);
    if ($default !== 'mien-bac' && $default !== 'mien-nam' && $default !== 'mien-trung') {
        $default = 'mien-bac';
    }
    $provinces = [];
    if ($default !== 'mien-bac') {
        $provinces = Province_Handler::fetch_provinces($default);
    }
    $unique_id = uniqid();
    ob_start();
    require LOTTERY_INFO_PATH . 'templates/lottery-template.php';
    return ob_get_clean();
}
add_shortcode('lottery_info', 'lottery_display_provinces');

