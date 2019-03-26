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
                <span class="tx-danger"><?php //echo validation_errors(); ?></span>
                <h4 class="tx-normal"><?php echo "Page name: ". $pages[0]['fbPageName']; ?></h4>
                <div class="form-group">
                    <!-- <form method='post' action='<?//= base_url(); ?>insertPG/'>-->

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-default justify-content-between">
                                        <h6 class="mg-b-0 tx-14 tx-white tx-normal">Page info</h6>
                                    </div><!-- card-header -->
                                    <div class="card-body bg-gray-200">
                                        <div class="form-group row">
                                            <div class="col-sm-12 col-xl-12 mg-t-12 mg-sm-t-12">
                                                <label for="">Page name</label>
                                                <input class="form-control" id="fbPageName" name="fbPageName"
                                                    type="text" value="<?php echo $pages[0]['fbPageName']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12 col-xl-12 mg-t-12 mg-sm-t-12">
                                                <label for="">Page ID</label>
                                                <input class="form-control" id="fbPageName" name="fbPageName"
                                                    type="text" value="<?php echo $pages[0]['fbPageId']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12 col-xl-12 mg-t-12 mg-sm-t-12">
                                                <label for="">Date of added</label>
                                                <input class="form-control" id="fbPageName" name="fbPageName"
                                                    type="text" value="<?php echo $pages[0]['dateAdded']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12 col-xl-12 mg-t-12 mg-sm-t-12">
                                                <label for="">Username for onwner</label>
                                                <input class="form-control" id="fbPageName" name="fbPageName"
                                                    type="text" value="<?php echo $pages[0]['addedby']; ?>">
                                            </div>
                                        </div>
                                        <?php echo form_open('settz'); ?>
                                        <div class="form-group row">
                                            <div class="col-sm-12 col-xl-12 mg-t-12 mg-sm-t-12">
                                            <label  for="">Time zone for page:</label>
                                            <input type="hidden" name="id" class="form-control" placeholder="Type email address" required
                                                value="<?php echo $pages[0]['id']; ?>">
                                                <select class="form-control" name="timezone" id="timezone" required>
                                                    <?php if(!empty($pages[0]['timezone'])): ?>
                                                    <option value="<?php echo $pages[0]['timezone']; ?>">
                                                        <?php echo $pages[0]['timezone']; ?></option>
                                                    <?php endif; ?>
                                                    <?php 
                                                        $array = DateTimeZone::listIdentifiers ();
                                                        echo "<option value=''>Chose time zone</option>";
                                                        foreach($array as $arr){
                                                            echo  "<option value='$arr'>$arr></option>";
                                                            //new \DateTimeZone($tz);
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input class="btn btn-dark" value="Set time zone for page" type="submit">
                                        </div>
                                        </form>
                                    </div><!-- card-body -->
                                </div><!-- card -->
                            </div><!-- col-6 -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-header-default justify-content-between">
                                        <h6 class="mg-b-0 tx-14 tx-white tx-normal">All groups</h6>
                                    </div><!-- card-header -->
                                    <div class="card-body bg-gray-200">
                                        <?php foreach ($free_groups as $grup): ?>
                                        <table>
                                            <td style="width:100%"><?php echo $grup['name']; ?></td>
                                            <td><a class="btn btn-outline-primary btn-icon rounded-circle sm"
                                                    href="<?=base_url()?>insertPG/<?=$grup['id']?>/<?=$pages[0]['id']?>">
                                                    <div><i class="fa fa-plus mg-r-2"></i></div>
                                                </a></td>
                                        </table>
                                        <?php endforeach; ?>
                                    </div><!-- card-body -->
                                </div><!-- card -->
                            </div><!-- col-6 -->
                            <div class="col-md-4">
                                <div class="card bd-0">
                                    <div class="card-header card-header-default justify-content-between">
                                        <h6 class="mg-b-0 tx-14 tx-white tx-normal">Page groups</h6>
                                    </div><!-- card-header -->
                                    <div class="card-body bg-gray-200">
                                        <?php foreach ($added_groups as $grup): ?>
                                        <table>
                                            <td style="width:100%"><?php echo $grup['name']; ?></td>
                                            <td><a onclick="dellData(<?php echo $grup['pgid'] .',&#39;' . base_url() . 'deletePG/&#39;'; ?>)"
                                                    class="btn btn-outline-danger btn-icon rounded-circle sm" href="">
                                                    <div><i class="fa fa-trash mg-r-2"></i></div>
                                                </a></div>
                                    </td>
                                    </table>
                                    <?php endforeach; ?>
                                </div><!-- card-body -->
                            </div><!-- card -->
                        </div><!-- col-6 -->
                </div>

            </div><!-- form-group -->

        </div><!-- table-wrapper -->
    </div><!-- card -->
    <!-- </form> -->
</div><!-- kt-pagebody -->

<?php $this->load->view('includes/footer'); ?>

<script>
function dellData(id, url) {
    event.preventDefault(); // prevent form submit
    var form = event.target.form; // storing the form
    console.log('url', url);
    swal.fire({
        text: "Are you sure you want remove group from selected page?",
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
                        'Removed!',
                        'Your group has been removed from selected pages.',
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