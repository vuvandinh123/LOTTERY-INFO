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
            <div class="col border p-2 hover-yellow fw-bold">${lottery}</div>
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
             <div class="row border">
                <div class="col-3 text-center border-end hover-yellow">${key}</div>
                <div class="col-9 fw-bold hover-yellow">${loto.join(', ')}</div>
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
                    <div class="row border row-lottery">
                        <div style="min-width: max-content" class="col-3 d-flex justify-content-center align-items-center border-end  text-center ${lottery.prize == 0 ? 'text-danger' : ''}">
                            ${lottery.name}
                        </div>
                        <div class="col-md-9 col m-0 h5 text-center">
                            <div class="row" >
                                ${lottery.data.map(item => `
                                    <div class="col hover-yellow  p-2 m-0 border ${item.prize == 0 ? 'text-danger h3' : ''} text-center">
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

