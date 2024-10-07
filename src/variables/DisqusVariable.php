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
     * @param string $disqusIdentifier
     * @param string $disqusTitle
     * @param string $disqusUrl
     * @param string $disqusCategoryId
     * @param string $disqusLanguage
     * @param array $scriptAttributes ,
     *
     * @return string
     */
    public function disqusEmbed(
        $disqusIdentifier = "",
        $disqusTitle = "",
        $disqusUrl = "",
        $disqusCategoryId = "",
        $disqusLanguage = "",
        $scriptAttributes = []
    ) {
        return Disqus::$plugin->disqusService->outputEmbedTag(
            $disqusIdentifier,
            $disqusTitle,
            $disqusUrl,
            $disqusCategoryId,
            $disqusLanguage,
            $scriptAttributes
        );
    }

    /**
     * @param string $disqusIdentifier
     *
     * @return int
     */
    public function disqusCount(
        $disqusIdentifier = ""
    ) {
        return Disqus::$plugin->disqusService->getCommentsCount(
            $disqusIdentifier
        );
    }

    /**
     * Return whether we are running Craft 3.1 or later
     *
     * @return bool
     */
    public function craft31(): bool
    {
        return Disqus::$craft31;
    }
}
