<?php
class Li_Table_Lottery_History
{
    // Hàm tạo bảng li_lottory_history
    static function create_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'li_lottory_history'; // Định nghĩa tên bảng
        $charset_collate = $wpdb->get_charset_collate(); // Lấy thông tin charset cho bảng

        // Câu lệnh SQL tạo bảng
        $sql = "CREATE TABLE $table_name (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            title VARCHAR(255) NULL,
            sortcode VARCHAR(200) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        // Chạy SQL để tạo bảng
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    // Hàm lấy dữ liệu từ bảng li_lottory_history
    public function get_data($current_page = 0, $limit = 10)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'li_lottory_history'; // Định nghĩa tên bảng
        // Lấy số bản ghi hiện có
        $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

        // Lấy trang hiện tại và số bản ghi trên mỗi trang
        $offset = ($current_page - 1) * $limit;
        // Truy vấn dữ liệu
        $query = $wpdb->prepare("SELECT * FROM $table_name LIMIT %d OFFSET %d", $limit, $offset);
        $results = $wpdb->get_results($query, ARRAY_A); // Lấy kết quả dưới dạng mảng kết hợp

        return [
            "total_items" => $total_items,
            "results" => $results
        ];
    }
    public function delete_items($ids)
    {
        if (empty($ids)) {
            return false;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'li_lottory_history';

        // Tạo một chuỗi các placeholder %d cho từng ID trong danh sách
        $placeholders = implode(',', array_fill(0, count($ids), '%d'));
        $query = $wpdb->prepare("DELETE FROM $table_name WHERE id IN ($placeholders)", ...$ids);

        $result = $wpdb->query($query);

        if ($result === false) {
            trigger_error($wpdb->last_error, E_USER_ERROR);
            return false;
        }

        return true;
    }

}

