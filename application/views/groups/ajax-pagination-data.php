 
<table id="datatable1" class="table display responsive">
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
                                <a href="<?=base_url()?>editgrup/<?php echo $group['id']; ?>">
                                    <span class="fa fa-edit"></span>
                                </a>
                                <a href="<?=base_url()?>deletegrup/<?php echo $group['id']; ?>">
                                    <span class="fa fa-trash"></span>
                                </a>
                                <a onclick="dellData()" data-togle="tooltip" href="" class="btn btn-danger">Delete
                                </a><?php //return confirm('Are you shure you want to delete ');  ?>
                            </td>
                        </tr>
                        
<?php endforeach; else: ?>
                       </tbody>
                </table>
<p>Post(s) not available.</p>
<?php endif; ?>
<?php echo $this->ajax_pagination->create_links(); ?>

 