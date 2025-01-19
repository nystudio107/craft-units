import {defineConfig} from 'vitepress'

export default defineConfig({
  title: 'Units Plugin',
  description: 'Documentation for the Units plugin',
  base: '/docs/units/',
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
      pattern: 'https://github.com/nystudio107/craft-units/edit/develop-v5/docs/docs/:path',
      text: 'Edit this page on GitHub'
    },
    algolia: {
      appId: 'TVGT09IBL5',
      apiKey: 'd2d2de61619265d05d80bf26ad24f9b4',
      indexName: 'nystudio107-units',
      searchParameters: {
        facetFilters: ["version:v5"],
      },
    },
    lastUpdatedText: 'Last Updated',
    sidebar: [],
    nav: [
      {text: 'Home', link: 'https://nystudio107.com/plugins/units'},
      {text: 'Store', link: 'https://plugins.craftcms.com/units'},
      {text: 'Changelog', link: 'https://nystudio107.com/plugins/units/changelog'},
      {text: 'Issues', link: 'https://github.com/nystudio107/craft-units/issues'},
      {
        text: '54', items: [
          {text: 'v5', link: '/'},
          {text: 'v4', link: 'https://nystudio107.com/docs/units/v4/'},
          {text: 'v1', link: 'https://nystudio107.com/docs/units/v1/'},
        ],
      },
    ]
  },
});
