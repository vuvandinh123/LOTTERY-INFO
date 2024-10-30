<?php
function lottery_display_provinces(array $attributes): string
{
    $default = $attributes['default'] ?? '';
    $title = $attributes['title'] ?? '';
    $province = $attributes['province'] ?? '';
    $loto_hidden = (int) ($attributes['loto-hidden'] ?? 0);

    if (!in_array($default, ['mien-bac', 'mien-nam', 'mien-trung', 'Vietlott'], true) && empty($province)) {
        $default = 'mien-bac';
    }

    $provinces = [];
    if ($default !== 'mien-bac') {
        $provinces = Province_Handler::fetch_provinces($default);
    } elseif (empty($province)) {
        $provinces = Province_Handler::fetch_provinces_mien_bac();
    }

    $uniqueId = uniqid();
    ob_start();
    require_once LOTTERY_INFO_PATH . 'templates/lottery-template.php';
    return ob_get_clean();
}
add_shortcode('lottery_info', 'lottery_display_provinces');