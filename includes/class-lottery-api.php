<?php

class Lottery_API
{

    // Hàm lấy thông tin xổ số từ API
    public static function get_lottery_results($region = 'mien-bac', $province = '', $day = '') // Tham số mặc định là 'mien-bac'
    {
        $url = 'https://ketqua365.net/api/lotteries';

        if (!empty($province)) {
            $url .= '?province=' . $province;
        } elseif (!empty($region)) {
            $url .= '?region=' . $region;
        }
        if (!empty($day)) {
            $url .= '&day=' . $day;
        }
        $response = wp_remote_get($url);

        if (is_wp_error($response)) {
            return false; // Trả về false nếu có lỗi
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);

        return $data['data'] ?? []; // Trả về dữ liệu hoặc mảng rỗng nếu không có dữ liệu
    }
    public static function convertWeekdaysToArray($serialized)
    {
        $array = unserialize($serialized);
        $result = array_values($array);
        return $result;
    }
    public static function parse_lottery_results($data)
    {
        $rank_name = ['Đặc biệt', 'Giải nhất', 'Giải nhì', 'Giải ba', 'Giải tư', 'Giải năm', 'Giải sáu', 'Giải bảy', 'Giải tám'];
        $result = [];
        foreach ($data as $item) {
            $prize = $item['prize'];
            if (!isset($result[$prize])) {
                $result[$prize] = [
                    'prize' => $prize,
                    'name' => $rank_name[$prize],
                    'data' => []
                ];
            }
            $result[$prize]['data'][] = $item;
        }
        return $result;
    }
    public static function prepare_response($region, $province, $date)
    {
        $lotterys = self::get_lottery_results($region, $province, $date);
        $weekdays_result_lottery = self::convertWeekdaysToArray($lotterys['province']['weekdays_result_lottery']);

        $data = $lotterys['results_detail'];
        $result = self::parse_lottery_results($data);

        $loto = [];
        foreach ($data as $item) {
            $loto[] = $item['prize_number_lotto'];
        }
        sort($loto);
        $payload = [
            'weekdays_result_lottery' => $weekdays_result_lottery,
            'prize_number_lotto' => $loto,
            'result_day' => $lotterys['result_day'],
            'province_name' => $lotterys['province']['name'],
            'data' => $result
        ];

        return $payload;
    }

}
