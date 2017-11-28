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
 - extend your project composer.json by new repository  
 ```json
   "repositories": [
     {
       "type": "git",
       "url": "https://github.com/mautic/mautic.git"
     }
   ],
   ```  
    - same way as it is in [```mautic-bundle-skeleton/composer.json```](./composer.json)
 - copy / paste whole *MauticBundleSkeleton* under name of **your** bundle name to a place you want
 - replace in the copied *MauticBundleSkeleton* the *Skeleton* word in every place by **your** bundle name
 - get inspired by EventListener\WhyMeSubscriber and **remove it**, or **rewrite**

## Troubleshooting
 If any error happens, check the logs for what happened.
 
 1. they are placed in app/logs dir in your Mautic, like `/var/www/mautic/app/logs/mautic_prod-2016-02-19.php` for example
 2. or, if they are more fatal or just Mautic does not catch them (error 500), see your web-server logs, like `/var/log/apache2/error.log`

## Technical details
This library provides [Mautic](https://www.mautic.org/) code by [composer](https://getcomposer.org/) ([packagist.org](https://packagist.org/) respectively),

# Hint for mautic Twig plugin
If you are going to create a Mautic plugin for [Twig](https://twig.symfony.com/doc/2.x/), a good start can be [mautic-twig-plugin-skeleton](https://github.com/dongilbert/mautic-twig-plugin-skeleton).