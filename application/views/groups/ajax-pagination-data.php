 
<table id="datatable1" class="table display responsive">
                    <thead>
                        <tr>
                            <th class="wd-5p all">Group name</th> 
                        </tr>
                    </thead>
                    <tbody>
<?php if(!empty($groups)): foreach($groups as $group): ?> 
    <tr>
                            <td><?php echo $group['name']; ?></td>
                        </tr>
                        
<?php endforeach; else: ?>
                       </tbody>
                </table>
<p>Post(s) not available.</p>
<?php endif; ?>
<?php echo $this->ajax_pagination->create_links(); ?>
 
 