<?php $this->load->view('includes/header'); ?>

<!-- ##### SIDEBAR MENU ##### -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- kt-sideleft -->

<!-- ##### HEAD PANEL ##### -->
<?php $this->load->view('includes/headPanel'); ?>
<!-- kt-breadcrumb -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
function searchFilter(page_num) {
    page_num = page_num ? page_num : 0;
    var username = $('#username').val();
    var role = $('#role').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>users/ajaxPaginationData/' + page_num,
        data: 'page=' + page_num + '&username=' + username + '&role=' + role,
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
        <h5>Application configuration</h5>
    </div><!-- kt-pagetitle -->

    <div class="kt-pagebody">

        <div class="row">
            <div class="col-md-8 col-lg-9 mg-t-30 mg-md-t-0">
                <label class="content-left-label">Configuration</label>
                <div class="card bg-gray-200 bd-0">
                    <div class="edit-profile-form">
                        <?php echo form_open('config'); ?>
                        <!-- <span class="tx-danger"><?php //echo validation_errors(); ?></span> -->
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Application time zone:<span class="tx-danger">*</span></label>
                            <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                                <select name="apptimezone" id="apptimezone" required>
                                <?php if(!empty($admin[0]['App_time_zone'])): ?>
                                    <option value="<?php echo $admin[0]['App_time_zone']; ?>"><?php echo $admin[0]['App_time_zone']; ?></option>
                                <?php endif; ?>
                                    <?php 
                                    $array = DateTimeZone::listIdentifiers ();
                                    echo "<option value=''>Chose time zone</option>";
                                    foreach($array as $arr){
                                        echo  "<option value='$arr'>$arr></option>";
                                        //new \DateTimeZone($tz);
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Posting interval for: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                                <select name="usrORpos" id="usrORpos" required>
                                <?php 
                                if(!empty($admin[0]['user_or_page'])){
                                    if($admin[0]['user_or_page'] == 1){
                                        echo "<option value='1'>User</option>";
                                        echo "<option value='2'>Page</option>";
                                    }else{
                                        echo "<option value='2'>Page</option>";
                                        echo "<option value='1'>User</option>";
                                    }
                                }else{
                                    echo "<option value=''>Chose one options</option>";
                                    echo "<option value='1'>User</option>";
                                    echo "<option value='2'>Page</option>";
                                } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">FB period in sec: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-6 col-xl-6 mg-t-10 mg-sm-t-0">
                                <input class="form-control" type="number" min="20" max="300" id="period" name="period" required
                                    value="<?php echo $admin[0]['period_in_sec_fb'] ? $admin[0]['period_in_sec_fb']: ""; ?>">
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> <span class="tx-danger"></span></label>
                            <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                                <button class="btn btn-default">Set config</button>

                            </div>
                        </div>
                        </form>
                    </div><!-- wd-60p -->
                </div><!-- card -->


            </div><!-- col-9 -->
        </div><!-- row -->

    </div><!-- kt-pagebody -->

    <?php $this->load->view('includes/footer'); ?>
    <script>
    function submitform() {
        document.formRessetPass.submit();
    }
      </script>