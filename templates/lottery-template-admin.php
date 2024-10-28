<div class="wrap">
    <h1>Shortcode Generator</h1>
    <form id="shortcode-form">
        <label for="type">Tiêu đề (Có thể trống)</label>
        <input placeholder="Tiêu đề" type="text" id="li_title" name="li_title">
        <label for="type">Loại hiển thị</label>
        <select id="li_type" name="type">
            <option value="province">Tỉnh / Thành phố</option>
            <option value="default">Vùng miền</option>
        </select>
        <label for="li_value" id="li_lable_value">Tỉnh thành</label>
        <select id="li_value" name="li_value">
        </select>
        <label for="li_loto">Hiển thị bảng loto</label>
        <input type="checkbox" id="li_loto" name="li_loto">
        <button type="button"
            style="padding: 6px 10px;background-color: #0073aa;color: #fff;border: none;cursor: pointer;border-radius: 4px"
            onclick="lsgGenerateShortcode()">Generate Shortcode</button>
    </form>
    <p style="margin-top: 20px; font-weight: bold;">
        <label for="generated-shortcode-input">
            Mã ngắn
        </label>
        <input type="text" value="[lottery_info]" id="generated-shortcode-input" readonly
            style="width: 500px;background-color: #fff">
        <button onclick="copyToClipboard()"
            style="background-color: #0073aa;color: #fff;border: none;cursor: pointer;padding: 6px 10px;border-radius: 4px"
            id="copy-button">Copy</button>
    <p><b>Cách sử dụng:</b> Bạn có thể chèn shortcode trực tiếp vào nội dung bài viết hoặc trang bằng cách thêm nó
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
            name: "Miền bắc"
        }, {
            slug: "mien-nam",
            name: "Miền nam"
        }, {
            slug: "mien-trung",
            name: "Miền trung"
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
    })
    function lsgGenerateShortcode() {
        let str_loto = `loto-hidden="1"`;
        if (li_loto.checked) {
            str_loto = `loto-hidden="0"`;
        }
        const shortcode = `[lottery_info title="${li_title.value}"  ${li_type.value}="${li_value.value}" ${str_loto} ]`;
        document.getElementById('generated-shortcode-input').value = shortcode;
    }
</script>