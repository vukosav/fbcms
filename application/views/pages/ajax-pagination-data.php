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
                 <a class="btn btn-default btn-icon rounded-circle mg-r-5 mg-b-10"
                     href="<?=base_url()?>editgrup/<?php echo $group['id']; ?>" data-toggle="tooltip"
                     data-placement="top" title="Edit group">
                     <div><i class="fa fa-edit"></i></div>
                 </a>
                 <a class="btn btn-danger btn-icon rounded-circle mg-r-5 mg-b-10"
                     onclick="dellData(<?php echo $group['id'] .',&#39;' . base_url() . 'deletegrup/&#39;'; ?>)" href=""
                     data-toggle="tooltip" data-placement="top" title="Delete group">
                     <div><i class="fa fa-trash"></i></div>
                 </a>
         </tr>

         <?php endforeach; ?>
     </tbody>
 </table> <?php else: ?>
 <p>Post(s) not available.</p>
 <?php endif; ?>
 <?php echo $this->ajax_pagination->create_links(); ?>