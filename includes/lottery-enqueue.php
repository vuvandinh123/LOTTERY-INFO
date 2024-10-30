<?php
if (!function_exists('li_lottery_info_enqueue_assets')) {
    function li_lottery_info_enqueue_assets()
    {
        // Danh sách các file CSS
        $list_lottery_info_style = [
            'li_main' => 'assets/css/li_main.css',
            'table' => 'assets/css/lottery_table.css',
            'flatpickr' => 'assets/css/flatpickr.min.css',
        ];

        // Danh sách các file JS
        $list_lottery_info_script = [
            'jquery' => 'assets/js/jquery-3.7.1.min.js',
            'flatpickr' => 'assets/js/flatpickr.js',
            'flatpickr_custom' => 'assets/js/flatpickr-custom.js',
            'function' => 'assets/js/function.js',
            'render' => 'assets/js/fn-render.js',
            'main' => 'assets/js/lottery.main.js',
        ];

        // Lặp qua từng file CSS trong danh sách
        foreach ($list_lottery_info_style as $id => $file) {
            $file_url = LOTTERY_INFO_URL . $file;
            $file_path = LOTTERY_INFO_PATH . $file; // Đường dẫn file thật sự trên server
            $version = file_exists($file_path) ? filemtime($file_path) : false;
            wp_enqueue_style($id, $file_url, [], $version);
        }

        // Lặp qua từng file JS trong danh sách
        foreach ($list_lottery_info_script as $id => $file) {
            $file_url = LOTTERY_INFO_URL . $file;
            $file_path = LOTTERY_INFO_PATH . $file; // Đường dẫn file thật sự trên server
            $version = file_exists($file_path) ? filemtime($file_path) : false;
            wp_enqueue_script($id, $file_url, ['jquery'], $version, true); // `true` để nạp ở footer
        }

        // Truyền dữ liệu cho JavaScript
        wp_localize_script('main', 'my_custom_object', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('my_custom_nonce'),
        ]);
    }

    add_action('wp_enqueue_scripts', 'li_lottery_info_enqueue_assets', 11);
}
if (!function_exists('li_lottery_info_enqueue_assets_admin')) {
    function li_lottery_info_enqueue_assets_admin()
    {
        // Danh sách các file CSS
        $list_lottery_info_style = [
            'li_admin_main_css' => 'assets/css/li_admin_main.css',
        ];

        // Danh sách các file JS
        $list_lottery_info_script = [
            'li_admin_main_js' => 'assets/js/li_admin_main.js',
        ];

        // Lặp qua từng file CSS trong danh sách
        foreach ($list_lottery_info_style as $id => $file) {
            $file_url = LOTTERY_INFO_URL . $file;
            $file_path = LOTTERY_INFO_PATH . $file; // Đường dẫn file thật sự trên server
            $version = file_exists($file_path) ? filemtime($file_path) : false;
            wp_enqueue_style($id, $file_url, [], $version);
        }

        // Lặp qua từng file JS trong danh sách
        foreach ($list_lottery_info_script as $id => $file) {
            $file_url = LOTTERY_INFO_URL . $file;
            $file_path = LOTTERY_INFO_PATH . $file; // Đường dẫn file thật sự trên server
            $version = file_exists($file_path) ? filemtime($file_path) : false;
            wp_enqueue_script($id, $file_url, ['jquery'], $version, true); // `true` để nạp ở footer
        }
    }

    add_action('admin_enqueue_scripts', 'li_lottery_info_enqueue_assets_admin');
}
