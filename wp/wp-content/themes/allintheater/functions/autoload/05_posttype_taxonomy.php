<?php

function ag_filter_post_json($response, $post, $context) {
    $tags = wp_get_post_tags($post->ID);
    $response->data['tag_names'] = [];
    foreach ($tags as $tag) {
        $response->data['tag_names'][] = $tag->name;
    }
    return $response;
}
add_filter( 'rest_prepare_post', 'ag_filter_post_json', 10, 3 );

add_action( 'init', 'custom_term_meta_setup');
function custom_term_meta_setup() {
    register_term_meta($term->term_id, 'isHotTag', 
        array('show_in_rest' => true)
    );
    register_term_meta($term->term_id, 'tagDisplayOrder', 
        array('show_in_rest' => true)
    );
    register_term_meta($term->term_id, 'tagImage', 
        array(
            'show_in_rest' => array(
                'prepare_callback' => function( $attachment ) {
                    return wp_get_attachment_image_url( $attachment, 'full' );
                },
            )
        )
    );
}

add_action( 'post_tag_add_form_fields', 'rudr_add_term_fields' );
function rudr_add_term_fields( $taxonomy ) {
	?>
        <div class="form-field">
			<label for="isHotTag">Hot Tag</label>
			<input type="checkbox" name="isHotTag" id="isHotTag" />
		</div>
        <div class="form-field">
			<label for="tagDisplayOrder">表示順</label>
			<input type="number" name="tagDisplayOrder" id="tagDisplayOrder" />
		</div>
		<div class="form-field">
			<label>タグ画像</label>
			<a href="#" class="button rudr-upload">画像をアップロードする</a>
			<a href="#" class="rudr-remove" style="display:none">画像を削除する</a>
			<input type="hidden" name="tagImage" value="">
		</div>
	<?php
}

add_action( 'post_tag_edit_form_fields', 'rudr_edit_term_fields', 10, 2 );
function rudr_edit_term_fields( $term, $taxonomy ) {

    $is_hot_tag = get_term_meta( $term->term_id, 'isHotTag', true );
    $text_field = get_term_meta( $term->term_id, 'tagDisplayOrder', true );
	$image_id = get_term_meta( $term->term_id, 'tagImage', true );

	?>
    <tr class="form-field">
        <th><label for="isHotTag">Hot Tag</label></th>
        <td>
            <input 
                name="isHotTag" 
                id="isHotTag" 
                type="checkbox" 
                <?php echo isset($is_hot_tag[0]) ? "checked" : ""; ?>
            />
        </td>
    </tr>
    <tr class="form-field">
        <th><label for="tagDisplayOrder">表示順</label></th>
        <td>
            <input name="tagDisplayOrder" id="tagDisplayOrder" type="number" value="<?php echo esc_attr( $text_field ) ?>" />
        </td>
    </tr>
    <tr class="form-field">
		<th>
			<label for="tagImage">タグ画像</label>
		</th>
		<td>
			<?php if( $image = wp_get_attachment_image_url( $image_id, 'medium' ) ) : ?>
				<a href="#" class="rudr-upload">
					<img src="<?php echo esc_url( $image ) ?>" />
				</a>
				<a href="#" class="rudr-remove">画像を削除する</a>
				<input type="hidden" name="tagImage" value="<?php echo absint( $image_id ) ?>">
			<?php else : ?>
				<a href="#" class="button rudr-upload">画像をアップロードする</a>
				<a href="#" class="rudr-remove" style="display:none">画像を削除する</a>
				<input type="hidden" name="tagImage" value="">
			<?php endif; ?>
		</td>
	</tr><?php
}

add_action( 'created_post_tag', 'rudr_save_term_fields' );
add_action( 'edited_post_tag', 'rudr_save_term_fields' );
function rudr_save_term_fields( $term_id ) {
    
    update_term_meta(
        $term_id,
        'isHotTag',
        $_POST[ 'isHotTag' ]
    );

    if( isset( $_POST['tagDisplayOrder'] ) && ! empty( $_POST['tagDisplayOrder'] ) ) {
        update_term_meta(
            $term_id,
            'tagDisplayOrder',
            sanitize_text_field( $_POST[ 'tagDisplayOrder' ] )
        );
    } else {
        delete_term_meta( $term_id, 'tagDisplayOrder' );
    }

    if( isset( $_POST['tagImage'] ) && ! empty( $_POST['tagImage'] ) ) {
        update_term_meta(
            $term_id,
            'tagImage',
            absint( $_POST[ 'tagImage' ] )
        );
    } else {
        delete_term_meta( $term_id, 'tagImage' );
    }
}

add_action( 'admin_enqueue_scripts', 'rudr_include_js' );
function rudr_include_js() {
	
	if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}
 	wp_enqueue_script( 
		'mishaupload', 
		get_stylesheet_directory_uri() . '/misha-uploader.js',
		array( 'jquery' )
	);
}