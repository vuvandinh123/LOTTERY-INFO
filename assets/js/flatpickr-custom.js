const Vietnamese = {
    weekdays: {
        shorthand: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
        longhand: [
            "Chủ nhật",
            "Thứ hai",
            "Thứ ba",
            "Thứ tư",
            "Thứ năm",
            "Thứ sáu",
            "Thứ bảy",
        ]
    },
    months: {
        shorthand: [
            "Th1",
            "Th2",
            "Th3",
            "Th4",
            "Th5",
            "Th6",
            "Th7",
            "Th8",
            "Th9",
            "Th10",
            "Th11",
            "Th12",
        ],
        longhand: [
            "Tháng một",
            "Tháng hai",
            "Tháng ba",
            "Tháng tư",
            "Tháng năm",
            "Tháng sáu",
            "Tháng bảy",
            "Tháng tám",
            "Tháng chín",
            "Tháng mười",
            "Tháng mười một",
            "Tháng mười hai",
        ]
    },
    firstDayOfWeek: 1,
    rangeSeparator: " đến ",
    weekAbbreviation: "Tuần",
    scrollTitle: "Cuộn để tăng",
    toggleTitle: "Nhấn để chuyển",
    amPM: ["SA", "CH"],
    yearAriaLabel: "Năm",
    monthAriaLabel: "Tháng",
    hourAriaLabel: "Giờ",
    minuteAriaLabel: "Phút"
};
function flatpickrCustom(validDays = [0, 1, 2, 3, 4, 5, 6], defaultDate = null, onChange = function () { },) {
    const today = new Date();
    const defaultDateValue = defaultDate ? new Date(defaultDate) : today;
    flatpickr("#date", {
        dateFormat: "Y-m-d", // Định dạng ngày tháng
        maxDate: today,
        defaultDate: new Date(defaultDateValue),
        locale: Vietnamese,
        enable: [
            function (date) {
                // Chặn các ngày không thuộc validDays và chặn ngày trong tương lai
                return !validDays.includes(date.getDay()) && date <= today;
            }
        ],
        onChange: onChange
    });
}