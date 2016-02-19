<?php
return [
    'name' => 'Skeleton',
    'description' => 'I am just a skeleton of a new bundle. Replace anything by your will.',
    'author' => 'Friends of Mautic',
    'version' => '1.0.0',

    'services' => [
        'events' => [
            'plugin.skeleton.whyMe.subscriber' => [
                'class' => 'MauticPlugin\MauticSkeletonBundle\EventListener\WhyMeSubscriber'
            ]
        ],
    ],
];