<?php
class Li_form_add_data
{
    public function __construct()
    {
        add_action('admin_post_li_add_lottery_history', [$this, 'handle_form_submit']);
    }

    public function display_admin_page()
    {
        include_once(LOTTERY_INFO_PATH . 'templates/lottery-template-admin.php');
    }
    public function handle_form_submit()
    {
        // Kiểm tra quyền quản trị
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to access this page.'));
        }
        // Lấy dữ liệu từ form
        if (isset($_POST['title']) && isset($_POST['sortcode'])) {
            $title = sanitize_text_field($_POST['title']);
            $sortcode =sanitize_text_field($_POST['sortcode']);

            // Thêm dữ liệu vào bảng
            global $wpdb;
            $table_name = $wpdb->prefix . 'li_lottory_history';

            // Sử dụng prepare() để chuẩn bị truy vấn SQL
            $wpdb->insert(
                $table_name,
                [
                    'title' => $title,
                    'sortcode' => $sortcode, // Sử dụng biến chứa shortcode
                ]
            );
            if ($wpdb->last_error) {
                // Xử lý lỗi ở đây, ví dụ: log lỗi hoặc hiển thị thông báo
                error_log('Error inserting data: ' . $wpdb->last_error);
                wp_die('Error inserting data: ' . $wpdb->last_error);
            }
        }

        // Chuyển hướng về trang quản trị với thông báo thành công
        wp_redirect(admin_url('admin.php?page=lottery_info&success=1'));
        exit;
    }

}
new Li_form_add_data();