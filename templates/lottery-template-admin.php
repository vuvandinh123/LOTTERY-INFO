<div class="wrap">
    <form id="li_lottery_form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="li_add_lottery_history">
        <table class="form-table">
            <tr>
                <th><label for="li_title">
                        Tiêu đề
                    </label></th>
                <td><input type="text" placeholder="Tiêu đề" style="width: 100%;" name="title" id="li_title" required>
                </td>
            </tr>
            <tr>
                <th><label for="li_type">Loại hiển thị</label></th>
                <td>
                    <select id="li_type" style="width: 100%;max-width: 100%" name="type">
                        <option value="province">Tỉnh / Thành phố</option>
                        <option value="default">Vùng miền</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="li_value" style="text-transform: capitalize;" id="li_lable_value">Tỉnh thành</label>
                </th>
                <td>
                    <select id="li_value" style="width: 100%;max-width: 100%" name="li_value">
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="li_loto">Hiển thị bảng loto</label></th>
                <td><input type="checkbox" name="loto" id="li_loto"></td>
            </tr>
            <tr>
                <th>
                    <label for="generated-shortcode-input">
                        Mã ngắn
                    </label>
                </th>
                <td>
                    <div style="display: flex;justify-content: center;align-items: center;">
                        <input type="text" name="sortcode" readonly value="[lottery_info]"
                            id="generated-shortcode-input" style="width: 100%;max-width: 100%;background-color: #fff">
                        <button onclick="copyToClipboard()" type="button"
                            style="background-color: #0073aa;color: #fff;border: none;cursor: pointer;padding: 6px 10px;border-radius: 4px"
                            id="copy-button">Copy</button>
                    </div>
                    <p class="" style="margin-top: 5px;"><b>Note:</b> Bạn có thể không cần lưu mà vẫn có thể sử dụng bằng cách  coppy nội dung mã ngắn trên !!</p>
                </td>
            </tr>

        </table>
        <?php submit_button(__('Lưu sortcode mới', 'textdomain')); ?>
    </form>
    <p style="margin-top: 20px; font-weight: bold;">
    <p><b>Cách sử dụng:</b> Bạn có thể chèn shortcode trực tiếp vào nội dung bài viết hoặc trang bằng cách thêm
        nó
        vào trình soạn thảo văn
        bản. Ví dụ: [lottery_info default="mien-bac" ...v ].</p>
    </p>
</div>

