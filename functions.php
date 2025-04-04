<?php
function blackwhiteblog_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('automatic-feed-links');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('custom-header', array(
        'default-image' => '',
        'width'         => 1200,
        'height'        => 300,
        'flex-height'   => true,
        'flex-width'    => true,
    ));
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ));
    register_nav_menus(array(
        'primary-menu' => __('Ana Menü', 'blackwhiteblog'),
    ));
    load_theme_textdomain('blackwhiteblog', get_template_directory() . '/languages');
    
    add_editor_style('style/editor-style.css');
}
add_action('after_setup_theme', 'blackwhiteblog_setup');

function blackwhiteblog_register_block_styles() {
    register_block_style(
        'core/paragraph',
        array(
            'name'  => 'highlight',
            'label' => __('Highlight', 'blackwhiteblog'),
            'inline_style' => '.wp-block-paragraph.is-style-highlight { background-color: #f5f5f5; padding: 10px; border-left: 4px solid #333; }',
        )
    );
    register_block_style(
        'core/button',
        array(
            'name'  => 'outline',
            'label' => __('Outline', 'blackwhiteblog'),
            'inline_style' => '.wp-block-button.is-style-outline .wp-block-button__link { background: transparent; border: 2px solid #333; color: #333; }',
        )
    );
}
add_action('init', 'blackwhiteblog_register_block_styles');

function blackwhiteblog_register_block_patterns() {
    register_block_pattern(
        'blackwhiteblog/hero-section',
        array(
            'title'       => __('Hero Section', 'blackwhiteblog'),
            'description' => __('A simple hero section with a heading and paragraph.', 'blackwhiteblog'),
            'content'     => "<!-- wp:heading {\"level\":1} -->\n<h1>Welcome to BlackwhiteBlog</h1>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p>A simple and modern blog theme.</p>\n<!-- /wp:paragraph -->",
            'categories'  => array('header'),
        )
    );
}
add_action('init', 'blackwhiteblog_register_block_patterns');

