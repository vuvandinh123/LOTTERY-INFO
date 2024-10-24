<?php
if (!function_exists('li_lottery_info_enqueue_assets')) {
    function li_lottery_info_enqueue_assets()
    {
        // Danh sách các file CSS
        $list_lottery_info_style = [
            'bootstrap' => 'assets/css/bootstrap.min.css',
            'table' => 'assets/css/lottery_table.css',
            'global' => 'assets/css/global.css',
            'flatpickr' => 'assets/css/flatpickr.min.css',
        ];

        // Danh sách các file JS
        $list_lottery_info_script = [
            'jquery' => 'assets/js/jquery-3.7.1.min.js',
            'flatpickr' => 'assets/js/flatpickr.js',
            'flatpickr_custom' => 'assets/js/flatpickr-custom.js',
            'function' => 'assets/js/function.js',
            'main' => 'assets/js/lottery.main.js',
        ];

        // Lặp qua từng file CSS trong danh sách
        foreach ($list_lottery_info_style as $id => $file) {
            $file_url = LOTTERY_INFO_URL . $file;
            wp_enqueue_style($id, $file_url);
        }
        // Lặp qua từng file JS trong danh sách
        foreach ($list_lottery_info_script as $id => $file) {
            $file_url = LOTTERY_INFO_URL . $file;
            wp_enqueue_script($id, $file_url, ['jquery'], false, true); // `true` để nạp ở footer
        }
        // Truyền dữ liệu cho JavaScript
        wp_localize_script('main', 'my_custom_object', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('my_custom_nonce'),
        ]);
    }

    add_action('wp_enqueue_scripts', 'li_lottery_info_enqueue_assets', 11);
}

