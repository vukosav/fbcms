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
        
        <div class="signbox signup">
            <div class="signbox-header">
                <h4>Create group</h4>
            </div><!-- signbox-header -->
            <div class="signbox-body">
                <span class="tx-danger"><?php echo validation_errors(); ?></span>
                <?php echo form_open('creategrp'); ?>
                <!-- <form action="creategrp" method="post"> -->
                <div class="form-group">
                    <label class="form-control-label">Group Name: <span class="tx-danger">*</span></label>
                    <input type="text" name="groupname" class="form-control" placeholder="Type grup name" required
                        value="<?php echo set_value('groupname'); ?>">
                </div><!-- form-group -->
                <button type="submit" class="btn btn-dark btn-block">Create group</button>
                </form>
                <!-- <div class="tx-center bd pd-10 mg-t-40">Already a member? <a href="page-signin.html">Sign In</a></div> -->
            </div><!-- signbox-body -->
        </div><!-- signbox -->
    
    </div><!-- signpanel-wrapper -->

    <?php $this->load->view('includes/footer'); ?>