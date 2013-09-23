
<div class="wrap">
	<div class="icon32" id="icon-options-general"><br></div><h2>Banner Settings</h2>
	
<?php if (isset($message)): ?>
	<div id="message" class="updated">
		<p><?php echo $message; ?></p>
	</div>
<?php endif; ?>

	<form method="post" action="<?php echo self::admin_url(); ?>" name="form">

		<p><label for="rsb_total"><?php _e('Number of banners:'); ?></label><br>
			<input type="text" id="rsb_total" name="rsb_total" size="2" value="<?php echo $rsb_total; ?>"></p>

<?php foreach (range(1, $rsb_total) as $n): ?>

<?php	if ($rsb_total > 1): ?>
		<p><strong>Banner <?php echo $n; ?></strong></p>
<?php	endif; ?>

<?php	if (self::$advanced_chooser): ?>

		<input type="hidden" name="rsb_image_<?php echo $n; ?>" value="<?php echo $rsb_image[$n]; ?>">
		<p><label for="rsb_image_<?php echo $n; ?>">Image:</label><br>
			<img name="rsb_image_<?php echo $n; ?>_preview" src="<?php echo array_shift(wp_get_attachment_image_src($rsb_image[$n], 'medium')); ?>" height="60"></p>
		<p>
			<a class="button choose-from-library-link"
				data-field="<?php echo 'rsb_image_'.$n; ?>"
				data-preview="<?php echo 'rsb_image_'.$n.'_preview'; ?>"
				data-choose="<?php esc_attr_e( 'Choose a Custom Banner' ); ?>"
				data-update="<?php esc_attr_e( 'Set as banner' ); ?>"><?php _e( 'Choose Image' ); ?></a>
			<a class="button remove-image-link"
				data-field="<?php echo 'rsb_image_'.$n; ?>"
				data-preview="<?php echo 'rsb_image_'.$n.'_preview'; ?>"><?php _e( 'Remove Image' ); ?></a>
		</p>

<?php	else: // basic chooser ?>

		<p><label for="rsb_image_<?php echo $n; ?>">Image:</label><br>
			<select id="rsb_image_<?php echo $n; ?>" name="rsb_image_<?php echo $n; ?>">
				<option value=""><?php _e('&mdash; Select &mdash;'); ?></option>
<?php		foreach ($images as $i): ?>
				<option value="<?php echo $i->ID; ?>"<?php if ($rsb_image[$n] == $i->ID) echo " selected"; ?>><?php echo $i->post_name; ?></option>
<?php		endforeach; ?>
			</select></p>

<?php	endif; ?>
			
		<p><label for="rsb_link_<?php echo $n; ?>">Link to:</label><br>
			<?php wp_dropdown_pages(array('name' => 'rsb_link_'.$n, 'show_option_none' => __('&mdash; Select &mdash;'), 'option_none_value' => '0', 'selected' => $rsb_link[$n])); ?></p>

<?php endforeach; ?>
		
		<p class="submit"><input type="submit" value="Save Changes" class="button-primary" id="submit" name="submit"></p>
	</form>
	
</div>
