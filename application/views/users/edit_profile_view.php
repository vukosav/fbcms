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
        <h5>Edit Profile</h5>
    </div><!-- kt-pagetitle -->

    <div class="kt-pagebody">

        <div class="row">
            <div class="col-md-4 col-lg-3">
                <label class="content-left-label">Your Profile Photo</label>
                <figure class="edit-profile-photo">
                    <img src="<?=base_url()?>theme/img/img1.jpg" class="img-fluid" alt="">
                    <figcaption>
                        <a href="" class="btn btn-dark">Edit Photo</a>
                    </figcaption>
                </figure>


            </div><!-- col-3 -->
            <div class="col-md-8 col-lg-9 mg-t-30 mg-md-t-0">
                <label class="content-left-label">Personal Information</label>
                <div class="card bg-gray-200 bd-0">
                    <div class="edit-profile-form">
                    <?php echo form_open('editprofile'); ?>
                    <span class="tx-danger"><?php echo validation_errors(); ?></span>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Fullname:<span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                                <input class="form-control" id="fullname" name="fullname" type="text" value="<?php echo  set_value('fullname')?set_value('fullname'):$this->session->userdata('user')['name']?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Email: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                                <input class="form-control" id="email" name="email" type="email"
                                value="<?php echo set_value('email')? set_value('email'):$this->session->userdata('user')['email']?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Username: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                                <input class="form-control" type="text" id="username" name="username" 
                                value="<?php echo set_value('username') ? set_value('username'):$this->session->userdata('user')['username']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-3 form-control-label">Password: <span
                                    class="tx-danger"></span></label>
                            <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                                <a href="">Change Password</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> <span
                                    class="tx-danger"></span></label>
                            <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                                <button class="btn btn-default">Update</button>
                                
                            </div>
                        </div>
                        </form>
                    </div><!-- wd-60p -->
                </div><!-- card -->
     

            </div><!-- col-9 -->
        </div><!-- row -->

    </div><!-- kt-pagebody -->

    <?php $this->load->view('includes/footer'); ?>