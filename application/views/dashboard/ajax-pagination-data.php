 <table id="datatable11" class="table table-striped">
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
                        <?php if(!empty($p_statistics)):  foreach ($p_statistics as $statistic): ?>
                        <tr>
                            <td><?php echo $statistic['pname']; ?></td>
                            <td><?php echo $statistic['pageLikes']; ?>
                                <?php if($statistic['diffLikes'] >= 0): ?>
                                <span class="tx-success">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-o-up">&nbsp;<?php echo $statistic['diffLikes']; ?></i> </span>
                                <?php else: ?>
                                <span class="tx-danger">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-o-down">&nbsp;</i><?php echo $statistic['diffLikes']; ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $statistic['groups']; ?></td>
                            <td><?php echo $statistic['current_posts24']; ?></td>
                            <td><?php echo $statistic['current_posts72']; ?></td>
                        </tr>

         <?php endforeach; ?>
     </tbody>
 </table> <?php else: ?>
 <p>Post(s) not available.</p>
 <?php endif; ?>
 <?php echo $this->ajax_pagination->create_links(); ?>