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

namespace nystudio107\disqus\twigextensions;

use nystudio107\disqus\Disqus;
use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

/**
 * @author    nystudio107
 * @package   Disqus
 * @since     1.0.0
 */
class DisqusTwigExtension extends Twig_Extension
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Disqus';
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('disqusEmbed', [$this, 'disqusEmbed']),
            new Twig_SimpleFilter('disqusCount', [$this, 'disqusCount']),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('disqusEmbed', [$this, 'disqusEmbed']),
            new Twig_SimpleFunction('disqusCount', [$this, 'disqusCount']),
        ];
    }

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
}
