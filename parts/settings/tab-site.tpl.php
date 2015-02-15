<?php 
?>
<p>
	<?php
		$default_pf_link_value = get_option('pf_link_to_source', 0);
		echo '<input id="pf_link_to_source" name="pf_link_to_source" type="number" class="pf_link_to_source_class" value="'.$default_pf_link_value.'" />';

		echo '<label class="description" for="pf_link_to_source"> ' .__('Seconds to redirect user to source. (0 means no redirect)', 'pf'). ' </label>';
	?>
</p>

<p>
	<?php
		$default_pf_use_advanced_user_roles = get_option('pf_use_advanced_user_roles', 'no');
	?>
	<select id="pf_use_advanced_user_roles" name="pf_use_advanced_user_roles">
		<option value="yes" <?php if ($default_pf_use_advanced_user_roles == 'yes'){ echo 'selected="selected"'; }?>>Yes</option>
		<option value="no" <?php if ($default_pf_use_advanced_user_roles == 'no'){ echo 'selected="selected"'; }?>>No</option>
	</select>
	<label class="description" for="pf_use_advanced_user_roles"> <?php _e('Use advanced user role management? (May be needed if you customize user roles or capabilities).', 'pf'); ?> </label>
</p>
<p>
	<?php
		$default_pf_present_author_value = get_option('pf_present_author_as_primary', 'yes');
	?>
	<select id="pf_present_author_as_primary" name="pf_present_author_as_primary">
		<option value="yes" <?php if ($default_pf_present_author_value == 'yes'){ echo 'selected="selected"'; }?>>Yes</option>
		<option value="no" <?php if ($default_pf_present_author_value == 'no'){ echo 'selected="selected"'; }?>>No</option>
	</select>
	<?php

	echo '<label class="description" for="pf_present_author_as_primary"> ' .__('Show item author as source.', 'pf'). ' </label>';
	?>
</p>
<?php
	if (class_exists('The_Alert_Box')){ ?>
		<p>
			<?php
				#if (class_exists('The_Alert_Box')){
					$alert_settings = the_alert_box()->settings_fields();
					$alert_switch = $alert_settings['switch'];
					$check = the_alert_box()->setting($alert_switch, $alert_switch['default']);
					#var_dump($check);
						$check = the_alert_box()->setting($alert_switch, $alert_switch['default']);
						if ('true' == $check){
							$mark = 'checked';
						} else {
							$mark = '';
						}
					echo '<input id="alert_switch" type="checkbox" name="'.the_alert_box()->option_name().'['.$alert_switch['parent_element'].']['.$alert_switch['element'].']" value="true" '.$mark.' class="'.$alert_switch['parent_element'].' '.$alert_switch['element'].'" />  <label for="'.the_alert_box()->option_name().'['.$alert_switch['parent_element'].']['.$alert_switch['element'].']" class="'.$alert_switch['parent_element'].' '.$alert_switch['element'].'" >' . $alert_switch['label_for'] . '</label>';
				#}
			?>
		</p>
<?php
	}
?>
<p>
	<?php
		$default_pf_link_value = get_option('pf_retain_time', 2);
		echo '<input id="pf_retain_time" name="pf_retain_time" type="number" class="pf_retain_time" value="'.$default_pf_link_value.'" />';

		echo '<label class="description" for="pf_retain_time"> ' .__('Months to retain feed items.', 'pf'). ' </label>';
	?>
</p>
<p>
	<?php
		$default_pf_link_value = get_option(PF_SLUG.'_errors_until_alert', 3);
		echo '<input id="pf_errors_until_alert" name="pf_errors_until_alert" type="number" class="pf_errors_until_alert" value="'.$default_pf_link_value.'" />';

		echo '<label class="description" for="pf_errors_until_alert"> ' .__('Number of errors before a feed is marked as malfunctioning.', 'pf'). ' </label>';
	?>
</p>