<?php
/*
Template Name: PS Books
*/
?>
<?php get_header(); ?>

<div id="contentTemplate">

<?php while ( have_posts() ) : the_post(); ?>
<?php $custom = get_post_custom($post->ID); ?>


<h1><?php the_title(); ?></h1>
<img src="<?php echo $custom["psbooks-cover"]; ?>" width="300" height="453" align="right" />
<ul>
	<?php if($custom["psbooks-preface"]) { ?>
	<li><a href="<?php echo $custom["psbooks-preface"]; ?>" target="_blank">Preface</a></li>
	<?php } ?>
	<?php if($custom["psbooks-toc"]) { ?>
	<li><a href="<?php echo $custom["psbooks-toc"]; ?>" target="_blank">Table of Contents</a></li>
	<?php } ?>
</ul>

</div><div id="delimiter"></div>

<?php get_footer(); ?>