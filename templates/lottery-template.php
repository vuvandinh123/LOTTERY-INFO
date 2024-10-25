<div class="li_border li_border-5 li_p-2 li_py-4" style="min-width: 300px;">
    <div id="outer_result_btr" class="lottery-info-shortcode" data-id="<?= $unique_id ?>">
        <div class="result_div" id="<?= "result_btr-" . $unique_id ?>" data-type="<?= $default ?>">
            <div>
                <h2 class="li_text-center li_fs-5" id="<?= "li-title-" . $unique_id ?>"
                    style="text-transform:uppercase">
                    <!-- title -->
                    <?= $title ?>
                </h2>
                <div class="">
                    <div id="<?= "show-date-" . $unique_id ?>" class=" li_text-center text-danger li_mb-3">
                        <!-- show date -->
                    </div>
                    <div class="li_row li_p-2">
                        <?php
                        if ($default !== 'mien-bac'): ?>
                            <div class=" li_col">
                                <select style="height: 50px;width:100%; border:1px solid #ccc;"
                                    class="li_form-select li_py-2" name="" id="<?= "province-select-" . $unique_id ?>">
                                    <?php foreach ($provinces as $province): ?>
                                        <option value="<?= $province['slug'] ?>"><?= $province['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <div class="li_col">
                            <input style="height: 50px;border:1px solid #ccc" type="date" placeholder="Select Date.."
                                name="date" id="<?= "date-" . $unique_id ?>" class="li_form-control">
                        </div>
                    </div>
                </div>
                <div class=" li_p-4 my-2" id="<?= "lottery-results-" . $unique_id ?>">
                    <!-- lottery results -->

                </div>
            </div>
            <?php if (!$loto_hidden): ?>
                <div class="li_p-3 lottery-table-hidden">
                    <div class="li_text-center li_mb-3 li_text-red li_fs-5 li_fw-bold" style="text-transform:uppercase">
                        Bảng loto
                    </div>
                    <div>
                        <div class="li_row" id="<?= "lottery-table-" . $unique_id ?>">
                            <!-- lottery table -->
                        </div>
                    </div>
                </div>
                <div class="li_row li_p-3 lottery-table-hidden">
                    <div class="li_p-3 li_col " style="min-width: 250px;flex-shrink: 0">
                        <div class="li_row">
                            <div class="li_col-12">
                                <div class="li_row li_bg-gray li_fw-bold li_border bg-light">
                                    <div class="li_col-3 li_fs-3 li_border-end">Đầu</div>
                                    <div class="li_col-9 li_fs-3">Lô tô</div>
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
                                <div class="li_row li_fw-bold li_border li_bg-gray">
                                    <div class="li_col-3 li_border-end li_fs-3">Đuôi</div>
                                    <div class="li_col-9 li_fs-3">Lô tô</div>
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
</div>