module.exports = {
  title: 'Units Plugin Documentation',
  description: 'Documentation for the Units plugin',
  base: '/docs/units/',
  lang: 'en-US',
  head: [
    ['meta', {content: 'https://github.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://www.youtube.com/channel/UCOZTZHQdC-unTERO7LRS6FA', property: 'og:see_also',}],
    ['meta', {content: 'https://www.facebook.com/newyorkstudio107', property: 'og:see_also',}],
  ],
  themeConfig: {
    repo: 'nystudio107/craft-units',
    docsDir: 'docs/docs',
    docsBranch: 'develop',
    algolia: {
      appId: '',
      apiKey: '',
      indexName: ''
    },
    editLinks: true,
    editLinkText: 'Edit this page on GitHub',
    lastUpdated: 'Last Updated',
    sidebar: 'auto',
  },
};
