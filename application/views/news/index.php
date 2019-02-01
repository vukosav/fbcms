<h2><?php echo $page_id; ?></h2>

<p><a href="<?php echo site_url('news/create'); ?>">Create news</a></p>

<?php foreach ($news as $news_item): ?>

<h3><?php echo $news_item['page_id']; ?></h3>
<div class="main">
    <?php echo $news_item['page_id']; ?>
</div>
<p><a href="<?php echo site_url('news/view/'.$page_id); ?>">View article</a></p>

<?php endforeach; ?>