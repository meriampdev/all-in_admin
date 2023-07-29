<?php
extract(import_vars_whitelist(get_defined_vars()));
$menu = [
    /**
     * template
    [
    'text' => string: $url,
    'href' => string: $href,
    'modifier' => string: $modifier(optional),
    'is-blank' => bool: $is-blank(optional),
    ],
     */
    [
        'text' => NAME_HOME,
        'href' => URL_HOME,
    ],/*
    [
        'text' => NAME_ABOUT,
        'href' => URL_ABOUT,
    ],
    [
        'text' => NAME_SERVICE,
        'href' => URL_SERVICE,
    ],
    [
        'text' => NAME_NEWS,
        'href' => URL_NEWS,
    ],
    [
        'text' => NAME_CASE,
        'href' => URL_CASE,
    ],
    [
        'text' => NAME_RECRUIT,
        'href' => URL_RECRUIT,
    ],
    [
        'text' => NAME_CONTACT,
        'href' => URL_CONTACT,
    ],
    [
        'text' => NAME_PRIVACY,
        'href' => URL_PRIVACY,
    ],*/
]
?>
<nav class="<?= get_modified_class('footer-menu', $modifier) ?><?= get_additional_class($additional) ?>">
    <ul class="footer-menu__list">
        <?php foreach ($menu as $m) : ?>
            <li class="footer-menu__item">
                <a class="footer-menu__link
                            <?php if (array_key_exists('modifier', $m)) echo get_modified_class('footer-menu__link', $m['modifier']) ?>" href="<?= $m['href'] ?>" <?php if (array_key_exists('is-blank', $m)) echo is_blank($m['is-blank']) ?>>
                    <span class="footer-menu__text">
                        <?= $m['text'] ?>
                    </span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>