<?php
/**
 * Disqus plugin for Craft CMS 3.x
 *
 * Integrates the Disqus commenting system into Craft 3 websites, including
 * Single Sign On (SSO) and custom login/logout URLs
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2017 nystudio107
 */

namespace nystudio107\disqus\controllers;

use Craft;
use craft\web\Controller;

/**
 * @author    nystudio107
 * @package   Disqus
 * @since     1.0.0
 */
class DefaultController extends Controller
{
    // Protected Properties
    // =========================================================================

    protected $allowAnonymous = ['logout-redirect'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionLogoutRedirect()
    {
        Craft::$app->getUser()->logout(false);
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
