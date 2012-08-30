
<div class="wrap">
	<div class="icon32" id="icon-options-general"><br></div><h2>Banner Settings</h2>
	
<?php if (isset($message)): ?>
	<div id="message" class="updated">
		<p><?php echo $message; ?></p>
	</div>
<?php endif; ?>
	
	<form method="post" action="<?php echo self::admin_url(); ?>" name="form">

<?php foreach (range(1, 4) as $n): ?>
		<p><strong>Banner <?php echo $n; ?></strong></p>
		<p><label for="rsb_image_<?php echo $n; ?>">Image:</label><br>
			<select id="rsb_image_<?php echo $n; ?>" name="rsb_image_<?php echo $n; ?>">
				<option value=""></option>
<?php foreach ($images as $i): ?>
				<option value="<?php echo $i->ID; ?>"<?php if ($rsb_image[$n] == $i->ID) echo " selected"; ?>><?php echo $i->post_name; ?></option>
<?php endforeach; ?>
			</select></p>
		<p><label for="rsb_link_<?php echo $n; ?>">Link to:</label><br>
			<select id="rsb_link_<?php echo $n; ?>" name="rsb_link_<?php echo $n; ?>">
				<option value=""></option>
<?php foreach ($pages as $p): ?>
				<option value="<?php echo $p->ID; ?>"<?php if ($rsb_link[$n] == $p->ID) echo " selected"; ?>><?php echo $p->post_title; ?></option>
<?php endforeach; ?>
			</select></p>
<?php endforeach; ?>
		
		<p class="submit"><input type="submit" value="Save Changes" class="button-primary" id="submit" name="submit"></p>
	</form>
	
</div>
