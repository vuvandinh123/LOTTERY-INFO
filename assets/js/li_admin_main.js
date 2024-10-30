function removeBackslashes(str) {
    return str.replace(/\\/g, ''); // Thay thế tất cả các dấu \ bằng chuỗi rỗng
}
function fn_copy(value) {
    const el = document.createElement('textarea');
    el.value = value
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
    this.textContent = 'Copied!';
    setTimeout(() => {
        this.textContent = 'Copy';
    }, 1000);
}
