<?php
add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 3);
function theme_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

add_action('wp_enqueue_scripts', 'theme_js');
function theme_js()
{
    wp_enqueue_script('theme_js', get_stylesheet_directory_uri() . '/custom_script.js', array('jquery'), '1.0', true);
}

// Display all the tags in the edit mode.
function wp_showAllTagsEditor($args)
{
    if (defined('DOING_AJAX') && DOING_AJAX && isset($_POST['action']) && $_POST['action'] === 'get-tagcloud') {
        unset($args['number']);
        $args['hide_empty'] = 0;
    }
    return $args;
}

add_filter('get_terms_args', 'wp_showAllTagsEditor');

// Display the author name in review
function getUserInfo()
{
    //get the all user
    $args = array(
        'role__not_in' => array('Subscriber')
    );
    $all_users = get_users($args);
    $userDetails = array();
    foreach ($all_users as $user) {
        $userDetails[$user->ID] = $user->display_name;
    }
    return $userDetails;
}

// Review details
if (!function_exists('reviews_custom_meta')) {
    function reviews_custom_meta()
    {
        $post_meta_standard = array(
            array(
                'id' => 'iframe_standard',
                'name' => esc_html__('Input url to be embeded', 'reviews'),
                'type' => 'text',
            ),
        );

        $meta_boxes[] = array(
            'title' => esc_html__('Standard Post Information', 'reviews'),
            'pages' => 'post',
            'fields' => $post_meta_standard,
        );

        $post_meta_gallery = array(
            array(
                'id' => 'gallery_images',
                'name' => esc_html__('Add images for the gallery', 'reviews'),
                'type' => 'image',
                'repeatable' => 1
            )
        );

        $meta_boxes[] = array(
            'title' => esc_html__('Gallery Post Information', 'reviews'),
            'pages' => 'post',
            'fields' => $post_meta_gallery,
        );


        $post_meta_audio = array(
            array(
                'id' => 'iframe_audio',
                'name' => esc_html__('Input URL for the audio', 'reviews'),
                'type' => 'text',
            ),

            array(
                'id' => 'audio_type',
                'name' => esc_html__('Select type of the audio', 'reviews'),
                'type' => 'select',
                'options' => array(
                    'embed' => esc_html__('Embed', 'reviews'),
                    'direct' => esc_html__('Direct Link', 'reviews')
                )
            ),
        );

        $meta_boxes[] = array(
            'title' => esc_html__('Audio Post Information', 'reviews'),
            'pages' => 'post',
            'fields' => $post_meta_audio,
        );

        $post_meta_video = array(
            array(
                'id' => 'video',
                'name' => esc_html__('Input video URL', 'reviews'),
                'type' => 'text',
            ),
            array(
                'id' => 'video_type',
                'name' => esc_html__('Select video type', 'reviews'),
                'type' => 'select',
                'options' => array(
                    'self' => esc_html__('Self Hosted', 'reviews'),
                    'remote' => esc_html__('Embed', 'reviews'),
                )
            ),
        );

        $meta_boxes[] = array(
            'title' => esc_html__('Video Post Information', 'reviews'),
            'pages' => 'post',
            'fields' => $post_meta_video,
        );

        $post_meta_quote = array(
            array(
                'id' => 'blockquote',
                'name' => esc_html__('Input the quotation', 'reviews'),
                'type' => 'textarea',
            ),
            array(
                'id' => 'cite',
                'name' => esc_html__('Input the quoted person\'s name', 'reviews'),
                'type' => 'text',
            ),
        );

        $meta_boxes[] = array(
            'title' => esc_html__('Quote Post Information', 'reviews'),
            'pages' => 'post',
            'fields' => $post_meta_quote,
        );

        $post_meta_link = array(
            array(
                'id' => 'link',
                'name' => esc_html__('Input link', 'reviews'),
                'type' => 'text',
            ),
        );

        $meta_boxes[] = array(
            'title' => esc_html__('Link Post Information', 'reviews'),
            'pages' => 'post',
            'fields' => $post_meta_link,
        );

        $reviews_meta = array(
            array(
                'id' => 'review_clicks',
                'name' => esc_html__('Review Clicks', 'reviews'),
                'type' => 'text',
                'default' => '0'
            ),
            array(
                'id' => 'review_images',
                'name' => esc_html__('Add images', 'reviews'),
                'type' => 'image',
                'repeatable' => 1
            ),
            array(
                'id' => 'review_tabs',
                'name' => esc_html__('Add Tab', 'reviews'),
                'type' => 'group',
                'fields' => array(
                    array(
                        'id' => 'review_tab_title',
                        'type' => 'text',
                        'name' => esc_html__('Tab Title', 'reviews'),
                    ),
                    array(
                        'id' => 'review_tab_content',
                        'type' => 'wysiwyg',
                        'name' => esc_html__('Tab Content', 'reviews'),
                    )
                ),
                'repeatable' => 1
            ),
            array(
                'id' => 'review_pros',
                'name' => esc_html__('Product / Service Pros', 'reviews'),
                'type' => 'text',
                'repeatable' => 1
            ),
            array(
                'id' => 'review_cons',
                'name' => esc_html__('Product / Service Cons', 'reviews'),
                'type' => 'text',
                'repeatable' => 1
            ),
            array(
                'id' => 'reviews_score',
                'name' => esc_html__('User\'s review criterias', 'reviews'),
                'type' => 'group',
                'fields' => array(
                    array(
                        'id' => 'review_criteria',
                        'name' => esc_html__('Name Of Criteria', 'reviews'),
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'review_score',
                        'type' => 'select',
                        'name' => esc_html__('Criteria Score', 'reviews'),
                        'options' => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5'
                        ),
                    )
                ),
                'repeatable' => 1
            ),
        );

        $meta_boxes[] = array(
            'title' => esc_html__('Reviews Details', 'reviews'),
            'pages' => 'review',
            'fields' => $reviews_meta,
        );

        $reviews_meta = array(
            array(
                'id' => 'author',
                'name' => esc_html__('Author', 'reviews'),
                'type' => 'group',
                'fields' => array(
                    array(
                        'id' => 'select_author',
                        'name' => esc_html__('Select Author', 'reviews'),
                        'placeholder' => 'Select Author',
                        'multiple' => false,
                        'show_option_none' => true,
                        'default' => 'custom',
                        'type' => 'select',
                        'options' => getUserInfo()
                    ),
                    array(
                        'id' => 'author_comments',
                        'name' => esc_html__('Author Comments', 'reviews'),
                        'type' => 'wysiwyg',
                    ),
                    array(
                        'id' => 'author_review_criteria',
                        'name' => esc_html__('Name Of Criteria', 'reviews'),
                        'repeatable' => 1,
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'author_review_score',
                        'type' => 'select',
                        'name' => esc_html__('Criteria Score', 'reviews'),
                        'repeatable' => 1,
                        'options' => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5'
                        ),
                    )
                ),
                'repeatable' => 1
            )
        );

        $meta_boxes[] = array(
            'title' => esc_html__('Author\'s Rating', 'reviews'),
            'pages' => 'review',
            'fields' => $reviews_meta,
        );
        $reviews_meta = array(
            array(
                'id' => 'review_cta_link',
                'name' => esc_html__('Button Link', 'reviews'),
                'type' => 'text',
            ),
        );

        $meta_boxes[] = array(
            'title' => esc_html__('Call To Action Button', 'reviews'),
            'pages' => 'review',
            'fields' => $reviews_meta,
        );

        $reviews_meta = array(
            array(
                'id' => 'reviews_wtb',
                'name' => esc_html__('Stores', 'reviews'),
                'type' => 'group',
                'fields' => array(
                    array(
                        'id' => 'review_wtb_store_link',
                        'name' => esc_html__('Store Link', 'reviews'),
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'review_wtb_store_name',
                        'name' => esc_html__('Store Name', 'reviews'),
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'review_wtb_store_logo',
                        'name' => esc_html__('Store Logo', 'reviews'),
                        'type' => 'image',
                    ),
                    array(
                        'id' => 'review_wtb_price',
                        'name' => esc_html__('Price', 'reviews'),
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'review_wtb_sale_price',
                        'name' => esc_html__('Sale Price', 'reviews'),
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'review_wtb_product_link',
                        'name' => esc_html__('Product / Service Link', 'reviews'),
                        'type' => 'text',
                    ),
                ),
                'repeatable' => 1
            ),
        );

        $meta_boxes[] = array(
            'title' => esc_html__('Where To Buy', 'reviews'),
            'pages' => 'review',
            'fields' => $reviews_meta,
        );

        return $meta_boxes;
    }

    add_filter('cmb_meta_boxes', 'reviews_custom_meta');
}

?>