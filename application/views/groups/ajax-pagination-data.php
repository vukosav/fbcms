 
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
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-info" href="<?=base_url()?>editgrup/<?php echo $group['id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit group">
                                        <span class="fa fa-edit"></span>
                                    </a>
                                    <a class="btn btn-info"
                                        onclick="dellData(<?php echo $group['id'] .',&#39;' . base_url() . 'deletegrup/&#39;'; ?>)"
                                        href="" data-toggle="tooltip" data-placement="top" title="Delete group">
                                        <span class="fa fa-trash"></span>
                                    </a>
                                </div>
                        </tr>
                        
<?php endforeach; ?>
                       </tbody>
                </table> <?php else: ?>
<p>Post(s) not available.</p>
<?php endif; ?>
<?php echo $this->ajax_pagination->create_links(); ?>