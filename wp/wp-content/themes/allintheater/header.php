<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="description" content="<?php echo DESCRIPTION; ?>">
  <meta property="og:title" content="<?php echo SITE_TITLE; ?>">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
  <meta property="og:description" content="<?php echo DESCRIPTION; ?>">
  <meta property="og:url" content="<?php echo bloginfo('url');; ?>">
  <meta property="og:image" content="<?php echo URL_OGP_IMAGE; ?>">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="viewport" content="width=device-width,initial-scale=1.0"> 
  <meta name="format-detection" content="telephone=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo SITE_TITLE; ?></title>
  <link rel="shortcut icon" href="<?= URL_FAVICON ?>">
  <link rel="apple-touch-icon-precomposed" href="<?= URL_TOUCH_ICON ?>">
  <link rel="stylesheet" href="<?= URL_APP_CSS ?>">
  <?php // Add MapBox ?>
  <script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>
  <link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
  <?php // Add Font ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!-- <link href="https://fonts.cdnfonts.com/css/avenir-next-lt-pro" rel="stylesheet"> -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet">
  <!-- <link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Display:wght@400;500;700&display=swap" rel="stylesheet"> -->
  <?php wp_head(); ?>
</head>
<body id="body" <?php body_class(); ?>>
<?php import_part('header') ?>