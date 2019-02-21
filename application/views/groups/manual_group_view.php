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
                <?php echo form_open('creategrp'); ?>
                <span class="tx-danger"><?php echo validation_errors(); ?></span>
                <div class="input-group">
                    <input type="text" name="groupname" class="col col-md-6 form-control" placeholder="Type grup name"
                        required value="<?php echo set_value('groupname'); ?>">
                    <div class="input-group-btn">
                        <button class="btn btn-default" data-toggle="tooltip" data-placement="top"
                            title="Add new group">Add new group</button>
                    </div>
                </div>
            </div>
            </form>


            <div class="row form-group">
                <div class="col col-sm-2">
                    <input type="text" class="form-control" id="grname" placeholder="Type group name"
                        onkeyup="searchFilter()" />
                </div>
                <div class="col col-sm-3">
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
                                <a class="btn btn-default btn-icon rounded-circle mg-r-5 mg-b-10"
                                    href="<?=base_url()?>editgrup/<?php echo $group['id']; ?>" data-toggle="tooltip"
                                    data-placement="top" title="Edit group">
                                    <div><i class="fa fa-edit"></i></div>
                                </a>
                                <a class="btn btn-danger btn-icon rounded-circle mg-r-5 mg-b-10"
                                    onclick="dellData(<?php echo $group['id'] .',&#39;' . base_url() . 'deletegrup/&#39;'; ?>)"
                                    href="" data-toggle="tooltip" data-placement="top" title="Delete group">
                                    <div><i class="fa fa-trash"></i></div>
                                </a>
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