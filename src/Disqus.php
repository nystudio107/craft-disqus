<?php
/**
 * Disqus plugin for Craft CMS 3.x
 *
 * Integrates the Disqus commenting system into Craft 3 websites, including Single Sign On (SSO) and custom login/logout URLs
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2017 nystudio107
 */

namespace nystudio107\disqus;

use nystudio107\disqus\services\DisqusService as DisqusService;
use nystudio107\disqus\variables\DisqusVariable;
use nystudio107\disqus\twigextensions\DisqusTwigExtension;

use Craft;
use craft\base\Plugin;

/**
 * Class Disqus
 *
 * @author    nystudio107
 * @package   Disqus
 * @since     1.0.0
 *
 * @property  DisqusService $disqusService
 */
class Disqus extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Disqus
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Craft::$app->view->twig->addExtension(new DisqusTwigExtension());

        Craft::info(Craft::t('disqus', '{name} plugin loaded', ['name' => $this->name]), __METHOD__);
    }

    /**
     * @inheritdoc
     */
    public function defineTemplateComponent()
    {
        return DisqusVariable::class;
    }

    // Protected Methods
    // =========================================================================

}
