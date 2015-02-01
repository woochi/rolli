<?php
  $default_footer_text_left = get_bloginfo('name');
  $default_footer_text_right = get_bloginfo('description');
  $default_footer_logo = get_template_directory_uri() . "/images/footer_logo.svg";
  $footer_logo = get_theme_mod('rolli_footer_logo', $default_footer_logo);
  $footer_text_left = get_theme_mod('rolli_theme_options[footer_text_left]', $default_footer_text_left);
  $footer_text_right = get_theme_mod('rolli_theme_options[footer_text_right]', $default_footer_text_right);
?>

			<!-- Sidebar navigation -->
      <footer class="footer">
        <div class="footer-content">
          <div class="column small-11 small-centered text-center">
            <div class="footer-logo-wrapper">
              <img class="footer-logo" src="<?php echo $footer_logo; ?>">
            </div>
            <div class="footer-tagline">
              <?php echo $footer_text_left; ?>
              &mdash;
              <?php echo $footer_text_right; ?>
            </div>
          </div>
        </div>
      </footer>
		  </main></div> <!-- /content -->
    </div> <!-- /content wrapper -->
    </div> <!-- /wrapper -->

		<?php wp_footer(); ?>
		<script>
      head.load("http://code.jquery.com/jquery-2.1.3.min.js")
      head.load('<?php echo script_uri("theme.js") ?>');
    </script>
	</body>
</html>
