<?php
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header class="site-header" itemscope itemtype="https://schema.org/WPHeader">
        <div class="container">
            <div class="header-inner">
                <div class="site-branding">
                    <?php if (get_theme_mod('blackwhite_header_logo_toggle', true) && has_custom_logo()) : ?>
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                        $logo_url = $logo[0];
                        ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="custom-logo-link" rel="home" itemprop="url">
                            <img src="<?php echo esc_url($logo_url); ?>" class="site-logo" alt="<?php bloginfo('name'); ?>" itemprop="logo" loading="lazy">
                        </a>
                    <?php endif; ?>
                    <?php if (get_theme_mod('blackwhite_header_site_title_toggle', true)) : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title" rel="home" itemprop="url"><?php bloginfo('name'); ?></a>
                    <?php endif; ?>
                </div>
                <?php if (get_theme_mod('blackwhite_header_menu_toggle', true)) : ?>
                <nav class="main-navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Menüyü Aç', 'blackwhiteblog'); ?>">
                        <i class="fas fa-bars"></i>
                    </button>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary-menu',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'menu_class'     => 'nav-menu',
                        'fallback_cb'    => false,
                        'depth'          => 2,
                    ));
                    ?>
                    <?php if (get_theme_mod('blackwhite_header_dark_mode_toggle', true)) : ?>
                    <div class="dark-mode-container">
                        <button class="dark-mode-toggle" aria-label="<?php esc_attr_e('Karanlık Modu Aç/Kapat', 'blackwhiteblog'); ?>">
                            <i class="fas fa-moon"></i>
                        </button>
                    </div>
                    <?php endif; ?>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </header>