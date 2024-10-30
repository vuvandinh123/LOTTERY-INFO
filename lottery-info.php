<?php
/*
Plugin Name: Thống Kê Xổ Số
Plugin URI: https://vuvandinh.id.vn
Description: Thống kê xổ số theo tỉnh thành.
Version: 1.1
Author: Vũ Văn Định
Author URI: https://vuvandinh.id.vn
License: GPL2
*/
if (!defined('ABSPATH')) {
    exit;
}
// Định nghĩa đường dẫn plugin.
define('LOTTERY_INFO_PATH', plugin_dir_path(__FILE__));
define('LOTTERY_INFO_URL', plugin_dir_url(__FILE__));
// Lớp WP_List_Table tuỳ chỉnh
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
require_once LOTTERY_INFO_PATH . 'includes/lottery-enqueue.php';
require_once LOTTERY_INFO_PATH . 'includes/class-lottery-api.php';
require_once LOTTERY_INFO_PATH . 'includes/class-province-handler.php';
require_once LOTTERY_INFO_PATH . 'includes/class-add-table-lottery-history.php';
include_once LOTTERY_INFO_PATH . 'includes/wp-form-add-data.php';
include_once LOTTERY_INFO_PATH . 'includes/wp-list-lottery-data-list-table.php';
include_once LOTTERY_INFO_PATH . 'includes/wp_add_sortcode_lottory_info.php';
// Kích hoạt plugin.
function lottery_info_activate()
{
    Li_Table_Lottery_History::create_table();
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
// menu
function lsg_add_admin_menu()
{
    add_menu_page(
        'lottery_info',           // Tên menu item
        'Thống Kê Xổ Số',           // Tên hiển thị
        'manage_options',                // Quyền hạn
        'lottery_info',           // Slug của menu
        'custom_admin_table_page',  // Hàm callback để hiển thị trang
        'dashicons-admin-generic',       // Icon
        20                               // Thứ tự
    );
}
add_action('admin_menu', 'lsg_add_admin_menu');



// Hàm để hiển thị trang bảng dữ liệu
function custom_admin_table_page()
{
    $add_data = new Li_form_add_data();
    $table = new Lottery_Data_List_Table();
    $table->prepare_items();

    echo '<div class="wrap"><h1>Thống Kê Xổ Số</h1>';
    if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
        echo '<div class="notice notice-success"><p>Xóa thành công!</p></div>';
    } else if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo '<div class="notice notice-success"><p>Thêm thành công!</p></div>';
    }
    ?>
    <div class="li_content_generator_wrapper">
        <div>
            <?php $add_data->display_admin_page(); ?>
        </div>
        <div>
            <form method="post">
                <?php $table->display(); ?>
            </form>
        </div>
    </div>
    <?php // Khởi tạo bảng
        echo '</div>';
}

