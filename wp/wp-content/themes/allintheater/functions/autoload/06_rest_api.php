<?php

add_action( 'rest_api_init', function () {

  register_rest_route( 'api/v1/', 'articles', array(
    'methods' => 'GET',
    'callback' => 'get_articles',
    'permission_callback' => '__return_true'
  ));

  register_rest_route( 'api/v1/', 'article-by-slug/(?P<slug>[a-z0-9]+(?:-[a-z0-9]+)*)', array(
    'methods' => 'GET',
    'callback' => 'get_article_by_slug',
    'permission_callback' => '__return_true',
    'args' => array(
      'slug' => array (
          'required' => true
      ),
    )
  ));

  register_rest_route( 'api/v1/', 'article-by-id/(?P<id>[a-z0-9]+(?:-[a-z0-9]+)*)', array(
    'methods' => 'GET',
    'callback' => 'get_article_by_id',
    'permission_callback' => '__return_true',
    'args' => array(
      'id' => array (
          'required' => true
      ),
    )
  ));

  register_rest_route( 'api/v1/', 'articles-by-tag/(?P<slug>[a-z0-9]+(?:-[a-z0-9]+)*)', array(
      'methods' => 'GET',
      'callback' => 'get_articles_by_tag',
      'permission_callback' => '__return_true',
      'args' => array(
          'slug' => array (
              'required' => true
          ),
      )
    ));

    register_rest_route( 'api/v1/', 'articles-by-category/(?P<slug>[a-z0-9]+(?:-[a-z0-9]+)*)', array(
      'methods' => 'GET',
      'callback' => 'get_articles_by_category',
      'permission_callback' => '__return_true',
      'args' => array(
          'slug' => array (
              'required' => true
          ),
      )
    ));

    register_rest_route( 'api/v1/', 'term/(?P<term>[a-z0-9]+(?:[-_][a-z0-9]+)*)/(?P<slug>[a-z0-9]+(?:-[a-z0-9]+)*)', array(
      'methods' => 'GET',
      'callback' => 'get_term_data',
      'permission_callback' => '__return_true',
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
      'permission_callback' => '__return_true'
    ));

    register_rest_route( 'api/v1/', 'articles-selection', array(
      'methods' => 'GET',
      'callback' => 'get_selection_articles',
      'permission_callback' => '__return_true'
    ));

    register_rest_route( 'api/v1/', 'articles-recommended', array(
      'methods' => 'GET',
      'callback' => 'get_recommended_articles',
      'permission_callback' => '__return_true'
    ));

    register_rest_route( 'api/v1/', 'articles-by-acf/(?P<field>[a-z0-9]+(?:-[a-z0-9]+)*)/(?P<fieldValue>[a-z0-9]+(?:-[a-z0-9]+)*)', array(
      'methods' => 'GET',
      'callback' => 'get_articles_by_acf',
      'permission_callback' => '__return_true',
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
      'permission_callback' => '__return_true'
    ));

    register_rest_route( 'api/v1/', 'get-top-categories', array(
      'methods' => 'GET',
      'callback' => 'get_top_categories',
      'permission_callback' => '__return_true'
    ));

    register_rest_route( 'api/v1/', 'get-parent-categories', array(
      'methods' => 'GET',
      'callback' => 'get_parent_categories',
      'permission_callback' => '__return_true'
    ));

    register_rest_route( 'api/v1/', 'sub-categories/(?P<term>[a-z0-9]+(?:[-_][a-z0-9]+)*)', array(
      'methods' => 'GET',
      'callback' => 'get_subcategories',
      'permission_callback' => '__return_true',
      'args' => array(
        'term' => array (
          'required' => true
        )
      )
    ));
    
} );

function format_response($posts) {
  foreach ($posts as $article) {
    $post_tags = get_the_tags($article->ID);
    $article->article_tags = $post_tags;

    $post_categories = get_the_category($article->ID);
    $article->post_categories = $post_categories;

    $post_acfs = get_fields($article->ID);
    $article->post_acfs = $post_acfs;
    $article->order = $post_acfs['order'];

    $thumbnail = get_the_post_thumbnail_url($article->ID);
    $article->featured_image = $thumbnail;
  }

  return $posts;
}

