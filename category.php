<?php
get_header();
?>
<div class="category-container">
    <div class="breadcrumbs">
        <a href="<?php echo esc_url(home_url()); ?>"><i class="fa-solid fa-house"></i> <?php _e('Anasayfa', 'blackwhiteblog'); ?></a> /
        <span><i class="fa-solid fa-layer-group"></i> <?php single_cat_title(); ?></span>
    </div>
    <div class="category-header">
        <h1 class="category-title"><?php single_cat_title(); ?></h1>
        <div class="category-description">
            <?php 
            if (category_description()) {
                echo category_description();
            } else {
                echo '<p>' . single_cat_title('', false) . ' ' . __('Kategorisinden Paylaşımlar', 'blackwhiteblog') . '</p>';
            }
            ?>
        </div>
    </div>
    <div class="category-posts-grid">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('category-post-item'); ?> itemscope itemtype="https://schema.org/Article">
                <div class="category-post-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                        </a>
                    <?php else : ?>
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/placeholder.jpg" alt="<?php esc_attr_e('Kategori gönderi görseli', 'blackwhiteblog'); ?>" loading="lazy">
                    <?php endif; ?>
                    <time class="post-time-ago" datetime="<?php echo get_the_date('c'); ?>"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ' . __('önce', 'blackwhiteblog'); ?></time>
                </div>
                <div class="category-post-content">
                    <h2 class="category-post-title" itemprop="headline"><a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a></h2>
                    <p class="category-post-excerpt" itemprop="description"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                    <?php wp_link_pages( array(
                        'before' => '<div class="page-links">' . __('Pages:', 'blackwhiteblog'),
                        'after'  => '</div>',
                    ) ); ?>
                    <div class="category-post-meta">
                        <?php echo get_avatar(get_the_author_meta('ID'), 24); ?>
                        <span class="category-post-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                            <span itemprop="name"><?php the_author(); ?></span>
                        </span>
                        <time class="category-post-date" datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="read-more-btn"><?php _e('Devamını Oku', 'blackwhiteblog'); ?></a>
                </div>
            </article>
        <?php
            endwhile;
        else :
            echo '<p>' . __('Bu kategoride henüz gönderi yok.', 'blackwhiteblog') . '</p>';
        endif;
        ?>
    </div>
    <div class="category-pagination">
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