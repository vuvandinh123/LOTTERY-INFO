function renderVietlott(data, container) {
    let num_win = ['6 số', '5 số', '4 số', '3 số', '2 số', '1 số'];
    let name_win = ['Jackpot','Giải nhất','Giải nhì','Giải ba','Giải bốn'];
    const { winner_data, prize_number } = data
    let html = `
        <h2 class="li_text-center li_fs-5 li_text-red">Kết quả sổ xố Vietlott</h2>
                <div>
                    <p style="color:blue" class="li_text-center li_fs-3">Kỳ quay thưởng ${winner_data['patch']}</p>
                </div>
                <div class="li_number-vietlott-content">
                ${prize_number.map(item => `
                    <div class="">
                        <span class="li_number-vietlott li_fs-4">${item}</span>
                    </div>
                    `).join('')}
                </div>
                <p class="li_text-center li_fs-3 li_mt-3">(Các con số dự thưởng không cần theo đúng thứ tự)</p>
                <p class="li_text-center li_fs-6 li_text-red li_fw-bold">${formatNumber(winner_data['prizes'][0].prize)
        } đồng</p>
                <div  class="li_table-responsive">
                    <table class="li_table li_table-bordered li_table-striped li_table-hover">
                        <thead>
                            <tr class="li_fs-3 li_text-center">
                                <th class="li_text-center">Giải thưởng</th>
                                <th>Trùng số</th>
                                <th>Số giải</th>
                                <th>Giá trị (đồng)</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${winner_data['prizes'].map((item, index) => `
                                <tr>
                                    <td class="li_fs-3 li_text-center">${name_win[index] ?? '--'}</td>
                                    <td class="li_fs-3 li_text-center">${num_win[index]}</td>
                                    <td class="li_fs-3 li_text-center">${item.win_count}</td>
                                    <td class="li_fs-3 li_text-center">${formatNumber(item.prize)}</td>
                                </tr>
                                `).join('')}
                        </tbody>
                    </table>
                </div>
    `;

    container.html(html);

}
function renderLotteryMax4D(result, container) {
    let html = `
    <div class="li_row  row-lottery">
        <div  class="li_col-3 li_border li_p-2 li_fs-3  li_fw-bold li_text-red  li_text-center ">
            Giải thưởng
        </div>
        <div  class="li_col li_p-2 li_fs-3  li_border li_fw-bold li_text-red li_text-center">
            Kết quả
        </div>
        <div class="li_col-3  li_fw-bold li_text-red li_border li_p-2 li_fs-3  li_text-center">
            Giá trị giải (đồng)
        </div>
    </div>
    `;
    if (Array.isArray(result)) {
        result.forEach(lottery => {
            html += `
                    <div class="li_row  row-lottery">
                        <div style="display:flex;justify-content:center;align-items:center;border-right:0px;min-width: max-content;" class="li_col-3 li_border li_p-2 li_fs-3  li_text-center ">
                            ${lottery.prize_name}
                        </div>
                        <div  class="li_col  li_text-center">
                            <div class="li_row" >
                                ${lottery.results.map(item => `
                                    <div class="li_col hover-yellow li_fw-bold li_fs-4 li_p-2 m-0 li_border li_text-center">
                                        ${item}
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                       <div style="display:flex;justify-content:center;align-items:center;min-width: max-content;" class="li_col-3 li_border li_p-2 li_fs-3  li_text-center">
                            ${formatNumber(lottery.prize)}
                        </div>
                    </div>
                `;
        });
    }
    container.html(html);
}

function renderLotteryResults(result, container) {
    let html = '';
    if (Array.isArray(result)) {
        result.forEach(lottery => {
            html += `
                    <div class="li_row  row-lottery">
                        <div style="display:flex;justify-content:center;align-items:center;border-right:0px;min-width: max-content;" class="li_col li_border li_p-2 li_fs-3  li_text-center ${lottery.prize == 0 ? 'li_text-red li_fw-bold' : ''}">
                            ${lottery.name}
                        </div>
                        <div  class="li_col-8  li_text-center">
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
    }

    container.html(html);
}

function renderLotoNumber(loto, container) {
    let html = '';
    loto.forEach(lottery => {
        html += `
        <div class="li_col li_border li_p-2 li_text-center hover-yellow li_fw-bold">${lottery}</div>
        `
    })
    container.html(html);
}

function renderLotoNumberStartOrEnd(data, container) {
    let html = '';
    for (let key in data) {
        let loto = data[key];
        html += `
         <div class="li_row li_border">
            <div style="width: 30%;" class=" li_text-center li_border-end hover-yellow">${key}</div>
            <div class="li_col li_fw-bold hover-yellow">${loto.join(', ')}</div>
        </div>
        `
    }
    container.html(html);
}