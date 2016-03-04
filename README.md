## Example

```php
<?php
 namespace MauticPlugin\VocativeBundle;
 
 use Mautic\PluginBundle\Bundle\PluginBundleBase;
 
 class VocativeBundle extends PluginBundleBase
 {
 
 }
```
*Try that in your IDE without the PluginBundleBase class available. Pain in the %body_part%.*

## Purpose
By fetching this skeleton to your code, the problem is solved.
Your IDE will finally get access to all those classes you are inheriting from.

## Usage
 - `composer require-dev friendsofmautic/bundle-skeleton`
 - replace *skeleton* word in every place by your bundle name
 - inspire by EventListener\WhyMeSubscriber and **remove it**, or rewrite

## Troubleshooting
 If any error happens, check the logs for what happened.
 
 1. they are placed in app/logs dir in your Mautic, like `/var/www/mautic/app/logs/mautic_prod-2016-02-19.php` for example
 2. or, if they are more fatal or just Mautic does not catch them (error 500), see your web-server logs, like `/var/log/apache2/error.log`

## Technical details
This library provides [Mautic](https://www.mautic.org/) code by [composer](https://getcomposer.org/) ([packagist.org](https://packagist.org/) respectively),

Included Mautic version is [1.2.4](https://github.com/mautic/mautic/tree/1.2.4)
