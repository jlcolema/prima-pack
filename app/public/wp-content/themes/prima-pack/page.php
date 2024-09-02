<?php get_header(); ?>
<div class="con-wrap">
<div class="container">
	<div class="row pro-wap">
		<div class="col-md-12 pro-dec-wrap">
			<?php 
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();  ?>
			
				<h4 class="title-se"> <?php the_title(); ?> </h4>
				<?php
					the_content();
				} 
			} 
			?>
		</div>
	</div>
</div>
</div>
<?php get_footer(); ?>