<?php

add_action( 'rest_api_init', function () {

  register_rest_route( 'api/v1/', 'articles-by-tag/(?P<slug>[a-z0-9]+(?:-[a-z0-9]+)*)', array(
      'methods' => 'GET',
      'callback' => 'get_articles_by_tag',
      'args' => array(
          'slug' => array (
              'required' => true
          ),
      )
    ));

    register_rest_route( 'api/v1/', 'articles-by-category/(?P<slug>[a-z0-9]+(?:-[a-z0-9]+)*)', array(
      'methods' => 'GET',
      'callback' => 'get_articles_by_category',
      'args' => array(
          'slug' => array (
              'required' => true
          ),
      )
    ));

    register_rest_route( 'api/v1/', 'term/(?P<term>[a-z0-9]+(?:[-_][a-z0-9]+)*)/(?P<slug>[a-z0-9]+(?:-[a-z0-9]+)*)', array(
      'methods' => 'GET',
      'callback' => 'get_term_data',
      'args' => array(
        'term' => array (
          'required' => true
        ),
        'slug' => array (
            'required' => true
        ),
      )
    ));

    register_rest_route( 'api/v1/', 'articles-featured', array(
      'methods' => 'GET',
      'callback' => 'get_featured_articles',
    ));

    register_rest_route( 'api/v1/', 'articles-selection', array(
      'methods' => 'GET',
      'callback' => 'get_selection_articles',
    ));

    register_rest_route( 'api/v1/', 'articles-recommended', array(
      'methods' => 'GET',
      'callback' => 'get_recommended_articles',
    ));

    register_rest_route( 'api/v1/', 'articles-by-acf/(?P<field>[a-z0-9]+(?:-[a-z0-9]+)*)/(?P<fieldValue>[a-z0-9]+(?:-[a-z0-9]+)*)', array(
      'methods' => 'GET',
      'callback' => 'get_articles_by_acf',
      'args' => array(
        'field' => array (
          'required' => true
        ),
        'fieldValue' => array (
            'required' => true
        ),
      )
    ));

    register_rest_route( 'api/v1/', 'get-hot-tags', array(
      'methods' => 'GET',
      'callback' => 'get_hot_tags',
    ));
} );

function format_response($posts) {
  foreach ($posts as $post) {
    $post_tags = get_the_tags($post->ID);
    $post->article_tags = $post_tags;

    $post_categories = get_the_category($post->ID);
    $post->post_categories = $post_categories;

    $post_acfs = get_fields($post->ID);
    $post->post_acfs = $post_acfs;
    $post->order = $post_acfs['order'];

    $thumbnail = get_the_post_thumbnail_url($post->ID);
    $post->featured_image = $thumbnail;
  }

  return $posts;
}

function get_articles_by_tag(WP_REST_Request $request){

  $slug = $request['slug'];
  $term = get_term_by('slug', $slug, 'post_tag');

  $args = array(
    'numberposts' => -1,
    'tag__in' => $term->term_id,
    'post_type'   => 'articles'
  );
  $posts_by_tag = get_posts( $args );
  format_response($posts_by_tag);

  usort($posts_by_tag, function($a, $b) {return strcmp($a->order, $b->order);});
  $response = new WP_REST_Response( $posts_by_tag );

  return $response;
}

function get_articles_by_category(WP_REST_Request $request){

  $slug = $request['slug'];
  $term = get_term_by('slug', $slug, 'category');

  $args = array(
    'numberposts' => -1,
    'category__in' => $term->term_id,
    'post_type'   => 'articles'
  );
  $posts_by_tag = get_posts( $args );
  format_response($posts_by_tag);
  usort($posts_by_tag, function($a, $b) {return strcmp($a->order, $b->order);});
  $response = new WP_REST_Response( $posts_by_tag );

  return $response;
}

function get_term_data(WP_REST_Request $request) {
  $term = $request['term'];
  $slug = $request['slug'];
  $data = get_term_by('slug', $slug, $term);
  $response = new WP_REST_Response( $data );

  return $response;
}

function get_featured_articles(WP_REST_Request $request) {
  $args = array(
    'numberposts' => -1,
    'post_type'   => 'articles',
    'meta_key'      => 'isFeatured',
    'meta_value'    => true
  );

  $data = get_posts( $args );
  format_response($data);
  usort($posts_by_tag, function($a, $b) {return strcmp($a->order, $b->order);});
  $response = new WP_REST_Response( $data );

  return $response;
}

function get_selection_articles(WP_REST_Request $request) {
  $args = array(
    'numberposts' => -1,
    'post_type'   => 'articles',
    'meta_key'      => 'isSelection',
    'meta_value'    => true
  );

  $data = get_posts( $args );
  format_response($data);
  usort($posts_by_tag, function($a, $b) {return strcmp($a->order, $b->order);});
  $response = new WP_REST_Response( $data );

  return $response;
}

function get_recommended_articles(WP_REST_Request $request) {
  $args = array(
    'numberposts' => -1,
    'post_type'   => 'articles',
    'meta_key'      => 'isRecommended',
    'meta_value'    => true
  );

  $data = get_posts( $args );
  format_response($data);
  usort($posts_by_tag, function($a, $b) {return strcmp($a->order, $b->order);});
  $response = new WP_REST_Response( $data );

  return $response;
}

function get_articles_by_acf(WP_REST_Request $request) {
  $field = $request['field'];
  $fieldValue = $request['fieldValue'];

  $args = array(
    'numberposts' => -1,
    'post_type'   => 'articles',
    'meta_key'      => $field,
    'meta_value'    => true
  );

  $data = get_posts( $args );
  format_response($data);

  $response = new WP_REST_Response( $data );

  return $response;
}

function get_hot_tags(WP_REST_Request $request) {
  $args = array( 
    'meta_key'      => 'isHotTag',
    'meta_value'    => 'on',
    'hide_empty' => false
  );
	$args = wp_parse_args( $args, $defaults = array() );
	$tags = get_categories( $args );

	if ( empty( $tags ) ) {
		$tags = array();
	} else {
		$tags = apply_filters( 'get_categories', $tags, $args );
    
    foreach ($tags as $tag) {
      $meta_data = get_term_meta($tag->term_id);
      $tagImageSrc = wp_get_attachment_image_url( $meta_data['tagImage'][0], 'full' );
      $tag->tagImageSrc = $tagImageSrc;
      $tag->meta = $meta_data;
      $tag->order = $meta_data['tagDisplayOrder'][0];
    }
	}

  usort($tags, function($a, $b) {return strcmp($a->order, $b->order);});
  $response = new WP_REST_Response( $tags );

  return $response;
}