function get_articles(WP_REST_Request $request){

  $offset = $request->get_param("offset");

  $args = array(
    'offset'       => $offset,
    'numberposts'  => 6,
    'post_type'   => 'articles'
  );
  $posts_by_tag = get_posts( $args );
  format_response($posts_by_tag);
  usort($posts_by_tag, function($a, $b) {
    if ($a->order == '' && $b->order != '') return 1;
    if ($b->order == '' && $a->order != '') return -1;
    $aOrder = $a->order;
    $bOrder = $b->order;
    return ($aOrder < $bOrder) ? -1 : (($aOrder > $bOrder) ? 1 : 0);
  });
  $response = new WP_REST_Response( $posts_by_tag );

  return $response;
}

function get_articles_by_tag(WP_REST_Request $request){

  $slug = $request['slug'];
  $offset = $request->get_param("offset");

  $term = get_term_by('slug', $slug, 'post_tag');

  $args = array(
    'offset'       => $offset,
    'numberposts' => 10,
    'tag__in' => $term->term_id,
    'post_type'   => 'articles'
  );
  $posts_by_tag = get_posts( $args );
  format_response($posts_by_tag);

  usort($posts_by_tag, function($a, $b) {
    if ($a->order == '' && $b->order != '') return 1;
    if ($b->order == '' && $a->order != '') return -1;
    $aOrder = $a->order;
    $bOrder = $b->order;
    return ($aOrder < $bOrder) ? -1 : (($aOrder > $bOrder) ? 1 : 0);
  });
  $response = new WP_REST_Response( $posts_by_tag );

  return $response;
}

function get_articles_by_category(WP_REST_Request $request){

  $slug = $request['slug'];
  $offset = $request->get_param("offset");
  $term = get_term_by('slug', $slug, 'category');

  $args = array(
    'category__in' => $term->term_id,
    'offset'       => $offset,
    'numberposts'  => 6,
    'post_type'   => 'articles'
  );
  $posts_by_tag = get_posts( $args );
  format_response($posts_by_tag);
  usort($posts_by_tag, function($a, $b) {
    if ($a->order == '' && $b->order != '') return 1;
    if ($b->order == '' && $a->order != '') return -1;
    $aOrder = $a->order;
    $bOrder = $b->order;
    return ($aOrder < $bOrder) ? -1 : (($aOrder > $bOrder) ? 1 : 0);
  });
  $response = new WP_REST_Response( $posts_by_tag );

  return $response;
}

function get_term_data(WP_REST_Request $request) {
  $term = $request['term'];
  $slug = $request['slug'];
  $data = get_term_by('slug', $slug, $term);

  $pickup = get_term_meta( $data->term_id, 'pickup_article', true );
  $data->pickup = $pickup;

  if(!empty($pickup)) {
    $args = array(
      'name' => $pickup,
      'post_type'   => 'articles'
    );
    $posts_by_tag = get_posts( $args );
    format_response($posts_by_tag);
   
    $data->pickup_article = $posts_by_tag[0];
  }
  

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
  usort($posts_by_tag, function($a, $b) {
    if ($a->order == '' && $b->order != '') return 1;
    if ($b->order == '' && $a->order != '') return -1;
    $aOrder = $a->order;
    $bOrder = $b->order;
    return ($aOrder < $bOrder) ? -1 : (($aOrder > $bOrder) ? 1 : 0);
  });
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
  usort($posts_by_tag, function($a, $b) {
    if ($a->order == '' && $b->order != '') return 1;
    if ($b->order == '' && $a->order != '') return -1;
    $aOrder = $a->order;
    $bOrder = $b->order;
    return ($aOrder < $bOrder) ? -1 : (($aOrder > $bOrder) ? 1 : 0);
  });
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
  usort($posts_by_tag, function($a, $b) {
    if ($a->order == '' && $b->order != '') return 1;
    if ($b->order == '' && $a->order != '') return -1;
    $aOrder = $a->order;
    $bOrder = $b->order;
    return ($aOrder < $bOrder) ? -1 : (($aOrder > $bOrder) ? 1 : 0);
  });
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
      $spTagImageSrc = wp_get_attachment_image_url( $meta_data['tagImageSP'][0], 'full' );
      $tag->spTagImageSrc = $spTagImageSrc;
      $tag->meta = $meta_data;
      $tag->order = $meta_data['tagDisplayOrder'][0];
    }
	}

  usort($tags, function($a, $b) {
    if ($a->order == '' && $b->order != '') return 1;
    if ($b->order == '' && $a->order != '') return -1;
    $aOrder = $a->order;
    $bOrder = $b->order;
    return ($aOrder < $bOrder) ? -1 : (($aOrder > $bOrder) ? 1 : 0);
  });
  $response = new WP_REST_Response( $tags );

  return $response;
}

