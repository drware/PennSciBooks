<?
/*
Plugin Name: PennSci Books
Plugin URI: none
Description: Allows for book listings
Author: David Ware (drw48@pitt.edu)
Version: 1.0
Author URI: http://www.davidrware.com/
*/

// Include the helper functions
//include_once("ps_functions.php");

if(!class_exists("PSBooks")) {
	class PSBooks {
		var $meta_fields = array("psbooks-price","psbooks-preface","psbooks-toc","psbooks-cover");		
		// Definition of custom post type
		function __construct() {
			register_post_type('book',
			array('label'=>_x('Books','books label'),
				'singular_label' => _x('Book','books singular label'),
				'public' => true,
				'show_ui' => true,
				'_builtin' => false,
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => array("slug" => "book"),
				'query_var' => "book",
				'supports' => array("title")));
			//add_filter("manage_edit-books_columns",array(&$this,"edit_columns"));
			//add_action("manage_posts_custom_column",array(&$this,"custom_columns"))
			add_action("admin_init", array(&$this, "admin_init"));
			add_action("template_redirect", array(&$this,'template_redirect'));
			add_action("wp_insert_post", array(&$this,"wp_insert_post"),10,2);
		}		
		//function edit_columns($columns) {
		//	$columns = array(
		//	'cb' => '<input type="checkbox" />',
		//	'title' => _x("Book Title","book title label for edit columns")
		//	);
		//}		
		//function custom_columns($column) {
		//	global $post;
			//switch($column) {
			//	case "psbooks_title"
		//}		
		function template_redirect() {
			global $wp;
			
			if(isset($wp->query_vars["post_type"])) {
				if($wp->query_vars["post_type"] == "book") {
					include WP_PLUGIN_DIR.'/psbooks/psbooks-template.php';
					die();
				}
			}
		}
		function wp_insert_post($post_id, $post = null) {
			if($post->post_type == "book") {
				foreach ($this->meta_fields as $key) {
					$value = $_POST[$key];
					if(empty($value)) {
						delete_post_meta($post_id, $key);
						continue;
					}

					if(!is_array($value)) {
						if(!update_post_meta($post_id, $key, $value)) {
							add_post_meta($post_id, $key, $value);
						}
					} else {
						delete_post_meta($post_id, $key);
						foreach ($value as $entry){
							add_post_meta($post_id, $key, $entry);
						}
					}
				}
			}
		}
		function admin_init() {
			add_meta_box("psbook-meta","Book Information",array(&$this,"meta_options"),"book","normal","core");
		}
		function meta_options() {
			global $post;
			$custom = get_post_custom($post->ID);
			
			if($custom["psbooks-price"][0]) {
				$psbooks_price = $custom["psbooks-price"][0];
			} else { $psbooks_price = ''; }
			
			if($custom["psbooks-preface"][0]) {
				$psbooks_preface = $custom["psbooks-preface"][0];
			} else { $psbooks_preface = ''; }
			
			if($custom["psbooks-toc"][0]) {
				$psbooks_toc = $custom["psbooks-toc"][0];
			} else { $psbooks_toc = ''; }
			
			if($custom["psbooks-cover"][0]) {
				$psbooks_cover = $custom["psbooks-cover"][0];
			} else { $psbooks_cover = ''; }
			?>
			<label><?php _ex('Price:','price label'); ?></label><input name="psbooks-price" value="<?php echo $psbooks_price; ?>" /><br />
			<em><?php _ex('(e.g. $39.99)','pricing example'); ?></em><br /><br />			
			<label><?php _ex('Preface URL:','preface URL label'); ?></label><input name="psbooks-preface" value="<?php echo $psbooks_preface; ?>" /><br />
			<em><?php _ex('(e.g. /wp-content/uploads/book-preface.pdf)','preface URL example'); ?></em><br /><br />			
			<label><?php _ex('Table of Contents URL:','ToC label'); ?></label><input name="psbooks-toc" value="<?php echo $psbooks_toc; ?>" /><br />
			<em><?php _ex('(e.g. /wp-content/uploads/book-toc.pdf)','ToC URL example'); ?></em><br /><br />			
			<label><?php _ex('Cover URL:','cover URL label'); ?></label><input name="psbooks-cover" value="<?php echo $psbooks_cover; ?>" /><br />
			<em><?php _ex('(e.g. /wp-content/uploads/book-cover.jpg)','cover URL example'); ?></em><br /><br />
			<?php
		}
	}
}
if(class_exists('PSBooks')) {
	//Initiate the plugin
	add_action("init","PSBookInit");	
	function PSBookInit() {
		global $psbook;
		$psbook = new PSBooks();
	}
}
?>