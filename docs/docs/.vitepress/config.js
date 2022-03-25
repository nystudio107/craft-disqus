module.exports = {
  title: 'Disqus Plugin Documentation',
  description: 'Documentation for the Disqus plugin',
  base: '/docs/disqus/',
  lang: 'en-US',
  head: [
    ['meta', {content: 'https://github.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://twitter.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://youtube.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://www.facebook.com/newyorkstudio107', property: 'og:see_also',}],
  ],
  themeConfig: {
    repo: 'nystudio107/craft-disqus',
    docsDir: 'docs/docs',
    docsBranch: 'v1',
    algolia: {
      appId: '',
      apiKey: '',
      indexName: 'disqus'
    },
    editLinks: true,
    editLinkText: 'Edit this page on GitHub',
    lastUpdated: 'Last Updated',
    sidebar: 'auto',
  },
};
