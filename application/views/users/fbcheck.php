<?php $this->load->view('includes/header'); ?>

    <!-- ##### SIDEBAR MENU ##### -->
    <?php $this->load->view('includes/sidebar'); ?> 
    <!-- kt-sideleft -->

    <!-- ##### HEAD PANEL ##### -->
    <?php $this->load->view('includes/headPanel'); ?> 
    <!-- kt-breadcrumb -->

    <!-- ##### MAIN PANEL ##### -->
    <div class="kt-mainpanel">
      <!-- <div class="kt-pagetitle">-->
      <!--   <h5>Dashboard</h5>-->
      <!-- </div> --><!-- kt-pagetitle -->
    
      <div class="kt-pagebody">
      <div class="alert alert-<?php echo $alert_type ?> alert-bordered pd-y-20" role="alert" style="display:<?php if($alert == 1) {echo 'block';} else { echo 'none';} ?>">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex align-items-center justify-content-start">
          <i class="icon ion-ios-close alert-icon tx-52 tx-<?php echo $alert_type ?> mg-r-20"></i>
          <div>
            <h5 class="mg-b-2 tx-<?php echo $alert_type ?>"><?php echo $fb_large_message ?></h5>
            <p class="mg-b-0 tx-gray"><?php echo $fb_message ?></p>
          </div>
        </div><!-- d-flex -->
      </div><!-- alert -->
      <div class="col-lg-4" style="margin:auto"> 
            <div class="card pd-40 tx-center"> 
              <h6 class="tx-md-20 tx-inverse mg-b-20">Facebook Page Check</h6>
              <p class="tx-13">Add new Facebook pages to be managed here or update your Facebook user and page access tokens. </p>
              <a href="<?php echo $loginUrl;?>" class="btn btn-default btn-block">FB  Check</a>
              <p class="tx-13">If your Facebook access tokens are not valid, expired or near expiration you won't be able to upload posts on Facebook trough this application and your statistics will not be updated.   </p>
              <a href="" class="btn btn-default btn-block">Not now</a>
            </div><!-- card -->
            <div class="col-lg-4">   


       </div><!-- kt-pagebody -->

<?php $this->load->view('includes/footer'); ?> 