<?php $this->load->view('includes/header'); ?>
<!-- ##### SIDEBAR MENU ##### -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- kt-sideleft -->

<!-- ##### HEAD PANEL ##### -->
<?php $this->load->view('includes/headPanel'); ?>
<!-- kt-breadcrumb -->

<!-- ##### MAIN PANEL ##### -->
<div class="kt-mainpanel">

    <div class="signpanel-wrapper">
    <?php echo form_open('createuesrs'); ?>
        <div class="signbox signup">
            <div class="signbox-header">
                <h4>katniss</h4>
                <p class="mg-b-0">Responsive Bootstrap 4 Admin Template</p>
            </div><!-- signbox-header -->
            <div class="signbox-body">
                <div class="form-group">
                    <label class="form-control-label">Email:</label>
                    <input type="email" name="email" class="form-control" placeholder="Type email address">
                </div><!-- form-group -->

                <div class="form-group">
                    <label class="form-control-label">Full Name:</label>
                    <input type="text" name="fullname" class="form-control" placeholder="Type full name">
                </div><!-- form-group -->


                <div class="form-group">
                    <label class="form-control-label">Usernamename:</label>
                    <input type="text" name="username" class="form-control" placeholder="Type username">
                </div><!-- form-group -->


                <div class="row row-xs">
                    <div class="col-sm">
                        <div class="form-group">
                            <label class="form-control-label">Password:</label>
                            <input type="password" name="password" class="form-control" placeholder="Type password">
                        </div><!-- form-group -->
                    </div><!-- col -->
                    <div class="col-sm">
                        <div class="form-group">
                            <label class="form-control-label">Confirm Password:</label>
                            <input type="password" name="conpassword" class="form-control"
                                placeholder="Retype password">
                        </div><!-- form-group -->
                    </div><!-- col -->
                </div><!-- row -->

                <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Role: <span class="tx-danger">*</span></label>
                    <select class="form-control select2" name="role" data-placeholder="Choose role">
                        <option label="Choose role"></option>
                        <option value="1">Admin</option>
                        <option value="2">Editor</option>
                    </select>
                </div>

              
                <button type="submit" class="btn btn-dark btn-block">Create user</button>
                <!-- <div class="tx-center bd pd-10 mg-t-40">Already a member? <a href="page-signin.html">Sign In</a></div> -->
            </div><!-- signbox-body -->
        </div><!-- signbox -->
        </form>
    </div><!-- signpanel-wrapper -->

    <?php $this->load->view('includes/footer'); ?>