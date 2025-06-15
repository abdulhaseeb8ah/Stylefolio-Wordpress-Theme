<?php
/**
 * Theme Header Template
 * 
 * Displays the HTML head section and opening body tags.
 * Contains the site header with logo and navigation menu.
 *
 * @package Stylefolio
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary">
        <?php esc_html_e( 'Skip to content', 'portfolio-pro' ); ?>
    </a>

    <header id="masthead" class="site-header">
        <div class="header-container">
            <div class="site-branding">
                <?php
                if ( has_custom_logo() ) :
                    the_custom_logo();
                else :
                ?>
                    <div class="site-title-wrapper">
                        <h1 class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </h1>
                    </div>
                <?php endif; ?>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="menu-toggle-icon"></span>
                    <span class="menu-toggle-icon"></span>
                    <span class="menu-toggle-icon"></span>
                </button>
                  <div class="mobile-menu">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'menu_class'     => 'nav-menu',
                            'container'      => false,
                            'fallback_cb'    => 'portfolio_pro_fallback_menu',
                        )
                    );
                    ?>
                </div>
            </nav><!-- #site-navigation -->
        </div><!-- .header-container -->
    </header><!-- #masthead -->