<?php
/*=============================
	DEFAULT SINGLE
=============================*/
get_header();
global $reviews_microdata_review;
$reviews_microdata_review = array();

reviews_count_clicks();
$post_pages = wp_link_pages(
    array(
        'before' => '',
        'after' => '',
        'link_before' => '<span>',
        'link_after' => '</span>',
        'next_or_number' => 'number',
        'nextpagelink' => esc_html__('&raquo;', 'reviews'),
        'previouspagelink' => esc_html__('&laquo;', 'reviews'),
        'separator' => ' ',
        'echo' => 0
    )
);

$permalink = reviews_get_permalink_by_tpl('page-tpl_search');
$title_before_images = reviews_get_option('title_before_images');

$user_reviews = get_post_meta(get_the_ID(), 'user_ratings_count', true);
if (empty($review_count)) {
    $review_count = 0;
}

$user_average = get_post_meta(get_the_ID(), 'user_average', true);
if (empty($user_average)) {
    $user_average = 0.0;
}

$featured_image_data = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnail');
$pager = '';


global $reviews_user_overall;;
ob_start();
comments_template('', true);
$comments_template = ob_get_contents();
ob_end_clean();

?>
    <section class="single-blog">
        <input type="hidden" name="post-id" value="<?php the_ID() ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-9">

                    <?php if ($title_before_images == 'no'): ?>
                        <h1 class="post-title size-h3"><?php the_title() ?></h1>
                    <?php endif; ?>

                    <div class="blog-media">
                        <ul class="list-unstyled review-slider">
                            <?php
                            $pager = '';
                            if (has_post_thumbnail()): ?>
                                <li>
                                    <?php reviews_single_review_slider_images(get_post_thumbnail_id()); ?>
                                </li>
                                <?php
                                $pager .= '<li>' . get_the_post_thumbnail(get_the_ID(), 'thumbnail') . '</li>';
                                ?>
                            <?php endif; ?>
                            <?php
                            $review_images = get_post_meta(get_the_ID(), 'review_images');
                            if (!empty($review_images)) {
                                foreach ($review_images as $review_image) {
                                    echo '<li>';
                                    reviews_single_review_slider_images($review_image);
                                    echo '</li>';
                                    add_filter('wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
                                    $pager .= '<li>' . wp_get_attachment_image($review_image, 'thumbnail') . '</li>';
                                    remove_filter('wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
                                }
                            } else {
                                $pager = '';
                            }
                            ?>
                        </ul>
                        <?php if (!empty($pager)): ?>
                            <ul class="slider-pager list-unstyled list-inline">
                                <?php echo $pager; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <?php
                    $review_tabs = get_post_meta(get_the_ID(), 'review_tabs');
                    $titles_html = '';
                    $contents_html = '';
                    if (!empty($review_tabs[0])) {
                        $titles_html .= '<li role="presentation" class="active"><a href="#tab_0" role="tab" data-toggle="tab">' . esc_html__('Our Analysis', 'reviews') . '</a></li>';
                        for ($i = 0; $i < sizeof($review_tabs); $i++) {
                            $titles_html .= '<li role="presentation"><a href="#tab_' . esc_attr($i + 1) . '" role="tab" data-toggle="tab">' . $review_tabs[$i]['review_tab_title'] . '</a></li>';
                            $contents_html .= '<div role="tabpanel" class="tab-pane" id="tab_' . esc_attr($i + 1) . '"><div class="white-block single-item"><div class="content-inner">' . (!empty($review_tabs[$i]['review_tab_content']) ? apply_filters('the_content', $review_tabs[$i]['review_tab_content']) : '') . '</div></div></div>';
                        }
                    }
                    ?>
                    <?php if (!empty($titles_html)): ?>
                        <ul class="nav nav-tabs review-tabs-btns" role="tablist">
                            <?php echo $titles_html ?>
                        </ul>
                    <?php endif; ?>

                    <!-- Tab panes -->
                    <div class="tab-content review-tabs">
                        <div role="tabpanel" class="tab-pane in active" id="tab_0">
                            <div class="white-block single-item">
                                <div class="content-inner">

                                    <?php if ($title_before_images == 'yes'): ?>
                                        <h1 class="post-title size-h3"><?php the_title() ?></h1>
                                    <?php endif; ?>

                                    <div class="post-content clearfix">
                                        <?php the_content(); ?>
                                        <div class="pagination">
                                            <?php wp_link_pages(); ?>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php echo $contents_html; ?>
                    </div>

                    <?php
                    $review_pros = get_post_meta(get_the_ID(), 'review_pros');
                    $review_cons = get_post_meta(get_the_ID(), 'review_cons');
                    if (!empty($review_pros) || !empty($review_cons)):
                        ?>
                        <div class="white-block pros-cons">
                            <div class="content-inner">
                                <!-- title -->
                                <div class="widget-title-wrap">
                                    <h5 class="widget-title">
                                        <?php esc_html_e('Pros And Cons', 'reviews'); ?>
                                    </h5>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul class="list-unstyled">
                                            <?php
                                            if (!empty($review_pros)) {
                                                foreach ($review_pros as $review_pro) {
                                                    echo '<li><i class="fa fa-plus-square-o"></i> ' . $review_pro . '</li>';
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <ul class="list-unstyled">
                                            <?php
                                            if (!empty($review_cons)) {
                                                foreach ($review_cons as $review_con) {
                                                    echo '<li><i class="fa fa-minus-square-o"></i> ' . $review_con . '</li>';
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>


                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    $reviews_score = get_post_meta(get_the_ID(), 'reviews_score');
                    $author_reviews = get_post_meta(get_the_ID(), 'author');
                    if (!empty($author_reviews)):
                        ?>
                        <div class="white-block score-breakdown">
                            <!--Individual Author Rating-->
                            <?php
                            $j = 0;
                            $selectAuthor=1;
                            $authorAvgScore = [];
                            foreach ($author_reviews as $key => $values) {
                                $authorID = $values['select_author'];
                                ?>
                                <div class="content-inner authornumber-<?php echo $selectAuthor?>">
                                    <!-- title -->
                                    <div class="widget-title-wrap">
                                        <h5 class="widget-title">
                                            <?php echo ucfirst(get_the_author_meta('display_name', $authorID));
                                            esc_html_e('\'s Review Score Breakdown', 'reviews'); ?>
                                        </h5>
                                    </div>
                                    <div class="other_author">
                                        <div class="col-md-2 authorInfo">
                                            <?php
                                            echo get_avatar(get_the_author_meta('ID', $authorID, $size = '100,100')); ?>
                                            <br>
                                            <a href="<?php echo esc_url(add_query_arg(array('post_type' => 'review'), get_author_posts_url(get_the_author_meta('ID', $authorID)))); ?>">
                                                <?php echo get_the_author_meta('display_name', $authorID); ?>
                                            </a>
                                        </div>
                                        <div class="col-md-10">
                                            <p>
                                                <?php echo $values['author_comments'] ?>
                                            </p>
                                        </div>
                                    </div>

                                    <ul class="list-unstyled ordered-list">
                                        <?php
                                        $reviewsScoreSum = 0.0;
                                        $reviewCriteria = 0;

                                        foreach ($values['author_review_criteria'] as $criteria) {
                                            $criteria_array[] = $criteria;
                                            $reviewCriteria++;
                                        }
                                        foreach ($values['author_review_score'] as $score) {
                                            $score_array[] = $score;
                                        }

                                        for ($i = 0; $i < count($criteria_array); $i++) {
                                            ?>
                                            <li>
                                                <?php echo $criteria_array[$i] ?> : <span
                                                        class="value author-ratings"> <?php reviews_rating_display($score_array[$i]); ?> </span>
                                            </li>
                                            <?php
                                            $reviewsScoreSum += $score_array[$i];
                                        }
                                        ?>
                                        <li>
                                            <strong><?php esc_html_e('Overall', 'reviews') ?>:</strong>
                                            <span class="value author-ratings">
									        <?php reviews_rating_display($reviewsScoreSum / $reviewCriteria); ?>
								        </span>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                                $authorAvgScore[$j++] = $score_array;
                                $criteria_array = [];
                                $score_array = [];
                                $selectAuthor++;
                            }
                            ?>

                            <!--Average Author Raiting-->
                            <div class="content-inner avg_author">
                                <!-- title -->
                                <div class="col-md-12">
                                    <div class="col-md-8 widget-title-wrap">
                                        <h5 class="widget-title">
                                            <?php esc_html_e('Author\'s Overal Review Score Breakdown', 'reviews'); ?>
                                        </h5>
                                    </div>
                                    <div class="col-md-4 dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                                            Individual Author's Rating
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" onchange="filterContent();"">
                                            <li role="presentation"><a role="menuitem" tabindex="-1"  value="N">Action</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#" value="Y">Another action</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <ul class="list-unstyled ordered-list">
                                    <?php
                                    $authorCounter = $i - 1;
                                    $criteriaCount = 0;
                                    $avgAuthorScore = 0.0;
                                    $authorSumScore = array();

                                    foreach ($authorAvgScore[0] as $k => $v) {
                                        $authorSumScore[$k] = array_sum(array_column($authorAvgScore, $k));
                                    }

                                    foreach ($reviews_score as $reviews_score_item) {
                                        ?>
                                        <li>
                                            <?php echo $reviews_score_item['review_criteria'];
                                            echo ':'; ?>
                                            <span class="value author-ratings"><?php reviews_rating_display($authorSumScore[$criteriaCount] / $authorCounter) ?>
										</span>
                                        </li>
                                        <?php
                                        $avgAuthorScore += $authorSumScore[$criteriaCount] / $authorCounter;
                                        $criteriaCount++;
                                    }
                                    ?>
                                    <li>
                                        <strong><?php esc_html_e('Overall', 'reviews') ?>:</strong>
                                        <span class="value author-ratings">
										<?php reviews_rating_display($avgAuthorScore / $criteriaCount); ?>
									</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endif;
                    $comment_number = get_comments_number();
                    if ($comment_number > 0 && comments_open()):
                        ?>
                        <div class="white-block score-breakdown">
                            <div class="content-inner">
                                <!-- title -->
                                <div class="widget-title-wrap">
                                    <h5 class="widget-title">
                                        <?php esc_html_e('Users\'s Overal Review Score Breakdown', 'reviews'); ?>
                                    </h5>
                                </div>
                                <ul class="list-unstyled ordered-list">
                                    <?php
                                    $counter = 0;

                                    foreach ($reviews_score as $reviews_score_item) {
                                        ?>
                                        <li>
                                            <?php echo $reviews_score_item['review_criteria'];
                                            echo ':'; ?>
                                            <span class="value user-ratings">
											<?php reviews_rating_display($reviews_user_overall[$counter] / $comment_number); ?>
										</span>
                                        </li>
                                        <?php
                                        $counter++;
                                    }
                                    ?>
                                    <li>
                                        <strong><?php esc_html_e('Overall', 'reviews') ?>:</strong>
                                        <span class="value user-ratings">
										<?php reviews_rating_display($user_average); ?>
									</span>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                    $tags = reviews_custom_tax('review-tag');
                    if (!empty($tags)):
                        ?>
                        <div class="post-tags white-block">
                            <div class="content-inner">
                                <i class="fa fa-tags"></i>
                                <?php esc_html_e('Tags: ', 'reviews');
                                echo $tags; ?>
                            </div>
                        </div>
                        <?php
                    endif;
                    ?>
                    <?php echo $comments_template; ?>
                </div>
                <?php include(get_theme_file_path('includes/reviews-sidebar.php')); ?>
            </div>
        </div>
    </section>
<?php

$average = $user_average;
$reviewCount = count($reviews_microdata_review);
if (empty($average) && !empty($author_average)) {
    $average = $author_average;
    $reviewCount = 1;
}
if ($average > 0): ?>
    <script type="application/ld+json">
{
	"@context": "http://schema.org/",
	"@type": "Product",
	"aggregateRating": {
		"@type": "AggregateRating",
		"ratingValue": "<?php echo esc_html($average); ?>",
		"reviewCount": "<?php echo esc_html($reviewCount) ?>"
	},
	"image": "<?php echo !empty($featured_image_data[0]) ? esc_url($featured_image_data[0]) : ''; ?>",
	"name": "<?php the_title(); ?>",
	"review": [<?php echo join(',', $reviews_microdata_review) ?>]
}




    </script>
<?php endif; ?>
<?php get_footer(); ?>