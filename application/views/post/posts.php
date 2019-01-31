<?php include 'includes/heder.php'; ?>

<!-- HEADER MOBILE-->
<?php include 'includes/headermenu.php'; ?>
<!-- END HEADER MOBILE-->

<!-- MENU SIDEBAR-->
<?php include 'includes/leftmenu.php'; ?>
<!-- END MENU SIDEBAR-->

<!-- PAGE CONTAINER-->
<div class="page-container">
    <!-- HEADER DESKTOP-->
    <?php include 'includes/headerDesktop.php'; ?>
    <!-- END HEADER DESKTOP-->

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row m-t-30">
                    <div class="col-lg-4">
                        <section class="card">
                            <button class="btn btn-primary">
                                <div class="card-body text-black">Queued posts</div>
                            </button>
                        </section>
                    </div>
                    <div class="col-lg-4">
                        <section class="card">
                            <button class="btn btn-default">
                                <div class="card-body text-black">Draft posts</div>
                            </button>
                        </section>
                    </div>
                    <div class="col-lg-4">
                        <section class="card">
                            <button class="btn btn-default">
                                <div class="card-body text-black">Sent posts</div>
                            </button>
                        </section>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-sm-3">
                        <input type="text" placeholder="Filter by working title & post text" class="form-control">
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="select" id="select" class="form-control">
                            <option value="0">Filter by group</option>
                            <option value="1">Option #1</option>
                            <option value="2">Option #2</option>
                            <option value="3">Option #3</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="select" id="select" class="form-control">
                            <option value="0">Filter by page</option>
                            <option value="1">Option #1</option>
                            <option value="2">Option #2</option>
                            <option value="3">Option #3</option>
                        </select>
                    </div>
                    <div class="col col-sm-3">
                        <button class="btn btn-info btn-sm">Reset</button>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-sm-3">
                        <input type="date" placeholder="Filter by date (from)" class="form-control">
                    </div>
                    <div class="col col-sm-3">
                        <input type="date" placeholder="Filter by date (to)" class="form-control">
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="select" id="select" class="form-control">
                            <option value="0">Filter by user</option>
                            <option value="1">Option #1</option>
                            <option value="2">Option #2</option>
                            <option value="3">Option #3</option>
                        </select>
                    </div>
                    <div class="col col-sm-3">
                        <button class="btn btn-primary btn-sm">Find</button>
                    </div>
                </div>

                <div class="table-responsive m-t-30">
                    <div class="form-check-inline form-check">
                        <div class="col col-sm-2">
                            <label for="all" class="form-check-label ">
                                <input type="checkbox" id="" value="" class="form-check-input" name="all">All posts
                            </label>
                        </div>
                        <div class="col col-sm-3">
                            <label for="scheduled" class="form-check-label ">
                                <input type="checkbox" id="" value="" class="form-check-input" name="scheduled">Scheduled
                                posts
                            </label>
                        </div>
                        <div class="col col-sm-3">
                            <label for="inProgres" class="form-check-label ">
                                <input type="checkbox" id="" value="" class="form-check-input" name="inProgres">In
                                progres posts
                            </label>
                        </div>
                        <div class="col col-sm-2">
                            <label for="paused" class="form-check-label ">
                                <input type="checkbox" id="" value="" class="form-check-input" name="paused">Paused
                                posts
                            </label>
                        </div>
                        <div class="col col-sm-3">
                            <label for="errors" class="form-check-label ">
                                <input type="checkbox" id="" value="" class="form-check-input" name="errors">Posts with
                                errors
                            </label>
                        </div>
                        <div class="col col-sm-2">
                            <label for="archived" class="form-check-label ">
                                <input type="checkbox" id="" value="" class="form-check-input" name="archived">Archivedposts
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row m-t-30">
                <div class="col-md-12">
                    <!-- DATA TABLE-->
                    <div class="table-responsive m-b-40">

                        <table class="table table-borderless table-data3">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Working title</th>
                                    <th>Post text</th>
                                    <th>Date / created by</th>
                                    <th>Groups</th>
                                    <th>Pages</th>
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="fa fa-adjust"></span>
                                        <span class="fa fa-pause"></span>
                                        <br>43/90
                                        <br>
                                        <a href="#">
                                            <span class="badge badge-success">1 errors</span>
                                        </a>
                                    </td>
                                    <td>Lorem ipsum dolor sit amet</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod
                                        bibendum laoreet...</td>
                                    <td>2018-09-29 05:57 <br>--------<br>User1</td>
                                    <td>Group1<br>Group2</td>
                                    <td>Facebook page 1<br>Facebook page 2<br>Facebook page 3<br>Facebook page 4</td>
                                    <td>
                                        <a href="#">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                        <a href="#">
                                            <span class="fa fa-play"></span>
                                        </a>
                                        <br>
                                        <a href="#">
                                            <span class="fa fa-copy"></span>
                                        </a>
                                        <a href="#">
                                            <span class="fa fa-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fa fa-circle-o"></span>
                                        <br>0/30
                                    </td>
                                    <td>Lorem ipsum dolor sit amet</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod
                                        bibendum laoreet...</td>
                                    <td>2018-09-29 05:57 <br>--------<br>User1</td>
                                    <td>Group1<br>Group2</td>
                                    <td>Facebook page 1<br>Facebook page 2<br>Facebook page 3<br>Facebook page 4</td>
                                    <td>
                                        <a href="#">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                        <a href="#">
                                            <span class="fa fa-times"></span>
                                        </a>
                                        <br>
                                        <a href="#">
                                            <span class="fa fa-copy"></span>
                                        </a>
                                        <a href="#">
                                            <span class="fa fa-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fa fa-adjust"></span>

                                        <span class="fa fa-play"></span>
                                        <br>43/90
                                    </td>
                                    <td>Lorem ipsum dolor sit amet</td>
                                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod
                                        bibendum laoreet...</td>
                                    <td>2018-09-29 05:57 <br>--------<br>User1</td>
                                    <td>Group1<br>Group2</td>
                                    <td>Facebook page 1<br>Facebook page 2<br>Facebook page 3<br>Facebook page 4</td>
                                    <td>
                                        <a href="#">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#">
                                            <span class="fa fa-pause"></span>
                                        </a>
                                        <br>
                                        <a href="#">
                                            <span class="fa fa-copy"></span>
                                        </a>
                                        <a href="#">
                                            <span class="fa fa-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE-->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'includes/footer.php'; ?>






























