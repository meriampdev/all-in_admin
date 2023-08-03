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
    define('DESCRIPTION', 'IPテック企業・株式会社allintheaterのコーポレートサイト。タレント肖像データのサブスクリプション「Skettt」と著名人から動画をもらう動画プラットフォーム「VOM」を開発・運営しています。');
    define('SITE_TITLE', '株式会社allintheater（ヴンダーバー）｜IP活用を科学する');
    define('SITE_NAME', '株式会社allintheater（ヴンダーバー）');

    define('SIGNATURE', <<<EOM
=====================================
株式会社allintheater

TEL: 03-1234-2766
MAIL: allin.theaterweb@gmail.com
URL: http://dev.all-in.jyminc.com/

123-1234
東京都渋谷区渋谷三丁目7番2号
第3矢木ビル 9階
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