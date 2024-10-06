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

use Craft;
use craft\base\Component;
use craft\helpers\Html;
use craft\helpers\Template;
use craft\web\User;
use craft\web\View;
use nystudio107\disqus\Disqus;
use nystudio107\disqus\models\Settings;
use yii\base\Exception;
use yii\base\InvalidConfigException;

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
     * @param array $scriptAttributes
     *
     * @return string
     */
    public function outputEmbedTag(
        $disqusIdentifier = "",
        $disqusTitle = "",
        $disqusUrl = "",
        $disqusCategoryId = "",
        $disqusLanguage = "",
        $scriptAttributes = [],
    ) {
        /** @var Settings $settings */
        $settings = Disqus::$plugin->getSettings();
        $disqusShortname = $settings->getDisqusShortName();

        $vars = [
            'disqusShortname' => $disqusShortname,
            'disqusIdentifier' => $disqusIdentifier,
            'disqusTitle' => $disqusTitle,
            'disqusUrl' => $disqusUrl,
            'disqusCategoryId' => $disqusCategoryId,
            'disqusLanguage' => $disqusLanguage,
            'scriptAttributes' => Html::renderTagAttributes($scriptAttributes),
        ];
        $vars = array_merge($vars, $this->getSSOVars());
        $templateName = 'disqusEmbedTag';
        if ($settings->lazyLoadDisqus) {
            $templateName = 'disqusEmbedTagLazy';
        }
        $result = $this->renderPluginTemplate($templateName, $vars);

        return $result;
    }

    /**
     * Return the number of comments for a particular thread
     *
     * @param string $disqusIdentifier
     *
     * @return int
     */
    public function getCommentsCount(
        $disqusIdentifier = ""
    ) {
        /** @var Settings $settings */
        $settings = Disqus::$plugin->getSettings();
        if (!empty($settings->getDisqusPublicKey())) {
            $disqusShortname = $settings->getDisqusShortname();
            $apiKey = $settings->getDisqusPublicKey();

            $url = "https://disqus.com/api/3.0/threads/details.json?api_key="
                . $apiKey
                . "&forum=" . $disqusShortname
                . "&thread:ident="
                . $disqusIdentifier;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $return = curl_exec($ch);
            curl_close($ch);

            $json = json_decode($return, true);
            if ($json !== null && !empty($json["code"]) && $json["code"] == 0) {
                return $json["response"]["posts"];
            } else {
                Craft::error(Craft::t('disqus', print_r($json, true)), __METHOD__);

                return 0;
            }
        } else {
            Craft::error(Craft::t('disqus', "Public API Key missing"), __METHOD__);

            return 0;
        }
    }

    // Protected Methods
    // =========================================================================

    /**
     * Return the SSO vars
     *
     * @return array
     */
    protected function getSSOVars(): array
    {
        /** @var Settings $settings */
        $settings = Disqus::$plugin->getSettings();
        $vars = [
            'useSSO' => false,
            'useCustomLogin' => false,
        ];
        if ($settings->getUseSSO()) {
            $data = [];

            // Set the data array
            /** @var User $user */
            $user = Craft::$app->getUser();
            $currentUser = $user->getIdentity();
            if ($currentUser) {
                $data['id'] = $currentUser->id;
                if (Craft::$app->getConfig()->getGeneral()->useEmailAsUsername) {
                    $data['username'] = $currentUser->getFullName();
                } else {
                    $data['username'] = $currentUser->username;
                }
                $data['email'] = $currentUser->email;
                try {
                    $data['avatar'] = $currentUser->getPhoto()->getUrl();
                } catch (InvalidConfigException $e) {
                }
            }

            // Encode the data array and generate the hMac
            $message = base64_encode(json_encode($data));
            $timestamp = time();
            $hMac = $this->disqusHmacSha1(
                $message
                .' '
                .$timestamp,
                $settings->getDisqusSecretKey()
            );

            // Set the vars for the template
            $vars = array_merge($vars, [
                'useSSO'          => true,
                'message'         => $message,
                'hmac'            => $hMac,
                'timestamp'       => $timestamp,
                'disqusPublicKey' => $settings->getDisqusPublicKey(),
            ]);

            // Set the vars for the custom login
            if ($settings->getCustomLogin()) {
                $vars = array_merge($vars, [
                    'useCustomLogin' => true,
                    'loginName'      => $settings->getLoginName(),
                    'loginButton'    => $settings->getLoginButton(),
                    'loginIcon'      => $settings->getLoginIcon(),
                    'loginUrl'       => $settings->getLoginUrl(),
                    'loginLogoutUrl' => $settings->getLoginLogoutUrl(),
                    'loginWidth'     => $settings->getLoginWidth(),
                    'loginHeight'    => $settings->getLoginHeight(),
                ]);
            }
        }

        return $vars;
    }

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
        // Stash the old template mode, and set it Control Panel template mode
        $oldMode = Craft::$app->view->getTemplateMode();
        try {
            Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
        } catch (Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }

        // Render the template with our vars passed in
        try {
            $htmlText = Craft::$app->view->renderTemplate('disqus/' . $templatePath, $vars);
        } catch (\Exception $e) {
            $htmlText = 'Error rendering template ' . $templatePath . ' -> ' . $e->getMessage();
            Craft::error(Craft::t('disqus', $htmlText), __METHOD__);
        }

        // Restore the old template mode
        try {
            Craft::$app->view->setTemplateMode($oldMode);
        } catch (Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }

        return Template::raw($htmlText);
    }

    /**
     * HMAC->SHA1
     * From:
     * https://github.com/disqus/DISQUS-API-Recipes/blob/master/sso/php/sso.php
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
                ($key ^ $oPad) . pack(
                    'H*',
                    $hashFunc(
                        ($key ^ $iPad) . $data
                    )
                )
            )
        );

        return bin2hex($hMac);
    }
}
