<?php
/**
 * The template for displaying 404 pages.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="inside-article">

	<?php
	/**
	 * generate_before_content hook.
	 *
	 * @since 0.1
	 *
	 * @hooked generate_featured_page_header_inside_single - 10
	 */
	do_action( 'generate_before_content' );
	?>

	<header <?php generate_do_attr( 'entry-header' ); ?>>
		<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is allowed in filter here. ?>
		<h1 class="entry-title" itemprop="headline"><?php echo apply_filters( 'generate_404_title', __( 'Oops! That page can&rsquo;t be found.', 'generatepress' ) ); ?></h1>
	</header>

	<?php
	/**
	 * generate_after_entry_header hook.
	 *
	 * @since 0.1
	 *
	 * @hooked generate_post_image - 10
	 */
	do_action( 'generate_after_entry_header' );

	$itemprop = '';

	if ( 'microdata' === generate_get_schema_type() ) {
		$itemprop = ' itemprop="text"';
	}
	?>

	<div class="entry-content"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
		<?php
		printf(
			'<p>%s</p>',
			apply_filters( 'generate_404_text', __( 'It looks like nothing was found at this location. Maybe try searching?', 'generatepress' ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is allowed in filter here.
		);

		get_search_form();

        ?>
        
        <h2><?php _e('Aktuelle Beiträge', 'threek'); ?></h2>

        <?php
        // Custom Post Loop 

        $args = array(
            'post_status' => 'publish',
            'posts_per_page'=>4,
            'order'=>'DESC',
            'orderby'=>'ID',
            );

        $latestPosts = new WP_Query($args);

        if ( $latestPosts->have_posts() ) :

            while ( $latestPosts->have_posts() ) :

                $latestPosts->the_post();

        // Recent Posts Template
                ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php generate_do_microdata( 'article' ); ?>>
	<div class="inside-article">
		<?php
		/**
		 * generate_before_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked generate_featured_page_header_inside_single - 10
		 */
		do_action( 'generate_before_content' );

		if ( generate_show_entry_header() ) : ?>

		<div class="archive-single-featured-image">
        
            <?php


            echo '<img src="'.esc_url(get_the_post_thumbnail_url()).'"/>'; 

                /**
             * generate_after_entry_header hook.
             *
             * @since 0.1
             *
             * @hooked generate_post_image - 10
             */
            do_action( 'generate_after_entry_header' ); ?>
        </div>
        <div class="archive-single-content">
			<header <?php generate_do_attr( 'entry-header' ); ?>>
            <?php
            $category = get_the_category(); echo '<span class="archive-single-category">'.$category[0]->cat_name.'</span>';
            ?>
				<?php
				/**
				 * generate_before_entry_title hook.
				 *
				 * @since 0.1
				 */
				do_action( 'generate_before_entry_title' );

				if ( generate_show_title() ) {
					$params = generate_get_the_title_parameters();

					the_title( $params['before'], $params['after'] );
				}
                
                ?>
                <div class="author-info">
                    <?php
                    global $post;  
                    $author_id = get_post_field('post_author' , $post->ID); 
					if(!is_archive()) {$linkToAuthor = '&nbsp;<a href="'.get_author_posts_url($author_id).'">';}
					echo '<img src="'.get_avatar_url($author_id).'"/> ' . __("Von ", "threek") . get_author_name($author_id).'</a>';
                    ?>
                </div>
			</header>
			<?php
		endif;

		

		$itemprop = '';

		if ( 'microdata' === generate_get_schema_type() ) {
			$itemprop = ' itemprop="text"';
		}

		if ( generate_show_excerpt() ) :
			?>

			<div class="entry-summary"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
				<?php the_excerpt(); ?>
			</div>

		<?php else : ?>

			<div class="entry-content"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'generatepress' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>
        </div>
			<?php
		endif;


		/**
		 * generate_after_content hook.
		 *
		 * @since 0.1
		 */
		do_action( 'generate_after_content' );
		?>
        <div class="read-more"><a href="<?php the_permalink(); ?>">Weiterlesen ></a></div>
	</div>
</article>
<?php
                // Recent Posts Template - END

            endwhile;

        else :

            generate_do_template_part( 'none' );

        endif;

        // Custom Post Loop - END

		?>

	<?php
	/**
	 * generate_after_content hook.
	 *
	 * @since 0.1
	 */
	do_action( 'generate_after_content' );
	?>

</div>
