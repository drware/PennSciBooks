<?php
/*
* @package: WordPress
* @subpackage: PennSci
* @since 2012 v1.0
*/
?>
<?php get_header(); ?>

<div id="contentTemplate">
<?php global $post; ?>
<?php $custom = get_post_custom($post->ID); ?>

<div id="book" style="width:600px; margin: auto;">
<h2><?php the_title(); ?></h2>
<img src="<?php echo $custom["psbooks-cover"][0]; ?>" width="240" height="362" align="right" />
<ul>
	<?php if($custom["psbooks-preface"][0]) { ?>
	<li><a href="<?php echo $custom["psbooks-preface"][0]; ?>" target="_blank">Preface</a></li>
	<?php } ?>
	<?php if($custom["psbooks-toc"][0]) { ?>
	<li><a href="<?php echo $custom["psbooks-toc"][0]; ?>" target="_blank">Table of Contents</a></li>
	<?php } ?>
</ul>
</div>

</div><div id="delimiter"></div>

<?php get_footer(); ?>