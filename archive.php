<?php
get_header();
?>
<div class="archive-container">
    <div class="breadcrumbs">
        <a href="<?php echo esc_url(home_url()); ?>"><i class="fa-solid fa-house"></i> <?php _e('Anasayfa', 'blackwhiteblog'); ?></a> /
        <span><i class="fa-solid fa-archive"></i> <?php _e('Arşiv:', 'blackwhiteblog'); ?> <?php the_archive_title(); ?></span>
    </div>
    <div class="archive-header">
        <h1 class="archive-title"><?php the_archive_title(); ?></h1>
        <div class="archive-description">
            <?php
            if (is_day()) {
                echo '<p>' . get_the_date('j F Y') . ' ' . __('tarihine ait gönderiler.', 'blackwhiteblog') . '</p>';
            } elseif (is_month()) {
                echo '<p>' . get_the_date('F Y') . ' ' . __('ayına ait gönderiler.', 'blackwhiteblog') . '</p>';
            } elseif (is_year()) {
                echo '<p>' . get_the_date('Y') . ' ' . __('yılına ait gönderiler.', 'blackwhiteblog') . '</p>';
            } else {
                the_archive_description();
            }
            ?>
        </div>
    </div>
    <div class="archive-posts-grid">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                $categories = get_the_category();
                $first_category = !empty($categories) ? $categories[0]->name : '';
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('archive-post-item'); ?> itemscope itemtype="https://schema.org/Article">
                <div class="archive-post-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                        </a>
                    <?php else : ?>
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/placeholder.jpg" alt="<?php esc_attr_e('Arşiv gönderi görseli', 'blackwhiteblog'); ?>" loading="lazy">
                    <?php endif; ?>
                    <span class="post-categories" itemprop="articleSection"><?php echo esc_html($first_category); ?></span>
                </div>
                <div class="archive-post-content">
                    <h2 class="archive-post-title" itemprop="headline"><a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a></h2>
                    <p class="archive-post-excerpt" itemprop="description"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                    <?php wp_link_pages( array(
                        'before' => '<div class="page-links">' . __('Pages:', 'blackwhiteblog'),
                        'after'  => '</div>',
                    ) ); ?>
                    <div class="archive-post-meta">
                        <?php echo get_avatar(get_the_author_meta('ID'), 24); ?>
                        <span class="archive-post-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                            <span itemprop="name"><?php the_author(); ?></span>
                        </span>
                        <time class="archive-post-date" datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="read-more-btn"><?php _e('Devamını Oku', 'blackwhiteblog'); ?></a>
                </div>
            </article>
        <?php
            endwhile;
        else :
            echo '<p>' . __('Bu arşivde henüz gönderi yok.', 'blackwhiteblog') . '</p>';
        endif;
        ?>
    </div>
    <div class="archive-pagination">
        <?php
        the_posts_pagination(array(
            'prev_text' => '<i class="fa-solid fa-chevron-left"></i> ' . __('Geri', 'blackwhiteblog'),
            'next_text' => __('İleri', 'blackwhiteblog') . ' <i class="fa-solid fa-chevron-right"></i>',
            'mid_size'  => 2,
        ));
        ?>
    </div>
</div>
<?php
get_footer();
?>