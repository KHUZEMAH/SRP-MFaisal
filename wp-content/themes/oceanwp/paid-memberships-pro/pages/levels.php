<?php 
global $wpdb, $pmpro_msg, $pmpro_msgt, $current_user;

$pmpro_levels = pmpro_getAllLevels(false, true);
$pmpro_level_order = pmpro_getOption('level_order');

if(!empty($pmpro_level_order))
{
	$order = explode(',',$pmpro_level_order);

	//reorder array
	$reordered_levels = array();
	foreach($order as $level_id) {
		foreach($pmpro_levels as $key=>$level) {
			if($level_id == $level->id)
				$reordered_levels[] = $pmpro_levels[$key];
		}
	}

	$pmpro_levels = $reordered_levels;
}

$pmpro_levels = apply_filters("pmpro_levels_array", $pmpro_levels);

if($pmpro_msg)
{
?>
<div class="<?php echo pmpro_get_element_class( 'pmpro_message ' . $pmpro_msgt, $pmpro_msgt ); ?>"><?php echo $pmpro_msg?></div>
<?php
}
?>
<div class="pricing-table">
	<?php	
	$count = 0;
	foreach($pmpro_levels as $level)
	{
	  if(isset($current_user->membership_level->ID))
		  $current_level = ($current_user->membership_level->ID == $level->id);
	  else
		  $current_level = false;
	?>
	  <div class="ptable-item" id="<?php echo "OnDemand".$level->id; ?>">
	    <div class="ptable-single">
	     <h2><?php echo $current_level ? "<span>{$level->name}</span>" : $level->name?></h2>
        <p> <?php 
				if(pmpro_isLevelFree($level))
					$cost_text = "<span>" . __("Free", 'paid-memberships-pro' ) . "</span>";
				else
					$cost_text = pmpro_getLevelCost($level, true, true); 
				    $expiration_text = pmpro_getLevelExpiration($level);
				if(!empty($cost_text) && !empty($expiration_text)){
					$without_now = str_replace("now.",'',$cost_text);
					echo $without_now;
					}
				/*elseif(!empty($cost_text))
					echo $cost_text;
				elseif(!empty($expiration_text))
					echo $expiration_text;*/
		
			      ?>
			      </p>
	          <?php if(empty($current_user->membership_level->ID)) { ?>
			<a class="<?php echo pmpro_get_element_class( 'btn-white' ); ?>" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Select', 'paid-memberships-pro' );?></a>
		     <?php } elseif ( !$current_level ) { ?>                	
			<a class="<?php echo pmpro_get_element_class( 'btn-white' ); ?>" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Select', 'paid-memberships-pro' );?></a>
		     <?php } elseif($current_level) { ?>      
			
			<?php
				//if it's a one-time-payment level, offer a link to renew				
				if( pmpro_isLevelExpiringSoon( $current_user->membership_level) && $current_user->membership_level->allow_signups ) {

					if (is_user_logged_in()) {
						switch ($current_user->membership_level->ID) {
							case 1:
								$pageId = 1864;
								break;
							case 2:
								$pageId = 1859;
								break;
							case 3:
								$pageId = 1863;
								break;
							case 6:
								$pageId = 4731;
								break;			
						}
					?>
						<a class="<?php echo pmpro_get_element_class( 'btn-white' ); ?>" href="<?php echo get_permalink( $pageId ); ?>">View</a><?php /*_e('Renew', 'paid-memberships-pro' ); */?>
					<?php
					}
				    else{
				    ?>
				    	<a class="<?php echo pmpro_get_element_class( 'btn-white' ); ?>" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>">View</a><?php /*_e('Renew', 'paid-memberships-pro' ); */?>
				    <?php
				    }
				} else {
					?>
						<a class="<?php echo pmpro_get_element_class( 'pmpro_btn disabled', 'pmpro_btn' ); ?>" href="<?php echo pmpro_url("account")?>"><?php _e('Your&nbsp;Level', 'paid-memberships-pro' );?></a>
					<?php
				}
			?>
			
		<?php } ?>
	    </div>
	  </div>
  <?php
	}
	?>
</div>

<p class="<?php echo pmpro_get_element_class( 'pmpro_actions_nav' ); ?>">
	 <?php if ( is_user_logged_in() ) { ?>
   <a href="<?php echo pmpro_url( 'account' ); ?>" id="pmpro_levels-return-home">Return to Your Account</a>
   <?php }?>
</p> 
