<?php
echo '<h2>'.$news_item['title'].'</h2>';
echo $news_item['text'];
echo "<p><a href=" .site_url('news/') .">Go back</a></p>";