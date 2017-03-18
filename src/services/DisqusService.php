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

namespace nystudio107\disqus\services;

use nystudio107\disqus\Disqus;

use Craft;
use craft\base\Component;
use craft\helpers\Template;
use craft\web\View;

/**
 * @author    nystudio107
 * @package   Disqus
 * @since     1.0.0
 */
class DisqusService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * Output the Disqus Tag
     *
     * @param string $disqusIdentifier
     * @param string $disqusTitle
     * @param string $disqusUrl
     * @param string $disqusCategoryId
     * @param string $disqusLanguage
     *
     * @return string
     */
    public function outputEmbedTag(
        $disqusIdentifier = "",
        $disqusTitle = "",
        $disqusUrl = "",
        $disqusCategoryId = "",
        $disqusLanguage = ""
    ) {
        $settings = Disqus::$plugin->getSettings();
        $disqusShortname = $settings['disqusShortname'];

        if ($settings['useSSO']) {
            $this->outputSSOTag();
        }

        $vars = array(
            'disqusShortname' => $disqusShortname,
            'disqusIdentifier' => $disqusIdentifier,
            'disqusTitle' => $disqusTitle,
            'disqusUrl' => $disqusUrl,
            'disqusCategoryId' => $disqusCategoryId,
            'disqusLanguage' => $disqusLanguage,
        );
        $result = $this->renderPluginTemplate('disqusEmbedTag', $vars);

        return $result;
    }

    /**
     * Output the Disqus SSO Tag
     *
     * @return string
     */
    public function outputSSOTag()
    {
        $settings = Disqus::$plugin->getSettings();
        $data = array();

        // Set the data array
        $currentUser = Craft::$app->getUser()->getIdentity();
        if ($currentUser) {
            $data['id'] = $currentUser->id;
            if (Craft::$app->config->get('useEmailAsUsername')) {
                $data['username'] = $currentUser->getFullName();
            } else {
                $data['username'] = $currentUser->username;
            }
            $data['email'] = $currentUser->email;
            $data['avatar'] = $currentUser->getPhoto();
        }

        // Encode the data array and generate the hMac
        $message = base64_encode(json_encode($data));
        $timestamp = time();
        $hMac = $this->disqusHmacSha1(
            $message
            . ' '
            . $timestamp,
            $settings['disqusSecretKey']
        );

        // Set the vars for the template
        $vars = array(
            'message' => $message,
            'hmac' => $hMac,
            'timestamp' => $timestamp,
            'disqusPublicKey' => $settings['disqusPublicKey'],
        );

        // Render the SSO custom login template
        if ($settings['customLogin']) {
            $vars = array_merge($vars, array(
                'loginName' => $settings['loginName'],
                'loginButton' => $settings['loginButton'],
                'loginIcon' => $settings['loginIcon'],
                'loginUrl' => $settings['loginUrl'],
                'loginLogoutUrl' => $settings['loginLogoutUrl'],
                'loginWidth' => $settings['loginWidth'],
                'loginHeight' => $settings['loginHeight'],
            ));
            $result = $this->renderPluginTemplate('disqusSsoCustomLogin', $vars);
        } else {
            // Render the SSO template
            $result = $this->renderPluginTemplate('disqusSso', $vars);
        }

        return $result;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Render a plugin template
     *
     * @param $templatePath
     * @param $vars
     *
     * @return string
     */
    protected function renderPluginTemplate($templatePath, $vars)
    {
        // Stash the old template mode, and set it AdminCP template mode
        $oldMode = Craft::$app->view->getTemplateMode();
        Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);

        // Render the template with our vars passed in
        try {
            $htmlText = Craft::$app->view->renderTemplate('disqus/' . $templatePath, $vars);
        } catch (\Exception $e) {
            $htmlText = 'Error rendering template ' . $templatePath . ' -> ' . $e->getMessage();
            Craft::error(Craft::t('disqus', $htmlText), __METHOD__);
        }

        // Restore the old template mode
        Craft::$app->view->setTemplateMode($oldMode);

        return Template::raw($htmlText);
    }

    /**
     * HMAC->SHA1
     * From: https://github.com/disqus/DISQUS-API-Recipes/blob/master/sso/php/sso.php
     *
     * @param $data
     * @param $key
     *
     * @return string
     */
    protected function disqusHmacSha1($data, $key)
    {
        $blockSize = 64;
        $hashFunc = 'sha1';
        if (strlen($key) > $blockSize) {
            $key = pack('H*', $hashFunc($key));
        }
        $key = str_pad($key, $blockSize, chr(0x00));
        $iPad = str_repeat(chr(0x36), $blockSize);
        $oPad = str_repeat(chr(0x5c), $blockSize);
        $hMac = pack(
            'H*',
            $hashFunc(
                ($key ^ $oPad).pack(
                    'H*',
                    $hashFunc(
                        ($key ^ $iPad).$data
                    )
                )
            )
        );

        return bin2hex($hMac);
    }
}
