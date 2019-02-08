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
            <!-- END HEADER DESKTOP-->
            
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row m-t-30">
                            <div class="col-lg-2"><a href="<?=base_url()?>addpost">
                                    <section class="card">
                                        <div class="card-body text-secondary">Schedule new post</div>
                                    </section></a>
                                </div>
                                <div class="col-lg-2"><a href="#">
                                    <section class="card">
                                        <div class="card-body text-secondary">Add new FB page</div>
                                    </section></a>
                                </div>
                                <div class="col-lg-2">
                                    <section class="card">
                                        <div class="card-body text-secondary"><?php echo $global['pLast72']; ?><br>Posts in last 72h</div>
                                    </section>
                                </div>
                                <div class="col-lg-2">
                                    <section class="card">
                                        <div class="card-body text-secondary"><?php echo $global['rLast72']; ?><br>Reactions in last 72h</div>
                                    </section>
                                </div>
                                <div class="col-lg-2">
                                    <section class="card">
                                        <div class="card-body text-secondary"><?php echo $global['cLast72']; ?><br>Comments in last 72h</div>
                                    </section>
                                </div>
                                <div class="col-lg-2">
                                    <section class="card">
                                        <div class="card-body text-secondary"><?php echo $global['sLast72']; ?><br>Shares in last 72h</div>
                                    </section>
                                </div>
                            <div class="col-md-12">
                                <!-- DATA TABLE-->
                                <div class="table-responsive m-b-40">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>Page name</th>
                                                <th>Page like count<br><small>(last 72h change)</small></th>
                                                <th>Group</th>
                                                <th>Posts in last 24h</th>
                                                <th>Posts in last 72h</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                <?php foreach ($p_statistics as $statistic): ?>

                                            <tr>
                                                <td><?php echo $statistic['page_id']; ?></td>
                                                <td class="process"><?php echo $statistic['pageLikes']; ?></td>
                                                <td>Group</td>
                                                <td><?php echo $statistic['p24']; ?></td>
                                                <td><?php echo $statistic['p72']; ?></td>
                                            </tr>
                                <?php endforeach; ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END DATA TABLE-->


<?php $this->load->view('includes/footer'); ?>