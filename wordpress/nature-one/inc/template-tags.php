<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package SKT Nature One
 */

if ( ! function_exists( 'skt_natureone_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function skt_natureone_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';
	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'nature-one' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'nature-one' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'nature-one' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'nature-one' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'nature-one' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>
		<div class="clear"></div>
	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // skt_natureone_content_nav

if ( ! function_exists( 'skt_natureone_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function skt_natureone_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'nature-one' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'nature-one' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, 34 ); ?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<?php printf( __( sprintf( '<cite class="fn">%s</cite> on', get_comment_author_link() ) ) ); ?>
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( _x( '%1$s', '1: date', 'nature-one' ), get_comment_date(), get_comment_time() ); ?>
						</time>
					</a>
					<?php edit_comment_link( __( 'Edit', 'nature-one' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'nature-one' ); ?></p>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>',
				) ) );
			?>
		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for skt_natureone_comment()

if ( ! function_exists( 'skt_natureone_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 */
function skt_natureone_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'skt_natureone_attachment_size', array( 1200, 1200 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the
	 * URL of the next adjacent image in a gallery, or the first image (if
	 * we're looking at the last image in a gallery), or, in a gallery of one,
	 * just the link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'skt_natureone_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function skt_natureone_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) )
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">Published %1$s</span><span class="byline"> by %2$s</span>', 'nature-one' ),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		)
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category
 */
function skt_natureone_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so skt_natureone_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so skt_natureone_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in skt_natureone_categorized_blog
 */
function skt_natureone_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'skt_natureone_category_transient_flusher' );
add_action( 'save_post',     'skt_natureone_category_transient_flusher' );


function edin_featured_pages() {
	$featured_page_1 = esc_attr( get_theme_mod( 'edin_featured_page_one_front_page', '0' ) );
	$featured_page_2 = esc_attr( get_theme_mod( 'edin_featured_page_two_front_page', '0' ) );
	$featured_page_3 = esc_attr( get_theme_mod( 'edin_featured_page_three_front_page', '0' ) );

	if ( 0 == $featured_page_1 && 0 == $featured_page_2 && 0 == $featured_page_3 ) {
		return;
	}
?>

	<div id="quaternary" class="featured-page-area">
		<div class="featured-page-wrapper clear">

			<?php for ( $page_number = 1; $page_number <= 3; $page_number++ ) : ?>
				<?php if ( 0 != ${'featured_page_' . $page_number} ) : // Check if a featured page has been set in the customizer ?>
					<div class="featured-page">

						<?php
							// Create new argument using the page ID of the page set in the customizer
							$featured_page_args = array(
								'page_id' => ${'featured_page_' . $page_number},
							);
							// Create a new WP_Query using the argument previously created
							$featured_page_query = new WP_Query( $featured_page_args );
						?>

						<?php while ( $featured_page_query->have_posts() ) : $featured_page_query->the_post(); ?>

							<div class="hero <?php echo edin_additional_class(); ?>">
	<?php if ( ! is_page_template( 'page-templates/front-page.php' ) ) : ?>

		<?php the_title( '<div class="hero-wrapper"><h1 class="page-title">', '</h1></div>' ); ?>

	<?php else : ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
				if ( 1 == get_theme_mod( 'edin_title_front_page' ) ) {
					the_title( '<header class="entry-header"><h1 class="page-title">', '</h1></header>' );
				}
			?>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php
					wp_link_pages( array(
						'before'      => '<div class="page-links">' . __( 'Pages:', 'edin' ),
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );
				?>
			</div><!-- .entry-content -->
			<?php edit_post_link( __( 'Edit', 'edin' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>
		</article><!-- #post-## -->

	<?php endif; ?>
</div><!-- .hero -->

<?php
	if ( ! function_exists( 'jetpack_breadcrumbs' ) || 0 == get_theme_mod( 'edin_breadcrumbs' ) || ! is_page() || is_page_template( 'page-templates/front-page.php' ) || is_front_page() ) {
		return;
	}
?>

<div class="breadcrumbs-wrapper">
	<?php jetpack_breadcrumbs(); ?>
</div><!-- .breadcrumbs-wrapper -->


						<?php
							endwhile;
							wp_reset_postdata();
						?>
					</div><!-- .featured-page -->
				<?php endif; ?>
			<?php endfor; ?>

		</div><!-- .featured-page-wrapper -->
	</div><!-- #quaternary -->

<?php
}
