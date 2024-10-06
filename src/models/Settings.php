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

namespace nystudio107\disqus\models;

use craft\base\Model;
use craft\behaviors\EnvAttributeParserBehavior;
use nystudio107\disqus\Disqus;
use yii\behaviors\AttributeTypecastBehavior;

/**
 * @author    nystudio107
 * @package   Disqus
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var bool
     */
    public $lazyLoadDisqus = true;

    /**
     * @var string
     */
    public $disqusShortname = '';

    /**
     * @var bool
     */
    public $useSSO = false;

    /**
     * @var string
     */
    public $disqusPublicKey = '';

    /**
     * @var string
     */
    public $disqusSecretKey = '';

    /**
     * @var bool
     */
    public $customLogin = false;

    /**
     * @var string
     */
    public $loginName = '';

    /**
     * @var string
     */
    public $loginButton = '';

    /**
     * @var string
     */
    public $loginIcon = '';

    /**
     * @var string
     */
    public $loginUrl = '';

    /**
     * @var string
     */
    public $loginLogoutUrl = '';

    /**
     * @var int
     */
    public $loginWidth = 800;

    /**
     * @var int
     */
    public $loginHeight = 400;

    // Public Methods
    // =========================================================================

    /**
     * @return string the parsed secret key (e.g. 'XXXXXXXXXXX')
     */
    public function getDisqusSecretKey(): string
    {
        return Disqus::$craft31 ? Craft::parseEnv($this->disqusSecretKey) : $this->disqusSecretKey;
    }

    /**
     * @return string the parsed public key (e.g. 'XXXXXXXXXXX')
     */
    public function getDisqusPublicKey(): string
    {
        return Disqus::$craft31 ? Craft::parseEnv($this->disqusPublicKey) : $this->disqusPublicKey;
    }

    /**
     * @return string 
     */
    public function getDisqusShortname(): string
    {
        return $this->disqusShortname;
    }

    /**
     * @return bool
     */
    public function getUseSSO(): bool
    {
        return $this->useSSO;
    }

    /**
     * @return bool
     */
    public function getCustomLogin(): bool
    {
        return $this->customLogin;
    }

    /**
     * @return string
     */
    public function getLoginName(): string
    {
        return Disqus::$craft31 ? Craft::parseEnv($this->loginName) : $this->loginName;
    }

    /**
     * @return string
     */
    public function getLoginButton(): string
    {
        return Disqus::$craft31 ? Craft::parseEnv($this->loginButton) : $this->loginButton;
    }

    /**
     * @return string
     */
    public function getLoginIcon(): string
    {
        return Disqus::$craft31 ? Craft::parseEnv($this->loginIcon) : $this->loginIcon;
    }

    /**
     * @return string
     */
    public function getLoginUrl(): string
    {
        return Disqus::$craft31 ? Craft::parseEnv($this->loginUrl) : $this->loginUrl;
    }

    /**
     * @return string
     */
    public function getLoginLogoutUrl(): string
    {
        return Disqus::$craft31 ? Craft::parseEnv($this->loginLogoutUrl) : $this->loginLogoutUrl;
    }

    /**
     * @return int
     */
    public function getLoginWidth(): int
    {
        return $this->loginWidth;
    }

    /**
     * @return int
     */
    public function getLoginHeight(): int
    {
        return $this->loginHeight;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['lazyLoadDisqus', 'boolean'],
            ['lazyLoadDisqus', 'default', 'value' => false],
            ['disqusShortname', 'string'],
            ['disqusShortname', 'default', 'value' => ''],
            ['useSSO', 'boolean'],
            ['useSSO', 'default', 'value' => false],
            ['disqusPublicKey', 'string'],
            ['disqusPublicKey', 'default', 'value' => ''],
            ['disqusSecretKey', 'string'],
            ['disqusSecretKey', 'default', 'value' => ''],
            ['customLogin', 'boolean'],
            ['customLogin', 'default', 'value' => false],
            ['loginName', 'string'],
            ['loginName', 'default', 'value' => ''],
            ['loginButton', 'string'],
            ['loginButton', 'default', 'value' => ''],
            ['loginIcon', 'string'],
            ['loginIcon', 'default', 'value' => ''],
            ['loginUrl', 'string'],
            ['loginUrl', 'default', 'value' => ''],
            ['loginLogoutUrl', 'string'],
            ['loginLogoutUrl', 'default', 'value' => ''],
            ['loginWidth', 'integer', 'min' => 400, 'max' => 2000],
            ['loginWidth', 'default', 'value' => 800],
            ['loginHeight', 'integer', 'min' => 200, 'max' => 1000],
            ['loginHeight', 'default', 'value' => 400],
        ];
    }


    /**
     * @return array
     */
    public function behaviors()
    {
        $craft31Behaviors = [];
        if (Disqus::$craft31) {
            $craft31Behaviors = [
                'parser' => [
                    'class' => EnvAttributeParserBehavior::class,
                    'attributes' => [
                        'loginName',
                        'loginButton',
                        'loginIcon',
                        'loginUrl',
                        'loginLogoutUrl',
                        'disqusPublicKey',
                        'disqusSecretKey',
                    ],
                ],
            ];
        }

        return array_merge($craft31Behaviors, [
            'typecast' => [
                'class' => AttributeTypecastBehavior::class,
                // 'attributeTypes' will be composed automatically according to `rules()`
            ],
        ]);
    }
}
