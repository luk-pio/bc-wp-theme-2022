<footer id="bc-footer">
    <div id="footer-head">
        <div id="footer-bc-logo-container" class="bc-logo-container">
            <span id="bc-logo-berenika" class="bc-logo-part">
                <?php get_template_part("static/icons/Logo", "Berenika.svg"); ?>
            </span>
            <span id="bc-logo-czarnota" class="bc-logo-part">
                <?php get_template_part("static/icons/Logo", "Czarnota.svg"); ?>
        </div>
        <div id="footer-social">
            <a class="social-icon" href="https://www.instagram.com/berenika_cz/">
                <?php get_template_part("static/icons/Icon", "IG.svg"); ?>
            </a>
            <a class="social-icon" href="https://pl-pl.facebook.com/BerenikaCzarnota/">
                <?php get_template_part("static/icons/Icon", "FB.svg"); ?>
            </a>
        </div>
    </div>
    <div id="footer-divider" class="bc-divider"></div>
    <div id="footer-content-container">
        <nav id="footer-nav">
            <?php
            wp_nav_menu(
                array(
                    'menu' => 'footer-menu',
                    'container' => '',
                    'theme_location' => 'footer-menu',
                )
            )
            ?>
        </nav>
        <div id="footer-image-copy-container">
            <div id="footer-image-container" class="<?php echo is_front_page() ? 'hidden' : '' ?>">
                <lottie-player class="footer-image work-in-progress-animation" background="transparent" speed="1" loop
                    autoplay src="<?php echo bc_get_attachment_url_by_slug('work-in-progress') ?>" alt="">
                </lottie-player>
            </div>
            <div id="footer-copy">
                <div id="footer-designed-by"><?php _e("Designed & developed by ", "bc-theme") ?>
                    <a id="wiseculture-url" href="https://www.wiseculture.space/">WiseCulture.Space</a>
                </div>
                <div id="footer-copywrite"><?php _e("© 2022 BERENIKA CZARNOTA", "bc-theme") ?></div>
            </div>
        </div>
    </div>

</footer>

</body>


<?php wp_footer(); ?>
<script>
function showWaitingListAnimation() {
    jQuery('.cwginstock-subscribe-form').after(
        '<lottie-player src="<?php echo bc_get_attachment_url_by_slug('waiting-list') ?>" background="transparent" speed="1" loop autoplay></lottie-player>'
    )

}
showWaitingListAnimation();
</script>

</html>