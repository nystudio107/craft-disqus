<?php
/**
 * Disqus plugin for Craft CMS 3.x
 *
 * Integrates the Disqus commenting system into Craft 3 websites, including Single Sign On (SSO) and custom login/logout URLs
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2017 nystudio107
 */

/**
 * Disqus config.php
 *
 * Completely optional configuration settings for Disqus if you want to
 * customize some of its more esoteric behavior, or just want specific control
 * over things.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'disqus.php' and
 * make your changes there.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

// Leave any value in the array blank to cause it to not override the Admin CP settings
return [
    'disqusShortname' => '',
    'useSSO' => false,
    'disqusPublicKey' => '',
    'disqusSecretKey' => '',
    'customLogin' => false,
    'loginName' => '',
    'loginButton' => '',
    'loginIcon' => '',
    'loginUrl' => '',
    'loginLogoutUrl' => '',
    'loginWidth' => '',
    'loginHeight' => '',
];
