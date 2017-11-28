<?php
return array(
    'name' => 'Skeleton',
    'description' => 'I am just a skeleton of a new bundle. Replace anything by your will.',
    'author' => 'Friends of Mautic',
    'version' => '1.0.0',

    'services' => array(
        'events' => array(
            'plugin.skeleton.whyMe.subscriber' => array(
                'class' => 'MauticPlugin\MauticSkeletonBundle\EventListener\WhyMeSubscriber'
            )
        ),
    ),
);