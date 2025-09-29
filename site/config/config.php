<?php

return [
    'debug'     => false,
    'url'       => require_once 'url.php',
    'languages' => false,
    'smartypants' => true,
    'markdown' => [
        'extra' => true,
    ],
    'routes'    => require_once 'routes.php',
    'panel'     => [
        'install' => false
    ],
    'thumbs'    => require_once 'thumbs.php',
    'email'     => require_once 'email.php',
    'robots'    => require_once 'robots.php',
    'cache'     => require_once 'cache.php',
    'bucklespublishing.placeholders.field' => 'placeholders',
    // 'johannschopplich.copilot'   => require_once 'copilot.php', // Disabled - requires Kirby 4+

];
