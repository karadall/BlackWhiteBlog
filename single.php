<?php get_header(); ?>
<div class="single-post-container">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?> itemscope itemtype="https://schema.org/Article">
            <?php if (get_theme_mod('blackwhite_single_breadcrumbs_toggle', true)) : ?>
            <div class="breadcrumbs">
                <a href="<?php echo esc_url(home_url()); ?>"><i class="fa-solid fa-house"></i> <?php _e('Anasayfa', 'blackwhiteblog'); ?></a> /
                <?php
                $categories = get_the_category();
                if (!empty($categories)) {
                    $primary_category = $categories[0];
                    echo '<a href="' . esc_url(get_category_link($primary_category->term_id)) . '"> <i class="fa-solid fa-layer-group"></i> ' . esc_html($primary_category->name) . '</a>';
                }
                ?> /
                <span><i class="fa-solid fa-newspaper"></i> <?php the_title(); ?></span>
            </div>
            <?php endif; ?>
            <div class="single-post-content">
                <div class="single-post-categories"><?php the_category(' '); ?></div>
                <h1 class="single-post-title"><?php the_title(); ?></h1>
                <div class="single-post-meta">
                    <span class="single-author-info">
                        <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                        <span class="single-author-name"><?php the_author_posts_link(); ?></span>
                    </span>
                    <span class="single-post-date"><?php echo get_the_date('d.m.Y'); ?></span>
                </div>
                <?php if (get_theme_mod('blackwhite_single_share_buttons_toggle', true)) : ?>
                <div class="single-share-buttons">
                    <span class="share-label"><i class="fa-solid fa-share-nodes"></i> <?php _e('Paylaş', 'blackwhiteblog'); ?></span>
                    <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://api.whatsapp.com/send?text=<?php the_title(); ?> <?php the_permalink(); ?>" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                    <button class="copy-link" data-link="<?php the_permalink(); ?>"><i class="fa-solid fa-link"></i></button>
                </div>
                <?php endif; ?>
                <hr class="single-divider">
                <?php if (get_theme_mod('blackwhite_single_thumbnail_toggle', true)) : ?>
                <div class="single-post-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large'); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/placeholder.jpg" alt="<?php esc_attr_e('Placeholder', 'blackwhiteblog'); ?>">
                    <?php endif; ?>
                </div>
                <hr class="single-divider">
                <?php endif; ?>
                <div class="single-content">
                    <?php
                    if (post_password_required()) {
                        echo get_the_password_form();
                    } else {
                        the_content();
                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . __('Pages:', 'blackwhiteblog'),
                            'after'  => '</div>',
                        ) );
                    }
                    ?>
                </div>
                <hr class="single-divider">
                <?php if (get_theme_mod('blackwhite_single_tags_toggle', true)) : ?>
                <div class="single-post-tags">
                    <?php the_tags('<span class="tags-label"><i class="fa-solid fa-tags"></i> ' . __('Etiketler:', 'blackwhiteblog') . ' </span>', ', ', ''); ?>
                </div>
                <?php endif; ?>
            </div>
            <?php if (get_theme_mod('blackwhite_single_comments_toggle', true)) : ?>
            <div class="single-comments-section">
                <?php
                if (!post_password_required() && (comments_open() || get_comments_number())) :
                    comments_template();
                endif;
                ?>
            </div>
            <?php endif; ?>
            <div class="single-notification" id="copy-notification"><?php _e('Link kopyalandı!', 'blackwhiteblog'); ?></div>
        </article>
    <?php
        endwhile;
    else :
        echo '<p>' . __('İçerik bulunamadı.', 'blackwhiteblog') . '</p>';
    endif;
    ?>
</div>
<?php if (get_theme_mod('blackwhite_single_share_buttons_toggle', true)) : ?>
<script>
    document.querySelector('.copy-link').addEventListener('click', function() {
        const link = this.getAttribute('data-link');
        navigator.clipboard.writeText(link).then(() => {
            const notification = document.getElementById('copy-notification');
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 2000);
        });
    });
</script>
<?php endif; ?>
<?php get_footer(); ?>