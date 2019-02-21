<?php $this->load->view('includes/header'); ?>
<!-- ##### SIDEBAR MENU ##### -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- kt-sideleft -->

<!-- ##### HEAD PANEL ##### -->
<?php $this->load->view('includes/headPanel'); ?>
<!-- kt-breadcrumb -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
function searchFilter(page_num) {
    page_num = page_num ? page_num : 0;
    var username = $('#username').val();
    var role = $('#role').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>users/ajaxPaginationData/' + page_num,
        data: 'page=' + page_num + '&username=' + username + '&role=' + role,
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
        <h5>Users</h5>
    </div><!-- kt-pagetitle -->

    <div class="kt-pagebody">
        <div class="card pd-20 pd-sm-40">
            <!-- <h6 class="card-body-title">Basic Responsive DataTable</h6>
            <p class="mg-b-20 mg-sm-b-30">Searching, ordering and paging goodness will be immediately added to the
                table, as shown in this example.</p> -->
            <div class="form-group">
                <a class="btn btn-default sm-4" href="<?=base_url()?>addusers">Add new user</a>
            </div>
            <div class="row form-group" id="srcForm">
                <div class="col col-sm-2">
                    <input type="text" class="form-control" id="username" placeholder="Type username"
                        onkeyup="searchFilter()" />
                </div>
                <div class="col col-sm-2">
                    <select class="form-control" id="role" name="role" onchange="searchFilter()">
                        <option value="">Role</option>
                        <?php if(!empty($roles)): foreach ($roles as $role): ?>
                        <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="col col-sm-3">
                    <input id="button" onclick="resetform()" type="button" name="reset" value="Reset">
                    <!-- <button class="btn btn-info btn-sm" name="reset">Reset</button> -->
                </div>
            </div>
            <div class="table-wrapper" id="postList">

                <table id="datatable11" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-15p">Full name</th>
                            <th class="wd-15p">Username</th>
                            <th class="wd-15p">E-mail</th>
                            <th class="wd-20p">Added date</th>
                            <th class="wd-15p">Added by</th>
                            <th class="wd-10p">Role</th>
                            <th class="wd-25p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($users)): foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['dateCreated']; ?></td>
                            <td><?php echo $user['addedby']; ?></td>
                            <td><?php echo $user['rname']; ?></td>
                            <td>
                                <a class="btn btn-default btn-icon rounded-circle mg-r-5 mg-b-10"
                                    href="<?=base_url()?>">
                                    <div><i class="fa fa-edit"></i></div>
                                </a>
                                <a class="btn btn-danger btn-icon rounded-circle mg-r-5 mg-b-10"
                                    onclick="dellData(<?php echo $user['id']  .',&#39;' . base_url() . 'deleteusr/&#39;'; ?>)"
                                    href="">
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

    function resetform() {
        // document.getElementById("srcForm").reset();
        document.getElementById("username").value = '';
        document.getElementById("role").value = '';
        location.reload();
    }
    </script>