jQuery(document).ready(function ($) {
    const { ajax_url, nonce } = my_custom_object;
    const today = new Date();
    const formattedDate = today.toISOString().slice(0, 10);
    $('.lottery-info-shortcode').each(function () {
        let unique_id = $(this).data('id');

        const region = $('#result_btr-' + unique_id).data('type');
        const provinceDefault = $('#result_btr-' + unique_id).data('province');
        let id_change = ["#province-select-" + unique_id, "#date-" + unique_id];
        $(id_change.join(',')).on('change', function () {
            const provinceSlug = $(id_change[0]).val();
            const date = $(id_change[1]).val();
            $(id_change[1]).prop('disabled', true);
            getLotteryResults({ provinceSlug: provinceSlug || provinceDefault, date, unique_id, region });
        });
        getLotteryResults({ provinceSlug: provinceDefault, date: formattedDate, region, unique_id });

    });

    function getLotteryResults({ provinceSlug = '', date = '', unique_id = "", region = "" }) {
        // variable dom
        let _lottery_results = $('#lottery-results-' + unique_id)
        let _show_date = $('#show-date-' + unique_id)
        let _show_title = $('#li-title-' + unique_id)
        let _show_select = $('#province-select-' + unique_id)
        let _lottery_hidden = $('.lottery-table-hidden-' + unique_id)
        let _lottery_table = $('#lottery-table-' + unique_id)
        let _lottery_table_start = $('#lottery-table-start-' + unique_id)
        let _lottery_table_end = $('#lottery-table-end-' + unique_id)
        let _date = $('#date-' + unique_id)
        let _li_content = $('#li_content-' + unique_id)
        _li_content.addClass('li_d-none');
        $('#li_loader-' + unique_id).removeClass('li_d-none');
        $.ajax({
            url: ajax_url,
            type: 'POST',
            data: {
                action: 'lottery_api_call',
                nonce: nonce,
                province: provinceSlug,
                region: region || '',
                date: date
            },
            success: function (response) {
                const data = response['data'];
                if (!data ) {
                    console.log("Không có dữ liệu");
                    return
                }
                // data
                let data_result_day = data['result_day'];
                let data_slug = data['province_slug'];
                let data_type = data['type'];
                let data_province_name = data['province_name'];
                let data_validate_day = data['weekdays_result_lottery']
                let data_prize_number_lotto = data['prize_number_lotto']
                let data_render = data['data']

                _show_date.text(formatDateString(data_result_day));
                if (region !== 'mien-bac') {
                    _show_title.text('XỔ SỐ ' + data_province_name)
                    _show_select.val(data_slug)
                }
                // flatpickr
                flatpickrCustom({
                    defaultDate: data_result_day,
                    id: '#date-' + unique_id,
                    validDays: (function () {
                        if (region === 'mien-bac') {
                            return []
                        } else if (region === 'Vietlott') {
                            return [0, 1, 3, 5]
                        }
                        return data_validate_day
                    })(),
                });

                // Hiển thị giao diện
                if (data_slug === 'max-4-d') {
                    renderLotteryMax4D(data_render, _lottery_results);
                } else if (data_slug === 'mega-6-45' || data_slug === 'power-5-66') {
                    renderVietlott(data_render, _lottery_results);
                } else {
                    renderLotteryResults(data_render, _lottery_results);
                }
                // Hiển thị số loto
                if (data_type === 'normal' && region !== 'Vietlott') {

                    _lottery_hidden.removeClass('li_d-none');
                    renderLotoNumber(data_prize_number_lotto, _lottery_table);

                    // Hiển thị bảng số loto đầu
                    const groupedNumbersStart = getLotoNumber(data_prize_number_lotto);
                    renderLotoNumberStartOrEnd(groupedNumbersStart, _lottery_table_start);

                    // Hiển thị bảng số loto đuôi
                    const groupedNumbersEnd = getLotoNumber(data_prize_number_lotto, 1);
                    renderLotoNumberStartOrEnd(groupedNumbersEnd, _lottery_table_end);
                } else {
                    console.log(data_type);

                    _lottery_hidden.addClass('li_d-none');
                }
                _date.prop('disabled', false);
                // loading
                _li_content.removeClass('li_d-none');
                $('#li_loader-' + unique_id).addClass('li_d-none');
            },
            error: function (error) {
                console.error('Error:', error);
                _date.prop('disabled', false);
            }
        });
    }





});

