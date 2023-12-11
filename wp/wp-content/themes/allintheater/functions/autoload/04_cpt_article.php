<?php

/*
* Creating a function to create our CPT
*/
  
function custom_post_type() {
  
  // Set UI labels for Custom Post Type
      $labels = array(
          'name'                => __( 'Articles'),
          'singular_name'       => __( 'Article'),
          'menu_name'           => __( 'Articles'),
          'parent_item_colon'   => __( 'Parent Article'),
          'all_items'           => __( 'All Articles'),
          'view_item'           => __( 'View Article'),
          'add_new_item'        => __( 'Add New Article'),
          'add_new'             => __( 'Add New'),
          'edit_item'           => __( 'Edit Article'),
          'update_item'         => __( 'Update Article'),
          'search_items'        => __( 'Search Article'),
          'not_found'           => __( 'Not Found'),
          'not_found_in_trash'  => __( 'Not found in Trash'),
      );
        
      $args = array(
          'label'               => __( 'articles'),
          'description'         => __( 'Article news and reviews'),
          'labels'              => $labels,
          'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields'),
          'taxonomies'          => array( 'category', 'post_tag' ),
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
      register_post_type( 'articles', $args );
    
}
    
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/

add_action( 'init', 'custom_post_type', 0 );

add_action('after_setup_theme', function () {
    /**
     * Enable Title
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail
     */
    add_theme_support('post-thumbnails', array('articles'));
});


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'article_recruitment',
        'title' => 'Recruitment',
        'layout' => 'horizontal',
        'fields' => array (
            array (
                'key' => 'recruitment_title',
                'label' => 'Title',
                'name' => 'recruitment_title',
                'type' => 'text',
                'layout' => 'horizontal',
            ),
            array (
                'key' => 'recruitment_description',
                'label' => 'Description',
                'name' => 'recruitment_description',
                'type' => 'text',
                'layout' => 'horizontal',
            ),
            array (
                'key' => 'recruitment_email',
                'label' => 'Email',
                'name' => 'recruitment_email',
                'type' => 'text',
                'layout' => 'horizontal',
            ),
            array (
                'key' => 'recruitment_url_link',
                'label' => '採用ページへ',
                'name' => 'recruitment_url_link',
                'type' => 'link',
                'layout' => 'horizontal',
            ),
            array (
                'key' => 'recruitment_image',
                'label' => 'Image',
                'name' => 'recruitment_image',
                'type' => 'image',
                'layout' => 'horizontal',
            ),
            array (
                'key' => 'application_requirements',
                'label' => '募集要項',
                'name' => 'application_requirements',
                'type' => 'wysiwyg',
                'layout' => 'horizontal',
            )
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'articles',
                ),
            ),
        ),
        'show_in_rest' => true,
    ));

    acf_add_local_field_group(array(
        'key' => 'article_control',
        'title' => 'Article Display Controls',
        'layout' => 'horizontal',
        'fields' => array (
            array (
                'key' => 'article_image_content',
                'label' => 'Article Content',
                'name' => 'article_image_content',
                'type' => 'image',
                'layout' => 'horizontal',
            ),
            array (
                'key' => 'animation_link',
                'label' => 'アニメーションを見る',
                'name' => 'animation_link',
                'type' => 'link',
                'layout' => 'horizontal',
            ),
            array (
                'key' => 'order',
                'label' => 'Display Order',
                'name' => 'order',
                'type' => 'number',
                'min' => 0,
                'layout' => 'horizontal',
            ),
            array (
                'key' => 'isFeatured',
                'label' => 'Is Featured',
                'name' => 'isFeatured',
                'type' => 'true_false',
                'layout' => 'horizontal',
                'message' => __('True', 'txtdomain'),
                'default_value' => 0,
                'ui' => 0,
                'ui_on_text' => __('Yes', 'txtdomain'),
                'ui_off_text' => __('No', 'txtdomain'),
            ),
            array (
                'key' => 'isSelection',
                'label' => 'Is Selection',
                'name' => 'isSelection',
                'type' => 'true_false',
                'layout' => 'horizontal',
                'message' => __('True', 'txtdomain'),
                'default_value' => 0,
                'ui' => 0,
                'ui_on_text' => __('Yes', 'txtdomain'),
                'ui_off_text' => __('No', 'txtdomain'),
            ),
            array (
                'key' => 'isRecommended',
                'label' => 'Is Recommended',
                'name' => 'isRecommended',
                'type' => 'true_false',
                'layout' => 'horizontal',
                'message' => __('True', 'txtdomain'),
                'default_value' => 0,
                'ui' => 0,
                'ui_on_text' => __('Yes', 'txtdomain'),
                'ui_off_text' => __('No', 'txtdomain'),
            )
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'articles',
                ),
            ),
        ),
        'show_in_rest' => true,
    ));
    
endif;


/**
 *  Return featured_image url
 */

add_action( 'rest_api_init', 'add_image_to_JSON' );
function add_image_to_JSON() {

    register_rest_field( 
        'articles', 
        'featured_image_src', 
        array(
            'get_callback'    => 'get_image_src',
            'update_callback' => null,
            'schema'          => null,
        )
    );

    register_rest_field( 
        'articles', 
        'recruitment_image', 
        array(
            'get_callback'    => 'get_rv_image_src',
            'update_callback' => null,
            'schema'          => null,
        )
    );

    register_rest_field( 
        'articles', 
        'article_image_content', 
        array(
            'get_callback'    => 'get_content_image_src',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function get_image_src( $object, $field_name, $request ) {
  $feat_img_array = wp_get_attachment_image_src(
    $object['featured_media'], 
    'full',  
    false
  );
  return $feat_img_array[0];
}

function get_rv_image_src( $object, $field_name, $request ) {
    if (!empty($object['acf'])) {
        if (!empty($object['acf']['recruitment_image'])) {
            $feat_img_array = wp_get_attachment_image_src(
                $object['acf']['recruitment_image'], 
                'full',  
                false
            );
            return $feat_img_array[0];
        }

        return null;
    } 

    return null;
}

function get_content_image_src( $object, $field_name, $request ) {
    if (!empty($object['acf'])) {
        if (!empty($object['acf']['article_image_content'])) {
            $feat_img_array = wp_get_attachment_image_src(
                $object['acf']['article_image_content'], 
                'full',  
                false
            );
            return $feat_img_array[0];
        }

        return null;
    } 

    return null;
}


/**
 *  Return tag data
 */

add_action( 'rest_api_init', 'add_tag_data_to_json' );
function add_tag_data_to_json() {

    register_rest_field( 
        'articles', 
        'article_tags', 
        array(
            'get_callback'    => 'get_tag_data',
            'update_callback' => null,
            'schema'          => null,
        )
    );

    register_rest_field( 
        'articles', 
        'post_categories', 
        array(
            'get_callback'    => 'get_cat_data',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function get_tag_data( $object, $field_name, $request ) {
    $formatted_tags = get_the_tags($object->id);
    return $formatted_tags;
}

function get_cat_data( $object, $field_name, $request ) {
    $formatted_tags = get_the_category($object->id);
    return $formatted_tags;
}
