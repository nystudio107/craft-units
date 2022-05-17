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
      appId: 'TVGT09IBL5',
      apiKey: 'd2d2de61619265d05d80bf26ad24f9b4',
      indexName: 'nystudio107-units'
    },
    editLinks: true,
    editLinkText: 'Edit this page on GitHub',
    lastUpdated: 'Last Updated',
    sidebar: 'auto',
  },
};
