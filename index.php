<?php
get_header();
?>
<main class="site-main" itemscope itemtype="https://schema.org/WebPage">
    <section class="search-section">
        <div class="container">
            <?php get_search_form(); ?>
        </div>
    </section>
    <?php if (get_theme_mod('blackwhite_featured_posts_toggle', true)) : ?>
    <section class="featured-posts-section" aria-label="<?php esc_attr_e('Öne Çıkan Gönderiler', 'blackwhiteblog'); ?>">
        <div class="container">
            <h1 class="section-title"><?php echo esc_html(get_theme_mod('blackwhite_featured_posts_title', __('Öne Çıkanlar', 'blackwhiteblog'))); ?></h1>
            <div class="post-slider">
                <?php
                $featured_category = get_theme_mod('blackwhite_featured_posts_category', '0');
                $args = array(
                    'posts_per_page' => absint(get_theme_mod('blackwhite_featured_posts_count', 3)),
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                );
                if ($featured_category !== '0') {
                    $args['cat'] = $featured_category;
                }
                $latest_post = new WP_Query($args);
                if ($latest_post->have_posts()) :
                    $index = 0;
                    while ($latest_post->have_posts()) : $latest_post->the_post();
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('featured-post ' . ($index === 0 ? 'active' : '')); ?> data-id="<?php echo $index; ?>" itemscope itemtype="https://schema.org/Article">
                        <div class="post-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                                </a>
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/placeholder.jpg" alt="<?php esc_attr_e('Öne çıkan görsel', 'blackwhiteblog'); ?>" loading="lazy">
                            <?php endif; ?>
                        </div>
                        <div class="post-content">
                            <h2 class="post-title" itemprop="headline"><a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a></h2>
                            <p class="post-excerpt" itemprop="description"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                            <?php wp_link_pages( array(
                                'before' => '<div class="page-links">' . __('Pages:', 'blackwhiteblog'),
                                'after'  => '</div>',
                            ) ); ?>
                            <div class="author-info" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                                <span class="author-name" itemprop="name"><?php the_author_posts_link(); ?></span>
                                <time class="post-date" datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time>
                            </div>
                        </div>
                    </article>
                <?php
                    $index++;
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>' . __('Henüz içerik bulunamadı.', 'blackwhiteblog') . '</p>';
                endif;
                ?>
            </div>
            <nav class="slider-pagination" aria-label="<?php esc_attr_e('Slider Navigasyonu', 'blackwhiteblog'); ?>">
                <?php for ($i = 0; $i < absint(get_theme_mod('blackwhite_featured_posts_count', 3)); $i++) : ?>
                    <span class="pagination-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-id="<?php echo $i; ?>"></span>
                <?php endfor; ?>
            </nav>
        </div>
    </section>
    <?php endif; ?>
    <?php if (get_theme_mod('blackwhite_pop_capture_outputular_posts_toggle', true)) : ?>
    <section class="popular-posts-section" aria-label="<?php esc_attr_e('Popüler Gönderiler', 'blackwhiteblog'); ?>">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_theme_mod('blackwhite_popular_posts_title', __('Popüler İçerikler', 'blackwhiteblog'))); ?></h2>
            <div class="popular-posts-grid">
                <?php
                $popular_category = get_theme_mod('blackwhite_popular_posts_category', '0');
                $popular_args = array(
                    'posts_per_page' => absint(get_theme_mod('blackwhite_popular_posts_count', 3)),
                    'post_status'    => 'publish',
                    'orderby'        => 'comment_count',
                    'order'          => 'DESC',
                );
                if ($popular_category !== '0') {
                    $popular_args['cat'] = $popular_category;
                    $popular_args['orderby'] = 'date';
                }
                $popular_posts = new WP_Query($popular_args);
                if ($popular_posts->have_posts()) :
                    $post_count = 0;
                    while ($popular_posts->have_posts()) : $popular_posts->the_post();
                        $post_count++;
                        $categories = get_the_category();
                        $first_category = !empty($categories) ? $categories[0]->name : '';
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('popular-post ' . ($post_count === 1 ? 'highlight' : '')); ?> itemscope itemtype="https://schema.org/Article">
                        <div class="popular-post-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php the_post_thumbnail_url($post_count === 1 ? 'large' : 'medium'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                                </a>
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/placeholder.jpg" alt="<?php esc_attr_e('Popüler gönderi görseli', 'blackwhiteblog'); ?>" loading="lazy">
                            <?php endif; ?>
                            <span class="post-categories" itemprop="articleSection"><?php echo esc_html($first_category); ?></span>
                        </div>
                        <div class="popular-post-content">
                            <h3 class="popular-post-title" itemprop="headline"><a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a></h3>
                            <?php wp_link_pages( array(
                                'before' => '<div class="page-links">' . __('Pages:', 'blackwhiteblog'),
                                'after'  => '</div>',
                            ) ); ?>
                            <div class="popular-post-meta">
                                <?php echo get_avatar(get_the_author_meta('ID'), 24); ?>
                                <span class="popular-post-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                    <span itemprop="name"><?php the_author(); ?></span>
                                </span>
                                <time class="popular-post-date" datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time>
                            </div>
                        </div>
                    </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>' . __('Henüz popüler içerik yok.', 'blackwhiteblog') . '</p>';
                endif;
                ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <section class="latest-posts-section" aria-label="<?php esc_attr_e('Son Gönderiler', 'blackwhiteblog'); ?>">
        <div class="container">
            <h2 class="section-title"><?php _e('Son Gönderiler', 'blackwhiteblog'); ?></h2>
            <div class="latest-posts-grid" id="latest-posts-container">
                <?php
                $latest_args = array(
                    'posts_per_page' => 9,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                );
                $latest_posts = new WP_Query($latest_args);
                if ($latest_posts->have_posts()) :
                    while ($latest_posts->have_posts()) : $latest_posts->the_post();
                        $categories = get_the_category();
                        $first_category = !empty($categories) ? $categories[0]->name : '';
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
                            <span class="post-categories" itemprop="articleSection"><?php echo esc_html($first_category); ?></span>
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
                else :
                    echo '<p>' . __('Henüz gönderi yok.', 'blackwhiteblog') . '</p>';
                endif;
                ?>
            </div>
            <button id="load-more-posts" class="load-more-btn" data-offset="9"><?php _e('Daha Fazla Yükle', 'blackwhiteblog'); ?></button>
        </div>
    </section>
</main>
<?php
get_footer();
?>