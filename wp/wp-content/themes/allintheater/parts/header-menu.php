<?php
extract(import_vars_whitelist(get_defined_vars()));
$menu = [
    /**
     * template
     * [
     * 'text' => string: $url,
     * 'href' => string: $href,
     * 'modifier' => string: $modifier(optional),
     * 'is-current' => bool: $is-current(optional),
     * 'is-blank' => bool: $is-blank(optional),
     * ],
     */
    [
        'text' => NAME_HOME,
        'href' => URL_HOME,
        'is-current' => is_front_page(),
    ],/*
    [
        'text' => NAME_ABOUT,
        'href' => URL_ABOUT,
        'is-current' => is_page('about'),
    ],
    [
        'text' => NAME_SERVICE,
        'href' => URL_SERVICE,
        'is-current' => is_page('service'),
    ],
    [
        'text' => NAME_NEWS,
        'href' => URL_NEWS,
        'is-current' => is_post_type_archive('news') || is_tax('news-category') || is_singular('news'),
    ],
    [
        'text' => NAME_CASE,
        'href' => URL_CASE,
        'is-current' => is_post_type_archive('case') || is_tax('case-category') || is_singular('case'),
    ],
    [
        'text' => NAME_RECRUIT,
        'href' => URL_RECRUIT,
        'is-current' => is_post_type_archive('recruit') || is_tax('recruit-category') || is_singular('recruit'),
    ],
    [
        'text' => NAME_CONTACT,
        'href' => URL_CONTACT,
        'is-current' => is_page('contact') || is_page('confirm') || is_page('complete'),
    ],*/
];
?>
<nav id="header-menu" class="<?= get_modified_class('header-menu', $modifier) ?><?= get_additional_class($additional) ?>">
    <ul class="header-menu__list">
        <?php foreach ($menu as $m) : ?>
            <li class="header-menu__item">
                <a class="header-menu__link
                                <?php if (array_key_exists('modifier', $m)) echo get_modified_class('header-menu__link', $m['modifier']) ?>
                                <?php if (array_key_exists('is-current', $m)) echo is_current($m['is-current']) ?>" href="<?= $m['href'] ?>" <?php if (array_key_exists('is-blank', $m)) echo is_blank($m['is-blank']) ?>>
                    <span class="header-menu__text">
                        <?= $m['text'] ?>
                    </span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>