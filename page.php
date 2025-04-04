<?php
get_header();
?>
<div class="page-container">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
        <div class="breadcrumbs">
            <a href="<?php echo esc_url(home_url()); ?>"><i class="fa-solid fa-house"></i> <?php _e('Anasayfa', 'blackwhiteblog'); ?></a> /
            <span><i class="fa-solid fa-file-lines"></i> <?php the_title(); ?></span>
        </div>
        <div class="page-content">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <div class="page-meta">
                <span class="page-date"><?php _e('Son Güncelleme:', 'blackwhiteblog'); ?> <time datetime="<?php echo get_the_modified_date('c'); ?>"><?php echo get_the_modified_date('d.m.Y'); ?></time></span>
                <div class="page-share-buttons">
                    <span class="share-label"><i class="fa-solid fa-share-nodes"></i> <?php _e('Paylaş', 'blackwhiteblog'); ?></span>
                    <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://api.whatsapp.com/send?text=<?php the_title(); ?> <?php the_permalink(); ?>" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                    <button class="copy-link" data-link="<?php the_permalink(); ?>"><i class="fa-solid fa-link"></i></button>
                </div>
            </div>
            <hr class="page-divider">
            <div class="page-image">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large'); ?>
                <?php else : ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/placeholder.jpg" alt="<?php esc_attr_e('Placeholder', 'blackwhiteblog'); ?>">
                <?php endif; ?>
            </div>
            <hr class="page-divider">
            <div class="page-text">
                <?php 
                the_content();
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . __('Pages:', 'blackwhiteblog'),
                    'after'  => '</div>',
                ) );
                ?>
            </div>
        </div>
        <div class="page-notification" id="copy-notification"><?php _e('Link kopyalandı!', 'blackwhiteblog'); ?></div>
    <?php
        endwhile;
    else :
        echo '<p>' . __('İçerik bulunamadı.', 'blackwhiteblog') . '</p>';
    endif;
    ?>
</div>
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
<?php
get_footer();
?>