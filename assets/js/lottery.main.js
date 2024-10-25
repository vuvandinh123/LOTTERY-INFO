jQuery(document).ready(function ($) {
    const { ajax_url, nonce } = my_custom_object;
    const today = new Date();
    const formattedDate = today.toISOString().slice(0, 10);

    $('.lottery-info-shortcode').each(function () {
        let id = $(this).data('id');
        const region = $('#result_btr-' + id).data('type');
        let id_change = ["#province-select-" + id, "#date-" + id];
        $(id_change.join(',')).on('change', function () {
            const provinceSlug = $(id_change[0]).val();
            const date = $(id_change[1]).val();
            $(id_change[1]).prop('disabled', true);
            getLotteryResults({ provinceSlug, date, id, region });
        });
        getLotteryResults({ provinceSlug: '', date: formattedDate, region, id });

    });

    function getLotteryResults({ provinceSlug = '', date = '', id = "", region = "" }) {
        $.ajax({
            url: ajax_url,  // URL được truyền từ PHP
            type: 'POST',
            data: {
                action: 'lottery_api_call',  // Tên action trong PHP để xử lý
                nonce: nonce, // Nonce bảo mật
                province: provinceSlug,
                region: region || '',
                date: date
            },
            success: function (response) {
                const data = response['data'];
                if (!data) {
                    console.log("Không có dữ liệu");
                    return
                }
                $('#show-date-' + id).text(formatDateString(data['result_day']));
                if (region !== 'mien-bac') {
                    $('#li-title-' + id).text('XỔ SỐ ' + data['province_name'])
                    $('#province-select-' + id).val(data['province_slug'])
                }
                if (region === 'mien-bac') {
                    flatpickrCustom({
                        defaultDate: data['result_day'],
                        id: '#date-' + id
                    });
                } else {
                    flatpickrCustom({
                        defaultDate: data['result_day'],
                        id: '#date-' + id,
                        validDays: data['weekdays_result_lottery'],
                    });
                }
                // Hiển thị bảng kết quả xổ số
                renderLotteryResults(data['data'], '#lottery-results-' + id);
                // Hiển thị số loto
                if (data['type'] === 'normal') {
                    $('.lottery-table-hidden').removeClass('li_d-none');
                    renderLotoNumber(data['prize_number_lotto'], '#lottery-table-' + id);
                    // Hiển thị bảng số loto đầu và cuối
                    const groupedNumbersStart = getLotoNumber(data['prize_number_lotto']);
                    renderLotoNumberStartOrEnd(groupedNumbersStart, '#lottery-table-start-' + id);

                    const groupedNumbersEnd = getLotoNumber(data['prize_number_lotto'], 1);
                    renderLotoNumberStartOrEnd(groupedNumbersEnd, '#lottery-table-end-' + id);
                } else {
                    $('.lottery-table-hidden').addClass('li_d-none');
                }
                $('#date-' + id).prop('disabled', false);
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }
    function renderLotoNumber(loto, id) {
        const container = $(id);
        let html = '';
        loto.forEach(lottery => {
            html += `
            <div class="li_col li_border li_p-2 li_text-center hover-yellow li_fw-bold">${lottery}</div>
            `
        })
        container.html(html);
    }
    function renderLotoNumberStartOrEnd(data, id) {
        const container = $(id);
        let html = '';
        for (let key in data) {
            let loto = data[key];
            html += `
             <div class="li_row li_border">
                <div class="li_col li_text-center li_border-end hover-yellow">${key}</div>
                <div class="li_col-9 li_fw-bold hover-yellow">${loto.join(', ')}</div>
            </div>
            `
        }
        container.html(html);
    }
    function renderLotteryResults(result, id) {
        const container = $(id)
        let html = '';
        if (Array.isArray(result)) {
            result.forEach(lottery => {
                html += `
                        <div class="li_row  row-lottery">
                            <div style="display:flex;justify-content:center;align-items:center;border-right:0px" class="li_col li_border li_p-2 li_fs-3  li_text-center ${lottery.prize == 0 ? 'li_text-red li_fw-bold' : ''}">
                                ${lottery.name}
                            </div>
                            <div class="li_col-7  li_text-center">
                                <div class="li_row" >
                                    ${lottery.data.map(item => `
                                        <div class="li_col hover-yellow li_fw-bold li_fs-4 li_p-2 m-0 li_border ${item.prize == 0 ? 'li_text-red li_fs-5' : ''} li_text-center">
                                            ${item.prize_number}
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    `;
            });
        } else {
            html += `
                        <div class="li_row  row-lottery">
                            <div style="display:flex;justify-content:center;align-items:center;border-right:0px" class="li_col li_border li_p-2 li_fs-3  li_text-center ${result['1'].prize == 0 ? 'li_text-red li_fw-bold' : ''}">
                                ${result['1'].name}
                            </div>
                            <div class="li_col-7  li_text-center">
                                <div class="li_row" >
                                    ${result['1']?.data?.map(item => `
                                        <div class="li_col hover-yellow li_fw-bold li_fs-4 li_p-2 m-0 li_border ${item.prize == 0 ? 'li_text-red li_fs-5' : ''} li_text-center">
                                            ${item.prize_number}
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    `;
        }

        container.html(html);
    }
});

