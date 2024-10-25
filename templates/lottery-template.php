<div class="li_border li_border-5 li_p-2 li_py-4">
    <div id="outer_result_btr">
        <div class="result_div" id="result_btr" data-uri="https://ketqua365.net/api/lotteries">
            <div>
                <h2 class="li_text-center li_fs-6" id="li-title" style="text-transform:uppercase">
                    <!-- title -->
                </h2>
                <div class="">
                    <div id="show-date" class=" li_text-center text-danger li_mb-3">
                        <!-- show date -->
                    </div>
                    <div class="li_row li_p-2">
                        <div class=" li_col-6">
                            <select style="height: 50px;width:100%; border:1px solid #ccc;" class="li_form-select li_py-2" name="" id="province-select">
                                <?php foreach ($provinces as $province): ?> 
                                    <option value="<?= $province->slug ?>"><?= $province->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="li_col-6">
                            <input style="height: 50px;border:1px solid #ccc" type="date" placeholder="Select Date.."
                                name="date" id="date" class="li_form-control">
                        </div>
                    </div>
                </div>
                <div class=" li_p-4 my-2" id="lottery-results">
                    <!-- lottery results -->

                </div>
            </div>
            <div class="li_p-3">
                <div class="li_text-center li_mb-3 li_text-red li_fs-5 li_fw-bold" style="text-transform:uppercase">
                    Bảng loto
                </div>
                <div>
                    <div class="li_row" id="lottery-table">
                        <!-- lottery table -->
                    </div>
                </div>
            </div>
            <div class=" li_p-3">
                <div class="li_p-3 li_col ">
                    <div class="li_row">
                        <div class="li_col-12" id="lottery-table">
                            <div class="li_row li_bg-gray li_fw-bold li_border bg-light">
                                <div class="li_col-3 li_border-end">Đầu</div>
                                <div class="li_col-9">Lô tô</div>
                            </div>
                            <div id="lottery-table-start">
                                <!-- lottery table start -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="li_p-3 li_col">
                    <div class="li_row">
                        <div class="li_col-12" id="lottery-table">
                            <div class="li_row li_fw-bold li_border li_bg-gray">
                                <div class="li_col-3 li_border-end">Cuối</div>
                                <div class="li_col-9">Lô tô</div>
                            </div>
                            <div id="lottery-table-end">
                                <!-- lottery table end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>