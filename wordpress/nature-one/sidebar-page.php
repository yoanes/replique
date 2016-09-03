<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package SKT Nature One
 */
?>
<?php if( function_exists('is_woocommerce') && is_woocommerce() ) { ?>
		</div>
<?php } ?>
<div id="sidebar">
  			<?php dynamic_sidebar('sidebar-2'); ?>
</div><!-- sidebar -->

<?php if( function_exists('is_woocommerce') && is_woocommerce() ) { ?>
		</div>
	</div>
    <div class="clear"></div>
<?php } ?>
