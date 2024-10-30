<?php
class Lottery_Data_List_Table extends WP_List_Table
{
    // Các cột cho bảng
    private $curent_per_page = 10;
    public function get_columns()
    {
        return [
            'cb' => '<input type="checkbox" />', // Cột checkbox
            'title' => __('Tiêu đề', 'textdomain'),
            'sortcode' => __('Sortcode', 'textdomain'),
        ];
    }
    public function column_sortcode($item)
    {
        $sortcode = stripslashes($item['sortcode']);
        return '
        <div style="display: flex;justify-content: center;align-items: center;" >
        <input title="' . $sortcode . '" type="text" name="sortcode" value="' . $sortcode . '"  readonly
                    style="width: 100%;max-width: 22rem;background-color: #fff">
        <button style="background-color: #0073aa;color: #fff;border: none;cursor: pointer;padding: 6px 10px;border-radius: 4px"  onclick="fn_copy.call(this,`' . $sortcode . '`)" type="button">Coppy</button>
        </div>
        ';
    }
    // Thêm cột hành động
    protected function column_title($item)
    {
        $delete_url = add_query_arg([
            'page' => $_REQUEST['page'],
            'action' => 'delete',
            'item_id' => $item['id']
        ], admin_url('admin.php'));
        $actions = [
            'delete' => sprintf(
                '<a href="%s" onclick="return confirm(\'Are you sure you want to delete this item?\')">Delete</a>',
                esc_url($delete_url)
            )
        ];

        return sprintf('%1$s %2$s', $item['title'], $this->row_actions($actions));
    }
    // Cột checkbox
    protected function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />',
            esc_attr($item['id'])
        );
    }
    public function get_bulk_actions()
    {
        return [
            'bulk-delete' => 'Xóa đã chọn'
        ];
    }
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'title':
            case 'sortcode':
            case 'province':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }
    // Xử lý dữ liệu khi chuẩn bị bảng
    public function prepare_items()
    {
        $table_history = new Li_Table_Lottery_History();
        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [$columns, $hidden, $sortable];
        // Dữ liệu mẫu hoặc lấy từ cơ sở dữ liệu
        $current_page = $this->get_pagenum();
        $data = $table_history->get_data($current_page, $this->curent_per_page);
        // Lấy thông tin cột và thứ tự sắp xếp
        $orderby = !empty($_REQUEST['orderby']) ? $_REQUEST['orderby'] : 'title';
        $order = !empty($_REQUEST['order']) ? $_REQUEST['order'] : 'asc';


        // Sắp xếp dữ liệu
        usort($data['results'], function ($a, $b) use ($orderby, $order) {
            if ($a[$orderby] == $b[$orderby]) {
                return 0;
            }
            if ($order === 'asc') {
                return ($a[$orderby] < $b[$orderby]) ? -1 : 1;
            } else {
                return ($a[$orderby] > $b[$orderby]) ? -1 : 1;
            }
        });

        $this->items = $data['results'];
        $this->set_pagination_args([
            'total_items' => $data["total_items"], // Tổng số bản ghi
            'per_page' => $this->curent_per_page, // Số bản ghi trên mỗi trang
            'total_pages' => ceil($data["total_items"] / $this->curent_per_page), // Tổng số trang
        ]);
        // Kiểm tra và xử lý hành động, nếu cần
        $this->process_action();
    }
    protected function handle_delete_item($ids)
    {

        $db_lottery_history = new Li_Table_Lottery_History();
        $db_lottery_history->delete_items($ids);
        // Chuyển hướng lại trang quản trị với thông báo thành công
        wp_redirect(add_query_arg('deleted', 1, admin_url('admin.php?page=' . $_REQUEST['page'])));
        exit;
    }

    public function get_sortable_columns()
    {
        return [
            'title' => ['title', false],  // true ở đây nghĩa là thứ tự mặc định là tăng dần (ASC)
            'sortcode' => ['sortcode', false]  // false nghĩa là giảm dần (DESC) mặc định
        ];
    }
    // Xử lý các hành động (xóa và sửa)
    public function process_action()
    {
        if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'delete' && isset($_REQUEST['item_id'])) {
            $this->handle_delete_item([intval($_REQUEST['item_id'])]);
        }
        if (
            (isset($_POST['action']) && $_POST['action'] == 'bulk-delete') ||
            (isset($_POST['action2']) && $_POST['action2'] == 'bulk-delete')
        ) {
            if (!empty($_POST['bulk-delete'])) {
                $ids = array_map('intval', $_POST['bulk-delete']);
                $this->handle_delete_item($_POST['bulk-delete']);
            }
        }
    }
}
