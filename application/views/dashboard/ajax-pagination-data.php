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
             <td class="process"><?php echo $statistic['pageLikes']; ?></td>
             <td>Group</td>
             <td><?php echo $statistic['p24']; ?></td>
             <td><?php echo $statistic['p72']; ?></td>
         </tr>

         <?php endforeach; ?>
     </tbody>
 </table> <?php else: ?>
 <p>Post(s) not available.</p>
 <?php endif; ?>
 <?php echo $this->ajax_pagination->create_links(); ?>