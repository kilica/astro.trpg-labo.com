import rss from '@astrojs/rss';
import { getCollection } from 'astro:content';

export async function GET(context) {
  const blogEntries = await getCollection('blog');
  const sortedEntries = blogEntries.sort(
    (a, b) => b.data.publishedAt.getTime() - a.data.publishedAt.getTime()
  );

  return rss({
    title: '氷川TRPG研究室 ブログ',
    description: 'TRPGや日常に関する記事を投稿しています。',
    site: context.site,
    items: sortedEntries.map((entry) => ({
      title: entry.data.title,
      pubDate: entry.data.publishedAt,
      description: entry.body ? entry.body.slice(0, 200) + '...' : '',
      link: `/blog/${entry.slug}/`,
      categories: entry.data.tags,
    })),
    customData: `<language>ja</language>`,
  });
}