function get_top_categories(WP_REST_Request $request) {
  $args = array( 
    'meta_key'      => 'showInTop',
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

  usort($tags, function($a, $b) {
    if ($a->order == '' && $b->order != '') return 1;
    if ($b->order == '' && $a->order != '') return -1;
    $aOrder = $a->order;
    $bOrder = $b->order;
    return ($aOrder < $bOrder) ? -1 : (($aOrder > $bOrder) ? 1 : 0);
  });
  $response = new WP_REST_Response( $tags );

  return $response;
}

function get_article_by_slug(WP_REST_Request $request) {
  $slug = $request['slug'];

  $args = array(
    'name' => $slug,
    'post_type'   => 'articles'
  );
  $posts_by_tag = get_posts( $args );
  format_response($posts_by_tag);

  global $post;
  foreach ( $posts_by_tag as $post ) {
    setup_postdata( $post );
  }
  
  $next_post = get_next_post();
  $prev_post = get_previous_post();
  $response = new WP_REST_Response([
    "article" => $posts_by_tag,
    "next" =>  $next_post,
    "prev" => $prev_post
  ]);

  return $response;
}

function get_article_by_id(WP_REST_Request $request) {
  $id = $request['id'];

  $article = get_post( $id );
  $posts_by_tag = array($article);
  format_response($posts_by_tag);

  global $post;
  foreach ( $posts_by_tag as $post ) {
    setup_postdata( $post );
  }
  
  $next_post = get_next_post();
  $prev_post = get_previous_post();
  $response = new WP_REST_Response([
    "article" => $posts_by_tag,
    "next" =>  $next_post,
    "prev" => $prev_post
  ]);

  return $response;
}

function get_subcategories(WP_REST_Request $request) {
  $term = $request['term'];
  $parent = get_term_by('slug', $term, 'category');
  $categories = get_terms( array(
    'taxonomy' => 'category',
    'hide_empty' => false,
    'parent' => $parent->term_id // or 
  ));
  $response = new WP_REST_Response( [
    "subs" => $categories,
    "parent" => $parent
  ] );

  return $response;
}


function get_parent_categories(WP_REST_Request $request) {
  $categories = get_terms(['taxonomy' => 'category', 'parent' => 0]);
  foreach ($categories as $cat) {
    $meta_data = get_term_meta($cat->term_id);
    $cat->order = $meta_data['tagDisplayOrder'][0];
    $subs = get_terms( array(
      'taxonomy' => 'category',
      'hide_empty' => false,
      'parent' => $cat->term_id 
    ));
    $cat->subs = $subs;
	}

  usort($categories, function($a, $b) {
    if ($a->order == '' && $b->order != '') return 1;
    if ($b->order == '' && $a->order != '') return -1;
    $aOrder = $a->order;
    $bOrder = $b->order;
    return ($aOrder < $bOrder) ? -1 : (($aOrder > $bOrder) ? 1 : 0);
  });
  $response = new WP_REST_Response( $categories );

  return $response;
}