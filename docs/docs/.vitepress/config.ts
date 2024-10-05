import {defineConfig} from 'vitepress'

export default defineConfig({
  title: 'Vite Plugin',
  description: 'Documentation for the Vite plugin',
  base: '/docs/disqus/v4/',
  lang: 'en-US',
  head: [
    ['meta', {content: 'https://github.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://twitter.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://youtube.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://www.facebook.com/newyorkstudio107', property: 'og:see_also',}],
  ],
  themeConfig: {
    socialLinks: [
      {icon: 'github', link: 'https://github.com/nystudio107'},
      {icon: 'twitter', link: 'https://twitter.com/nystudio107'},
    ],
    logo: '/img/plugin-logo.svg',
    editLink: {
      pattern: 'https://github.com/nystudio107/craft-disqus/edit/develop-v4/docs/docs/:path',
      text: 'Edit this page on GitHub'
    },
    algolia: {
      appId: 'AE3HRUJFEW',
      apiKey: 'c5dcc2be096fff3a4714c3a877a056fa',
      indexName: 'disqus',
      searchParameters: {
        facetFilters: ["version:v4"],
      },
    },
    lastUpdatedText: 'Last Updated',
    sidebar: [],
    nav: [
      {text: 'Home', link: 'https://nystudio107.com/plugins/disqus'},
      {text: 'Store', link: 'https://plugins.craftcms.com/disqus'},
      {text: 'Changelog', link: 'https://nystudio107.com/plugins/disqus/changelog'},
      {text: 'Issues', link: 'https://github.com/nystudio107/craft-disqus/issues'},
      {
        text: 'v4', items: [
          {text: 'v5', link: 'https://nystudio107.com/docs/disqus/'},
          {text: 'v4', link: '/'},
          {text: 'v1', link: 'https://nystudio107.com/docs/disqus/v1/'},
        ],
      },
    ]
  },
});
