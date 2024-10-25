jQuery(document).ready(function ($) {
    const { ajax_url, nonce } = my_custom_object;
    // Sự kiện thay đổi tỉnh thành và ngày tháng
    $('#province-select, #date').on('change', function () {
        const provinceSlug = $('#province-select').val();
        const date = $('#date').val();
        getLotteryResults({ provinceSlug, date });
    });
    // Gửi yêu cầu Ajax
    getLotteryResults({ provinceSlug: 'tp-hcm', date: '' });
    function getLotteryResults({ provinceSlug = '', date = '' }) {
        $.ajax({
            url: ajax_url,  // URL được truyền từ PHP
            type: 'POST',
            data: {
                action: 'lottery_api_call',  // Tên action trong PHP để xử lý
                nonce: nonce, // Nonce bảo mật
                province: provinceSlug,
                date: date
            },
            success: function (response) {
                const data = response['data'];
                if (!data) {
                    console.log("Không có dữ liệu");
                    return
                }
                $('#show-date').text(formatDateString(data['result_day']));
                $('#li-title').text('XỔ SỐ ' + data['province_name'])
                flatpickrCustom(data['weekdays_result_lottery'], data['result_day']);
                // Hiển thị bảng kết quả xổ số
                renderLotteryResults(data['data']);

                // Hiển thị số loto
                renderLotoNumber(data['prize_number_lotto']);

                // Hiển thị bảng số loto đầu và cuối
                const groupedNumbersStart = getLotoNumber(data['prize_number_lotto']);
                renderLotoNumberStartOrEnd(groupedNumbersStart, '#lottery-table-start');

                const groupedNumbersEnd = getLotoNumber(data['prize_number_lotto'], 1);
                renderLotoNumberStartOrEnd(groupedNumbersEnd, '#lottery-table-end');
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }
    function renderLotoNumber(loto) {
        const container = $('#lottery-table');
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
                <div class="li_col text-center li_border-end hover-yellow">${key}</div>
                <div class="li_col-8 li_fw-bold hover-yellow">${loto.join(', ')}</div>
            </div>
            `
        }
        container.html(html);
    }
    function renderLotteryResults(result) {
        const container = $('#lottery-results')
        let html = '';
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
        container.html(html);
    }
});

