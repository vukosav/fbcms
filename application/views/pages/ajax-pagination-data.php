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
                            <td><?php echo $page['groups']; ?></td>
                            <td>
                                <a href="<?=base_url()?>editpage/<?php echo $page['id']; ?>">
                                    <span class="fa fa-edit" style="font-size: xx-large;margin: 6px; color: #3b6998;" data-toggle="tooltip" data-placement="top" title="Edit page"></span>
                                </a>
                                <a onclick="dellData(<?php echo $page['id'] .',&#39;' . base_url() . 'deletepage/&#39;'; ?>)" href="">
                                    <span class="fa fa-trash" style='font-size: xx-large;color: #dc3545;margin: 6px;' data-toggle='tooltip' data-placement='top' title='Delete page'></span>
                                </a>
                            </td>

         <?php endforeach; ?>
     </tbody>
 </table> <?php else: ?>
 <p>Post(s) not available.</p>
 <?php endif; ?>
 <?php echo $this->ajax_pagination->create_links(); ?>