 <table id="datatable11" class="table table-striped">
     <thead>
         <tr>
             <th class="wd-5p all">Group name</th>
             <th class="wd-5p all">Created by</th>
             <th class="wd-5p all">Date create</th>
             <th class="wd-5p all">Operations</th>
         </tr>
     </thead>
     <tbody>
         <?php if(!empty($groups)): foreach($groups as $group): ?>
         <tr>
             <td><?php echo $group['name']; ?></td>
             <td><?php echo $group['addedby']; ?></td>
             <td><?php echo $group['createDate']; ?></td>
             <td>
                <?php if($group['userId'] == $this->session->userdata('user')['user_id']): ?>
                <a href="<?=base_url()?>editgrup/<?php echo $group['id']; ?>">
                    <span class="fa fa-edit" style="font-size: xx-large;margin: 6px; color: #3b6998;" data-toggle="tooltip" data-placement="top" title="Edit group"></span>
                </a>
                <a onclick="dellData(<?php echo $group['id'] .',&#39;' . base_url() . 'deletegrup/&#39;'; ?>)" href="">
                    <span class="fa fa-trash" style='font-size: xx-large;color: #dc3545;margin: 6px;' data-toggle='tooltip' data-placement='top' title='Delete group'></span>
                </a>
                <?php endif; ?>
             </td>
         </tr>

         <?php endforeach; ?>
     </tbody>
 </table> <?php else: ?>
 <p>Post(s) not available.</p>
 <?php endif; ?>
 <?php echo $this->ajax_pagination->create_links(); ?>