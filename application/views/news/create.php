<h1><?php echo $title; ?></h1>

<?php echo validation_errors(); ?>

<?php echo form_open('news/create'); ?>

<label for="title">Title</label>
<input type="input" name="title" required /><br />

<label for="text">Text</label>
<textarea name="text" id="" cols="30" rows="10" required></textarea><br />

<input type="submit" name="submit" value="Create news item" />
</form>