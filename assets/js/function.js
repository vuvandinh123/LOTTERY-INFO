function formatDateString(dateString) {
    const daysOfWeek = ['Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy'];

    // Tạo đối tượng Date từ chuỗi
    const date = new Date(dateString);

    // Lấy các thông tin cần thiết
    const dayOfWeek = daysOfWeek[date.getDay()];
    const day = date.getDate();
    const month = date.getMonth() + 1; // getMonth() trả về từ 0 - 11, cần cộng 1
    const year = date.getFullYear();

    // Trả về định dạng mong muốn
    return `${dayOfWeek} ${day} - ${month} - ${year}`;
}
function formatNumber(number) {
    return number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}
function getPrizeNumberLottery(data) {
    if (!data || typeof data !== 'object') {
        return []
    }
    const arr = data.map(item => item.prize_number_lotto);
    return arr
}
function getLotoNumber(data, key = 0) {
    let groupedNumbers = {
        '0': [],
        '1': [],
        '2': [],
        '3': [],
        '4': [],
        '5': [],
        '6': [],
        '7': [],
        '8': [],
        '9': []
    }
    data.forEach(element => {
        let number = element[key];
        groupedNumbers[number].push(element);
    });
    return groupedNumbers
}