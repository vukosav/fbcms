<?php $this->load->view('includes/header'); ?>
<!-- ##### SIDEBAR MENU ##### -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- kt-sideleft -->

<!-- ##### HEAD PANEL ##### -->
<?php $this->load->view('includes/headPanel'); ?>
<!-- kt-breadcrumb -->

<script>
function searchFilter(page_num) {
    page_num = page_num ? page_num : 0;
    var wtitle = $('#wtitle').val();
    var group = $('#group').val();
    var fbpage = $('#fbpage').val();
    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();
    var createdBy = $('#createdBy').val();
    var paused = $('#paused').is(':checked');
    var errors = $('#errors').is(':checked');
    var inProgres = $('#inProgres').is(':checked');
    var scheduled = $('#scheduled').is(':checked');
    var post_status = $('#post_status').val(); //uvijek se prosledjuje status kako bi se znalo jesu li qpos, sent ili draft
    var archived = $('#archived').is(':checked');
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>post/ajaxPaginationData/' + page_num,
        data: 'page=' + page_num + '&createdBy=' + createdBy + '&wtitle=' + wtitle + '&date_from=' + date_from +  '&date_to=' + date_to  + '&group=' + group + '&fbpage=' + fbpage +
             '&post_status=' + post_status + '&archived=' + archived + '&paused=' + paused + '&errors=' + errors + '&scheduled=' + scheduled + '&inProgres=' + inProgres,
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
        <!-- <h5>Queued posts</h5> -->
    </div><!-- kt-pagetitle -->
    <div class="kt-pagebody">
    <div class="pd-10 bg-gray-800 mg-t">
            <ul class="nav nav-pills nav-pills-for-dark flex-column flex-md-row" role="tablist">
              <li class="nav-item"><a class="nav-link <?php if($this->uri->segment(2)=="1"){echo "active2";}?>" href="<?=base_url()?>posting/1" role="tab">Queued posts</a></li>
              <li class="nav-item"><a class="nav-link <?php if($this->uri->segment(2)=="2"){echo "active2";}?>" href="<?=base_url()?>posting/2" role="tab">Draft posts</a></li>
              <li class="nav-item"><a class="nav-link <?php if($this->uri->segment(2)=="3"){echo "active2";}?>" href="<?=base_url()?>posting/3" role="tab">Sent posts</a></li>
            </ul>
          </div>
        <div class="card pd-20 pd-sm-40 mg-t-5">

            <div class="table-wrapper">
                <?php echo form_open('posting'); ?>
                <div class="row form-group">
                    <div class="col col-sm-2">
                        <input type="text" id="wtitle" name="wtitle" placeholder="Filter by working title" class="form-control"
                        onkeyup="searchFilter()" />
                        <input type="hidden" id="post_status" name="post_status" value="<?php echo $pos; ?>">
                    </div>
                    <div class="col col-sm-2">
                        <select name="group" id="group" class="form-control" onchange="searchFilter()">
                            <option value="">Filter by group</option>
                            <option value="1">Option #1</option>
                            <option value="2">Option #2</option>
                            <option value="3">Option #3</option>
                        </select>
                    </div>
                    <div class="col col-sm-2">
                        <select class="form-control" id="fbpage" name="fbpage" onchange="searchFilter()">
                            <option value="">Filter by fb page</option>
                            <?php if(!empty($fbpg)): foreach ($fbpg as $fbp): ?>
                            <option value="<?php echo $fbp['id']; ?>"><?php echo $fbp['fbPageName']; ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="col col-sm-2">
                        <a id="button" href="" onclick="resetform()" name="reset" value="Reset"
                         class="btn  btn-icon rounded-circle" style='font-size: xx-large;'  data-toggle="tooltip" data-placement="top" title="Reset filter"><i class="fa fa-refresh"></i></a>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-sm-2">
                        <input type="date" id="date_from" name="date_from" placeholder="Filter by date (from)" class="form-control" onchange="searchFilter()" />
                    </div>
                    <div class="col col-sm-2">
                        <input type="date" id="date_to" name="date_to" placeholder="Filter by date (to)" class="form-control" onchange="searchFilter()" />
                    </div>
                    <div class="col col-sm-2">
                        <select class="form-control" id="createdBy" name="createdBy" onchange="searchFilter()">
                            <?php if($this->session->userdata('user')['role'] == 2): ?>
                            <option value="<?php echo $this->session->userdata('user')['user_id']; ?>"><?php echo $this->session->userdata('user')['username']; ?></option>
                            <?php else: ?>
                            <option value="">created by</option>
                            <?php if(!empty($usr)): foreach ($usr as $user): ?>
                            <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
                            <?php endforeach; endif; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="row form-group">
                    <!-- <div class="col col-sm-2">
                                <label for="all" class="form-check-label ">
                                    <input type="checkbox" id="" class="form-check-input" name="all">All posts
                                </label>
                            </div> -->
                            <?php if($this->uri->segment(2) == 1): ?>
                            <div class="col col-sm-2">
                                <label for="scheduled" class="ckbox">
                                    <input type="checkbox" id="scheduled" name="scheduled" onchange="searchFilter()" />
                                    <span class="tx-16"><b>Scheduled posts</b></span>
                                </label>
                            </div>
                    <div class="col col-sm-2">
                        <label for="inProgres" class="ckbox">
                            <input type="checkbox" id="inProgres" name="inProgres" onchange="searchFilter()"
                                /><span class="tx-16"><b>In progres posts</b></span>
                        </label>
                    </div>
                    <div class="col col-sm-2">
                        <label for="paused" class="ckbox">
                            <input type="checkbox" id="paused"  name="paused" onchange="searchFilter()"
                                /><span class="tx-16"><b>Paused posts</b></span>
                        </label>
                    </div>
                    <div class="col col-sm-2">
                        <label for="errors" class="ckbox">
                            <input type="checkbox" id="errors"  name="errors" onchange="searchFilter()"
                                ><span class="tx-16"><b>Posts with errors</b></span>
                        </label>
                    
                    </div>
                    <?php elseif($this->uri->segment(2) == 3): ?>
                    <div class="col col-sm-2">
                        <label for="errors" class="ckbox">
                            <input type="checkbox" id="errors"  name="errors" onchange="searchFilter()"
                                ><span class="tx-16"><b>Posts with errors</b></span>
                        </label>
                    </div>
                    <?php endif; ?>
                    
                    <div class="col col-sm-2"> 
                        <label for="archived" class="ckbox">
                            <input type="checkbox" id="archived"  name="archived" onchange="searchFilter()"/><span class="tx-16"><b>Archived posts</b></span>
                        </label>
                     </div>
                   
                </div>

                </form>
            </div><!-- table-wrapper -->
        </div><!-- card -->

        <div class="card pd-20 pd-sm-40">
            <div class="table-wrapper" id="postList">
                <table id="datatable11"  class="table display responsive nowrap">
                    <!-- ako se izbrise nowrap prikazace se sva polja u tabeli -->
                    <thead>
                        <tr>
                            <th class="wd-5p">Status</th>
                            <th class="wd-5p">Working title</th>
                            <th class="wd-5p">Post text</th>
                            <th class="wd-5p">Date / created by</th>
                            <th class="wd-5p">Groups</th>
                            <th class="wd-5p">Pages</th>
                            <th class="wd-5p">Operations</th>
                        </tr>
                    </thead>
                    <tbody id = "postListBody">
                        <?php if(!empty($posts)): foreach ($posts as $q): ?>
                        <tr>
                            <?php if($q['PostStatus'] ==1 ){
                                 echo "<td>Draft</td>";
                            }
                            elseif($q['PostStatus'] ==2 ){
                                        echo "<td><span class='fa fa-circle-o'></span>";
                                        echo "<br>0/90</td>";
                                        
                                    } elseif($q['PostStatus'] ==3 ){
                                    echo "<td><span class='fa fa-adjust'></span> ";
                                    echo "<span class='fa fa-pause'></span>";
                                    echo "<br>0/90</td>";
                                    }else{
                                        echo "<td><span class='fa fa-circle'></span> ";
                                    echo "<span class='fa fa-pause'></span>";
                                    echo "<br>0/90</td>";
                                    } ?>
                            <!-- <td>
                                        <span class="fa fa-adjust"></span>
                                        <span class="fa fa-pause"></span>
                                        <span class="fa fa-circle-o"></span>
                                        <span class="fa fa-play"></span>
                                        <br>43/90
                                        <br>
                                        <a href="#">
                                            <span class="badge badge-success">1 errors</span>
                                        </a>
                                    </td> -->
                            <td><?php echo $q['title']; ?></td>
                            <td><?php echo substr($q['content'], 0, 60) ."..."; ?></td>
                            <td><?php echo $q['created_date'] ." /<br>" .$q['addedby'] ; ?></td>
                            <td>Group1<br>Group2</td>
                            <td><?php echo $q['pages']; ?></td>
                            <!-- <td>Facebook page 1<br>Facebook page 2<br>Facebook page 3<br>Facebook page 4</td> -->
                            <td>
                                <div class="btn-group1" role="group" aria-label="Basic example">
                                 <a href="#"><span class="fa fa-edit" style="font-size: xx-large;margin: 6px; color: #3b6998;" data-toggle="tooltip" data-placement="top" title="Edit post"></span></a>
                                 <a href="#"><span class="fa fa-copy" style="font-size: xx-large;margin: 6px; color: #3b6998;" data-toggle="tooltip" data-placement="top" title="Copy post"></span></a>
                                
                                <?php 
                                 if($q['PostStatus']==2){
                                    echo "<a href='#'><span class='fa fa-calendar-o' style='font-size: xx-large;color: #3b6998;margin: 6px;' data-toggle='tooltip' data-placement='top' title='Draft post'></span></a>";
                                }if($q['PostStatus']==3){
                                    if($q['ActionStatus']==1){
                                    echo "<a href='#'><span class='fa fa-pause-circle-o' style='font-size: xx-large;color: #3b6998;margin: 6px;' data-toggle='tooltip' data-placement='top' title='Pauze posting'></span></a>";
                                    }
                                    if($q['ActionStatus']==2){
                                        echo "<a href='#'><span class='fa fa-play-circle-o' style='font-size: xx-large;color: #3b6998; margin: 6px;' data-toggle='tooltip' data-placement='top' title='Continue posting'></span></a>";
                                    }
                                }
                                 ?>
                                <a href="#"><span class="fa fa-trash" style='font-size: xx-large;color: #dc3545;margin: 6px;' data-toggle='tooltip' data-placement='top' title='Archive post'></span></a>
                                
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p>Post(s) not available.</p>
                <?php endif; ?>
                <?php echo $this->ajax_pagination->create_links(); ?>
            </div><!-- table-wrapper -->
        </div><!-- card -->

    </div><!-- kt-pagebody -->

    <?php $this->load->view('includes/footer'); ?>
  
    <script> 
     function resetform() {
        location.reload();
    }
    function dellData(id, url) {
        event.preventDefault(); // prevent form submit
        var form = event.target.form; // storing the form
        console.log('url', url);
        swal.fire({
                text: "Are you sure you want to delete?",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                cancelButtonText: "No!",
                closeOnConfirm: false,
                closeOnCancel: false
             }).then((result) => {
                    if (result.value) { 
                        console.log('klik na yes u modal', id);
                    $.ajax({
                        type: 'POST',
                        url: url + id,
                        //data: {
                        //    id: id
                        //},
                        success: function(data) {
                           
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                ).then((result) => {
                                    if (result.value) {
                                        location.reload();
                                    }
                                    });
                                
                           // window.location(url); 
                        },
                        error: function(data) {
                            swal("NOT Deleted!", "Something blew up.", "error");
                        }
                    });
                }else{
                    console.log('klik na no u modal');
                }
            });
            
    }

    function resetform() {
        // document.getElementById("srcForm").reset();
        // document.getElementById("date_from").value = '';
        // document.getElementById("date_to").value = '';
        location.reload();
    }
    </script>