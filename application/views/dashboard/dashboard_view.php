<?php $this->load->view('includes/header'); ?>

<!-- ##### SIDEBAR MENU ##### -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- kt-sideleft -->

<!-- ##### HEAD PANEL ##### -->
<?php $this->load->view('includes/headPanel'); ?>
<!-- kt-breadcrumb -->

<script>
function searchFilter(page_num) {
    page_num = page_num ? page_num : 0;
    var pagename = $('#pagename').val();
    var group = $('#group').val();
    var pwithoutPL24 = $('#pwithoutPL24').val($(this).is(':checked'));
    var pwithoutPL72 = $('#pwithoutPL72').val($(this).is(':checked'));
    
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>dashboard/ajaxPaginationData/' + page_num,
        data: 'page=' + page_num + '&pagename=' + pagename + '&group=' + group + '&pwithoutPL24=' + pwithoutPL24 + '&pwithoutPL72=' + pwithoutPL72,
        beforeSend: function() {
            $('.loading').show();
        },
        success: function(html) {
            $('#postList').html(html);
            $('.loading').fadeOut("slow");
            $('#datatable1').DataTable({
                responsive: true,
                "paging": false,
                "info": false,
                searching: false,
                retrieve: true
            });
        }
    });
}
</script>

<!-- ##### MAIN PANEL ##### -->
<div class="kt-mainpanel">
    <div class="kt-pagetitle">
        <h5>Dashboard</h5>
    </div><!-- kt-pagetitle -->

    <div class="kt-pagebody">
    <div class="card pd-20">
            <!-- <div class="form-group">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-default"> <i class="fa fa-plus"></i>&nbsp; Shedule new
                        post</button>
                </div>

                <div class="col-lg-2">
                    <button type="button" class="btn btn-default"> <i class="fa fa-facebook"></i>&nbsp; Add new FB
                        page</button>
                </div>
            </div> -->
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
                        <p class="tx-lato tx-inverse tx-bold">&nbsp;<span
                                style="text-size: 24px"><?php echo $global['cLast72']; ?></span></p>
                    </div>
                    <div class="pd-x-10">
                        <label class="tx-12">Shares in last 72h</label>
                        <p class="tx-lato tx-inverse tx-bold"><?php echo $global['sLast72']; ?></p>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-default"> <i class="fa fa-plus"></i>&nbsp; Shedule new
                                post</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-default"> <i class="fa fa-facebook"></i>&nbsp; Add new
                                FB
                                page</button>
                        </div>
                    </div>
                </div><!-- d-flex -->
            </div><!-- card pd-20 -->
        </div><!-- row m-t-30 -->
        <div class="form-group">
        </div>

        <div class="card pd-20 pd-sm-40">
            <div class="table-wrapper">
                <?php echo form_open('dashboard', 'id='.'myform'); ?>
                <div class="row form-group">
                    <div class="col col-sm-3">
                        <input type="text" id="pagename" name="pagename" placeholder="Filter by page name"
                            class="form-control" onkeyup="searchFilter()" />
                    </div>
                    <div class="col col-sm-2">
                        <select name="group" id="group" class="form-control" onchange="searchFilter()">
                            <option value="">Filter by group</option>
                            <option value="1">Option #1</option>
                            <option value="2">Option #2</option>
                            <option value="3">Option #3</option>
                        </select>
                    </div>
                    
                <!-- </div>
                <div class="row form-group"> -->
                    <div class="col col-sm-2">
                        <label for="inProgres" class="form-check-label ">
                            <input type="checkbox" id="pwithoutPL24" class="form-check-input" name="pwithoutPL24" value="false"
                                onchange="searchFilter()" />Pages without post in last 24h
                        </label>
                    </div>
                    <div class="col col-sm-2">
                        <label for="paused" class="form-check-label ">
                            <input type="checkbox" id="pwithoutPL72" class="form-check-input" name="pwithoutPL72" value="false"
                                onchange="searchFilter()" />Pages without post in last 72h
                        </label>
                    </div>
                    <div class="col col-sm-2">
                        <input id="button" onclick="resetform()" type="button" name="reset" value="Reset">
                    </div>
                </div>

                </form>
            </div><!-- table-wrapper -->
        </div><!-- card -->

        <div class="card pd-20 pd-sm-40">

            <!-- DATA TABLE-->
            <div class="table-wrapper" id="postList">
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
                        <?php if(!empty($p_statistics)):  foreach ($p_statistics as $statistic): ?>

                        <tr>
                            <td><?php echo $statistic['pname']; ?></td>
                            <td class="process"><?php echo $statistic['pageLikes']; ?></td>
                            <td>Group</td>
                            <td><?php echo $statistic['p24']; ?></td>
                            <td><?php echo $statistic['p72']; ?></td>
                        </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
                <?php else: ?>
                <p>Post(s) not available.</p>
                <?php endif; ?>
                <?php echo $this->ajax_pagination->create_links(); ?>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>
</div>


</div><!-- kt-pagebody -->

<?php $this->load->view('includes/footer'); ?>