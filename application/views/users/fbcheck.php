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

      <div class="col-lg-4">
            <div class="card pd-40 tx-center">
              <div class="d-flex justify-content-center mg-b-30">
                <img src="../img/icon1.svg" class="wd-100" alt="">
              </div>
              <h6 class="tx-md-20 tx-inverse mg-b-20">Facebook Page Check</h6>
              <a href="<?php echo $loginUrl;?>" class="btn btn-default btn-block">FB  Check</a>
              <p class="tx-13">Add new Facebook pages to be managed here or update your Facebook user and page access tokens. </p>
              <p class="tx-13">If your Facebook access tokens are not valid, expired or near expiration you won't be able to upload posts on Facebook trough this application and your statistics will not be updated.   </p>
              <a href="" class="btn btn-default btn-block">Not now</a>
            </div><!-- card -->
            <div class="col-lg-4">   


       </div><!-- kt-pagebody -->

<?php $this->load->view('includes/footer'); ?> 