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
                     <a class="btn btn-default btn-icon rounded-circle mg-r-5 mg-b-10" href="<?=base_url()?>">
                     <div><i class="fa fa-edit"></i></div>
                     </a>
                     <a class="btn btn-danger btn-icon rounded-circle mg-r-5 mg-b-10"
                         onclick="dellData(<?php echo $user['id']  .',&#39;' . base_url() . 'deleteusr/&#39;'; ?>)"
                         href="">
                         <div><i class="fa fa-trash"></i></div>
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