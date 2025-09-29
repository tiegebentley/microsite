<?php

use Kirby\Uuid\Uuid;

class LocationsPage extends Page
{
    public function children(): Pages
    {
        if ($this->children instanceof Pages) {
            return $this->children;
        }

        $csvFilePath = kirby()->root('content') . '/locations.csv';

        if (!file_exists($csvFilePath)) {
            return Pages::factory([], $this);
        }

        $csv = csv($csvFilePath, ';');
        $children = [];

        foreach ($csv as $location) {
            $mainLocation = $location['MainLocation'];
            $subLocation = $location['SubLocation'] ?? null;

            $mainLocationSlug = Str::slug($mainLocation);
            $subLocationSlug = $subLocation ? Str::slug($subLocation) : null;

            if (!isset($children[$mainLocationSlug])) {
                $children[$mainLocationSlug] = [
                    'slug'     => 'service-in-' . $mainLocationSlug,
                    'template' => 'location',
                    'model'    => 'locations',
                    'num'      => 0,
                    'content'  => [
                        'title' => $mainLocation,
                        'uuid'  => Uuid::generate(),
                    ],
                    'children' => []
                ];
            }

            if ($subLocation) {
                $children[$mainLocationSlug]['children'][$subLocationSlug] = [
                    'slug'     => 'service-in-' . $subLocationSlug . '-' . $mainLocationSlug,
                    'template' => 'sublocation',
                    'model'    => 'sublocation',
                    'num'      => 0,
                    'content'  => [
                        'title'       => $subLocation,
                        'uuid'        => Uuid::generate(),
                        'mainLocation' => $mainLocation,
                        'subLocation' => $subLocation,
                    ]
                ];
            }
        }

        return $this->children = Pages::factory(array_values($children), $this);
    }
}
