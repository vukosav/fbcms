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
<?php if($q['PostStatus'] ==1 ){
                                 echo "<td>Draft</td>";
                            }
                            elseif($q['PostStatus'] ==2 ){
                                        echo "<td><span class='fa fa-circle-o' style='font-size: xx-large;margin: 6px; color: #3b6998;' data-toggle='tooltip' data-placement='top'></span>";
                                        echo "<br>0/90</td>";
                                        
                                    } elseif($q['PostStatus'] ==3 ){
                                        echo "<td><span class='fa fa-adjust' style='font-size: xx-large;margin: 6px; color: #3b6998;' data-toggle='tooltip' data-placement='top'></span> ";
                                        if($q['ActionStatus'] ==2 ){
                                            echo "<span class='fa fa-pause-circle-o' style='font-size: xx-large;margin: 6px; color: #3b6998;' data-toggle='tooltip' data-placement='top'></span>";
                                        }else{
                                            echo "<span class='fa fa-play-circle-o' style='font-size: xx-large;margin: 6px; color: #3b6998;' data-toggle='tooltip' data-placement='top'></span>";
                                        }
                                    echo "<br>0/90</td>";
                                    }elseif($q['PostStatus'] ==4 ){
                                        echo "<td><span class='fa fa-circle' style='font-size: xx-large;margin: 6px; color: #3b6998;' data-toggle='tooltip' data-placement='top'></span> ";
                                    echo "<span style='font-size: xx-large;margin: 6px; color: #3b6998;' data-toggle='tooltip' data-placement='top'><br>0/90</span></td>";
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
                            <td><?php echo $q['created_date'] ." /<br>" .$q['addedby'] ; ?></td>
                            <td>Group1<br>Group2</td>
                            <td><?php echo $q['pages']; ?></td>
                            <!-- <td>Facebook page 1<br>Facebook page 2<br>Facebook page 3<br>Facebook page 4</td> -->
                            <td>
                                <div class="btn-group1" role="group" aria-label="Basic example">
                                 <a href="<?=base_url()?>edit_post/<?php echo $q['id']; ?>"><span class="fa fa-edit" style="font-size: xx-large;margin: 6px; color: #3b6998;" data-toggle="tooltip" data-placement="top" title="Edit post"></span></a>
                                 <a href="<?=base_url()?>copy_post/<?php echo $q['id']; ?>"><span class="fa fa-copy" style="font-size: xx-large;margin: 6px; color: #3b6998;" data-toggle="tooltip" data-placement="top" title="Copy post"></span></a>
                                
                                 <?php 
                                 if($q['PostStatus']==2){
                                    echo "<a href='#'><span class='fa fa-calendar-o' style='font-size: xx-large;color: #3b6998;margin: 6px;' data-toggle='tooltip' data-placement='top' title='Draft post'></span></a>";
                                }if($q['PostStatus']==3){
                                    if($q['ActionStatus']==1){
                                    echo "<a href='' onclick='Halt(" . $q['id'] . ");'><span class='fa fa-pause-circle-o' style='font-size: xx-large;color: #3b6998;margin: 6px;' data-toggle='tooltip' data-placement='top' title='Pause posting'></span></a>";
                                    }
                                    if($q['ActionStatus']==2){
                                        echo "<a href='' onclick='Resume(" .$q['id']. ");'><span class='fa fa-play-circle-o' style='font-size: xx-large;color: #3b6998; margin: 6px;' data-toggle='tooltip' data-placement='top' title='Continue posting'></span></a>";
                                    }
                                }
                                 ?>
                                <a href="#"><span class="fa fa-trash" style='font-size: xx-large;color: #dc3545;margin: 6px;' data-toggle='tooltip' data-placement='top' title='Archive post'></span></a>
                                
                                </div>
                            </td>
                        </tr>
<?php endforeach; ?>
                       </tbody>
                       </table> <?php else: ?>
<p>Post(s) not available.</p>
<?php endif; ?>
<?php echo $this->ajax_pagination->create_links(); ?>

 