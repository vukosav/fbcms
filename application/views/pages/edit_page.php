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
        <h5>Page editing</h5>
    </div><!-- kt-pagetitle -->

    <div class="kt-pagebody">
        <div class="card pd-20 pd-sm-40">
            <div class="table-wrapper">
                <?php //echo form_open('insertPG/'); ?>
                <span class="tx-danger"><?php echo validation_errors(); ?></span>
                <h4 class="tx-normal"><?php echo "Page name: ". $pages[0]['fbPageName']; ?></h4>
                <div class="form-group">
                <form method='post' action='<?= base_url(); ?>insertPG/'>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header card-header-default justify-content-between">
                                    <h6 class="mg-b-0 tx-14 tx-white tx-normal">All groups</h6>
                                </div><!-- card-header -->
                                <div class="card-body bg-gray-200">
                                    <?php foreach ($free_groups as $grup): ?>
                                        <div class="form-group"><?php echo $grup['name']; ?> <a class="btn btn-outline-primary btn-icon rounded-circle sm" href="<?=base_url()?>insertPG/<?=$grup['id']?>/<?=$pages[0]['id']?>"><div><i class="fa fa-plus mg-r-2"></i></div></a></div>
                                    <?php endforeach; ?>
                                </div><!-- card-body -->
                            </div><!-- card -->
                        </div><!-- col-6 -->
                        <div class="col-md-6 mg-t-30 mg-md-t-0">
                            <div class="card bd-0">
                                <div class="card-header card-header-default justify-content-between">
                                    <h6 class="mg-b-0 tx-14 tx-white tx-normal">Page groups</h6>
                                </div><!-- card-header -->
                                <div class="card-body bg-gray-200">
                                    <?php foreach ($added_groups as $grup): ?>
                                        <div class="form-group"><?php echo $grup['name']; ?> <a class="btn btn-outline-danger btn-icon rounded-circle sm" href="<?=base_url()?>deletePG/<?=$grup['id']?>/<?=$grup['pgid']?>"><div><i class="fa fa-trash mg-r-2"></i></div></a></div>
                                    <?php endforeach; ?>
                                </div><!-- card-body -->
                            </div><!-- card -->
                        </div><!-- col-6 -->
                    </div>




                </div><!-- form-group -->

            </div><!-- table-wrapper -->
        </div><!-- card -->
        </form>
    </div><!-- kt-pagebody -->

    <?php $this->load->view('includes/footer'); ?>