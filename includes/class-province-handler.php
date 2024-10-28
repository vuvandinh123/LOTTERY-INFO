<?php

class Province_Handler
{

    private static $table = 'lottery_info_provinces';
    private static $url_api = 'https://ketqua365.net/api/region';
    static function fetch_province()
    {
        $response = wp_remote_get('https://ketqua365.net/api/provinces');
        if (is_wp_error($response)) {
            return [];
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);
        $result = [];
        foreach ($data['data'] as $item) {
            $result[] = [
                'slug' => $item['slug'],
                'name' => $item['name']
            ];
        }
        return $result ?? [];
    }
    public static function fetch_provinces($slug = 'mien-nam')
    {
        $response = wp_remote_get(self::$url_api);
        if (is_wp_error($response)) {
            return [];
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);
        $foundItem = null;
        foreach ($data['data'] as $item) {
            if ($item['slug'] === $slug) {
                $foundItem = $item;
                break; // Dừng vòng lặp khi đã tìm thấy
            }
        }
        return $foundItem['provinces'] ?? [];
    }
    public static function fetch_provinces_mien_bac()
    {
        $provinces = self::fetch_provinces('mien-bac');
        $data = [];
        foreach ($provinces as $province) {
            if ($province['type'] !== 'normal') {
                $data[] = $province;
            }
        }
        return $data ?? [];
    }


    // Hàm lấy dữ liệu tỉnh thành từ CSDL
    public static function get_provinces()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table;
        return $wpdb->get_results("SELECT * FROM $table_name");
    }
}
