<?php

return [
    // Route for sublocations without parent slug
    [
        'pattern' => 'service-in-(:any)-(:all)',
        'action' => function ($mainLocationSlug, $subLocationSlug) {
            $mainLocationSlug = Str::slug(urldecode($mainLocationSlug));
            $subLocationSlug = Str::slug(urldecode(str_replace([' ', '.', ','], '-', $subLocationSlug)));

            // Find the sublocation page directly
            $subLocationPage = page('service-areas')->index()->filterBy('slug', 'service-in-' . $mainLocationSlug . '-' . $subLocationSlug)->first();
            if ($subLocationPage) {
                return $subLocationPage;
            }

            return site()->errorPage(); // Return the site's error page if the sublocation is not found
        }
    ],
    // Removes /service-areas/ succesfully for all locations
    [
        'pattern' => '(:any)',
        'action'  => function($uid) {
            $page = page($uid);
            if(!$page) $page = page('service-areas/' . $uid);
            if(!$page) $page = site()->errorPage();
            return site()->visit($page);
        }
    ],
    [
        'pattern' => 'service-areas/(:any)',
        'action'  => function($uid) {
            go($uid);
        }
    ],
    [
        'pattern' => '(:any)/(:any)',
        'action'  => function($parent, $uid) {

            $page = page($parent.'/'.$uid);

            if(!$page) $page = page('service-areas/' .$parent .'/'. $uid);
            if(!$page) $page = site()->errorPage();

            return site()->visit($page);

        }
    ],
    [
        'pattern' => 'service-areas/(:all)',
        'action'  => function($uid) {
            go($uid);
        }
    ],
];