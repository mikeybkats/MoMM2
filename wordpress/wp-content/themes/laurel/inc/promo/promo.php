<div id="promo-area">

	<div class="feat-line"></div>

	<div class="sp-container subscribe-promo">

		<div class="sp-row">

			<?php if(get_theme_mod('laurel_promo1_title') || get_theme_mod('laurel_promo1_image')) : ?>
			<div class="sp-col-12">
				<div class="promo-item" style="background-image:url(<?php if(get_theme_mod('laurel_promo1_image')) { echo get_theme_mod('laurel_promo1_image'); } else { echo get_template_directory_uri() . '/img/slider-default.png'; } ?>)">
					<?php if(get_theme_mod('laurel_promo1_url')) : ?><a href="<?php echo esc_url(get_theme_mod('laurel_promo1_url')); ?>" class="promo-link"></a><?php endif; ?>
					<div class="promo-overlay">
						<?php if(get_theme_mod('laurel_promo1_title')) : ?>
						<h4><?php echo wp_kses_post(get_theme_mod('laurel_promo1_title')); ?></h4>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>

	</div>

</div>
