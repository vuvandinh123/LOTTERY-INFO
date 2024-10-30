<div class="li_border li_border-5 li_p-2 li_py-4" style="min-width: 300px;">
    <div id="outer_result_btr-<?= $unique_id ?>" class="lottery-info-shortcode" data-id="<?= $unique_id ?>">
        <div class="result_div" id="<?= "result_btr-" . $unique_id ?>" data-province="<?= $province ?>"
            data-type="<?= $default ?>">
            <div>
                <h2 class="li_text-center li_fs-5" id="<?= $title ?: "li-title-" . $unique_id ?>"
                    style="text-transform:uppercase">
                    <!-- title -->
                    <?= $title ?: "Kết quả xổ số" ?>
                </h2>
                <div class="">
                    <div id="<?= "show-date-" . $unique_id ?>" class=" li_text-center text-danger li_mb-3">
                        <!-- show date -->
                    </div>
                    <div class="li_row li_p-2">
                        <?php if ($province === ''): ?>
                            <div class=" li_col">
                                <select style="height: 50px;width:100%; border:1px solid #ccc;"
                                    class="li_form-select li_py-2" name="" id="<?= "province-select-" . $unique_id ?>">
                                    <?php if ($default === 'mien-bac'): ?>
                                        <option value="">Xổ số truyền thống</option>
                                    <?php endif; ?>
                                    <?php foreach ($provinces as $province): ?>
                                        <option value="<?= $province['slug'] ?>"><?= $province['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        <div class="li_col">
                            <input
                                style="height: 50px;border:1px solid #ccc;width:98%;background-color: #fff;padding:0;padding-left: 10px;border-radius: 5px;"
                                type="date" placeholder="Select Date.." name="date" id="<?= "date-" . $unique_id ?>"
                                class="li_form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div id="<?= "li_content-" . $unique_id ?>">
                <div class=" li_p-4 my-2" id="<?= "lottery-results-" . $unique_id ?>">
                    <!-- lottery results -->

                </div>
                <?php if ($loto_hidden == "0" && $default !== 'Vietlott'): ?>
                    <div class="li_p-3 <?= 'lottery-table-hidden-' . $unique_id ?>">
                        <div class="li_text-center li_mb-3 li_text-red li_fs-5 li_fw-bold" style="text-transform:uppercase">
                            Bảng loto
                        </div>
                        <div>
                            <div class="li_row" id="<?= "lottery-table-" . $unique_id ?>">
                                <!-- lottery table -->
                            </div>
                        </div>
                    </div>
                    <div class="li_row li_p-3 <?= 'lottery-table-hidden-' . $unique_id ?>">
                        <div class="li_p-3 li_col " style="min-width: 250px;flex-shrink: 0">
                            <div class="li_row">
                                <div class="li_col-12">
                                    <div class="li_row li_bg-gray li_fw-bold li_border bg-light">
                                        <div style="width: 30%;" class=" li_fs-3 li_border-end li_text-center">Đầu</div>
                                        <div class="li_col li_fs-3">Lô tô</div>
                                    </div>
                                    <div id="<?= "lottery-table-start-" . $unique_id ?>">
                                        <!-- lottery table start -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="li_p-3 li_col lottery-table-hidden" style="flex-shrink: 0;min-width: 250px">
                            <div class="li_row">
                                <div class="li_col-12" id="lottery-table">
                                    <div class="li_row li_fw-bold li_border li_bg-gray ">
                                        <div style="width: 30%;" class="li_border-end li_fs-3 li_text-center">Đuôi</div>
                                        <div class="li_col li_fs-3 ">Lô tô</div>
                                    </div>
                                    <div id="<?= "lottery-table-end-" . $unique_id ?>">
                                        <!-- lottery table end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="li_d-none" id="<?= "li_loader-" . $unique_id ?>"
            style="display:flex;justify-content:center;align-items:center;min-height:300px">
            <div class="li_loader"></div>
        </div>
    </div>
</div>