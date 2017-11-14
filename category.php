<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>












<?php
		$aa = 0;
		$pData = [];
while ( have_posts() ) : the_post();
	$aa= $aa + 1;
	$pData[$aa]['title']  = get_the_title();
	$pData[$aa]['link']  = get_the_permalink();
	$pData[$aa]['desc'] = get_the_excerpt();
	if($aa == 1){
	$pData[$aa]['image']  = '<img src="' . get_the_post_thumbnail_url() . '" width="680" height="470">';//get_the_post_thumbnail($post,'post-thumbnail');
	}else{

		$pData[$aa]['image']  = '<img src="' . get_the_post_thumbnail_url() . '" width="345" height="218">';//get_the_post_thumbnail($post,'post-thumbnail');

	}
?>	

<?php endwhile; ?>
<div class="page-container">		
	 <div class="row">
     		<div class="col-sm-12">
            	<h1 class="main_heading">
                	TRIARC Blog
                </h1>
            </div>
			<div class="col-sm-8 main_slide">
				
				<a href="<?php echo $pData[1]['link'] ?>"><?php echo $pData[1]['image'];?></a>
				<div class="img-text">
					<div class="category_name">Category Name</div>
					<div class="heading"><?php echo $pData[1]['title']?></div>
					<div class="desc"><?php echo wp_trim_words(  $pData[1]['desc'], 40, '...' );
;?></div>
				
		</div>
			</div>	
			<div class="col-sm-4 text-left">
				<div class="row">
					<div class="col-sm-12">
						<a href="<?php echo $pData[2]['link'] ?>"><?php echo $pData[2]['image'];?></a>
							<?php if(isset($pData[2]['link'])){?>
							<div class="img-text">
								
													<div class="category_name">Category Name</div>
					<div class="heading"><?php echo $pData[2]['title']?></div>
				
							</div>
							<?php }?>
					</div>

				</div>
				<div class="row thrid-footer">
					<div class="col-sm-12">
					<a href="<?php echo $pData[3]['link'] ?>"><?php echo $pData[3]['image'];?></a>
<?php if(isset($pData[3]['link'])){?>
						<div class="img-text">
							
							<div class="category_name">Category Name</div>
					<div class="heading"><?php echo $pData[3]['title']?></div>
				
					</div>
					<?php }?>
				</div>

				</div>

			</div>			

	</div>
<br>
	<div class="row">

		<div class="col-sm-4 left_side_main">
			<a href="<?php echo $pData[4]['link'] ?>"><?php echo $pData[4]['image'];?></a>
<?php if(isset($pData[4]['link'])){?>
<div class="img-text">
					<div class="category_name">Category Name</div>
					<div class="heading"><?php echo $pData[4]['title']?></div>
					
				</div>
				<?php }?>

		</div>
		<div class="col-sm-4 left_side_main">
			<a href="<?php echo $pData[5]['link'] ?>"><?php echo $pData[5]['image'];?></a>
<?php if(isset($pData[5]['link'])){?>

<div class="img-text">
					
					<div class="category_name">Category Name</div>
					<div class="heading"><?php echo $pData[5]['title']?></div>
				
				</div>
<?php }?>
		</div>
		<div class="col-sm-4 left_side_main">
			<a href="<?php echo $pData[6]['link'] ?>"><?php echo $pData[6]['image'];?></a>
<?php if(isset($pData[6]['link'])){?>

<div class="img-text">
					
					<div class="category_name">Category Name</div>
					<div class="heading"><?php echo $pData[6]['title']?></div>
					
				</div>
				<?php }?>

		</div>	
	</div> 


	
	<br>

<div class="row">
	<div class="col-sm-8 post-section">



		<?php 
	
		$filter['posts_per_page'] = 10;

			
			$q = new WP_Query($filter);
			$aa = 0;
				 while ( have_posts() ) : the_post();

				 	$aa = $aa + 1;
					
				//while ( have_posts() ) : the_post();
				 	if($aa > 6){
		?>
		<div class="row">
				<div class="col-sm-4 post-scection_image">
					<a href="<?php the_permalink() ?>">

					<img src="<?php echo get_the_post_thumbnail_url();?>" width="240" height="150">
				</a>
				</div>
				<div class="col-sm-8">
									<div class="row">
                                            <div class="col-lg-12">
                                                <div class="cat-name">CATEGORY NAME</div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="blog-headline mrgn-botm-10">

                                                	<a href="<?php the_permalink() ?>"><?php the_title()?></a></div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="blog-text"><?php echo wp_trim_words(  get_the_excerpt(), 40, '...' ) ;?></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
				</div>
				

		</div>
		<div class="dvd">
			<hr >
		</div>
		<?php 
}
		endwhile; ?>
	</div>
	<div class="col-sm-4">
		<div class="cat-section">

<div class="col-lg-12">
                                <div class="row blog-right-box">
                                    <div class="col-lg-12 cat-name mrgn-top-10">CATEGORYIES</div>
                                </div>
                            </div>
<?php

$categories =  get_categories();  
foreach  ($categories as $category) {
	
	$category_link = get_category_link( $category->term_id )

?>
                            <div class="col-lg-12">
                                <div class="row blog-right-box">
                                    <div class="col-lg-12">
                                        <div class="blog-headline-right mrgn-botm-10">
										<a href="<?php echo $category_link?>">	
                                        	<?php echo $category->name?></a></div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="blog-text mrgn-botm-45"><?php echo $category->description;?></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <?php }?>


		</div>

	</div>
</div>
</div>

<?php get_footer(); ?>
