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
        <h5>Groups</h5>
    </div><!-- kt-pagetitle -->

    <div class="kt-pagebody">
        <div class="card pd-20 pd-sm-40">
            <!-- <h6 class="card-body-title">Basic Responsive DataTable</h6>
            <p class="mg-b-20 mg-sm-b-30">Searching, ordering and paging goodness will be immediately added to the
                table, as shown in this example.</p> -->
            <div class="form-group">
                <a class="btn btn-primary sm-4" href="<?=base_url()?>addgrp">Add new group</a>
            </div>
            <div class="table-wrapper">
                <table id="datatable1" class="table display responsive">
                    <thead>
                        <tr>
                            <th class="wd-5p all">Group name</th>
                            <th class="wd-5p all">Created by</th>
                            <th class="wd-5p all">Date create</th>
                            <th class="wd-5p all">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groups as $group): ?>
                        <tr>
                            <td><?php echo $group['name']; ?></td>
                            <td><?php echo $group['addedby']; ?></td>
                            <td><?php echo $group['createDate']; ?></td>
                            <td>
                                <a href="<?=base_url()?>editgrup/<?php echo $group['id']; ?>">
                                    <span class="fa fa-edit"></span>
                                </a>
                                <a href="<?=base_url()?>deletegrup/<?php echo $group['id']; ?>">
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