<?php
/*
Template Name: staff_single
*/
  get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
  <?php if ( is_single() ) : ?>
     <section class="module parallax parallax-1" style="background-image: url(<?php 
         $url = get_post_meta( $post->ID, '_cmb2_staff_image', true ); 
         echo $url;
        ?>)">
        <div class="container">
          <h1><?php the_title() ?></h1>
        </div>
     </section>
<div class="row">  
    <div class="large-3 medium-3 columns thumb_col">
      <img src="<?php echo get_post_meta( $post->ID, '_cmb2_staff_thumb', true ); ?>"/>
    </div>
    <div class="large-9 medium-9 columns bio_col">
      <h1><?php the_title() ?></h1>
      <p class="bio_block"><?php echo get_post_meta( $post->ID, '_cmb2_bio', true ); ?></p>
    </div>
  <?php endif; // is_single() ?>
 <?php endwhile; ?>
</div>

<?php get_footer(); ?>