<?php
?>
<footer class="site-footer">
    <div class="footer-top">
        <div class="footer-column">
            <h3 class="footer-title"><?php _e('Hakkımızda', 'blackwhiteblog'); ?></h3>
            <p><?php echo esc_html(get_theme_mod('blackwhite_footer_about_text', __('Burası senin siten! Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.', 'blackwhiteblog'))); ?></p>
            <?php if (get_theme_mod('blackwhite_footer_logo_container_toggle', true)) : ?>
            <div class="footer-logo-wrapper">
                <div class="footer-logo-container">
                    <?php
                    if (function_exists('the_custom_logo') && has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/images/placeholder.jpg" alt="' . esc_attr__('Site Logo', 'blackwhiteblog') . '" class="footer-logo">';
                    }
                    ?>
                    <span class="footer-site-name"><?php bloginfo('name'); ?></span>
                </div>
            </div>
            <?php endif; ?>
            <div class="footer-social-links">
                <?php
                $social_platforms = array(
                    'twitter' => 'fa-x-twitter',
                    'instagram' => 'fa-instagram',
                    'facebook' => 'fa-facebook-f'
                );
                foreach ($social_platforms as $key => $icon) {
                    if (get_theme_mod("blackwhite_footer_social_{$key}_toggle", true)) {
                        $url = get_theme_mod("blackwhite_footer_social_{$key}_url", "https://{$key}.com");
                        echo '<a href="' . esc_url($url) . '" target="_blank"><i class="fa-brands ' . esc_attr($icon) . '"></i></a>';
                    }
                }
                ?>
            </div>
        </div>
        <div class="footer-column">
            <h3 class="footer-title"><?php _e('Kategoriler', 'blackwhiteblog'); ?></h3>
            <ul class="footer-links">
                <?php
                $categories = get_categories(array('hide_empty' => 0, 'number' => 5));
                foreach ($categories as $category) {
                    echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
                }
                ?>
            </ul>
        </div>
        <div class="footer-column">
            <h3 class="footer-title"><?php _e('İletişim', 'blackwhiteblog'); ?></h3>
            <ul class="footer-links">
                <li><a href="mailto:<?php echo esc_attr(get_theme_mod('blackwhite_footer_contact_email', 'info@example.com')); ?>">
                    <?php echo esc_html(get_theme_mod('blackwhite_footer_contact_email', 'info@example.com')); ?></a></li>
                <li><a href="tel:<?php echo esc_attr(get_theme_mod('blackwhite_footer_contact_phone', '+90 123 456 78 90')); ?>">
                    <?php echo esc_html(get_theme_mod('blackwhite_footer_contact_phone', '+90 123 456 78 90')); ?></a></li>
                <li><a href="<?php echo esc_url(get_theme_mod('blackwhite_footer_contact_link_url', home_url('/contact'))); ?>">
                    <?php echo esc_html(get_theme_mod('blackwhite_footer_contact_link_text', __('İletişim', 'blackwhiteblog'))); ?></a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>
            <?php echo esc_html(get_theme_mod('blackwhite_footer_copyright_text', '© ' . date('Y') . ' ' . __('Tüm hakları saklıdır.', 'blackwhiteblog'))); ?> 
            <a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('name'); ?></a>
            <?php if (get_theme_mod('blackwhite_footer_wordpress_attribution_toggle', true)) : ?>
                | <?php printf(__('Powered by %s', 'blackwhiteblog'), '<a href="https://wordpress.org/" target="_blank">WordPress</a>'); ?>
            <?php endif; ?>
        </p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>