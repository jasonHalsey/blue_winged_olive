<?php
/*
Template Name: reviews
*/
  get_header();
?>
<section class="interior_hero river_archive_hero">
  
</section>
<!-- TODO: Add Backgroungd Image Header  -->
<div class="row">
  <h3 class="page_title"><?php the_title();?></h3> 
  <h3 class="page_subtitle">Read The Latest From Our Customers</h3>
</div>
<div class="row">  
  <div id='yelpwidget' class="large-4 medium-12 columns review-col">
  </div><!-- End yelpwidget -->
  <div id="testimonials" class="large-4 medium-12 columns review-col">
     <?php
      $mypost = array( 'post_type' => 'testi','orderby' => 'menu_order');
      $loop = new WP_Query( $mypost );
    ?>
    <?php while ( $loop->have_posts() ) : $loop->the_post();?>
      <div class="testimonial-wrap">
        <p class="testimonial_quote"><?php echo get_post_meta( $post->ID, '_cmb2_client_quote', true ); ?></p>
        <p class="testimonial_name">-&nbsp;<?php echo get_post_meta( $post->ID, '_cmb2_client_name', true ); ?></p>
      </div>
    <?php endwhile; ?>

    <?php wp_reset_query(); ?>
  </div><!-- End testimonials -->
  <div id="tripAdvisor" class="large-4 medium-12 columns review-col">
      <div id="TA_selfserveprop730" class="TA_selfserveprop">
        <ul id="DoQOQdIXnd" class="TA_links wDsRncs2">
          <li id="bVXz9wwVD" class="W5Vl8mjUkFep">
            <a target="_blank" href="https://www.tripadvisor.com/"><img src="https://www.tripadvisor.com/img/cdsi/img2/branding/150_logo-11900-2.png" alt="TripAdvisor"/></a>
          </li>
        </ul>
      </div>
      <script src="https://www.jscache.com/wejs?wtype=selfserveprop&amp;uniq=730&amp;locationId=9707255&amp;lang=en_US&amp;rating=true&amp;nreviews=5&amp;writereviewlink=true&amp;popIdx=true&amp;iswide=false&amp;border=true&amp;display_version=2"></script>
  </div><!-- End tripAdvisor -->
</div>

<div class="insta_footer">
  <?php if ( is_active_sidebar( 'instagram_footer_1' ) ) : ?>
          <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
            <?php dynamic_sidebar( 'instagram_footer_1' ); ?>
          </div><!-- #primary-sidebar -->
        <?php endif; ?>
</div>
<?php get_footer(); ?>