			
			<!-- END ROW -->
			</div>
			
		<!-- END CONTAINER -->
		</div>
		
		<footer id="footer">

<div class="row footer-toprow">
  <div class="col-sm-4 col-xs-12">
    <h3>About MoMM</h3>
    <p>Methods of a Modern Male is a lifestyle blog focused on everything millennial men need to live a happier, healthier life. Think of us as your trendy friend in LA who’s in the know about everything from fashion to fitness, but still comes back home to bro down with the boys on the weekends. Straight talk on the things that matter to help make the weird transition to adulthood a little easier. <br/><br/>
<a href=""><span class="underline-link">Learn about us</span></a>
</p>
  </div>
  <div class="col-sm-2 col-xs-12"></div>
  <div class="col-sm-2 col-xs-12">
    <a href=""><h3>Contact</h3></a>
  </div>
  <div class="col-sm-2 col-xs-12">
    <a href=""><h3>Contribute</h3></a>
    <ul>
      <li><a href="">Current & Past Contributors</a></li>
      <li><a href="">Become a Contributor</a></li>
    </ul>
  </div>
  <div class="col-sm-2 col-xs-12">
    <h3><a>Advertise</a></h3>
  </div>
</div>

<div class="row footer-bottomrow">
  <div class="col-sm-4 col-xs-12"><a href=""></a></div>
  <div class="col-sm-2 col-xs-12"><a href="">Site Map</a></div>
  <div class="col-sm-2 col-xs-12"><a href="">Privacy Policy</a></div>
  <div class="col-sm-2 col-xs-12"><a href="">Terms of Use</a></div>
  <div class="col-sm-2 col-xs-12"><p>Copyright 2017</p></div>
</div>

			<div id="ig-footer">
				<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('sidebar-2') ) ?>
			</div>
			
			<?php if(!get_theme_mod('laurel_footer_share')) : ?>
			<div class="container">
				
				<div id="footer-social">
					
					<?php if(get_theme_mod('laurel_facebook')) : ?><a href="http://facebook.com/<?php echo esc_html(get_theme_mod('laurel_facebook')); ?>" target="_blank"><i class="fa fa-facebook"></i> <span><?php esc_html_e( 'Facebook', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_twitter')) : ?><a href="http://twitter.com/<?php echo esc_html(get_theme_mod('laurel_twitter')); ?>" target="_blank"><i class="fa fa-twitter"></i> <span><?php esc_html_e( 'Twitter', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_instagram')) : ?><a href="http://instagram.com/<?php echo esc_html(get_theme_mod('laurel_instagram')); ?>" target="_blank"><i class="fa fa-instagram"></i> <span><?php esc_html_e( 'Instagram', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_pinterest')) : ?><a href="http://pinterest.com/<?php echo esc_html(get_theme_mod('laurel_pinterest')); ?>" target="_blank"><i class="fa fa-pinterest"></i> <span><?php esc_html_e( 'Pinterest', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_bloglovin')) : ?><a href="http://bloglovin.com/<?php echo esc_html(get_theme_mod('laurel_bloglovin')); ?>" target="_blank"><i class="fa fa-heart"></i> <span><?php esc_html_e( 'Bloglovin', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_google')) : ?><a href="http://plus.google.com/<?php echo esc_html(get_theme_mod('laurel_google')); ?>" target="_blank"><i class="fa fa-google-plus"></i> <span><?php esc_html_e( 'Google +', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_tumblr')) : ?><a href="http://<?php echo esc_html(get_theme_mod('laurel_tumblr')); ?>.tumblr.com/" target="_blank"><i class="fa fa-tumblr"></i> <span><?php esc_html_e( 'Tumblr', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_youtube')) : ?><a href="http://youtube.com/<?php echo esc_html(get_theme_mod('laurel_youtube')); ?>" target="_blank"><i class="fa fa-youtube-play"></i> <span><?php esc_html_e( 'Youtube', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_dribbble')) : ?><a href="http://dribbble.com/<?php echo esc_html(get_theme_mod('laurel_dribbble')); ?>" target="_blank"><i class="fa fa-dribbble"></i> <span><?php esc_html_e( 'Dribbble', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_soundcloud')) : ?><a href="http://soundcloud.com/<?php echo esc_html(get_theme_mod('laurel_soundcloud')); ?>" target="_blank"><i class="fa fa-soundcloud"></i> <span><?php esc_html_e( 'Soundcloud', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_vimeo')) : ?><a href="http://vimeo.com/<?php echo esc_html(get_theme_mod('laurel_vimeo')); ?>" target="_blank"><i class="fa fa-vimeo-square"></i> <span><?php esc_html_e( 'Vimeo', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_linkedin')) : ?><a href="<?php echo esc_html(get_theme_mod('laurel_linkedin')); ?>" target="_blank"><i class="fa fa-linkedin"></i> <span><?php esc_html_e( 'Linkedin', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_snapchat')) : ?><a href="http://snapchat.com/add/<?php echo esc_html(get_theme_mod('laurel_soundcloud')); ?>" target="_blank"><i class="fa fa-snapchat-ghost"></i> <span><?php esc_html_e( 'Snapchat', 'laurel' ); ?></span></a><?php endif; ?>
					<?php if(get_theme_mod('laurel_rss')) : ?><a href="<?php echo esc_url(get_theme_mod('laurel_rss')); ?>" target="_blank"><i class="fa fa-rss"></i> <span><?php esc_html_e( 'RSS', 'laurel' ); ?></span></a><?php endif; ?>
					
				</div>
				
			</div>
			<?php endif; ?>
			
		</footer>
		
		<div id="footer-bottom">
			
			<div class="container">
				
				<div class="copyright">
					<p><?php echo wp_kses_post(get_theme_mod('laurel_footer_copyright_text', '&copy; Copyright 2016 - Solo Pine. All Rights Reserved. Designed & Developed by <a href="http://solopine.com">Solo Pine</a>')); ?></p>
				</div>
				
			</div>
			
		</div>	
		
	<!-- END INNER WRAPPER -->
	</div>
		
	<!-- END WRAPPER -->
	</div>
	
	
	<?php wp_footer(); ?>
	
</body>

</html>
