<?php $this->load->view('includes/header'); ?>

    <div class="signpanel-wrapper">
    <?php echo form_open('login', 'id = "login_form"'); ?>
      <div class="signbox">
        <div class="signbox-header">
          <h4>DATADAT</h4>
          <p class="mg-b-0">Please type your email and password!</p>
        </div><!-- signbox-header -->
        <div class="signbox-body">
        <span class="tx-danger"><?php echo validation_errors(); ?><?php echo isset($errors)? $errors:""; ?></span>
          <div class="form-group">
            <label class="form-control-label">Email: <span class="tx-danger"></span></label>
            <input type="text" name="email" placeholder="Enter your email or password" class="form-control"  value="<?php echo set_value('email'); ?>">
          </div><!-- form-group -->
          <div class="form-group">
            <label class="form-control-label">Password: <span class="tx-danger">*</span></label>
            <input type="password" name="password" placeholder="Enter your password" class="form-control"  value="<?php echo set_value('password'); ?>">
          </div><!-- form-group -->
          <div class="form-group">
            <a href="">Forgot password?</a>
          </div><!-- form-group -->
          <button id="btn_login" class="btn btn-dark btn-block"><span id= "span_log" class="fa fa-sign-in" style="font-size:20px"></span>   Sign In</button>
          <!-- <div class="tx-center bd pd-10 mg-t-40">Not yet a member? <a href="page-signup.html">Create an account</a></div> -->
        </div><!-- signbox-body -->
      </div><!-- signbox -->
    </div><!-- signpanel-wrapper -->
    <?php $this->load->view('includes/footer'); ?>
    <script>
     $(document).ready(function() {
      document.querySelector("#login_form").addEventListener("submit", function(e){ 
        $('#span_log').removeClass('fa-sign-in');
        $('#span_log').addClass('fa-refresh');
        $('#span_log').addClass('fa-spin');
       });
     });
    </script>
    
    