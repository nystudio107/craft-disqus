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

use nystudio107\disqus\Disqus;

use Craft;
use craft\base\Model;

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
     * @inheritdoc
     */
    public function rules()
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
}
