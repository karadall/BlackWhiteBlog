<?php
get_header();
?>
<div class="tag-container">
    <div class="breadcrumbs">
        <a href="<?php echo esc_url(home_url()); ?>"><i class="fa-solid fa-house"></i> <?php _e('Anasayfa', 'blackwhiteblog'); ?></a> /
        <span><i class="fa-solid fa-tag"></i> <?php single_tag_title(); ?></span>
    </div>
    <div class="tag-header">
        <h1 class="tag-title"><?php single_tag_title(); ?></h1>
        <div class="tag-description">
            <?php 
            if (tag_description()) {
                echo tag_description();
            } else {
                echo '<p>' . single_tag_title('', false) . ' ' . __('Etiketi ile İlgili Paylaşımlar', 'blackwhiteblog') . '</p>';
            }
            ?>
        </div>
    </div>
    <div class="tag-posts-grid">
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'posts_per_page' => 9,
            'post_status'    => 'publish',
            'tag_id'         => get_query_var('tag_id'),
            'paged'          => $paged,
        );
        $tag_query = new WP_Query($args);
        if ($tag_query->have_posts()) :
            while ($tag_query->have_posts()) : $tag_query->the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('tag-post-item'); ?> itemscope itemtype="https://schema.org/Article">
                <div class="tag-post-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                        </a>
                    <?php else : ?>
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/placeholder.jpg" alt="<?php esc_attr_e('Tag gönderi görseli', 'blackwhiteblog'); ?>" loading="lazy">
                    <?php endif; ?>
                    <time class="post-time-ago" datetime="<?php echo get_the_date('c'); ?>"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ' . __('önce', 'blackwhiteblog'); ?></time>
                </div>
                <div class="tag-post-content">
                    <h2 class="tag-post-title" itemprop="headline"><a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a></h2>
                    <p class="tag-post-excerpt" itemprop="description"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                    <?php wp_link_pages( array(
                        'before' => '<div class="page-links">' . __('Pages:', 'blackwhiteblog'),
                        'after'  => '</div>',
                    ) ); ?>
                    <div class="tag-post-meta">
                        <?php echo get_avatar(get_the_author_meta('ID'), 24); ?>
                        <span class="tag-post-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                            <span itemprop="name"><?php the_author(); ?></span>
                        </span>
                        <time class="tag-post-date" datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date(get_option('date_format')); ?></time>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="read-more-btn"><?php _e('Devamını Oku', 'blackwhiteblog'); ?></a>
                </div>
            </article>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>' . __('Bu etiketle henüz gönderi yok.', 'blackwhiteblog') . '</p>';
        endif;
        ?>
    </div>
    <div class="tag-pagination">
        <?php
        the_posts_pagination(array(
            'prev_text' => '<i class="fa-solid fa-chevron-left"></i> ' . __('Geri', 'blackwhiteblog'),
            'next_text' => __('İleri', 'blackwhiteblog') . ' <i class="fa-solid fa-chevron-right"></i>',
            'mid_size'  => 2,
            'total'     => $tag_query->max_num_pages,
        ));
        ?>
    </div>
</div>
<?php
get_footer();
?>