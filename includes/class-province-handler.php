<?php

class Province_Handler
{

    private static $table = 'lottery_info_provinces';
    private static $url_api = 'https://ketqua365.net/api/provinces';
    // Hàm tạo bảng lưu tỉnh thành
    public static function create_province_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            slug varchar(255) NOT NULL,
            alias varchar(255) NOT NULL,
            weekdays_result_lottery varchar(1000) NOT NULL,
            time time NOT NULL,
            type varchar(50) NOT NULL,
            status varchar(50) NOT NULL,
            region_id mediumint(9) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // Hàm lấy danh sách tỉnh thành từ API và lưu vào CSDL
    public static function fetch_and_store_provinces()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table;
        $response = wp_remote_get(self::$url_api);

        if (is_wp_error($response)) {
            return;
        }

        $body = wp_remote_retrieve_body($response);
        $provinces = json_decode($body, true);
        $data = $provinces['data'];

        if (!empty($data) && is_array($data)) {

            // Xóa dữ liệu cũ
            $wpdb->query("TRUNCATE TABLE $table_name");

            // Lưu dữ liệu mới
            foreach ($data as $province) {
                $wpdb->insert(
                    $table_name,
                    array(
                        'name' => $province['name'],  // Sử dụng cú pháp mảng
                        'slug' => $province['slug'],
                        'alias' => $province['alias'],
                        'weekdays_result_lottery' => $province['weekdays_result_lottery'],
                        'time' => $province['time'],
                        'type' => $province['type'],
                        'status' => $province['status'],
                        'region_id' => $province['region_id'],
                    )
                );
            }
        }
    }


    // Hàm lấy dữ liệu tỉnh thành từ CSDL
    public static function get_provinces()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table;
        return $wpdb->get_results("SELECT * FROM $table_name");
    }
}