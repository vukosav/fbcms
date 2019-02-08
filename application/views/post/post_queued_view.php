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
        <h5>Queued posts</h5>
    </div><!-- kt-pagetitle -->

    <div class="kt-pagebody">

        <div class="card pd-20 pd-sm-40 mg-t-50">

            <div class="table-wrapper">
            <?php echo form_open('posting', 'id='.'myform'); ?>
            <div class="row form-group">
                    <div class="col col-sm-3">
                        <input type="text" id="" name="working_title" placeholder="Filter by working title & post text" class="form-control"  value="<?php echo set_value('working_title') ?>">
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="group" id="" class="form-control">
                        <option value="<?php echo set_value('group') ?>"><?php echo set_value('group') ?></option>"
                            <option value="">Filter by group</option>
                            <option value="1">Option #1</option>
                            <option value="2">Option #2</option>
                            <option value="3">Option #3</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="fbpage" id="" class="form-control">
                            <option value="<?php echo set_value('fbpage') ?>"><?php echo set_value('fbpage') ?></option>"
                            <option value="">Filter by page</option>
                            <option value="1">Option #1</option>
                            <option value="2">Option #2</option>
                            <option value="3">Option #3</option>
                        </select>
                    </div>
                    <div class="col col-sm-3">
                            <input id="button" onclick="resetform()" type="button" name="reset" value="Reset"><!-- <button class="btn btn-info btn-sm" name="reset">Reset</button> -->
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-sm-3">
                        <input type="date" id="" name="date_from" placeholder="Filter by date (from)" class="form-control" value="<?php echo set_value('date_from') ?>">
                    </div>
                    <div class="col col-sm-3">
                        <input type="date" id="" name="date_to" placeholder="Filter by date (to)" class="form-control" value="<?php echo set_value('date_to') ?>">
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="user" id="myform" class="form-control">
                        <option value="<?php echo set_value('user') ?>"><?php echo set_value('user') ?></option>"
                            <option value="">Filter by user</option>
                            <option value="1">Option #1</option>
                            <option value="2">Option #2</option>
                            <option value="3">Option #3</option>
                        </select>
                    </div>
                    <div class="col col-sm-3">
                        <button class="btn btn-primary btn-sm">Find</button>
                    </div>
                </div>

                        <div class="row form-group">
                            <!-- <div class="col col-sm-2">
                                <label for="all" class="form-check-label ">
                                    <input type="checkbox" id="" value="" class="form-check-input" name="all" <?php //echo (set_value('all') ? 'checked' : '') ?>>All posts
                                </label>
                            </div>
                            <div class="col col-sm-3">
                                <label for="scheduled" class="form-check-label ">
                                    <input type="checkbox" id="" value="" class="form-check-input" name="scheduled" <?//php echo (set_value('scheduled') ? 'checked' : '') ?>>Scheduled
                                    posts
                                </label>
                            </div> -->
                            <div class="col col-sm">
                                <label for="inProgres" class="form-check-label ">
                                    <input type="checkbox" id="" value="1" class="form-check-input" name="inProgres" <?php echo (set_value('inProgres') ? 'checked' : '') ?>>In progres posts
                                </label>
                            </div>
                            <div class="col col-sm">
                                <label for="paused" class="form-check-label ">
                                    <input type="checkbox" id="" value="2" class="form-check-input" name="paused" <?php echo (set_value('paused') ? 'checked' : '') ?>>Paused posts
                                </label>
                            </div>
                            <div class="col col-sm-4">
                                <label for="errors" class="form-check-label ">
                                    <input type="checkbox" id="" value="" class="form-check-input" name="errors" <?php echo (set_value('errors') ? 'checked' : '') ?>>Posts with errors
                                </label>
                            </div>
                            <div class="col col-sm-3">
                                <label for="archived" class="form-check-label ">
                                    <input type="checkbox" id="" value='false' class="form-check-input" name="archived" <?php echo (set_value('archived') ? 'checked' : '') ?>>Archived posts
                                </label>
                            </div>
                        </div>
                    
                </form>
            </div><!-- table-wrapper -->
        </div><!-- card -->

        <div class="card pd-20 pd-sm-40">
            <h6 class="card-body-title">Basic Responsive DataTable</h6>
            <p class="mg-b-20 mg-sm-b-30">Searching, ordering and paging goodness will be immediately added to the
                table, as shown in this example.</p>

            <div class="table-wrapper">
                <table id="datatable1" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-15p">Status</th>
                            <th class="wd-15p">Working title</th>
                            <th class="wd-20p">Post text</th>
                            <th class="wd-15p">Date / created by</th>
                            <th class="wd-10p">Groups</th>
                            <th class="wd-25p">Pages</th>
                            <th class="wd-25p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($queued as $q): ?>
                        <tr>
                            <?php if($q['PostStatus'] ==2 ){
                                        echo "<td><span class='fa fa-circle-o'></span>";
                                        echo "<br>0/90</td>";
                                        
                                    } else{
                                    echo "<td><span class='fa fa-adjust'></span>";
                                    echo "<span class='fa fa-pause'></span>";
                                    echo "<br>0/90</td>";
                                    } ?>
                            <!-- <td>
                                        <span class="fa fa-adjust"></span>
                                        <span class="fa fa-pause"></span>
                                        <span class="fa fa-circle-o"></span>
                                        <span class="fa fa-play"></span>
                                        <br>43/90
                                        <br>
                                        <a href="#">
                                            <span class="badge badge-success">1 errors</span>
                                        </a>
                                    </td> -->
                            <td><?php echo $q['title']; ?></td>
                            <td><?php echo substr($q['content'], 0, 100) ."..."; ?></td>
                            <td><?php echo $q['created_date'] ." /<br>" .$q['created_by'] ; ?></td>
                            <td>Group1<br>Group2</td>
                            <td>Facebook page 1<br>Facebook page 2<br>Facebook page 3<br>Facebook page 4</td>
                            <td>
                                <a href="#">
                                    <span class="fa fa-edit"></span>
                                </a>
                                <a href="#">
                                    <span class="fa fa-copy"></span>
                                </a>
                                <?php 
                                 if($q['PostStatus']==2){
                                    echo "<a href='#'><span class='fa fa-calendar-o'></span></a>";
                                }
                                else{
                                    if($q['ActionStatus']==1){
                                    echo "<a href='#'><span class='fa fa-pause'></span></a> ";
                                    }
                                    if($q['ActionStatus']==2){
                                        echo "<a href='#'><span class='fa fa-pause'></span></a> ";
                                    }
                                } ?>
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