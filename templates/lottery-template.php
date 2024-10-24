<div class="border border-5 p-2 py-4">
    <div id="outer_result_btr">
        <div class="result_div" id="result_btr" data-uri="https://ketqua365.net/api/lotteries?region=mien-bac">
            <div>
                <h2 class="h4 text-center" id="li-title" style="text-transform:uppercase">xổ số</h2>
                <div class="row">
                    <div id="show-date" class="col-12 text-center text-danger mb-3">
                        <!-- show date -->
                    </div>
                    <div class="col-12 row">
                        <div class=" col-6">
                            <select class="form-select form-select-lg" name="" id="province-select">
                                <?php foreach ($provinces as $province): ?>
                                    <option value="<?= $province->slug ?>"><?= $province->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <input type="date" placeholder="Select Date.." name="date" id="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class=" p-4 my-2" id="lottery-results">
                    <!-- lottery results -->

                </div>
            </div>
            <div class="p-3">
                <div class="text-center mb-3 text-danger h4" style="text-transform:uppercase">
                    Bảng loto
                </div>
                <div>
                    <div class="row" id="lottery-table">
                        <!-- lottery table -->
                    </div>
                </div>
            </div>
            <div class="p-3 ">
                <div class="row">
                    <div class="col-12" id="lottery-table">
                        <div class="row border bg-light">
                            <div class="col-3 border-end">Đầu</div>
                            <div class="col-9">Lô tô</div>
                        </div>
                        <div id="lottery-table-start">
                            <!-- lottery table start -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-3 ">
                <div class="row">
                    <div class="col-12" id="lottery-table">
                        <div class="row border bg-light">
                            <div class="col-3 border-end">Cuối</div>
                            <div class="col-9">Lô tô</div>
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