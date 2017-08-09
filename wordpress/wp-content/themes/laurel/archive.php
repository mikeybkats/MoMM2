<?php get_header(); ?>
	
	<div class="archive-box-wrapper">
		<div class="archive-box">
			<?php
				if ( is_day() ) :
					echo wp_kses( __( '<span>Daily Archives:</span>', 'laurel' ), array( 'span' => array( 'class' => array() ) ) );
					
					printf( wp_kses( __( '<h1>%s</h1>', 'laurel' ), array( 'h1' => array( 'class' => array() ) ) ), get_the_date() );

				elseif ( is_month() ) :
				
					
					echo wp_kses( __( '<span>Monthly Archives:</span>', 'laurel' ), array( 'span' => array( 'class' => array() ) ) );
					
					printf( wp_kses( __( '<h1>%s</h1>', 'laurel' ), array( 'h1' => array( 'class' => array() ) ) ), get_the_date( _x( 'F Y', 'monthly archives date format', 'laurel' ) ) );
					

				elseif ( is_year() ) :
					
					echo wp_kses( __( '<span>Yearly Archives:</span>', 'laurel' ), array( 'span' => array( 'class' => array() ) ) );
					
					printf( wp_kses( __( '<h1>%s</h1>', 'laurel' ), array( 'h1' => array( 'class' => array() ) ) ), get_the_date( _x( 'Y', 'yearly archives date format', 'laurel' ) ) );
					

				else :
					echo wp_kses( __( '<h1>Archives:</h1>', 'laurel' ), array( 'h1' => array( 'class' => array() ) ) );

				endif;
			?>
		</div>
	</div>
	
	<div class="sp-container">
		
		<div class="sp-row">
			
			<div id="main" <?php if(get_theme_mod('laurel_sidebar_archive') == true) : ?>class="fullwidth"<?php endif; ?>>
			
				<div class="sp-row post-layout <?php if(get_theme_mod('laurel_archive_layout') == 'full_grid') : ?>full-grid<?php elseif(get_theme_mod('laurel_archive_layout') == 'grid') : ?>grid<?php endif; ?>">
				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
					<?php if(get_theme_mod('laurel_archive_layout') == 'grid') : ?>
						
						<?php get_template_part('content', 'grid'); ?>
					
					<?php elseif(get_theme_mod('laurel_archive_layout') == 'full_grid') : ?>
					
						<?php if( $wp_query->current_post == 0 && !is_paged() ) : ?>
							<?php get_template_part('content'); ?>
						<?php else : ?>
							<?php get_template_part('content', 'grid'); ?>
						<?php endif; ?>
					
					<?php elseif(get_theme_mod('laurel_archive_layout') == 'list') : ?>
					
						<?php get_template_part('content', 'list'); ?>
						
					<?php elseif(get_theme_mod('laurel_archive_layout') == 'full_list') : ?>
					
						<?php if( $wp_query->current_post == 0 && !is_paged() ) : ?>
							<?php get_template_part('content'); ?>
						<?php else : ?>
							<?php get_template_part('content', 'list'); ?>
						<?php endif; ?>
					
					<?php else : ?>
						
						<?php get_template_part('content'); ?>
						
					<?php endif; ?>	
				
				<?php endwhile; ?>
				
					<?php laurel_pagination(); ?>
				
				<?php endif; ?>
				
				<!-- END POST LAYOUT ROW -->
				</div>
			
			</div>

<?php if(get_theme_mod('laurel_sidebar_archive')) : else : ?><?php get_sidebar(); ?><?php endif; ?>
<?php get_footer(); ?>