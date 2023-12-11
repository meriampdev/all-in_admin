<?php

add_action('init', function () {
    /**
     * General Settings
     */
    define('NAME_SITE', get_bloginfo('name'));

    /**
     * ASSETS
     */
    define('URL_ASSETS', get_template_directory_uri().'/assets/');
    define('URL_IMAGES', URL_ASSETS . 'images/');

    define('URL_JS', URL_ASSETS . 'js/');
    define('URL_CSS', URL_ASSETS . 'css/');
    define('URL_SVG', URL_ASSETS . 'svg/');

    define('URL_FAVICON', resolve_uri('/assets/images/favicon.ico'));
    define('URL_TOUCH_ICON', resolve_uri('/assets/images/apple-touch-icon.png'));
    define('URL_NO_IMAGE', resolve_uri('assets/images/noimage.png'));
    define('URL_APP_JS', resolve_uri('/assets/js/app.js'));
    define('URL_APP_CSS', resolve_uri('/assets/css/app.css'));
    define('URL_OGP_IMAGE', resolve_uri('assets/images/ogp.jpg'));

    // define('PATH_IMAGES', STYLESHEETPATH . '/assets/images/');
    // define('PATH_SVG_SPRITE', STYLESHEETPATH . '/assets/svg/sprite.svg');

    // define('URL_COMPANY_LOGO', URL_SVG.'logo.svg');
    // define('URL_COMPANY_NAME', '株式会社allintheater');
    // define('KEY_COLOR', ' #0f5599');

    /**
     * CONTENTS
     */

    //front page
    define('URL_HOME', home_url('/'));
    define('NAME_HOME', 'HOME');

    /**
     * Head tag information
     */
    define('DESCRIPTION', 'Umplexはエンジニアや営業といった職種の垣根を超え、「感情」を軸に求人情報を検索できる新機軸の求人サイトです。さまざまな感情が巻き起こるストーリー仕立ての求人広告が、先入観にとらわれない企業と求職者の出会いを提供します。');
    define('SITE_TITLE', 'Umplex｜「感情」で検索する求人情報サイト');
    define('SITE_NAME', 'Umplex');

    define('SIGNATURE', <<<EOM
=====================================
【Umplex】
=====================================
EOM);


    //post type
//    define('URL_NEWS', URL_HOME . 'news/');
//    define('NAME_NEWS', 'NEWS');
//
//    define('URL_ABOUT', URL_HOME . 'about/');
//    define('NAME_ABOUT', 'ABOUT');
//
//    define('URL_SERVICE', URL_HOME . 'service/');
//    define('NAME_SERVICE', 'SERVICE');
//
//    define('URL_CASE', URL_HOME . 'case/');
//    define('NAME_CASE', 'CASE');
//
//    define('URL_RECRUIT', URL_HOME . 'recruit/');
//    define('NAME_RECRUIT', 'RECRUIT');
//
//    define('URL_CONTACT', URL_HOME . 'contact/');
//    define('NAME_CONTACT', 'CONTACT');
//
//    define('URL_CONFIRM', URL_CONTACT . 'confirm/');
//    define('URL_COMPLETE', URL_CONTACT . 'complete/');
//
//    define('URL_PRIVACY', URL_HOME . 'privacy/');
//    define('NAME_PRIVACY', 'PRIVACY');

    /*
    define('URL_', URL_HOME . '/');
    define('NAME_', '');
    */

    /**
     * SNS
     */
    // define('URL_YOUTUBE', 'https://www.youtube.com/');
    // define('URL_TWITTER', 'https://twitter.com/');
    // define('URL_FACEBOOK', 'https://facebook.com/');
    // define('URL_INSTAGRAM', 'https://instagram.com/');
    // define('URL_LINKED_IN', 'https://www.linkedin.com/');
    // define('URL_HATEBU', 'https://b.hatena.ne.jp/');
    // define('URL_PINTEREST', 'https://www.pinterest.jp/');

    /**
     * EXTERNAL LINKS
     */
    /*
    define('', '');
    */


    /**
     * Google Maps API
     */
    // define('GMAP_API_LOCAL','');
    // define('GMAP_API_DEVELOPMENT','');
    // define('GMAP_API_STAGING','');
    // define('GMAP_API_PRODUCTION','');


    /**
     * IMAGE SIZES
     */
    // define('RESIZE_IMAGE_SIZES', [
    //     560,
    //     1125,
    //     2880,
    // ]);

    /*
     * キーはメディアクエリ、値は入れたい画像
     * 'default'=>'default'を入れると、imgタグは元画像のurlがセットされます
     * 'default'=>414にすると、imgタグに414のsrcsetが挿入されますcot
     */

    // define('IMAGE_SIZES_MIN', [
    //     767 => 560,
    //     1440 => 1125,
    //     'default' => 'original'
    // ]);

    // define('IMAGE_SIZES_FULL', [
    //     767 => 1125,
    //     1440 => 2880,
    //     'default' => 'original'
    // ]);
}, 0);

add_filter( 'preview_post_link', 'the_preview_fix', 10, 2 );

function the_preview_fix($link, $post) {
    $site_url = site_url();
    if($post->post_type == 'contents') {
        if($post->post_name == 'job-board-page') {
            return "$site_url/jobboard";
        } else if($post->post_name == 'about-page') {
            return "$site_url/about";
        } else {
            return "$site_url/story/detail?preview=true&id=$post->ID";
        }
    } else {
        return "$site_url/story/detail?preview=true&id=$post->ID";
    }
}

function change_link( $permalink, $post ) {
    $site_url = site_url();
    if($post->post_type == 'contents') {
        if($post->post_name == 'job-board-page') {
            return "$site_url/jobboard";
        } else if($post->post_name == 'about-page') {
            return "$site_url/about";
        } else {
            return "$site_url/story/detail?slug=$post->post_name";
        }
    } else {
        return "$site_url/story/detail?slug=$post->post_name";
    }
}
add_filter('post_type_link',"change_link",10,2);

// Workaround script until there's an official solution for https://github.com/WordPress/gutenberg/issues/13998
function fix_preview_link_on_draft() {
    echo '<script type="text/javascript">
        jQuery(document).ready(function () {
            const checkPreviewInterval = setTimeout(checkPreview, 1000);
        //checkPreview();
        function checkPreview() {
            const ToggleButton = jQuery(".block-editor-post-preview__button-toggle");
            const editorPreviewButton = jQuery(".editor-post-preview");
            ToggleButton.hide();
            editorPreviewButton.show();
            if (editorPreviewButton.length && editorPreviewButton.attr("href") !== "' . get_preview_post_link() . '" ) {
                editorPreviewButton.attr("href", "' . get_preview_post_link() . '");
                editorPreviewButton.off();
                editorPreviewButton.click(false);
                editorPreviewButton.on("click", function() {
                    setTimeout(function() { 
                        const win = window.open("' . get_preview_post_link() . '", "_blank");
                        if (win) {
                            win.focus();
                        }
                    }, 1000);
                });
            }
        }
    });
    </script>';
}

add_action('admin_footer', 'fix_preview_link_on_draft');

add_filter( 'big_image_size_threshold', '__return_false' ); 