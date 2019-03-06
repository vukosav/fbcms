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
                        <!-- <a href="" class="btn btn-dark">Edit Photo</a> -->
                    </figcaption>
                </figure>


                <div id="modaldemo3" class="modal fade" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content tx-size-sm">
                            <div class="modal-header pd-x-20">
                                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Resset password</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body pd-20">
                            <?php  $attributes = array('name' => 'formRessetPass');
                            echo form_open('ressetpwd', $attributes); ?>
                                <!-- <form name="formRessetPass" action="<?//=base_url()?>ressetpwd" method="POST"> -->

                                    <div class='error_msg'>
                                        <span class="tx-danger"><?php echo validation_errors(); ?></span>
                                    </div>
                                    <input type="password" id="password" name="password"
                                        class="col col-md-12 form-control" placeholder="Type password" required />
                                    <input type="password" id="conpassword" name="conpassword"
                                        class="col col-md-12 form-control" placeholder="Retype password" required>
                                
                            </div><!-- modal-body -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pd-x-20">Resset</button>
                                <button type="button" class="btn btn-secondary pd-x-20"
                                    data-dismiss="modal">Close</button>
                            </div>
                            </form>
                        </div>
                    </div><!-- modal-dialog -->
                </div>
                <!------------------------------>






            </div><!-- col-3 -->
            <div class="col-md-8 col-lg-9 mg-t-30 mg-md-t-0">
                <label class="content-left-label">Personal Information</label>
                <div class="card bg-gray-200 bd-0">
                    <div class="edit-profile-form">
                        <?php echo form_open('editprofile', 'enctype="multipart/form-data"'); ?>
                        <span class="tx-danger"><?php echo validation_errors(); ?></span>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Fullname:<span class="tx-danger">*</span></label>
                            <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                                <input class="form-control" id="fullname" name="fullname" type="text" required
                                    value="<?php echo  set_value('fullname')?set_value('fullname'):$this->session->userdata('user')['name']?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Email: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                                <input class="form-control" id="email" name="email" type="email" required
                                    value="<?php echo set_value('email')? set_value('email'):$this->session->userdata('user')['email']?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Username: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                                <input class="form-control" type="text" id="username" name="username" required
                                    value="<?php echo set_value('username') ? set_value('username'):$this->session->userdata('user')['username']; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Picture: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                                <input type="file" class="form-control" name="picture" id="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Password: <span class="tx-danger"></span></label>
                            <div class="col-sm-8 col-xl-6 mg-t-10 mg-sm-t-0">
                                <a href="" data-toggle="modal" data-target="#modaldemo3">Change Password</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label"> <span class="tx-danger"></span></label>
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
    <script>
    function submitform() {
        document.formRessetPass.submit();
    }
      </script>