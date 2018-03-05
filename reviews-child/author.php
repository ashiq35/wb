<?php
get_header();
$is_reviews = !empty( $_GET['post_type'] ) ? true : false;
?>
<section>
    <div class="container">
        <div class="row">
        <div class="col-md-12">
                <div class="col-md-2">
                    <?php echo get_avatar( get_the_author_meta('user_email'), $size='252,252'); ?>
                    <p><?php echo  get_the_author_meta('display_name'); ?></p>
                </div>
                <div class="col-md-10">
                    <p><?php echo nl2br(get_the_author_meta('description')); ?>
                   <b>E-mail:</b> <?php the_author_meta('user_email'); ?></p>
                </div>
            <hr>
        </div>
        </div>
        <hr/>

    </div>
</section>
<section>
	<div class="container">
		<div class="row <?php echo $is_reviews ? esc_attr( 'masonry' ) : '' ?>">
			<?php
			if( !$is_reviews ){
				echo '<div class="col-sm-9">';
			}
			if( have_posts() ){
				while( have_posts() ){
					the_post();
					if( $is_reviews ){
						echo '<div class="col-sm-4 masonry-item">';
							include( reviews_load_path( 'includes/review-box.php' ) );
						echo '</div>';
					}
					else{
						include( reviews_load_path( 'includes/blog-list.php' ) );
					}
				}
			}
			if( !$is_reviews ){
				echo '</div>';
				echo '<div class="col-sm-3">';
					get_sidebar();
				echo '</div>';
			}
			?>
		</div>
	</div>
</section>
<?php
get_footer();
?>