<?php $this->load->view('includes/header'); ?>

    <!-- ##### SIDEBAR MENU ##### -->
    <?php $this->load->view('includes/sidebar'); ?> 
    <!-- kt-sideleft -->

    <!-- ##### HEAD PANEL ##### -->
    <?php $this->load->view('includes/headPanel'); ?> 
    <!-- kt-breadcrumb -->

    <!-- ##### MAIN PANEL ##### -->
    <div class="kt-mainpanel">
      <div class="kt-pagetitle">
        <h5>Dashboard</h5>
      </div><!-- kt-pagetitle -->

      <div class="kt-pagebody">

        <div class="row row-sm">
          <div class="col-lg-8">
            <div class="row row-sm">
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-body pd-b-0">
                    <h6 class="card-body-title tx-12 tx-spacing-2 mg-b-20 tx-success">Page Impressions</h6>
                    <h2 class="tx-lato tx-inverse">323,360</h2>
                    <p class="tx-12"><span class="tx-success">2.5%</span> change from yesterday</p>
                  </div><!-- card-body -->
                  <div id="rs1" class="ht-50 ht-sm-70 mg-r--1"></div>
                </div><!-- card -->
              </div><!-- col-6 -->
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-body pd-b-0">
                    <h6 class="card-body-title tx-12 tx-spacing-2 mg-b-20 tx-danger">Page Impressions</h6>
                    <h2 class="tx-lato tx-inverse">674,221</h2>
                    <p class="tx-12"><span class="tx-success">2.5%</span> change from yesterday</p>
                  </div><!-- card-body -->
                  <div id="rs2" class="ht-50 ht-sm-70 mg-r--1"></div>
                </div><!-- card -->
              </div><!-- col-6 -->
            </div><!-- row -->

            <div class="card pd-20 pd-sm-40 mg-t-20">
              <h6 class="card-body-title">Horizontal Bar Chart</h6>
              <p class="mg-b-20 mg-sm-b-30">A bar chart or bar graph is a chart with rectangular bars with lengths proportional to the values that they represent.</p>
              <canvas id="chartBar4" height="380"></canvas>
            </div><!-- card -->

            <div class="row row-sm mg-t-20">
              <div class="col-lg-6">
                <div class="card pd-20">
                  <h6 class="tx-12 tx-uppercase tx-info tx-bold mg-b-15">Sales Report</h6>
                  <div class="d-flex mg-b-10">
                    <div class="bd-r pd-r-10">
                      <label class="tx-12">Today</label>
                      <p class="tx-lato tx-inverse tx-bold">1,898</p>
                    </div>
                    <div class="bd-r pd-x-10">
                      <label class="tx-12">This Week</label>
                      <p class="tx-lato tx-inverse tx-bold">32,112</p>
                    </div>
                    <div class="pd-l-10">
                      <label class="tx-12">This Month</label>
                      <p class="tx-lato tx-inverse tx-bold">72,067</p>
                    </div>
                  </div><!-- d-flex -->
                  <div class="progress mg-b-10">
                    <div class="progress-bar bg-info wd-50p" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                  </div>
                  <p class="tx-12 mg-b-0">Maecenas tempus, tellus eget condimentum rhoncus</p>
                </div><!-- card -->
              </div><!-- col-6 -->
              <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                <div class="card pd-20">
                  <h6 class="tx-12 tx-uppercase tx-danger tx-bold mg-b-15">Sales Report</h6>
                  <div class="d-flex mg-b-10">
                    <div class="bd-r pd-r-10">
                      <label class="tx-12">Today</label>
                      <p class="tx-lato tx-inverse tx-bold">1,898</p>
                    </div>
                    <div class="bd-r pd-x-10">
                      <label class="tx-12">This Week</label>
                      <p class="tx-lato tx-inverse tx-bold">32,112</p>
                    </div>
                    <div class="pd-l-10">
                      <label class="tx-12">This Month</label>
                      <p class="tx-lato tx-inverse tx-bold">72,067</p>
                    </div>
                  </div><!-- d-flex -->
                  <div class="progress mg-b-10">
                    <div class="progress-bar bg-danger wd-50p" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                  </div>
                  <p class="tx-12 mg-b-0">Maecenas tempus, tellus eget condimentum rhoncus</p>
                </div><!-- card -->
              </div><!-- col-6 -->
            </div><!-- row -->

          </div><!-- col-8 -->
          <div class="col-lg-4">
            <div class="card pd-40 tx-center">
              <div class="d-flex justify-content-center mg-b-30">
                <img src="<?=base_url()?>theme/img/icon1.svg" class="wd-100" alt="">
              </div>
              <h6 class="tx-md-20 tx-inverse mg-b-20">Document Management</h6>
              <p class="tx-13">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia. Even the all-powerful Pointing has no control about the blind texts.</p>
              <a href="" class="btn btn-default btn-block">Getting Started</a>
            </div><!-- card -->

            <div class="card mg-t-20">
              <div class="card-header d-flex justify-content-between">
                <span class="tx-uppercase tx-12 tx-medium tx-inverse">Recent Messages</span>
                <a href="" class="tx-gray-600"><i class="icon ion-more"></i></a>
              </div><!-- card-header -->
              <div class="list-group list-group-flush">
                <div class="list-group-item">
                  <div class="media">
                    <img src="<?=base_url()?>theme/img/img1.jpg" class="wd-30 rounded-circle" alt="">
                    <div class="media-body mg-l-10">
                      <h6 class="mg-b-0 tx-inverse tx-13">Katherine Lumaad</h6>
                      <p class="mg-b-0 tx-gray-500 tx-12">an hour ago</p>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <p class="mg-t-10 mg-b-0 tx-13">The European languages are members of the same family. Their separate existence is a myth...</p>
                </div><!-- list-group-item -->
                <div class="list-group-item">
                  <div class="media">
                    <img src="<?=base_url()?>theme/img/img2.jpg" class="wd-30 rounded-circle" alt="">
                    <div class="media-body mg-l-10">
                      <h6 class="mg-b-0 tx-inverse tx-13">Mary Grace Ceballos</h6>
                      <p class="mg-b-0 tx-gray-500 tx-12">2 hours ago</p>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <p class="mg-t-10 mg-b-0 tx-13">The European languages are members of the same family. Their separate existence is a myth...</p>
                </div><!-- list-group-item -->
                <div class="list-group-item">
                  <div class="media">
                    <img src="<?=base_url()?>theme/img/img4.jpg" class="wd-30 rounded-circle" alt="">
                    <div class="media-body mg-l-10">
                      <h6 class="mg-b-0 tx-inverse tx-13">Rowella Sombrio</h6>
                      <p class="mg-b-0 tx-gray-500 tx-12">3 hours ago</p>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <p class="mg-t-10 mg-b-0 tx-13">The European languages are members of the same family. Their separate existence is a myth...</p>
                </div><!-- list-group-item -->
              </div><!-- list-group -->
              <div class="card-footer">
                <a href="" class="tx-12"><i class="fa fa-angle-down mg-r-5"></i> Show all messages</a>
              </div><!-- card-footer -->
            </div><!-- card -->

            <div class="card card-body pd-20 mg-t-20">
              <h6 class="card-body-title tx-12 tx-spacing-1">Get Connected</h6>
              <p>Just select any of your available social account to get started.</p>
              <div class="tx-20">
                <a href="" class="tx-primary mg-r-5"><i class="fa fa-facebook"></i></a>
                <a href="" class="tx-info mg-r-5"><i class="fa fa-twitter"></i></a>
                <a href="" class="tx-danger mg-r-5"><i class="fa fa-google-plus"></i></a>
                <a href="" class="tx-danger mg-r-5"><i class="fa fa-pinterest"></i></a>
                <a href="" class="tx-inverse mg-r-5"><i class="fa fa-github"></i></a>
                <a href="" class="tx-pink mg-r-5"><i class="fa fa-instagram"></i></a>
              </div>
            </div><!-- card -->

          </div><!-- col-4 -->
        </div><!-- row -->
      </div><!-- kt-pagebody -->

      <?php $this->load->view('includes/footer'); ?> 