<script>
    const li_type = document.getElementById('li_type');
    const li_value = document.getElementById('li_value');
    const li_title = document.getElementById('li_title');
    const li_loto = document.getElementById('li_loto');
    function copyToClipboard() {
        const el = document.createElement('textarea');
        el.value = document.getElementById('generated-shortcode-input').value;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        document.getElementById('copy-button').textContent = 'Copied!';
        setTimeout(() => {
            document.getElementById('copy-button').textContent = 'Copy';
        }, 1000);

    }
    function renderProvince() {
        let data = [
            {
                "slug": "tp-hcm",
                "name": "TP. HCM"
            },
            {
                "slug": "dong-thap",
                "name": "Đồng Tháp"
            },
            {
                "slug": "ca-mau",
                "name": "Cà Mau"
            },
            {
                "slug": "ben-tre",
                "name": "Bến Tre"
            },
            {
                "slug": "vung-tau",
                "name": "Vũng Tàu"
            },
            {
                "slug": "bac-lieu",
                "name": "Bạc Liêu"
            },
            {
                "slug": "dong-nai",
                "name": "Đồng Nai"
            },
            {
                "slug": "can-tho",
                "name": "Cần Thơ"
            },
            {
                "slug": "soc-trang",
                "name": "Sóc Trăng"
            },
            {
                "slug": "tay-ninh",
                "name": "Tây Ninh"
            },
            {
                "slug": "an-giang",
                "name": "An Giang"
            },
            {
                "slug": "binh-thuan",
                "name": "Bình Thuận"
            },
            {
                "slug": "vinh-long",
                "name": "Vĩnh Long"
            },
            {
                "slug": "binh-duong",
                "name": "Bình Dương"
            },
            {
                "slug": "tra-vinh",
                "name": "Trà Vinh"
            },
            {
                "slug": "long-an",
                "name": "Long An"
            },
            {
                "slug": "hau-giang",
                "name": "Hậu Giang"
            },
            {
                "slug": "binh-phuoc",
                "name": "Bình Phước"
            },
            {
                "slug": "tien-giang",
                "name": "Tiền Giang"
            },
            {
                "slug": "kien-giang",
                "name": "Kiên Giang"
            },
            {
                "slug": "da-lat",
                "name": "Đà Lạt"
            },
            {
                "slug": "thua-t-hue",
                "name": "Thừa T. Huế"
            },
            {
                "slug": "phu-yen",
                "name": "Phú Yên"
            },
            {
                "slug": "quang-nam",
                "name": "Quảng Nam"
            },
            {
                "slug": "dak-lak",
                "name": "Đắk Lắk"
            },
            {
                "slug": "da-nang",
                "name": "Đà Nẵng"
            },
            {
                "slug": "khanh-hoa",
                "name": "Khánh Hòa"
            },
            {
                "slug": "binh-dinh",
                "name": "Bình Định"
            },
            {
                "slug": "quang-tri",
                "name": "Quảng Trị"
            },
            {
                "slug": "quang-binh",
                "name": "Quảng Bình"
            },
            {
                "slug": "gia-lai",
                "name": "Gia Lai"
            },
            {
                "slug": "ninh-thuan",
                "name": "Ninh Thuận"
            },
            {
                "slug": "quang-ngai",
                "name": "Quảng Ngãi"
            },
            {
                "slug": "dak-nong",
                "name": "Đắk Nông"
            },
            {
                "slug": "kon-tum",
                "name": "Kon Tum"
            },
            {
                "slug": "ha-noi",
                "name": "Hà Nội"
            },
            {
                "slug": "quang-ninh",
                "name": "Quảng Ninh"
            },
            {
                "slug": "bac-ninh",
                "name": "Bắc Ninh"
            },
            {
                "slug": "hai-phong",
                "name": "Hải Phòng"
            },
            {
                "slug": "nam-dinh",
                "name": "Nam Định"
            },
            {
                "slug": "thai-binh",
                "name": "Thái Bình"
            },
            {
                "slug": "dien-toan-123",
                "name": "Điện Toán 123"
            },
            {
                "slug": "dien-toan-6-36",
                "name": "Điện Toán 6x36"
            },
            {
                "slug": "than-tai",
                "name": "Thần Tài"
            },
            {
                "slug": "mega-6-45",
                "name": "Mega 6/45"
            },
            {
                "slug": "power-5-66",
                "name": "Power 6/55"
            },
            {
                "slug": "max-4-d",
                "name": "Max 4D"
            }
        ]
        let html = ''
        for (let item of data) {
            html += `<option value="${item.slug}">${item.name}</option>`
        }
        document.getElementById('li_value').innerHTML = html;
    }
    function renderRegion() {
        let data = [{
            slug: "mien-bac",
            name: "Miền Bắc"
        }, {
            slug: "mien-nam",
            name: "Miền Nam"
        }, {
            slug: "mien-trung",
            name: "Miền Trung"
        },
        {
            slug: "Vietlott",
            name: "Vietlott"
        }
        ]
        let html = ''
        for (let item of data) {
            html += `<option value="${item.slug}">${item.name}</option>`
        }
        document.getElementById('li_value').innerHTML = html;
    }
    renderProvince()
    li_type.addEventListener('change', function () {
        if (li_type.value === 'province') {
            renderProvince()
            document.getElementById('li_lable_value').innerHTML = 'Tỉnh thành'
        } else {
            renderRegion()
            document.getElementById('li_lable_value').innerHTML = 'Vùng miền'

        }
        lsgGenerateShortcode();
    })
    li_title.addEventListener('input', function () {
        lsgGenerateShortcode();
    })
    li_value.addEventListener('change', function () {
        lsgGenerateShortcode();
    })
    li_loto.addEventListener('change', function () {
        lsgGenerateShortcode();
    })
    function lsgGenerateShortcode() {
        let str_loto = `loto-hidden='1'`;
        if (li_loto.checked) {
            str_loto = `loto-hidden='0'`;
        }
        const shortcode = `[lottery_info title='${li_title.value}'  ${li_type.value}='${li_value.value}' ${str_loto} ]`;
        document.getElementById('generated-shortcode-input').value = shortcode;
    }
</script>