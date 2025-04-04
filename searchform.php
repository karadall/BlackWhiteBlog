<?php
/**
 * Custom search form with Font Awesome icon
 */
?>
<form method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text"><?php _e('İçerik Ara', 'blackwhiteblog'); ?></span>
        <input type="search" class="search-field" placeholder="<?php esc_attr_e('İçerik ara...', 'blackwhiteblog'); ?>" value="<?php echo get_search_query(); ?>" name="s" aria-label="<?php esc_attr_e('Arama yap', 'blackwhiteblog'); ?>" />
    </label>
    <button type="submit" class="search-submit" aria-label="<?php esc_attr_e('Ara', 'blackwhiteblog'); ?>"><i class="fas fa-search"></i></button>
</form>