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
                <h4>Create user</h4>
            </div><!-- signbox-header -->
            <div class="signbox-body">
                <span class="tx-danger"><?php echo validation_errors(); ?></span>
                <div class="form-group">
                    <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="Type email address" required value="<?php echo set_value('email'); ?>">
                </div><!-- form-group -->

                <div class="form-group">
                    <label class="form-control-label">Full Name: <span class="tx-danger">*</span></label>
                    <input type="text" name="fullname" class="form-control" placeholder="Type full name" required value="<?php echo set_value('fullname'); ?>">
                </div><!-- form-group -->


                <div class="form-group">
                    <label class="form-control-label">Username: <span class="tx-danger">*</span></label>
                    <input type="text" name="username" class="form-control" placeholder="Type username" required value="<?php echo set_value('username'); ?>">
                </div><!-- form-group -->


                <div class="row row-xs">
                    <div class="col-sm">
                        <div class="form-group">
                            <label class="form-control-label">Password: <span class="tx-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Type password" required value="<?php echo set_value('password'); ?>">
                        </div><!-- form-group -->
                    </div><!-- col -->
                    <div class="col-sm">
                        <div class="form-group">
                            <label class="form-control-label">Confirm Password: <span class="tx-danger">*</span></label>
                            <input type="password" name="conpassword" class="form-control" placeholder="Retype password" required value="<?php echo set_value('conpassword'); ?>">
                        </div><!-- form-group -->
                    </div><!-- col -->
                </div><!-- row -->

                <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Role: <span class="tx-danger">*</span></label>
                    <select class="form-control select2" name="role" data-placeholder="Choose role" required>
                        <?php echo (set_value('role') == "")? 
                        "<option label='Choose role'></option><option value='1'>Admin</option><option value='2'>Editor</option>" : 
                        ((set_value('role') == 1)?"<option value='1'>Admin</option><option value='2'>Editor</option>": "<option value='2'>Editor</option><option value='1'>Admin</option>")?>
                    </select>
                </div>

              
                <button type="submit" class="btn btn-dark btn-block">Create user</button>
                <!-- <div class="tx-center bd pd-10 mg-t-40">Already a member? <a href="page-signin.html">Sign In</a></div> -->
            </div><!-- signbox-body -->
        </div><!-- signbox -->
        </form>
    </div><!-- signpanel-wrapper -->

    <?php $this->load->view('includes/footer'); ?>