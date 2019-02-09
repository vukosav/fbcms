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
        <h5>Users</h5>
    </div><!-- kt-pagetitle -->

    <div class="kt-pagebody">
        <div class="card pd-20 pd-sm-40">
            <!-- <h6 class="card-body-title">Basic Responsive DataTable</h6>
            <p class="mg-b-20 mg-sm-b-30">Searching, ordering and paging goodness will be immediately added to the
                table, as shown in this example.</p> -->
            <div class="form-group">
                <a class="btn btn-primary sm-4" href="<?=base_url()?>addusers">Add new user</a>
            </div>
            <div class="table-wrapper">
                <table id="datatable1" class="table display responsive nowrap">
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
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['dateCreated']; ?></td>
                            <td><?php echo $user['addedby']; ?></td>
                            <td><?php echo $user['rname']; ?></td>
                            <td>
                                <a href="#">
                                    <span class="fa fa-edit"></span>
                                </a>
                                <a href="#">
                                    <span class="fa fa-trash"></span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!-- table-wrapper -->
        </div><!-- card -->

    </div><!-- kt-pagebody -->

    <?php $this->load->view('includes/footer'); ?>
    <script>
    function resetform() {
        document.getElementById("myform").reset();
    }
    </script>