<?php $this->load->view('includes/footer'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
function searchFilter(page_num) {
	page_num = page_num?page_num:0;
	var keywords = $('#keywords').val();
	var sortBy = $('#sortBy').val();
	$.ajax({
		type: 'POST',
		url: '<?php echo base_url(); ?>groups/ajaxPaginationData/'+page_num,
		data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy,
		beforeSend: function () {
			$('.loading').show();
		},
		success: function (html) {
			$('#postList').html(html);
			$('.loading').fadeOut("slow");
            $('#datatable1').DataTable({
                    responsive: true, 
                    "paging":   false,
                    "info":     false,
                    searching: true,
                    retrieve: true
              });
		}
	});
}
</script>

<div class="container">
    <h1>Ajax Pagination with Search in CodeIgniter Framework</h1>
    <div class="row">
		<div class="post-search-panel">
			<input type="text" id="keywords" placeholder="Type keywords to filter posts" onkeyup="searchFilter()"/>
			<select id="sortBy" onchange="searchFilter()">
				<option value="">Sort By</option>
				<option value="asc">Ascending</option>
				<option value="desc">Descending</option>
			</select>
		</div>
        <div class="post-list" id="postList">
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
        </div>
        <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div></div>
    </div>
</div>
<?php $this->load->view('includes/footer'); ?>