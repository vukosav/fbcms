<div class="kt-headpanel">
      <div class="kt-headpanel-left">
        <a id="naviconMenu" href="" class="kt-navicon d-none d-lg-flex"><i class="icon ion-navicon-round"></i></a>
        <a id="naviconMenuMobile" href="" class="kt-navicon d-lg-none"><i class="icon ion-navicon-round"></i></a>
      </div><!-- kt-headpanel-left -->

      <div class="kt-headpanel-right">
        <!-- <div class="dropdown dropdown-notification"> -->
          <!-- <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown"> -->
            <!-- <i class="icon ion-ios-bell-outline tx-24"></i> -->
            <!-- start: if statement -->
            <!-- <span class="square-8 bg-danger pos-absolute t-15 r-0 rounded-circle"></span> -->
            <!-- end: if statement -->
          <!-- </a> -->
          <div class="dropdown-menu wd-300 pd-0-force"> 
            <div class="media-list"> 
              
            </div><!-- media-list -->
          </div><!-- dropdown-menu -->
        <!-- </div> -->
        <!-- dropdown -->
        <div class="dropdown dropdown-profile">
          <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
          <img src="<?=base_url()?><?php echo (isset($this->session->userdata('user')['user_image']))?($this->session->userdata('user')['user_image']): './uploads/profilepictures/avatar.jpg';?>" class="wd-32 rounded-circle" alt="">
            <span class="logged-name"><span class="hidden-xs-down"><?php echo (isset($this->session->userdata('user')['name']))?($this->session->userdata('user')['name']): "Jane Doe"?></span> <i class="fa fa-angle-down mg-l-3"></i></span>
          </a>
          <div class="dropdown-menu wd-200">
            <ul class="list-unstyled user-profile-nav">
              <li><a href="<?=base_url()?>editprofile"><i class="icon ion-ios-person-outline"></i> Edit Profile</a></li>
              <!-- <li><a href=""><i class="icon ion-ios-gear-outline"></i> Settings</a></li>
              <li><a href=""><i class="icon ion-ios-download-outline"></i> Downloads</a></li>
              <li><a href=""><i class="icon ion-ios-star-outline"></i> Favorites</a></li>
              <li><a href=""><i class="icon ion-ios-folder-outline"></i> Collections</a></li> -->
              <li><a href="<?=base_url()?>logout"><i class="icon ion-power"></i> Sign Out</a></li>
            </ul>
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
      </div><!-- kt-headpanel-right -->
    </div><!-- kt-headpanel -->
    <div class="kt-breadcrumb">
      <nav class="breadcrumb2">
       <?php
            $fb_uat = $this->session->userdata('FB_UAT');
            //var_dump($fb_uat);
             $count_page_invalid = $fb_uat['count_page_invalid'];
             $count_page_expires = $fb_uat['count_page_expires'];
             $user_AT_is_valid = $fb_uat['user_AT_is_valid'];
             $user_AT_expires_in7d = $fb_uat['user_AT_exp_date'];
             
            $message="";
            if(!$user_AT_is_valid || $count_page_invalid>0 ){
              $message=$message . "Your Facebook page tokens are  <a  href='#' data-toggle='modal' data-target='#modaldemo333' style='color: red;text-decoration: underline;'>INVALID</a>.";
            }
           if( $user_AT_expires_in7d){
              $message=$message . "Your Facebook tokens are EXPIRED or will EXPIRE</a> in < 7days.";
            }
            if($message!="") {
              echo '<p style="color:red; margin: 15px;">' . $message 
              . " Please go to <a  href='" . base_url() . "fbcheck' style='color: red;text-decoration: underline;'>FB CHECK</a> to update your Facebook access tokens.</p>";
           }
           
        ?>
        <!-- <span class="breadcrumb-item active">Dashboard</span> -->
      </nav> 
     
     </div>

      <div id="modaldemo333" class="modal fade" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Message Preview</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body pd-20">
              <div class="table-responsive">
                <table class="table table-white mg-b-0 tx-12">
               <?php
                $fb_uat = $this->session->userdata('FB_UAT');
                if(  $fb_uat != null &&  $fb_uat['pages'] != null && is_array($fb_uat['pages'])){ 
                  echo '<tbody>'  ;
                  foreach($fb_uat['pages'] as $pageObj ){
                    echo " <tr><td>
                           <a href='' class='tx-inverse tx-14 tx-medium d-block'>{$pageObj['page_id']}</a>
                           <span class='tx-11 d-block'>{$pageObj['page_AT_is_valid']}</span>
                         </td>";
                    echo " <td class='tx-12'>
                           <span class='square-8 bg-pink mg-r-5 rounded-circle'></span>
                          </td>
                          <td>{$pageObj['page_AT_exp_date']}</td> </tr>" ;    
                  } 
                  echo '</tbody>';
                }
               ?>
                </table>
              </div>
              </div><!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-default pd-x-20">Save changes</button>
            <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div>
