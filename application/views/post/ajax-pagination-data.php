 
<table id="datatable11" class="table table-striped">
                    <thead>
                    <tr>
                            <th class="wd-5p">Status</th>
                            <th class="wd-5p">Working title</th>
                            <th class="wd-5p">Post text</th>
                            <th class="wd-5p">Date / created by</th>
                            <th class="wd-5p">Groups</th>
                            <th class="wd-5p">Pages</th>
                            <th class="wd-5p">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
<?php if(!empty($posts)): foreach ($posts as $q): ?> 
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
                            <td><?php echo substr($q['content'], 0, 60) ."..."; ?></td>
                            <td><?php echo $q['created_date'] ." /<br>" .$q['created_by'] ; ?></td>
                            <td>Group1<br>Group2</td>
                            <td>Facebook page 1<br>Facebook page 2<br>Facebook page 3<br>Facebook page 4</td>
                            <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-info" href="#">
                                    <span class="fa fa-edit"></span>
                                </a>
                                <a class="btn btn-info" href="#">
                                    <span class="fa fa-copy"></span>
                                </a>
                                <?php 
                                 if($q['PostStatus']==2){
                                    echo "<a class='btn btn-info' href='#'><span class='fa fa-calendar-o'></span></a>";
                                }
                                else{
                                    if($q['ActionStatus']==1){
                                    echo "<a class='btn btn-info' href='#'><span class='fa fa-pause'></span></a> ";
                                    }
                                    if($q['ActionStatus']==2){
                                        echo "<a class='btn btn-info' href='#'><span class='fa fa-pause'></span></a> ";
                                    }
                                } ?>
                                <a class="btn btn-info" href="#">
                                    <span class="fa fa-trash"></span>
                                </a>
                                </div>
                            </td>
                        </tr>
<?php endforeach; ?>
                       </tbody>
                       </table> <?php else: ?>
<p>Post(s) not available.</p>
<?php endif; ?>
<?php echo $this->ajax_pagination->create_links(); ?>

 