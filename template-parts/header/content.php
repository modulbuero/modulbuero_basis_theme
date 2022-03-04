<?php
if(is_active_sidebar('mb-header-sidebar')):
	$hamburgerOn = (get_option('mbgi-settings-make-hamburger') != 'on')? "hamburger-off":"";
?>

	<div class="header-sidebar-wrap <?php echo $hamburgerOn ?>">
		<?php dynamic_sidebar( 'mb-header-sidebar' ); ?>
		<div class="hamburger-menu"></div>
	</div>

<?php endif;?>
