<?php $this->load->view('includes/header'); ?>

<!-- ##### SIDEBAR MENU ##### -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- kt-sideleft -->

<!-- ##### HEAD PANEL ##### -->
<?php $this->load->view('includes/headPanel'); ?>
<!-- kt-breadcrumb -->

<script>
function CreateNewPost(){
    console.log('before');
    window.location.replace('<?php echo base_url()?>create_post');
}
function searchFilter(page_num) {
    page_num = page_num ? page_num : 0;
    var pagename = $('#pagename').val();
    var group = $('#group').val();
    var pwithoutPL24 = $('#pwithoutPL24').is(':checked');
    var pwithoutPL72 = $('#pwithoutPL72').is(':checked');

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>dashboard/ajaxPaginationData/' + page_num,
        data: 'page=' + page_num + '&pagename=' + pagename + '&group=' + group + '&pwithoutPL24=' +
            pwithoutPL24 + '&pwithoutPL72=' + pwithoutPL72,
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
            <h6 class="tx-12 tx-uppercase tx-info tx-bold mg-b-15"></h6>
            <div class="d-flex mg-b-5">
                <div class="pd-r-10">
                    <a href="<?php echo base_url()?>create_post">
                        <div
                            style="background:#3b6998; color:white; text-align:center; height:90px; border-radius:5px;padding:10px;">
                            <i class="fa fa-plus-circle" style="font-size: 4em;"></i>
                            <div style="background:#3b6998; color:white; text-align:center; height:20px;">
                                <h6>Schedule new post</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="bd-r pd-r-10">
                    <a href="<?=base_url()?>fbcheck">
                        <div
                            style="background:#3b6998; color:white; text-align:center; height:90px; border-radius:5px;padding:10px;">
                            <i class="fa fa-facebook" style="font-size: 4em;"></i>
                            <div style="background:#3b6998; color:white; text-align:center; height:20px;">
                                <h6>Add new fb page</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="bd-r pd-x-10">
                    <label class="tx-18" style='color: #3b6998;'>Posts in last 72h</label>
                    <p class="tx-lato tx-inverse tx-bold tx-24"><?php echo $global['pLast72']; ?></p>
                    <p class="tx-lato tx-inverse tx-bold"><span class="tx-success"><i class="fa fa-arrow-circle-o-up"
                                style="font-size: 2em;"></i> 6</span></p>
                </div>
                <div class="bd-r pd-x-10">
                    <label class="tx-18" style='color: #3b6998;'>Reactions in last 72h</label>
                    <p class="tx-lato tx-inverse tx-bold tx-24"><?php echo $global['rLast72']; ?></p>
                    <p class="tx-lato tx-inverse tx-bold"><span class="tx-danger"><i class="fa fa-arrow-circle-o-down"
                                style="font-size: 2em;"></i> -6</span></p>
                </div>
                <div class="bd-r pd-x-10">
                    <label class="tx-18" style='color: #3b6998;'> &nbsp;Comments in last 72h</label>
                    <p class="tx-lato tx-inverse tx-bold tx-24">&nbsp;<span
                            style="text-size: 24px"><?php echo $global['cLast72']; ?></span></p>
                    <p class="tx-lato tx-inverse tx-bold"><span class="tx-success"><i class="fa fa-arrow-circle-o-up"
                                style="font-size: 2em;"></i> 6</span></p>
                </div>
                <div class="pd-x-10">
                    <label class="tx-18" style='color: #3b6998;'>Shares in last 72h</label>
                    <p class="tx-lato tx-inverse tx-bold tx-24"><?php echo $global['sLast72']; ?></p>
                    <p class="tx-lato tx-inverse tx-bold"><span class="tx-success"><i class="fa fa-arrow-circle-o-up"
                                style="font-size: 2em;"></i> 6</span></p>
                </div>

                <div>



                    <!-- </div> -->
                </div><!-- d-flex -->
            </div><!-- card pd-20 -->
        </div><!-- row m-t-30 -->


        <div class="card pd-20 pd-sm-40">
            <div class="table-wrapper">
                <?php echo form_open('dashboard', 'id='.'myform'); ?>
                <div class="row form-group">
                    <div class="col col-sm-2">
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
                    <div class="col col-sm-3">
                        <label for="pwithoutPL24" class="ckbox">
                            <input type="checkbox" id="pwithoutPL24" name="pwithoutPL24"
                                onchange="searchFilter()" /><span class="tx-16"><b>Pages without post in last
                                    24h</b></span>
                        </label>
                    </div>
                    <div class="col col-sm-3">
                        <label for="pwithoutPL72" class="ckbox">
                            <input type="checkbox" id="pwithoutPL72" name="pwithoutPL72"
                                onchange="searchFilter()" /><span class="tx-16"><b>Pages without post in last
                                    72h</b></span>
                        </label>
                    </div>
                    <div class="col col-sm-2">
                        <a id="button" href="" onclick="resetform()" name="reset" value="Reset"
                            class="btn  btn-icon rounded-circle" style='font-size: xx-large;' data-toggle="tooltip"
                            data-placement="top" title="Reset filter"><i class="fa fa-refresh"></i></a>
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
                            <td><?php echo $statistic['pageLikes']; ?>
                                <?php if($statistic['diffLikes'] >= 0): ?>
                                <span class="tx-success">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-o-up">&nbsp;<?php echo $statistic['diffLikes']; ?></i> </span>
                                <?php else: ?>
                                <span class="tx-danger">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-o-down">&nbsp;</i><?php echo $statistic['diffLikes']; ?></span>
                                <?php endif; ?>
                            </td>
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
<script> 
     function resetform() {
        location.reload();
    }
</script>