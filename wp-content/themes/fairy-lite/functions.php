<?php

/**
 * Loads the child theme textdomain.
 */
function fairy_lite_load_language()
{
    load_child_theme_textdomain('fairy-lite');
}
add_action('after_setup_theme', 'fairy_lite_load_language');

/**
 * Fairy Theme Customizer default values and infer from Fairy
 *
 * @package Fairy
 */
if (!function_exists('fairy_default_theme_options_values')) :
    function fairy_default_theme_options_values()
    {
        $default_theme_options = array(
            /*Top Header*/
            'fairy-enable-top-header' => false,
            'fairy-enable-top-header-social' => true,
            'fairy-enable-top-header-menu' => true,
            'fairy-enable-top-header-search' => true,

            /*Slider Settings Option*/
            'fairy-enable-slider' => false,
            'fairy-select-category' => 0,
            'fairy-image-size-slider' => 'cropped-image',

            /*Category Boxes*/
            'fairy-enable-category-boxes' => false,
            'fairy-single-cat-posts-select-1' => 0,


            /*Sidebar Options*/
            'fairy-sidebar-blog-page' => 'right-sidebar',
            'fairy-sidebar-single-page' => 'right-sidebar',
            'fairy-enable-sticky-sidebar' => true,


            /*Blog Page Default Value*/
            'fairy-column-blog-page' => 'two-column',
            'fairy-content-show-from' => 'excerpt',
            'fairy-excerpt-length' => 25,
            'fairy-pagination-options' => 'numeric',
            'fairy-read-more-text' => esc_html__('Read More', 'fairy-lite'),
            'fairy-blog-page-masonry-normal' => 'masonry',
            'fairy-blog-page-image-position' => 'full-image',
            'fairy-image-size-blog-page' => 'original-image',
            'fairy-site-layout-blog-overlay' => 1,

            /*Single Page Default Value*/
            'fairy-single-page-featured-image' => true,
            'fairy-single-page-tags' => false,
            'fairy-enable-underline-link' => true,
            'fairy-single-page-related-posts' => true,
            'fairy-single-page-related-posts-title' => esc_html__('Related Posts', 'fairy-lite'),


            /*Breadcrumb Settings*/
            'fairy-blog-site-breadcrumb' => true,
            'fairy-breadcrumb-display-from-option' => 'theme-default',
            'fairy-breadcrumb-text' => '',

            /*General Colors*/
            'fairy-primary-color' => '#6ca12b',
            'fairy-header-description-color' => '#404040',

            'fairy-overlay-color' => 'rgba(255, 126, 0, 0.5)',
            'fairy-overlay-second-color' => 'rgba(0, 0, 0, 0.5)',

            /*Footer Options*/
            'fairy-footer-copyright' => esc_html__('All Rights Reserved 2021.', 'fairy-lite'),
            'fairy-go-to-top' => true,
            'fairy-footer-social-icons' => false,
            'fairy-footer-mailchimp-subscribe' => false,
            'fairy-footer-instagram' => '',
            'fairy-footer-mailchimp-form-id' => '',
            'fairy-footer-mailchimp-form-title' =>  esc_html__('Subscribe to my Newsletter', 'fairy-lite'),
            'fairy-footer-mailchimp-form-subtitle' => esc_html__('Be the first to receive the latest buzz on upcoming contests & more!', 'fairy-lite'),

            /*Font Options*/
            'fairy-font-family-url' => 'Muli:400,300italic,300',
            'fairy-font-heading-family-url' => 'Poppins:400,500,600,700',

            /*Extra Options*/
            'fairy-post-published-updated-date' => 'post-published',

        );
        return apply_filters('fairy_default_theme_options_values', $default_theme_options);
    }
endif;

/**
 * Enqueue Style
 */
add_action('wp_enqueue_scripts', 'fairy_lite_style');
function fairy_lite_style()
{
    wp_enqueue_style('fairy-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('fairy-lite-style', get_stylesheet_directory_uri() . '/style.css', array('fairy-parent-style'));
}

if (!function_exists('fairy_footer_theme_info')) {
    /**
     * Add Powered by texts on footer
     *
     * @since 1.0.0
     */
    function fairy_footer_theme_info()
    {
?>
        <div class="site-info text-center">
            <a href="<?php echo esc_url(__('https://wordpress.org/', 'fairy-lite')); ?>">
                <?php
                /* translators: %s: CMS name, i.e. WordPress. */
                printf(esc_html__('Proudly powered by %s', 'fairy-lite'), 'WordPress');
                ?>
            </a>
            <span class="sep"> | </span>
            <?php
            /* translators: 1: Theme name, 2: Theme author. */
            printf(esc_html__('Theme: %1$s by %2$s.', 'fairy-lite'), 'Fairy Lite', '<a href="http://www.candidthemes.com/">Candid Themes</a>');
            ?>
        </div><!-- .site-info -->
<?php
    }
}
add_action('fairy_footer_info_texts', 'fairy_footer_theme_info', 20);

function fairy_lite_header_setup()
{
    add_theme_support(
        'custom-header',
        apply_filters(
            'fairy_custom_header_args',
            array(
                'default-image'      => '',
                'default-text-color' => '6ca12b',
                'width'              => 1900,
                'height'             => 250,
                'flex-height'        => true,
                'wp-head-callback'   => 'fairy_header_style',
            )
        )
    );
}
add_action('after_setup_theme', 'fairy_lite_header_setup');


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fairy_lite_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Footer 4', 'fairy-lite'),
            'id'            => 'footer-4',
            'description'   => esc_html__('Add widgets here.', 'fairy-lite'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'fairy_lite_widgets_init', 11);


if (!function_exists('fairy_get_category')) :
    function fairy_get_category($post_id = 0)
    {

        if (0 == $post_id) {
            global $post;
            $post_id = $post->ID;
        }
        $categories = get_the_category($post_id);
        $output = '';
        $separator = ' ';
        if ($categories) {
            $output .= '<div class="category-label-group bg-label">';
            $output .= '<span class="cat-links">';
            foreach ($categories as $category) {
                $output .= '<a class="ct-cat-item-' . esc_attr($category->term_id) . '" href="' . esc_url(get_category_link($category->term_id)) . '"  rel="category tag">' . esc_html($category->cat_name) . '</a>' . $separator;
            }
            $output .= '</span>';
            $output .= '</div>';
            return $output;
        }
    }
endif;
