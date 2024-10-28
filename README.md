# LOTTERY INFO
Created by: Vu Van Dinh
## Giới thiệu về Plugin
Lottery Info là một plugin WordPress giúp hiển thị kết quả xổ số Việt Nam bao gồm:
- Kết quả xổ số của các tỉnh ở ba miền: Bắc, Trung và Nam.
- Kết quả xổ số Vietlott.
Plugin này được thiết kế để cập nhật nhanh chóng, hiển thị rõ ràng và dễ dàng tích hợp vào các trang WordPress có nhu cầu cập nhật thông tin kết quả xổ số cho người dùng.
## Tính năng nổi bật
- Hiển thị kết quả xổ số theo ngày và khu vực (miền Bắc, Trung, Nam).
- Tùy chọn hiển thị các loại hình xổ số như Vietlott.
- Giao diện thân thiện, dễ dàng tùy chỉnh để phù hợp với thiết kế website.
- Cập nhật tự động để đảm bảo kết quả xổ số chính xác, nhanh chóng.
- Sử dụng sortcode dễ dàng sử dụng bất cứ đâu trong website
## Hướng dẫn cài đặt
### Bước 1 Tải plugin
- Tải plugin từ kho lưu trữ của bạn dưới dạng file `.zip`.
### Bước 2 Cài đặt plugin
1. Truy cập vào trang quản trị WordPress.
2. Đi tới Plugins > Add New (Cài mới).
3. Chọn Upload Plugin (Tải lên plugin) và chọn file .zip của plugin Lottery Info mà bạn đã tải về.
4. Nhấn Install Now (Cài đặt).
5. Sau khi cài đặt xong, nhấn Activate Plugin (Kích hoạt Plugin) để bắt đầu sử dụng.
### Bước 3: Sử dụng plugin
1. Vào Menu Thống kê xổ số tại trang quản trị
2. Nhập tiêu đề muốn hiển thị
3. Chọn loại xổ số muốn hiển thị Theo Tỉnh hoặc Theo Miền
4. Chọn Tỉnh hoặc miền muốn hiển thị tại giao diện
5. Sao chép và dán trong các trang muốn sử dụng

### Các tham số trong sortcode 
1. `title` tiêu đề  hiển thị
2. `default` Miền hiển thị hoặc Vietlott có các giá trị `mien-nam | mien-bac | mien-trung | Vietlott`
3. `loto-hidden` Có hiển thị bảng chi tiết loto hay không Giá trị `0 | 1`
4. `province` Chọn tỉnh muốn hiển thị kết quả xổ số giá trị VD: `tp-hcm | dong-nai | binh-dinh | ...vv`

-| Lưu ý nếu chọn cả `default` và `province` thì `province` sẽ được ưu tiên hơn
## Câu hỏi thường gặp
### Làm sao để hiển thị nhiều loại xổ số trên 1 trang
Sử dụng các shortcode riêng biệt cho từng loại xổ số bạn muốn hiển thị, ví dụ:
```
[lottery_info default="mien-trung"]
[lottery_info default="mien-bac"]
[lottery_info default="mien-nam"]
[lottery_info default="Vietlott"]
```
