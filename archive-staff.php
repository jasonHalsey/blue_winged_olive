<?php
/*
Template Name: archive_staff
*/
  get_header();
?>
<section class="interior_hero river_archive_hero">
</section>
<!-- TODO: Add Backgroungd Image Header -->
<div class="row">   
  <h3 class="page_title"><?php the_title();?></h3>
  <h3 class="page_subtitle">Meet The Team</h3>
</div>
<section class="staff_thumbs">
  <?php
    $staffpost = array( 'post_type' => 'staff','orderby' => 'menu_order');
    $loop = new WP_Query( $staffpost );
  ?>
  <?php while ( $loop->have_posts() ) : $loop->the_post();?>
    <a class="staff_block" href="<?php the_permalink() ?>">
      <img src="<?php echo get_post_meta( $post->ID, '_cmb2_staff_thumb', true ); ?>"/>
      <span class="staff_name"><?php the_title(); ?></span>
      <span class="staff_title"><?php echo get_post_meta( $post->ID, '_cmb2_title', true ); ?></span>
    </a>
  <?php endwhile; ?>
  <?php wp_reset_query(); ?>
</section>
<?php get_footer(); ?>