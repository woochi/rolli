<?php
  $default_footer_text_left = get_bloginfo('name');
  $default_footer_text_right = get_bloginfo('description');
  $default_footer_logo = get_template_directory_uri() . "/images/footer_logo.svg";
  $footer_logo = get_theme_mod('rolli_theme_options[footer_logo]', $default_footer_logo);
  $footer_text_left = get_theme_mod('rolli_theme_options[footer_text_left]', $default_footer_text_left);
  $footer_text_right = get_theme_mod('rolli_theme_options[footer_text_right]', $default_footer_text_right);
?>

			<!-- Sidebar navigation -->
      <footer class="footer">
        <div class="row">
          <div class="colum small-11 medium-10 small-centered small-text-center">
            <img class="footer-logo" url="<?php echo $footer_logo; ?>">
            <?php echo $footer_text_left; ?>
            <span class="show-for-small-only">&mdash;</span>
            <?php echo $footer_text_right; ?>
          </div>
        </div>
      </footer>
		  </main></div> <!-- /content -->
    </div> <!-- /content wrapper -->
    </div> <!-- /wrapper -->

		<?php wp_footer(); ?>
		<script>
    // conditionizr.com
    // configure environment tests
    conditionizr.config({
        assets: '<?php echo get_template_directory_uri(); ?>',
        tests: {}
    });
    </script>

		<!-- analytics -->
		<script>
		(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
		(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
		l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
		ga('send', 'pageview');
		</script>

	</body>
</html>
