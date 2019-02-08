<?php $this->load->view('includes/header'); ?>

<!-- HEADER MOBILE-->
<?php $this->load->view('includes/headermobile'); ?>
<!-- END HEADER MOBILE-->

<!-- MENU SIDEBAR-->
<?php $this->load->view('includes/leftmenu'); ?>
<!-- END MENU SIDEBAR-->

<!-- PAGE CONTAINER-->
<div class="page-container">
    <!-- HEADER DESKTOP-->
    <?php $this->load->view('includes/headerDesktop'); ?>
    <!-- HEADER DESKTOP-->

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <strong>Add post</strong>
                            </div>
                            <div class="card-body card-block">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="row form-group">
                                        <div class="col-12 col-md-12">
                                            <input type="text" class="form-control" id="" name="text-input"
                                                placeholder="Working title" value="">
                                            <!-- <small class="form-text text-muted">This is a help text</small> -->
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-12 col-md-12">
                                            <textarea class="form-control" name="textarea-input" id="" rows="9"
                                                placeholder="What do you want to share?"></textarea>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-12 col-md-9">
                                            <input type="file" id="file-input" name="file-input"
                                                class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-12 col-md-9">
                                            <input type="file" id="file-input" name="file-input"
                                                class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-link"></i>
                                            </div>
                                            <input type="text" id="" name="" placeholder="Link" class="form-control">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <!-- <i class="fa fa-dot-circle-o"></i> --> Save as draft
                                </button>
                                <button type="reset" class="btn btn-danger btn-sm">
                                    <i class="fa fa-calendar"></i> Schedule
                                </button>
                                <button type="reset" class="btn btn-primary btn-sm">
                                    <!-- <i class="fa fa-ban"></i> --> Share now
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <strong>Add to</strong>
                            </div>
                            <div class="card-body card-block">
                                <form action="" method="post" class="form-horizontal">
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label class=" form-control-label">Radios</label>
                                        </div>
                                        <div class="col col-md-9">
                                            <div class="form-check">
                                                <div class="radio">
                                                    <label for="radio1" class="form-check-label ">
                                                        <input type="radio" id="radio1" name="radios" value="option1"
                                                            class="form-check-input">Add to group
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label for="radio2" class="form-check-label ">
                                                        <input type="radio" id="radio2" name="radios" value="option2"
                                                            class="form-check-input">Add to page
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="select" class=" form-control-label">Select</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="select" id="select" class="form-control">
                                                        <option value="0">Please select</option>
                                                        <option value="1">Option #1</option>
                                                        <option value="2">Option #2</option>
                                                        <option value="3">Option #3</option>
                                                    </select>
                                                </div>
                                            </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="multiple-select" class=" form-control-label">Selectet groups or pages</label>
                                        </div>
                                        <div class="col col-md-9">
                                            <select name="multiple-select" id="multiple-select" multiple=""
                                                class="form-control">
                                                <option value="1">Option #1</option>
                                                <option value="2">Option #2</option>
                                                <option value="3">Option #3</option>
                                                <option value="4">Option #4</option>
                                                <option value="5">Option #5</option>
                                                <option value="6">Option #6</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-dot-circle-o"></i> Insert groups or page
                                </button>
                                <button type="reset" class="btn btn-danger btn-sm">
                                    <i class="fa fa-ban"></i> Delete selected groups or page
                                </button>
                            </div>
                        </div>
                  

                        <?php $this->load->view('includes/footer'); ?>