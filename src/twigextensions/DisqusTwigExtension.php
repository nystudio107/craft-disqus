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
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * @author    nystudio107
 * @package   Disqus
 * @since     1.0.0
 */
class DisqusTwigExtension extends AbstractExtension
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'Disqus';
    }

    /**
     * @inheritdoc
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('disqusEmbed', [$this, 'disqusEmbed']),
            new TwigFilter('disqusCount', [$this, 'disqusCount']),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('disqusEmbed', [$this, 'disqusEmbed']),
            new TwigFunction('disqusCount', [$this, 'disqusCount']),
        ];
    }

    /**
     * @param string $disqusIdentifier
     * @param string $disqusTitle
     * @param string $disqusUrl
     * @param string $disqusCategoryId
     * @param string $disqusLanguage
     *
     * @return Markup
     */
    public function disqusEmbed(
        string $disqusIdentifier = "",
        string $disqusTitle = "",
        string $disqusUrl = "",
        string $disqusCategoryId = "",
        string $disqusLanguage = ""
    ): Markup
    {
        return Disqus::$plugin->disqusService->outputEmbedTag(
            $disqusIdentifier,
            $disqusTitle,
            $disqusUrl,
            $disqusCategoryId,
            $disqusLanguage
        );
    }

    /**
     * @param string $disqusIdentifier
     *
     * @return int
     */
    public function disqusCount(
        string $disqusIdentifier = ""
    ): int
    {
        return Disqus::$plugin->disqusService->getCommentsCount(
            $disqusIdentifier
        );
    }
}
