<?php
/*=============================
	FAQ BLOG POST LISTING PAGE
=============================*/
get_header();
global $wp_query;

$cur_page = (get_query_var('paged')) ? get_query_var('paged') : 1; //get curent page
$page_links_total = $wp_query->max_num_pages;
$pagination = paginate_links(
    array(
        'base' => esc_url(add_query_arg('paged', '%#%')),
        'prev_next' => true,
        'end_size' => 2,
        'mid_size' => 2,
        'total' => $page_links_total,
        'current' => $cur_page,
        'prev_next' => false
    )
);
?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <?php
                        if (have_posts()) {
                            $counter = 0;
                            while (have_posts()) { ?>
                                <div class="col-md-4">
                                    <?php the_post();
                                    $post_format = get_post_format();
                                    $has_media = reviews_has_media();
                                    ?>
                                    <div <?php post_class('blog-item white-block') ?>>

                                        <?php if (reviews_has_media()): ?>
                                            <div class="blog-media">
                                                <?php
                                                add_filter('wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
                                                include(reviews_load_path('media/media' . (!empty($post_format) ? '-' . $post_format : '') . '.php'));
                                                remove_filter('wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
                                                ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (is_sticky()): ?>
                                            <div class="sticky-wrap">
                                                <i class="fa fa-thumb-tack sticky-pin"></i>
                                            </div>
                                        <?php endif; ?>

                                        <div class="content-inner">

                                            <div class="blog-title-wrap">
                                                <?php
                                                $extra_class = '';
                                                $words = explode(" ", get_the_title());
                                                foreach ($words as $word) {
                                                    if (strlen($word) > 25) {
                                                        $extra_class = 'break-word';
                                                    }
                                                }
                                                ?>
                                                <a href="<?php the_permalink(); ?>"
                                                   class="blog-title <?php echo esc_attr($extra_class); ?>">
                                                    <h4><?php the_title(); ?></h4>
                                                </a>
                                                <!--<ul class="post-meta list-unstyled list-inline">
                                                    <li>
                                                        <i class="fa fa-user"></i>
                                                        <a href="<?php /*echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); */?>">
                                                            <?php /*echo get_the_author_meta('display_name') */?>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <i class="fa fa-clock-o"></i>
                                                        <?php /*the_time('F j, Y'); */?>
                                                    </li>
                                                    <li>
                                                        <i class="fa fa-folder-o"></i>
                                                        <?php /*echo reviews_the_category(); */?>
                                                    </li>
                                                </ul>-->
                                            </div>

                                            <?php the_excerpt() ?>

                                            <a href="<?php the_permalink(); ?>" class="btn">
                                                <?php esc_html_e('Continue reading', 'reviews') ?>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } else {
                            ?>
                            <!-- 404 -->
                            <div class="widget white-block">
                                <div class="widget-title-wrap">
                                    <h5 class="widget-title">
                                        <?php esc_html_e('Nothing Found', 'reviews') ?>
                                    </h5>
                                </div>
                                <p><?php esc_html_e('Sorry but we could not find anything which resembles you search criteria. Try again.', 'reviews') ?></p>
                                <?php get_search_form(); ?>
                            </div>
                            <!--.404 -->
                            <?php
                        }
                        ?>
                        <?php
                        if (!empty($pagination)): ?>
                            <div class="pagination">
                                <?php echo $pagination; ?>
                            </div>
                            <?php
                        endif;
                        ?>

                    </div>
                </div>
                <div class="col-md-3">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </section>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>