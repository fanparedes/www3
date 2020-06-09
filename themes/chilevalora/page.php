<?php
	get_header(); 

	global $post;
?>
<?php
	while ( have_posts() ) : the_post();
?>
<div class="bloque-titular">
    <div class="container">
        <h1><?php the_title(); ?></h1>
       
    </div>
</div>
<style type="text/css">
	.content_justify p, .content_justify ul{
		text-align: justify !important;
	}
</style>
<div class="container">
    <div class="row">
        <!-- BLOQUE TEXTO -->
        <div class="col-12 content_justify" >
<?php
		
			the_content();
?>
			</div>
	</div>
</div>
<?php
       
    endwhile;
			?>



<?php
	get_footer();
?>