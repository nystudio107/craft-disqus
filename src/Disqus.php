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

use Craft;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use nystudio107\disqus\models\Settings;

use nystudio107\disqus\services\DisqusService as DisqusService;
use nystudio107\disqus\twigextensions\DisqusTwigExtension;
use nystudio107\disqus\variables\DisqusVariable;

use yii\base\Event;

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

    /**
     * @var bool
     */
    public static $craft31 = false;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSection = false;

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        $config['components'] = [
            'disqusService' => DisqusService::class,
        ];

        parent::__construct($id, $parent, $config);
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Version helpers
        self::$craft31 = version_compare(Craft::$app->getVersion(), '3.1', '>=');

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('disqus', DisqusVariable::class);
            }
        );

        Craft::$app->view->registerTwigExtension(new DisqusTwigExtension());

        Craft::info(
            Craft::t(
                'disqus',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
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
