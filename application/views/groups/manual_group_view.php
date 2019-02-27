<?php $this->load->view('includes/header'); ?>
<!-- ##### SIDEBAR MENU ##### -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- kt-sideleft -->

<!-- ##### HEAD PANEL ##### -->
<?php $this->load->view('includes/headPanel'); ?>
<!-- kt-breadcrumb -->

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
<script>
function searchFilter(page_num) {
    page_num = page_num ? page_num : 0;
    var grname = $('#grname').val();
    var sortBy = $('#sortBy').val();
    var createdBy = $('#createdBy').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>groups/ajaxPaginationData/' + page_num,
        data: 'page=' + page_num + '&createdBy=' + createdBy + '&grname=' + grname + '&sortBy=' + sortBy,
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
        <h5>Groups</h5>
    </div><!-- kt-pagetitle -->

    <div class="kt-pagebody">
        <div class="card pd-20 pd-sm-40">
            <div class="form-group">
                <!--    <?php //echo form_open('creategrp'); ?>
                <span class="tx-danger"><?php //echo validation_errors(); ?></span>
                <div class="input-group">
                    <input type="text" name="groupname" class="col col-md-6 form-control" placeholder="Type grup name"
                        required value="<?php //echo set_value('groupname'); ?>">
                    <div class="input-group-btn">
                        <button class="btn btn-default" data-toggle="tooltip" data-placement="top"
                            title="Add new group">Add new group</button>
                    </div>
                </div>
            </div>
            </form> -->


                <div id="modaldemo3" class="modal fade" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content tx-size-sm">
                            <div class="modal-header pd-x-20">
                                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Message Preview</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body pd-20">
                                <form name="formGroupName" action="<?=base_url()?>creategrp" method="POST">
                                    <input type="text" name="groupname" class="col col-md-12 form-control"
                                        placeholder="Type grup name" required>
                                </form>
                            </div><!-- modal-body -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pd-x-20" onclick="submitform()">Add
                                    group</button>
                                <button type="button" class="btn btn-secondary pd-x-20"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div><!-- modal-dialog -->
                </div>
                <!------------------------------>
                <div class="row form-group">
                <div class="col col-sm-2">
                    <a href="" class="btn btn-default" data-toggle="modal" data-target="#modaldemo3">Add new group</a>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-sm-2">
                        <input type="text" class="form-control" id="grname" placeholder="Type group name"
                            onkeyup="searchFilter()" />
                    </div>
                    <div class="col col-sm-2">
                        <select id="sortBy" class="form-control" onchange="searchFilter()">
                            <option value="">Sort By group name</option>
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                    <div class="col col-sm-2">
                        <select class="form-control" id="createdBy" name="createdBy" onchange="searchFilter()">
                            <option value="">created by</option>
                            <?php if(!empty($usr)): foreach ($usr as $user): ?>
                            <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                    <div class="col col-sm-1">
                        <a id="button" href="" onclick="resetform()" name="reset" value="Reset"
                         class="btn  btn-icon rounded-circle" style='font-size: xx-large;'  data-toggle="tooltip" data-placement="top" title="Reset filter"><i class="fa fa-refresh"></i></a>
                    </div>
                </div>
                <div class="table-wrapper" id="postList">

                    <table id="datatable11" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="wd-5p all">Group name</th>
                                <th class="wd-5p all">Created by</th>
                                <th class="wd-5p all">Date create</th>
                                <th class="wd-5p all">Operations</th>
                            </tr>
                        </thead>
                        <tbody id="postListBody">
                            <?php if(!empty($groups)): foreach ($groups as $group): ?>
                            <tr>
                                <td><?php echo $group['name']; ?></td>
                                <td><?php echo $group['addedby']; ?></td>
                                <td><?php echo $group['createDate']; ?></td>
                                <td>
                                    <?php if($group['userId'] == $this->session->userdata('user')['user_id']): ?>
                                    <a href="<?=base_url()?>editgrup/<?php echo $group['id']; ?>">
                                        <span class="fa fa-edit" style="font-size: xx-large;margin: 6px; color: #3b6998;" data-toggle="tooltip" data-placement="top" title="Edit group"></span>
                                    </a>
                                    <a onclick="dellData(<?php echo $group['id'] .',&#39;' . base_url() . 'deletegrup/&#39;'; ?>)" href="">
                                        <span class="fa fa-trash" style='font-size: xx-large;color: #dc3545;margin: 6px;' data-toggle='tooltip' data-placement='top' title='Delete group'></span>
                                    </a>
                                    <?php endif; ?>
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
        function submitform() {
            document.formGroupName.submit();
        }
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
                } else {
                    console.log('klik na no u modal');
                }
            });

        }
        </script>