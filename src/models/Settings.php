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
use craft\helpers\App;
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
    public bool $lazyLoadDisqus = true;

    /**
     * @var string
     */
    public string $disqusShortname = '';

    /**
     * @var bool
     */
    public bool $useSSO = false;

    /**
     * @var string
     */
    public string $disqusPublicKey = '';

    /**
     * @var string
     */
    public string $disqusSecretKey = '';

    /**
     * @var bool
     */
    public bool $customLogin = false;

    /**
     * @var string
     */
    public string $loginName = '';

    /**
     * @var string
     */
    public string $loginButton = '';

    /**
     * @var string
     */
    public string $loginIcon = '';

    /**
     * @var string
     */
    public string $loginUrl = '';

    /**
     * @var string
     */
    public string $loginLogoutUrl = '';

    /**
     * @var int
     */
    public int $loginWidth = 800;

    /**
     * @var int
     */
    public int $loginHeight = 400;

    // Public Methods
    // =========================================================================

    /**
     * @return string the parsed secret key (e.g. 'XXXXXXXXXXX')
     */
    public function getDisqusSecretKey(): string
    {
        return App::parseEnv($this->disqusSecretKey);
    }

    /**
     * @return string the parsed public key (e.g. 'XXXXXXXXXXX')
     */
    public function getDisqusPublicKey(): string
    {
        return App::parseEnv($this->disqusPublicKey);
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
        return App::parseEnv($this->loginName);
    }

    /**
     * @return string
     */
    public function getLoginButton(): string
    {
        return App::parseEnv($this->loginButton);
    }

    /**
     * @return string
     */
    public function getLoginIcon(): string
    {
        return App::parseEnv($this->loginIcon);
    }

    /**
     * @return string
     */
    public function getLoginUrl(): string
    {
        return App::parseEnv($this->loginUrl);
    }

    /**
     * @return string
     */
    public function getLoginLogoutUrl(): string
    {
        return App::parseEnv($this->loginLogoutUrl);
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
    public function rules(): array
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
    public function behaviors(): array
    {
        return [
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
            'typecast' => [
                'class' => AttributeTypecastBehavior::class,
                // 'attributeTypes' will be composed automatically according to `rules()`
            ],
        ];
    }
}
