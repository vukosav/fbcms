<?php $this->load->view('includes/header'); ?>

<!-- ##### SIDEBAR MENU ##### -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- kt-sideleft -->

<!-- ##### HEAD PANEL ##### -->
<?php $this->load->view('includes/headPanel'); ?>
<!-- kt-breadcrumb -->

<!-- ##### MAIN PANEL ##### -->
<div class="kt-mainpanel">
    <div class="kt-pagetitle">
        <h5>Dashboard</h5>
    </div><!-- kt-pagetitle -->

    <div class="kt-pagebody">
        <div class="row m-t-30">
            <div class="form-group">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-primary"> <i class="fa fa-plus"></i>&nbsp; Shedule new
                        post</button>
                </div>
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-primary"> <i class="fa fa-facebook"></i>&nbsp; Add new FB
                    page</button>
            </div>

            <div class="card pd-20">
                <h6 class="tx-12 tx-uppercase tx-info tx-bold mg-b-15">Facebook Report</h6>
                <div class="d-flex mg-b-5">
                    <div class="bd-r pd-r-10">
                        <label class="tx-12">Posts in last 72h</label>
                        <p class="tx-lato tx-inverse tx-bold"><?php echo $global['pLast72']; ?></p>
                    </div>
                    <div class="bd-r pd-x-10">
                        <label class="tx-12">Reactions in last 72h</label>
                        <p class="tx-lato tx-inverse tx-bold"><?php echo $global['rLast72']; ?></p>
                    </div>
                    <div class="bd-r pd-r-10">
                        <label class="tx-12"> &nbsp;Comments in last 72h</label>
                        <p class="tx-lato tx-inverse tx-bold">&nbsp;<?php echo $global['cLast72']; ?></p>
                    </div>
                    <div class="pd-x-10">
                        <label class="tx-12">Shares in last 72h</label>
                        <p class="tx-lato tx-inverse tx-bold"><?php echo $global['sLast72']; ?></p>
                    </div>
                </div><!-- d-flex -->
            </div><!-- card pd-20 -->
        </div><!-- row m-t-30 -->
        <div class="form-group">
        </div>
        <div class="row m-t-30">
            <div class="col-md-12">
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead>
                            <tr>
                                <th>Page name</th>
                                <th>Page like count<br><small>(last 72h change)</small></th>
                                <th>Group</th>
                                <th>Posts in last 24h</th>
                                <th>Posts in last 72h</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($p_statistics as $statistic): ?>

                            <tr>
                                <td><?php echo $statistic['page_id']; ?></td>
                                <td class="process"><?php echo $statistic['pageLikes']; ?></td>
                                <td>Group</td>
                                <td><?php echo $statistic['p24']; ?></td>
                                <td><?php echo $statistic['p72']; ?></td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE-->
            </div>
        </div>



    </div><!-- kt-pagebody -->

    <?php $this->load->view('includes/footer'); ?>