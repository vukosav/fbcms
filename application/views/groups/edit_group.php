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
        <h5>Grup editing</h5>
    </div><!-- kt-pagetitle -->

    <div class="kt-pagebody">
        <div class="card pd-20 pd-sm-40">
            <div class="table-wrapper">
                <?php //echo form_open('insertPG/'); ?>
                <span class="tx-danger"><?php echo validation_errors(); ?></span>
                <h4 class="tx-normal"><?php echo "Group name: ". $groups[0]['name']; ?></h4>
                <div class="form-group">
                <form method='post' action='<?= base_url(); ?>insertPG/'>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header card-header-default justify-content-between">
                                    <h6 class="mg-b-0 tx-14 tx-white tx-normal">All pages</h6>
                                    <!-- <div class="card-option tx-24">
                                        <a href="" class="tx-gray-600 mg-l-10"><i
                                                class="icon ion-ios-refresh-empty lh-0"></i></a>
                                        <a href="" class="tx-gray-600 mg-l-10"><i
                                                class="icon ion-ios-arrow-down lh-0"></i></a>
                                        <a href="" class="tx-gray-600 mg-l-10"><i
                                                class="icon ion-android-more-vertical lh-0"></i></a>
                                    </div>card-option -->
                                </div><!-- card-header -->
                                <div class="card-body bg-gray-200">
                                    <?php foreach ($free_pages as $pag): ?>
                                        <!-- <div class="form-group"> -->
                                        <table>
                                                <td style="width:100%"><?php echo $pag['fbPageName']; ?></td>
                                                <td><a class="btn btn-outline-primary btn-icon rounded-circle sm" href="<?=base_url()?>insertPG/<?=$groups[0]['id']?>/<?=$pag['id']?>"><div><i class="fa fa-plus mg-r-2"></i></div></a></td>
                                        </table>
                                    <!-- </div> -->
                                    <?php endforeach; ?>
                                </div><!-- card-body -->
                            </div><!-- card -->
                        </div><!-- col-6 -->
                        <div class="col-md-6 mg-t-30 mg-md-t-0">
                            <div class="card bd-0">
                                <div class="card-header card-header-default justify-content-between">
                                    <h6 class="mg-b-0 tx-14 tx-white tx-normal">Pages added to a group</h6>
                                    <!-- <div class="card-option tx-24">
                                        <a href="" class="tx-white-7 hover-white mg-l-10"><i
                                                class="icon ion-ios-refresh-empty lh-0"></i></a>
                                        <a href="" class="tx-white-7 hover-white mg-l-10"><i
                                                class="icon ion-ios-arrow-down lh-0"></i></a>
                                        <a href="" class="tx-white-7 hover-white mg-l-10"><i
                                                class="icon ion-android-more-vertical lh-0"></i></a>
                                    </div>card-option -->
                                </div><!-- card-header -->
                                <div class="card-body bg-gray-200">
                                    <?php foreach ($added_pages as $page): ?>
                                        <table>
                                                <td style="width:100%"><?php echo $page['fbPageName']; ?></td>
                                                <td><a onclick="dellData(<?php echo $page['pgid'] .',&#39;' . base_url() . 'deletePG/&#39;'; ?>)" class="btn btn-outline-danger btn-icon rounded-circle sm" href=""><div><i class="fa fa-trash mg-r-2"></i></div></a></div></td>
                                        </table>
                                    <?php endforeach; ?>
                                </div><!-- card-body -->
                            </div><!-- card -->
                        </div><!-- col-6 -->
                    </div>


                </div><!-- form-group -->

                <!-- <form action="" method='post'> -->
                <!-- <ol data-draggable="target"> -->
                    <?php //foreach ($pages as $page): ?>
                    <!-- <li data-draggable="item" value="<?php //echo $page['id']; ?>"><?php //echo $page['fbPageName']; ?>BLA BLA BLA</li> -->
                    <?php //endforeach; ?>
                <!-- </ol>

                <ol data-draggable="target" name="pagesIdArray[]">

                </ol> -->
               
                <!-- </form> -->

                <!-- <div class="tx-center bd pd-10 mg-t-40">Already a member? <a href="page-signin.html">Sign In</a></div> -->
            </div><!-- table-wrapper -->
        </div><!-- card -->
        </form>
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


    (function() {

        //exclude older browsers by the features we need them to support
        //and legacy opera explicitly so we don't waste time on a dead browser
        if (
            !document.querySelectorAll ||
            !('draggable' in document.createElement('span')) ||
            window.opera
        ) {
            return;
        }

        //get the collection of draggable items and add their draggable attribute
        for (var
                items = document.querySelectorAll('[data-draggable="item"]'),
                len = items.length,
                i = 0; i < len; i++) {
            items[i].setAttribute('draggable', 'true');
        }

        //variable for storing the dragging item reference 
        //this will avoid the need to define any transfer data 
        //which means that the elements don't need to have IDs 
        var item = null;

        //dragstart event to initiate mouse dragging
        document.addEventListener('dragstart', function(e) {
            //set the item reference to this element
            item = e.target;

            //we don't need the transfer data, but we have to define something
            //otherwise the drop action won't work at all in firefox
            //most browsers support the proper mime-type syntax, eg. "text/plain"
            //but we have to use this incorrect syntax for the benefit of IE10+
            e.dataTransfer.setData('text', '');

        }, false);

        //dragover event to allow the drag by preventing its default
        //ie. the default action of an element is not to allow dragging 
        document.addEventListener('dragover', function(e) {
            if (item) {
                e.preventDefault();
            }

        }, false);

        //drop event to allow the element to be dropped into valid targets
        document.addEventListener('drop', function(e) {
            //if this element is a drop target, move the item here 
            //then prevent default to allow the action (same as dragover)
            if (e.target.getAttribute('data-draggable') == 'target') {
                e.target.appendChild(item);

                e.preventDefault();
            }

        }, false);

        //dragend event to clean-up after drop or abort
        //which fires whether or not the drop target was valid
        document.addEventListener('dragend', function(e) {
            item = null;

        }, false);

    })();
    </script>

    <style type="text/css">
    /* canvas styles */
    html,
    body {
        font: normal normal normal 100%/1.4 tahoma, sans-serif;
        background: #f9f9f9;
        color: #000;
    }

    body {
        font-size: 0.8em;
    }

    /* draggable targets */
    [data-draggable="target"] {
        float: left;
        list-style-type: none;

        width: 42%;
        height: 7.5em;
        overflow-y: auto;

        margin: 0 0.5em 0.5em 0;
        padding: 0.5em;

        border: 2px solid #888;
        border-radius: 0.2em;

        background: #ddd;
        color: #555;
    }

    /* draggable items */
    [data-draggable="item"] {
        display: block;
        list-style-type: none;

        margin: 0 0 2px 0;
        padding: 0.2em 0.4em;

        border-radius: 0.2em;

        line-height: 1.3;
    }
    </style>