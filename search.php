<?php
get_header();
?>
<div class="search-container">
    <div class="breadcrumbs">
        <a href="<?php echo esc_url(home_url()); ?>"><i class="fa-solid fa-house"></i> <?php _e('Anasayfa', 'blackwhiteblog'); ?></a> /
        <span><i class="fa-solid fa-magnifying-glass"></i> <?php _e('Arama:', 'blackwhiteblog'); ?> "<?php echo get_search_query(); ?>"</span>
    </div>
    <section class="search-section">
        <div class="container">
            <?php get_search_form(); ?>
        </div>
    </section>
    <div class="search-header">
        <h1 class="search-title"><?php _e('Arama Sonuçları:', 'blackwhiteblog'); ?> "<?php echo get_search_query(); ?>"</h1>
        <div class="search-info">
            <?php
            global $wp_query;
            $total_results = $wp_query->found_posts;
            if ($total_results > 0) {
                echo '<p>' . $total_results . ' ' . __('sonuç bulundu.', 'blackwhiteblog') . '</p>';
            } else {
                echo '<p>' . __('Aramanızla eşleşen bir sonuç bulunamadı.', 'blackwhiteblog') . '</p>';
            }
            ?>
        </div>
    </div>
    <div class="search-results-grid">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?> itemscope itemtype="https://schema.org/Article">
                <div class="search-result-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                        </a>
                    <?php else : ?>
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/placeholder.jpg" alt="<?php esc_attr_e('Arama sonucu görseli', 'blackwhiteblog'); ?>" loading="lazy">
                    <?php endif; ?>
                </div>
                <div class="search-result-content">
                    <h2 class="search-result-title" itemprop="headline"><a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a></h2>
                    <p class="search-result-excerpt" itemprop="description"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                    <?php wp_link_pages( array(
                        'before' => '<div class="page-links">' . __('Pages:', 'blackwhiteblog'),
                        'after'  => '</div>',
                    ) ); ?>
                    <div class="search-result-meta">
                        <?php echo get_avatar(get_the_author_meta('ID'), 24); ?>
                        <span class="search-result-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                            <span itemprop="name"><?php the_author(); ?></span>
                        </span>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="read-more-btn"><?php _e('Devamını Oku', 'blackwhiteblog'); ?></a>
                </div>
            </article>
        <?php
            endwhile;
        else :
            echo '<p>' . __('Üzgünüz, aramanıza uygun bir içerik bulamadık. Lütfen başka bir kelimeyle tekrar deneyin.', 'blackwhiteblog') . '</p>';
        endif;
        ?>
    </div>
    <div class="search-pagination">
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