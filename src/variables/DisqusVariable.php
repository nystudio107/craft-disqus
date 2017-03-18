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

namespace nystudio107\disqus\variables;

use nystudio107\disqus\Disqus;

use Craft;

/**
 * @author    nystudio107
 * @package   Disqus
 * @since     1.0.0
 */
class DisqusVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function disqusSSO()
    {
        return Disqus::$plugin->disqusService->outputSSOTag();
    }

    /**
     * @param string $disqusIdentifier
     * @param string $disqusTitle
     * @param string $disqusUrl
     * @param string $disqusCategoryId
     * @param string $disqusLanguage
     *
     * @return mixed
     */
    public function disqusEmbed(
        $disqusIdentifier = "",
        $disqusTitle = "",
        $disqusUrl = "",
        $disqusCategoryId = "",
        $disqusLanguage = ""
    ) {
        return Disqus::$plugin->disqusService->outputEmbedTag(
            $disqusIdentifier,
            $disqusTitle,
            $disqusUrl,
            $disqusCategoryId,
            $disqusLanguage
        );
    }
}
