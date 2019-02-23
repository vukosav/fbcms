 <table id="datatable11" class="table table-striped">
     <thead>
         <tr>
             <th class="wd-5p all">Page name</th>
             <th class="wd-5p all">Page ID</th>
             <th class="wd-5p all">Added date</th>
             <th class="wd-5p all">Added by</th>
             <th class="wd-5p all">Groups</th>
             <th class="wd-5p all">Operations</th>
         </tr>
     </thead>
     <tbody>
         <?php if(!empty($pages)): foreach($pages as $page): ?>
         <tr>
             <td><?php echo $page['fbPageName']; ?></td>
             <td><?php echo $page['fbPageId']; ?></td>
             <td><?php echo $page['dateAdded']; ?></td>
             <td><?php echo $page['addedby']; ?></td>
             <td><?php echo $page['group']; ?></td>
             <td>
                 <a class="btn btn-default btn-icon rounded-circle mg-r-5 mg-b-10"
                     href="<?=base_url()?>editpage/<?php echo $page['id']; ?>" data-toggle="tooltip"
                     data-placement="top" title="Edit page">
                     <div><i class="fa fa-edit"></i></div>
                 </a>
                 <a class="btn btn-danger btn-icon rounded-circle mg-r-5 mg-b-10"
                     onclick="dellData(<?php echo $page['id'] .',&#39;' . base_url() . 'deletepage/&#39;'; ?>)" href=""
                     data-toggle="tooltip" data-placement="top" title="Delete page">
                     <div><i class="fa fa-trash"></i></div>
                 </a>
             </td>
         </tr>

         <?php endforeach; ?>
     </tbody>
 </table> <?php else: ?>
 <p>Post(s) not available.</p>
 <?php endif; ?>
 <?php echo $this->ajax_pagination->create_links(); ?>