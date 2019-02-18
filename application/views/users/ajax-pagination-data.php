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
                 <div class="btn-group" role="group" aria-label="Basic example">
                     <a class="btn btn-info" href="<?=base_url()?>">
                         <span class="fa fa-edit"></span>
                     </a>
                     <a class="btn btn-info"
                         onclick="dellData(<?php echo $user['id']  .',&#39;' . base_url() . 'deleteusr/&#39;'; ?>)"
                         href="">
                         <span class="fa fa-trash"></span>
                     </a>
                 </div>
             </td>
         </tr>

         <?php endforeach; ?>
     </tbody>
 </table>
 <?php else: ?>
 <p>Post(s) not available.</p>
 <?php endif; ?>
 <?php echo $this->ajax_pagination->create_links(); ?>