function blackwhiteblog_widgets_init() {
    register_sidebar(array(
        'name'          => __('Primary Sidebar', 'blackwhiteblog'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'blackwhiteblog'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'blackwhiteblog_widgets_init');

function blackwhiteblog_enqueue_scripts() {
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'blackwhiteblog_enqueue_scripts');

function blackwhiteblog_enqueue_styles() {
    wp_enqueue_style('blackwhiteblog-main-css', get_template_directory_uri() . '/style/main.css');
    wp_enqueue_style('blackwhiteblog-header-css', get_template_directory_uri() . '/style/header.css');
    wp_enqueue_style('blackwhiteblog-footer-css', get_template_directory_uri() . '/style/footer.css');
    wp_enqueue_style('blackwhiteblog-page-css', get_template_directory_uri() . '/style/page.css');
    wp_enqueue_style('blackwhiteblog-tag-css', get_template_directory_uri() . '/style/tag.css');
    wp_enqueue_style('blackwhiteblog-search-css', get_template_directory_uri() . '/style/search.css');
    wp_enqueue_style('blackwhiteblog-category-css', get_template_directory_uri() . '/style/category.css');
    wp_enqueue_style('blackwhiteblog-archive-css', get_template_directory_uri() . '/style/archive.css');
    wp_enqueue_style('blackwhiteblog-dark-theme-css', get_template_directory_uri() . '/style/dark-theme.css');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/all.css', array(), '6.5.1', 'all');
    wp_enqueue_style('blackwhiteblog-single-css', get_template_directory_uri() . '/style/single.css');
    wp_enqueue_style('blackwhiteblog-comments-css', get_template_directory_uri() . '/style/comments.css');
    wp_enqueue_style('ubuntu-font', 'https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap', array(), null);
    wp_enqueue_script('jquery');
    wp_enqueue_script('blackwhiteblog-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
    wp_localize_script('blackwhiteblog-scripts', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('load_more_nonce'),
    ));
    wp_localize_script('blackwhiteblog-scripts', 'dark_theme_settings', array(
        'default_mode' => get_theme_mod('blackwhiteblog_dark_theme_default', 'light'),
    ));
}
add_action('wp_enqueue_scripts', 'blackwhiteblog_enqueue_styles');

function load_more_posts() {
    check_ajax_referer('load_more_nonce', 'nonce');
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $args = array(
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'offset'         => $offset,
    );
    $latest_posts = new WP_Query($args);
    if ($latest_posts->have_posts()) :
        while ($latest_posts->have_posts()) : $latest_posts->the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('latest-post-item'); ?> itemscope itemtype="https://schema.org/Article">
            <div class="latest-post-image">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                    </a>
                <?php else : ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/placeholder.jpg" alt="<?php esc_attr_e('Son gönderi görseli', 'blackwhiteblog'); ?>" loading="lazy">
                <?php endif; ?>
                <span class="post-categories" itemprop="articleSection"><?php the_category(', '); ?></span>
                <time class="post-time-ago" datetime="<?php echo get_the_date('c'); ?>"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ' . __('önce', 'blackwhiteblog'); ?></time>
            </div>
            <div class="latest-post-content">
                <h3 class="latest-post-title" itemprop="headline"><a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a></h3>
                <p class="latest-post-excerpt" itemprop="description"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                <?php wp_link_pages( array(
                    'before' => '<div class="page-links">' . __('Pages:', 'blackwhiteblog'),
                    'after'  => '</div>',
                ) ); ?>
                <a href="<?php the_permalink(); ?>" class="read-more-btn"><?php _e('Devamını Oku', 'blackwhiteblog'); ?></a>
            </div>
        </article>
    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    wp_die();
}

function blackwhiteblog_posts_per_page($query) {
    if (is_category() && $query->is_main_query()) {
        $query->set('posts_per_page', 9);
    }
}
add_action('pre_get_posts', 'blackwhiteblog_posts_per_page');

add_filter('the_password_form', 'blackwhiteblog_password_form');
function blackwhiteblog_password_form($output) {
    $post = get_post();
    $label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
    $output = '<form action="' . esc_url(home_url('wp-login.php?action=postpass', 'login_post')) . '" method="post" class="single-password-form">
        <div class="password-form-inner">
            <i class="fa-solid fa-lock password-icon"></i>
            <h3>' . __('Korumalı İçerik', 'blackwhiteblog') . '</h3>
            <p>' . __('Bu gönderiyi görüntülemek için şifreyi giriniz.', 'blackwhiteblog') . '</p>
            <input name="post_password" id="' . $label . '" type="password" placeholder="' . esc_attr__('Şifreyi girin', 'blackwhiteblog') . '" required />
            <button type="submit" class="password-submit"><i class="fa-solid fa-arrow-right"></i> ' . __('Gönder', 'blackwhiteblog') . '</button>
        </div>
    </form>';
    return $output;
}

add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

function blackwhiteblog_customize_register($wp_customize) {
    $wp_customize->add_section('blackwhiteblog_home_settings', array(
        'title'    => __('Ana Sayfa Ayarları', 'blackwhiteblog'),
        'priority' => 30,
    ));
    $wp_customize->add_setting('blackwhiteblog_featured_posts_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
    ));
    $wp_customize->add_control('blackwhiteblog_featured_posts_toggle', array(
        'label'    => __('Öne Çıkanlar Bölümünü Göster', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_home_settings',
        'type'     => 'checkbox',
    ));
    $wp_customize->add_setting('blackwhiteblog_featured_posts_title', array(
        'default'           => __('Öne Çıkanlar', 'blackwhiteblog'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('blackwhiteblog_featured_posts_title', array(
        'label'       => __('Öne Çıkanlar Başlığı', 'blackwhiteblog'),
        'section'     => 'blackwhiteblog_home_settings',
        'type'        => 'text',
        'active_callback' => 'blackwhiteblog_featured_posts_active',
    ));
    $wp_customize->add_setting('blackwhiteblog_featured_posts_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('blackwhiteblog_featured_posts_count', array(
        'label'       => __('Öne Çıkanlar Gönderi Sayısı', 'blackwhiteblog'),
        'section'     => 'blackwhiteblog_home_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 10,
            'step' => 1,
        ),
        'active_callback' => 'blackwhiteblog_featured_posts_active',
    ));
    $wp_customize->add_setting('blackwhite_footer_copyright_text', array(
        'default'           => '© ' . date('Y') . ' All rights reserved.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('blackwhite_footer_copyright_text', array(
        'label'    => 'Copyright Text',
        'section'  => 'blackwhiteblog_footer_settings',
        'type'     => 'text',
        'description' => 'Customize the copyright text at the bottom of the footer.',
    ));
    
    $wp_customize->add_setting('blackwhite_footer_wordpress_attribution_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
    ));
    $wp_customize->add_control('blackwhite_footer_wordpress_attribution_toggle', array(
        'label'    => 'Show WordPress Attribution',
        'section'  => 'blackwhiteblog_footer_settings',
        'type'     => 'checkbox',
        'description' => 'Show or hide the "Powered by WordPress" link in the footer.',
    ));
    $wp_customize->add_setting('blackwhiteblog_featured_posts_category', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('blackwhiteblog_featured_posts_category', array(
        'label'       => __('Öne Çıkanlar Kategori', 'blackwhiteblog'),
        'section'     => 'blackwhiteblog_home_settings',
        'type'        => 'select',
        'choices'     => blackwhiteblog_get_categories(),
        'active_callback' => 'blackwhiteblog_featured_posts_active',
    ));
    $wp_customize->add_setting('blackwhiteblog_popular_posts_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
    ));
    $wp_customize->add_control('blackwhiteblog_popular_posts_toggle', array(
        'label'    => __('Popüler İçerikler Bölümünü Göster', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_home_settings',
        'type'     => 'checkbox',
    ));
    $wp_customize->add_setting('blackwhiteblog_popular_posts_title', array(
        'default'           => __('Popüler İçerikler', 'blackwhiteblog'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('blackwhiteblog_popular_posts_title', array(
        'label'       => __('Popüler İçerikler Başlığı', 'blackwhiteblog'),
        'section'     => 'blackwhiteblog_home_settings',
        'type'        => 'text',
        'active_callback' => 'blackwhiteblog_popular_posts_active',
    ));
    $wp_customize->add_setting('blackwhiteblog_popular_posts_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('blackwhiteblog_popular_posts_count', array(
        'label'       => __('Popüler İçerikler Gönderi Sayısı', 'blackwhiteblog'),
        'section'     => 'blackwhiteblog_home_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 10,
            'step' => 1,
        ),
        'active_callback' => 'blackwhiteblog_popular_posts_active',
    ));
    $wp_customize->add_setting('blackwhiteblog_popular_posts_category', array(
        'default'           => '0',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('blackwhiteblog_popular_posts_category', array(
        'label'       => __('Popüler İçerikler Kategori', 'blackwhiteblog'),
        'section'     => 'blackwhiteblog_home_settings',
        'type'        => 'select',
        'choices'     => blackwhiteblog_get_categories(),
        'active_callback' => 'blackwhiteblog_popular_posts_active',
    ));
    $wp_customize->add_section('blackwhiteblog_footer_settings', array(
        'title'    => __('Footer Ayarları', 'blackwhiteblog'),
        'priority' => 35,
    ));
    $wp_customize->add_setting('blackwhiteblog_footer_about_text', array(
        'default'           => __('Burası senin siten! Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.', 'blackwhiteblog'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('blackwhiteblog_footer_about_text', array(
        'label'    => __('Hakkımızda Metni', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_footer_settings',
        'type'     => 'textarea',
    ));
    $wp_customize->add_setting('blackwhiteblog_footer_logo_container_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
    ));
    $wp_customize->add_control('blackwhiteblog_footer_logo_container_toggle', array(
        'label'    => __('Logo ve Site Adı Konteynırını Göster', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_footer_settings',
        'type'     => 'checkbox',
    ));
    $social_platforms = array('twitter' => 'Twitter', 'instagram' => 'Instagram', 'facebook' => 'Facebook');
    foreach ($social_platforms as $key => $label) {
        $wp_customize->add_setting("blackwhiteblog_footer_social_{$key}_toggle", array(
            'default'           => true,
            'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
        ));
        $wp_customize->add_control("blackwhiteblog_footer_social_{$key}_toggle", array(
            'label'    => sprintf(__('%s İkonunu Göster', 'blackwhiteblog'), $label),
            'section'  => 'blackwhiteblog_footer_settings',
            'type'     => 'checkbox',
        ));
        $wp_customize->add_setting("blackwhiteblog_footer_social_{$key}_url", array(
            'default'           => "https://{$key}.com",
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("blackwhiteblog_footer_social_{$key}_url", array(
            'label'    => sprintf(__('%s URL', 'blackwhiteblog'), $label),
            'section'  => 'blackwhiteblog_footer_settings',
            'type'     => 'url',
            'active_callback' => function($control) use ($key) {
                return $control->manager->get_setting("blackwhiteblog_footer_social_{$key}_toggle")->value();
            },
        ));
    }
    $wp_customize->add_setting('blackwhiteblog_footer_contact_email', array(
        'default'           => 'info@example.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('blackwhiteblog_footer_contact_email', array(
        'label'    => __('E-posta Adresi', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_footer_settings',
        'type'     => 'email',
    ));
    $wp_customize->add_setting('blackwhiteblog_footer_contact_phone', array(
        'default'           => '+90 123 456 78 90',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('blackwhiteblog_footer_contact_phone', array(
        'label'    => __('Telefon Numarası', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_footer_settings',
        'type'     => 'text',
    ));
    $wp_customize->add_setting('blackwhiteblog_footer_contact_link_text', array(
        'default'           => __('İletişim', 'blackwhiteblog'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('blackwhiteblog_footer_contact_link_text', array(
        'label'    => __('İletişim Link Metni', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_footer_settings',
        'type'     => 'text',
    ));
    $wp_customize->add_setting('blackwhiteblog_footer_contact_link_url', array(
        'default'           => home_url('/contact'),
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('blackwhiteblog_footer_contact_link_url', array(
        'label'    => __('İletişim Link URL', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_footer_settings',
        'type'     => 'url',
    ));
    $wp_customize->add_section('blackwhiteblog_single_settings', array(
        'title'    => __('Single Post Ayarları', 'blackwhiteblog'),
        'priority' => 40,
    ));
    $wp_customize->add_setting('blackwhiteblog_single_breadcrumbs_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
    ));
    $wp_customize->add_control('blackwhiteblog_single_breadcrumbs_toggle', array(
        'label'    => __('Breadcrumbs Göster', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_single_settings',
        'type'     => 'checkbox',
    ));
    $wp_customize->add_setting('blackwhiteblog_single_thumbnail_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
    ));
    $wp_customize->add_control('blackwhiteblog_single_thumbnail_toggle', array(
        'label'    => __('Thumbnail Göster', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_single_settings',
        'type'     => 'checkbox',
    ));
    $wp_customize->add_setting('blackwhiteblog_single_share_buttons_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
    ));
    $wp_customize->add_control('blackwhiteblog_single_share_buttons_toggle', array(
        'label'    => __('Sosyal Paylaşım Butonlarını Göster', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_single_settings',
        'type'     => 'checkbox',
    ));
    $wp_customize->add_setting('blackwhiteblog_single_tags_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
    ));
    $wp_customize->add_control('blackwhiteblog_single_tags_toggle', array(
        'label'    => __('Etiketleri Göster', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_single_settings',
        'type'     => 'checkbox',
    ));
    $wp_customize->add_setting('blackwhiteblog_single_comments_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
    ));
    $wp_customize->add_control('blackwhiteblog_single_comments_toggle', array(
        'label'    => __('Yorumları Göster', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_single_settings',
        'type'     => 'checkbox',
    ));
    $wp_customize->add_section('blackwhiteblog_header_settings', array(
        'title'    => __('Header Ayarları', 'blackwhiteblog'),
        'priority' => 25,
    ));
    $wp_customize->add_setting('blackwhiteblog_header_logo_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
    ));
    $wp_customize->add_control('blackwhiteblog_header_logo_toggle', array(
        'label'    => __('Logoyu Göster', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_header_settings',
        'type'     => 'checkbox',
    ));
    $wp_customize->add_setting('blackwhiteblog_header_site_title_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
    ));
    $wp_customize->add_control('blackwhiteblog_header_site_title_toggle', array(
        'label'    => __('Site Adını Göster', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_header_settings',
        'type'     => 'checkbox',
    ));
    $wp_customize->add_setting('blackwhiteblog_header_menu_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
    ));
    $wp_customize->add_control('blackwhiteblog_header_menu_toggle', array(
        'label'    => __('Menüyü Göster', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_header_settings',
        'type'     => 'checkbox',
    ));
    $wp_customize->add_setting('blackwhiteblog_header_dark_mode_toggle', array(
        'default'           => true,
        'sanitize_callback' => 'blackwhiteblog_sanitize_checkbox',
    ));
    $wp_customize->add_control('blackwhiteblog_header_dark_mode_toggle', array(
        'label'    => __('Karanlık Mod Düğmesini Göster', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_header_settings',
        'type'     => 'checkbox',
    ));
    $wp_customize->add_section('blackwhiteblog_dark_theme_settings', array(
        'title'    => __('Dark Theme Ayarları', 'blackwhiteblog'),
        'priority' => 45,
    ));
    $wp_customize->add_setting('blackwhiteblog_dark_theme_default', array(
        'default'           => 'light',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('blackwhiteblog_dark_theme_default', array(
        'label'    => __('Varsayılan Tema Modu', 'blackwhiteblog'),
        'section'  => 'blackwhiteblog_dark_theme_settings',
        'type'     => 'select',
        'choices'  => array(
            'light' => __('Varsayılan Olarak Açık', 'blackwhiteblog'),
            'dark'  => __('Varsayılan Olarak Karanlık', 'blackwhiteblog'),
        ),
    ));
}
add_action('customize_register', 'blackwhiteblog_customize_register');

function blackwhiteblog_sanitize_checkbox($checked) {
    return (isset($checked) && true == $checked) ? true : false;
}

function blackwhiteblog_featured_posts_active($control) {
    return $control->manager->get_setting('blackwhiteblog_featured_posts_toggle')->value();
}

function blackwhiteblog_popular_posts_active($control) {
    return $control->manager->get_setting('blackwhiteblog_popular_posts_toggle')->value();
}

function blackwhiteblog_get_categories() {
    $categories = get_categories();
    $category_options = array(
        '0' => __('Tüm Kategoriler / Son Gönderiler', 'blackwhiteblog'),
    );
    foreach ($categories as $category) {
        $category_options[$category->term_id] = $category->name;
    }
    return $category_options;
}
?>