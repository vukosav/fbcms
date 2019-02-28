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
    var pagename = $('#pagename').val();
    var group = $('#group').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>pages/ajaxPaginationData/' + page_num,
        data: 'page=' + page_num + '&pagename=' + pagename + '&group=' + group,
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
        <h5>Pages</h5>
    </div><!-- kt-pagetitle -->

    <div class="kt-pagebody">
        <div class="card pd-20 pd-sm-40">

        <div class="row form-group">
                <div class="col col-sm-2">
                    <a href="<?=base_url()?>fbcheck" class="btn btn-default">Add new pages</a>
                </div>
            </div>
            <div class="row form-group">
                <div class="col col-sm-2">
                    <input type="text" class="form-control" id="pagename" placeholder="Filter by page name"
                        onkeyup="searchFilter()" />
                </div>
                <div class="col col-sm-2">
                    <select id="group" class="form-control" onchange="searchFilter()">
                        <option value="">Filter By group name</option>
                        <?php if(!empty($group)): foreach ($group as $gr): ?>
                            <option value="<?php echo $gr['id']; ?>"><?php echo $gr['name']; ?></option>
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
                            <th class="wd-5p all">Page name</th>
                            <th class="wd-5p all">Page ID</th>
                            <th class="wd-5p all">Added date</th>
                            <th class="wd-5p all">Added by</th>
                            <th class="wd-5p all">Groups</th>
                            <th class="wd-5p all">Operations</th>
                        </tr>
                    </thead>
                    <tbody id="postListBody">
                        <?php if(!empty($pages)): foreach ($pages as $page): ?>
                        <tr>
                            <td><?php echo $page['fbPageName']; ?></td>
                            <td><?php echo $page['fbPageId']; ?></td>
                            <td><?php echo $page['dateAdded']; ?></td>
                            <td><?php echo $page['addedby']; ?></td>
                            <td><?php echo $page['groups']; ?></td>
                            <td>
                                <a href="<?=base_url()?>editpage/<?php echo $page['id']; ?>">
                                    <span class="fa fa-edit" style="font-size: xx-large;margin: 6px; color: #3b6998;" data-toggle="tooltip" data-placement="top" title="Edit page"></span>
                                </a>
                                <a onclick="dellData(<?php echo $page['id'] .',&#39;' . base_url() . 'deletepage/&#39;'; ?>)" href="">
                                    <span class="fa fa-trash" style='font-size: xx-large;color: #dc3545;margin: 6px;' data-toggle='tooltip' data-placement='top' title='Delete page'></span>
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