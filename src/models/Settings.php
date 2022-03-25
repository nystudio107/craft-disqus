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
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
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
            'typecast' => [
                'class' => AttributeTypecastBehavior::class,
                // 'attributeTypes' will be composed automatically according to `rules()`
            ],
            'parser' => [
                'class' => EnvAttributeParserBehavior::class,
                'attributes' => [
                    'disqusPublicKey',
                    'disqusSecretKey',
                ],
            ]
        ];
    }
}
