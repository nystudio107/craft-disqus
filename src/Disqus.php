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

namespace nystudio107\disqus;

use nystudio107\disqus\services\DisqusService as DisqusService;
use nystudio107\disqus\variables\DisqusVariable;
use nystudio107\disqus\twigextensions\DisqusTwigExtension;
use nystudio107\disqus\models\Settings;

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

    /**
     * @inheritdoc
     */
    public function getSettings()
    {
        $settings = parent::getSettings();
        /**
         * Doesn't work yet as per: https://github.com/craftcms/cms/issues/1548
         *
        $baseModel = $this->createSettingsModel();
        $base = $baseModel->toArray();
        foreach ($base as $key => $row) {
            $override = Craft::$app->config->get($key, 'disqus');

            if (!is_null($override) && !empty($override)) {
                $settings->$key = $override;
            }
        }
        */

        return $settings;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        // Render our settings template
        return Craft::$app->view->renderTemplate(
            'disqus/settings',
            [
                'settings' => $this->getSettings(),
            ]
        );
    }
}
