<?php

/*
* Creating a function to create our CPT
*/
  
function content_custom_post_type() {
  
  // Set UI labels for Custom Post Type
      $labels = array(
          'name'                => __( 'Contents'),
          'singular_name'       => __( 'Content'),
          'menu_name'           => __( 'Contents'),
          'parent_item_colon'   => __( 'Parent Content'),
          'all_items'           => __( 'All Contents'),
          'view_item'           => __( 'View Content'),
          'add_new_item'        => __( 'Add New Content'),
          'add_new'             => __( 'Add New'),
          'edit_item'           => __( 'Edit Content'),
          'update_item'         => __( 'Update Content'),
          'search_items'        => __( 'Search Content'),
          'not_found'           => __( 'Not Found'),
          'not_found_in_trash'  => __( 'Not found in Trash'),
      );
        
      $args = array(
          'label'               => __( 'contents'),
          'description'         => __( 'Content news and reviews'),
          'labels'              => $labels,
          'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields'),
          /* A hierarchical CPT is like Pages and can have
          * Parent and child items. A non-hierarchical CPT
          * is like Posts.
          */
          'hierarchical'        => false,
          'public'              => true,
          'show_ui'             => true,
          'show_in_menu'        => true,
          'show_in_nav_menus'   => true,
          'show_in_admin_bar'   => true,
          'menu_position'       => 5,
          'can_export'          => true,
          'has_archive'         => true,
          'exclude_from_search' => false,
          'publicly_queryable'  => true,
          'capability_type'     => 'post',
          'show_in_rest' => true,
    
      );
        
      // Registering your Custom Post Type
      register_post_type( 'contents', $args );
    
}
    
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/

add_action( 'init', 'content_custom_post_type', 0 );

add_action('after_setup_theme', function () {
    /**
     * Enable Title
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail
     */
    add_theme_support('post-thumbnails', array('contents'));
});

if( function_exists('acf_add_local_field_group') ):
  acf_add_local_field_group(array(
      'key' => 'Content Control',
      'title' => 'Content Fields',
      'layout' => 'horizontal',
      'fields' => array (
        array (
          'key' => 'content_image',
          'label' => 'Image',
          'name' => 'content_image',
          'type' => 'image',
          'layout' => 'horizontal',
      ),
        array (
          'key' => 'title',
          'label' => 'Title',
          'name' => 'title',
          'type' => 'text',
          'layout' => 'horizontal',
        ),
        array (
          'key' => 'content_title',
          'label' => 'Content Title',
          'name' => 'content_title',
          'type' => 'text',
          'layout' => 'horizontal',
        ),
        array (
          'key' => 'content_body',
          'label' => 'Content Body',
          'name' => 'content_body',
          'type' => 'wysiwyg',
          'layout' => 'horizontal',
        ),
        array (
          'key' => 'content_link',
          'label' => 'Link',
          'name' => 'content_link',
          'type' => 'link',
          'layout' => 'horizontal',
        ),
      ),
      'location' => array (
          array (
            array (
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'contents'
            )
          )
      ),
      'show_in_rest' => true,
  ));
  
endif;

add_action( 'rest_api_init', 'add_content_image' );
function add_content_image() {

  register_rest_field( 
      'contents', 
      'content_image', 
      array(
          'get_callback'    => 'cb_content_image_src',
          'update_callback' => null,
          'schema'          => null,
      )
  );
}


function cb_content_image_src( $object, $field_name, $request ) {
  if (!empty($object['acf'])) {
      if (!empty($object['acf']['content_image'])) {
          $feat_img_array = wp_get_attachment_image_src(
              $object['acf']['content_image'], 
              'full',  
              false
          );
          return $feat_img_array[0];
      }

      return null;
  } 

  return null;
}