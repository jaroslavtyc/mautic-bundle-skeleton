<?php
namespace MauticPlugin\MauticSkeletonBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;

class HealthySkeletonIntegration extends AbstractIntegration
{
    protected $authenticationTypeCallback;

    public function getName()
    {
        // should be the name of the integration
        return 'HealthySkeleton';
    }

    public function getAuthenticationType()
    {
        /** @see \Mautic\PluginBundle\Integration\AbstractIntegration::getAuthenticationType */
        return 'oauth2';
    }

}