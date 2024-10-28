<?php

class Lottery_API
{

    private $url_api = 'https://ketqua365.net/api/lotteries';
    // Hàm lấy thông tin xổ số từ API
    private function get_lottery_results($region = 'mien-bac', $province = '', $day = '')
    {
        $url = $this->url_api;

        if (!empty($region) && empty($province)) {
            $url .= '?region=' . $region;
        } elseif (!empty($province)) {
            $url .= '?province=' . $province;
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
    private function convertWeekdaysToArray($serialized)
    {
        $array = unserialize($serialized);
        $result = array_values($array);
        return $result;
    }
    private function parse_lottery_results_vietlott($lottery_results)
    {
        $parsed_results = [];
        $type = $lottery_results['province']['alias'];
        $vietlot_ranks = [
            'Giải nhất',
            'Giải nhì',
            'Giải ba',
            'Giải KK 1',
            'Giải KK 2',
        ];
        $lotterys = json_decode($lottery_results['lotteries_db_content'], true);
        if ($type === 'max4d') {
            foreach ($lotterys['prizes'] as $key => $value) {
                $parsed_results[] = [
                    'prize_name' => $vietlot_ranks[$key],
                    'results' => $value['results'],
                    'prize' => $value['prize'],
                ];
            }
        }else{
            $parsed_results['winner_data'] = $lotterys;
            foreach ($lottery_results['results_detail'] as $key => $value) {
                $parsed_results['prize_number'][] = $value['prize_number'];
            }
        }

        return $parsed_results;
    }
    private function parse_lottery_results_nomal(array $lottery_results): array
    {
        $parsed_results = [];
        $rank_names = [
            'Đặc biệt',
            'Giải nhất',
            'Giải nhì',
            'Giải ba',
            'Giải tư',
            'Giải năm',
            'Giải sáu',
            'Giải bảy',
            'Giải tám',
        ];
        foreach ($lottery_results['results_detail'] as $key => $result) {

            $prize = (int) $result['prize'];
            // Check if prize is a valid index in the rank_names array
            if ($prize < 0 || $prize >= count($rank_names)) {
                continue;
            }
            // Create a new entry in the parsed_results array if it doesn't exist
            if (!isset($parsed_results[$prize])) {
                $parsed_results[$prize] = [
                    'prize' => $prize,
                    'name' => $rank_names[$prize],
                    'data' => [],
                ];
            }
            $parsed_results[$prize]['data'][] = $result;
        }
        return array_values($parsed_results);
    }

    public function prepare_response($region, $province, $date)
    {
        $lotterys = $this->get_lottery_results($region, $province, $date);
        if (empty($lotterys)) {
            return []; // Return an empty array if no lottery data is found
        }

        $weekdays_result_lottery = [];
        if (!empty($lotterys['province']['weekdays_result_lottery'])) {
            $weekdays_result_lottery = $this->convertWeekdaysToArray($lotterys['province']['weekdays_result_lottery']);
        }

        $data = $lotterys['results_detail'] ?? [];
        if ($region !== 'Vietlott') {
            $result = $this->parse_lottery_results_nomal($lotterys);
        } else {
            $result = $this->parse_lottery_results_vietlott($lotterys);
        }

        $loto = [];
        foreach ($data as $item) {
            if (isset($item['prize_number_lotto'])) {
                $loto[] = $item['prize_number_lotto'];
            }
        }
        sort($loto);

        $payload = [
            'weekdays_result_lottery' => $weekdays_result_lottery,
            'prize_number_lotto' => $loto,
            'result_day' => $lotterys['result_day'] ?? '',
            'type' => $lotterys['type'] ?? '',
            'province_name' => $lotterys['province']['name'] ?? '',
            'province_slug' => $lotterys['province']['slug'] ?? '',
            'data' => $result
        ];

        return $payload;
    }

}
