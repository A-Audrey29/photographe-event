<footer class="site_footer">

    <?php get_template_part('template-parts/content', 'contact'); ?>

    <?php wp_nav_menu([
        'theme_location' => 'footer',
        'container' => false,
        'menu_class' => 'footer_nav',
    ]);
    ?>
</footer>

<?php wp_footer(); ?>

</body>

</html>