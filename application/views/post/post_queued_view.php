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
    var post_status = $('#post_status').val(); //uvijek se prosledjuje status kako bi se znalo jesu li qpos, sent ili draft
    var archived = $('#archived').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>post/ajaxPaginationData/' + page_num,
        data: 'page=' + page_num + '&createdBy=' + createdBy + '&wtitle=' + wtitle + '&group=' + group + '&fbpage=' + fbpage +
            '&date_from=' + date_from + '&date_to=' + date_to  + '&post_status=' +
            post_status + '&archived=' + archived,
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
        <h5>Queued posts</h5>
    </div><!-- kt-pagetitle -->

    <div class="kt-pagebody">

        <div class="card pd-20 pd-sm-40 mg-t-50">

            <div class="table-wrapper">
                <?php echo form_open('posting', 'id='.'myform'); ?>
                <div class="row form-group">
                    <div class="col col-sm-2">
                        <input type="text" id="wtitle" name="wtitle" placeholder="Filter by working title & post text" class="form-control"
                        onkeyup="searchFilter()" />
                        <input type="hidden" id="post_status" name="post_status" value="3">
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
                        <input id="button" onclick="resetform()" type="button" name="reset" value="Reset">
                        <!-- <button class="btn btn-info btn-sm" name="reset">Reset</button> -->
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-sm-2">
                        <input type="date" id="date_from" name="date_from" placeholder="Filter by date (from)"
                            class="form-control" onchange="searchFilter()" />
                    </div>
                    <div class="col col-sm-2">
                        <input type="date" id="date_to" name="date_to" placeholder="Filter by date (to)"
                            class="form-control" onchange="searchFilter()" />
                    </div>
                    <div class="col col-sm-2">
                        <select class="form-control" id="createdBy" name="createdBy" onchange="searchFilter()">
                            <option value="">created by</option>
                            <?php if(!empty($usr)): foreach ($usr as $user): ?>
                            <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="col col-sm-3">
                        <button class="btn btn-primary btn-sm">Find</button>
                    </div>
                </div>

                <div class="row form-group">
                    <!-- <div class="col col-sm-2">
                                <label for="all" class="form-check-label ">
                                    <input type="checkbox" id="" value="" class="form-check-input" name="all" <?php //echo (set_value('all') ? 'checked' : '') ?>>All posts
                                </label>
                            </div>
                            <div class="col col-sm-3">
                                <label for="scheduled" class="form-check-label ">
                                    <input type="checkbox" id="" value="" class="form-check-input" name="scheduled" <?//php echo (set_value('scheduled') ? 'checked' : '') ?>>Scheduled
                                    posts
                                </label>
                            </div> -->
                    <div class="col col-sm-2">
                        <label for="inProgres" class="form-check-label ">
                            <input type="checkbox" id="" value="1" class="form-check-input" name="inProgres"
                                >In progres posts
                        </label>
                    </div>
                    <div class="col col-sm-2">
                        <label for="paused" class="form-check-label ">
                            <input type="checkbox" id="" value="2" class="form-check-input" name="paused"
                               >Paused posts
                        </label>
                    </div>
                    <div class="col col-sm-2">
                        <label for="errors" class="form-check-label ">
                            <input type="checkbox" id="" value="" class="form-check-input" name="errors"
                                >Posts with errors
                        </label>
                    </div>
                    <div class="col col-sm-2">
                        <label for="archived" class="form-check-label ">
                            <input type="checkbox" id="archived" value='false' class="form-check-input" name="archived"
                                >Archived posts
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
                            <?php if($q['PostStatus'] ==2 ){
                                        echo "<td><span class='fa fa-circle-o'></span>";
                                        echo "<br>0/90</td>";
                                        
                                    } else{
                                    echo "<td><span class='fa fa-adjust'></span>";
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
                            <td><?php echo $q['created_date'] ." /<br>" .$q['created_by'] ; ?></td>
                            <td>Group1<br>Group2</td>
                            <td>Facebook page 1<br>Facebook page 2<br>Facebook page 3<br>Facebook page 4</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-info" href="#">
                                    <span class="fa fa-edit"></span>
                                </a>
                                <a class="btn btn-info" href="#">
                                    <span class="fa fa-copy"></span>
                                </a>
                                <?php 
                                 if($q['PostStatus']==2){
                                    echo "<a class='btn btn-info' href='#'><span class='fa fa-calendar-o'></span></a>";
                                }
                                else{
                                    if($q['ActionStatus']==1){
                                    echo "<a class='btn btn-info' href='#'><span class='fa fa-pause'></span></a> ";
                                    }
                                    if($q['ActionStatus']==2){
                                        echo "<a class='btn btn-info' href='#'><span class='fa fa-pause'></span></a> ";
                                    }
                                } ?>
                                <a class="btn btn-info" href="#">
                                    <span class="fa fa-trash"></span>
                                </a>
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
    <!-- <script>
    function resetform() {
        document.getElementById("myform").reset();
    }
    </script> -->
    <script>
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
    </script>