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

        <div class="col-lg-12">
                <div class="card pd-40 tx-center">
                <div class="d-flex justify-content-center mg-b-30">
                    <img src="https://graph.facebook.com/<?php echo $fb_user_id; ?>/picture?redirect=1&amp;height=40&amp;width=40&amp;type=normal" style="vertical-align:top;" onerror="this.src = 'theme/default/images/facebookUser.jpg'">
                </div>
                <h6 class="tx-md-20 tx-inverse mg-b-20">Add Facebook Pages</h6>
               

                        <?php echo form_open('insert_pages'); ?>     
                        <div class="row" style="width:60%; margin: 0 auto;">
                                <?php  
                                    $numofpages = count( $fbpages);
                                    $last= $numofpages-1;
                                    echo '<input type="hidden" name="numofpages" value="' . $numofpages . '"</input>' ;
                                            
                                        for ($i = 0; $i <=  $last; $i++) {
                                               /* echo '<div class="col-lg-3">';
                                                echo '<br>' . $fbpages[$i]['id'];
                                                echo '<br>' . $fbpages[$i]['name'];
                                                echo '<br><img src="' . $fbpages[$i]['picture']['data']['url'] . '">';
                                                // echo '<br><br>' . $fbpages[$i]['access_token'];
                                                echo '<br><input type="checkbox" name="chk'.  ($i+1) . '">Add page</input>';
                                                echo '<input type="hidden" name="fbp' . ($i+1) . '" value="fbpid=' . $fbpages[$i]['id'] . 'fbpn=' . $fbpages[$i]['name'] . '"</input>' ;
                                                echo '</div>'; */

                                                echo '<div class="card wd-xs-150" style="margin-right:10px;">';
                                                echo '<div class="card-body bd bd-b-0">';
                                                echo '<h6 class="mg-b-3"><a href="" class="tx-dark">' . $fbpages[$i]['name'] . '</a></h6>';
                                                echo '<span class="tx-12"><input type="checkbox" name="chk'.  ($i+1) . '">Add page</input></span>';
                                                echo '<input type="hidden" name="fbp' . ($i+1) . '" value="fbpid=' . $fbpages[$i]['id'] . 'fbpn=' . $fbpages[$i]['name'] . '_fbpAT=_' . $fbpages[$i]['access_token'] .'"</input>' ;
                                               
                                                //added fbpage access token as fbpAT
                                               
                                                echo '</div><!-- card-body -->';
                                                echo '<img class="card-img-bottom img-fluid" src="' . $fbpages[$i]['picture']['data']['url'] . '" alt="Image">';
                                                echo '</div><!-- card -->';
                                




                                        }
                                ?>
                            </div>
                            <br>
                            
                              <button type="submit" class="btn btn-default btn-block" style="width:200px; margin:0 auto">Add selected pages</button>
                            
                          <a class="btn btn-block" href="<?=base_url()?>pages" style="width:200px; margin:0 auto">Cancel</a>     
                          </div>       
                        </div><!-- card -->
                        </div><!-- card -->
                        </form>
            
                                        
                   
        </div><!-- kt-pagebody -->
    </div>  <!-- main panel -->  
    
<?php $this->load->view('includes/footer'); ?> 

