<?php
namespace MauticPlugin\MauticSkeletonBundle\EventListener;

use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\UserBundle\Event\UserEvent;
use Mautic\UserBundle\UserEvents;

class WhyMeSubscriber extends CommonSubscriber
{

    /**
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return [
            UserEvents::USER_PRE_DELETE => 'iWarnYou',
            UserEvents::USER_POST_DELETE => 'whoWillPayForThis'
        ];
    }

    public function iWarnYou(UserEvent $event)
    {
        trigger_error(
            'I warn you, the skeleton subscriber should be rewritten.'
            . ' Besides to your violence to ' . $event->getUser()->getName(),
            E_USER_WARNING
        );
    }

    public function whoWillPayForThis()
    {
        throw new \LogicException('Who will pay for forgotten skeleton code?');
    }

}
