<?php get_header(); ?>
<style>
    .my-slider-container{
        overflow: hidden;
        position:relative;
    }
    .my-slider-container ul{
        position:relative;
    }
    .my-slider-container li{
        list-style: none;
        margin:10px;
        display:inline-block;
        width:150px;
    }
    .my-slider-container li img{
        max-width:100%;
        height:200px;
    }
</style>

<?php get_template_part( "/templates/beforeloop", "index" ); ?>   


<!-- news -->
<?php 

 $args = array(
			'post_type' => 'post',
			'posts_per_page' => 10,
                    'tax_query' => array(
		array(
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => array( '新闻文章' ),
		),

	),
                    
			);
		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();?>
<div><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <?php the_modified_time('Y-m-d');?></div>
<div><?php the_excerpt();?></div>
			<?php	//wc_get_template_part( 'content', 'product' );
			endwhile;
		} else {
			echo __( 'No news found' );
		}
?>
<!-- close news-->
<!-- products-->
<?php 
$args = array(
			'post_type' => 'product',
			'posts_per_page' => 20
			);
		$loop = new WP_Query( $args );
                $slider_count = 0;
		if ( $loop->have_posts() ) {
                    echo '<div class="my-slider-container"><ul>';
			while ( $loop->have_posts() ) : $loop->the_post();?>
			<?php	//wc_get_template_part( 'content', 'product' );
                        if ( has_post_thumbnail() ) {
                        $slider_count++;
			$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
			$image_link  	= get_the_permalink();//wp_get_attachment_url( get_post_thumbnail_id() );
			$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	=> $image_title,
				'alt'	=> $image_title
				) );
echo '<li class="my-slider-item">';
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-my-slider-thumbnail title="%s" data-rel="prettyPhoto">%s</a>', $image_link, $image_caption, $image ), $post->ID );
echo '</li>';
		} else {

			//echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );

		}
			endwhile;
                        echo '</ul></div>';
		} else {
			//echo __( 'No products found' );
		}
?>
<!--close products-->
<script>
jQuery.noConflict();
jQuery(document).ready(function(){
    var slider_index = 0;
    var total_slider = <?php echo isset($slider_count) ? $slider_count : 0;?>;
    if(total_slider){
        setInterval(function(){ 
            slider_index++;
            if(total_slider == slider_index){
                slider_index = 0;
            }
            jQuery('.my-slider-container ul').css('left', -1*slider_index*200);
            //alert(slider_index);
        }, 2000);
    }
});
</script>
	<?php if (0 &&have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

			<?php get_template_part( "/templates/content", "index" ) ?>

		<?php endwhile; ?>

		<?php get_template_part( "pagination", "index" ); ?>
		
	<?php else : ?>

		<?php// get_template_part( "/templates/content", "none" ); ?>

	<?php endif; ?>

<?php get_template_part( "/templates/afterloop", "index" ) ?> 


<?php get_footer(); ?>