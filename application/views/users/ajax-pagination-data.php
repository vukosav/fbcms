 <table id="datatable11" class="table display responsive">
     <thead>
         <tr>
             <th class="wd-15p">Full name</th>
             <th class="wd-15p">Username</th>
             <th class="wd-15p">E-mail</th>
             <th class="wd-20p">Added date</th>
             <th class="wd-15p">Added by</th>
             <th class="wd-10p">Role</th>
             <th class="wd-25p">Operations</th>
         </tr>
     </thead>
     <tbody>
         <?php if(!empty($users)): foreach ($users as $user): ?>
         <tr>
             <td><?php echo $user['name']; ?></td>
             <td><?php echo $user['username']; ?></td>
             <td><?php echo $user['email']; ?></td>
             <td><?php echo $user['dateCreated']; ?></td>
             <td><?php echo $user['addedby']; ?></td>
             <td><?php echo $user['rname']; ?></td>
             <td>
                 <a href="<?=base_url()?>showusers/<?php echo $user['id']; ?>">
                     <span class="fa fa-edit" style="font-size: xx-large;margin: 6px; color: #3b6998;"
                         data-toggle="tooltip" data-placement="top" title="Edit user"></span>
                 </a>
                 <a onclick="dellData(<?php echo $user['id']  .',&#39;' . base_url() . 'deleteusr/&#39;'; ?>)" href="">
                     <span class="fa fa-trash" style='font-size: xx-large;color: #dc3545;margin: 6px;'
                         data-toggle='tooltip' data-placement='top' title='Delete user'></span>
                 </a>
             </td>
         </tr>

         <?php endforeach; ?>
     </tbody>
 </table>
 <?php else: ?>
 <p>Post(s) not available.</p>
 <?php endif; ?>
 <?php echo $this->ajax_pagination->create_links(); ?>