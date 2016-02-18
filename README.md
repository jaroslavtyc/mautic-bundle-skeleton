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
`composer require-dev friendsofmautic/bundle-skeleton` 

## Technical details
This library provides [Mautic](https://www.mautic.org/) code by [composer](https://getcomposer.org/) ([packagist.org](https://packagist.org/) respectively),

Included Mautic version is [1.2.4](https://github.com/mautic/mautic/tree/1.2.4)
