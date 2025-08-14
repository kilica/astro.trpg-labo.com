import { defineCollection, z } from 'astro:content';

const laboCollection = defineCollection({
  type: 'content',
  schema: z.object({
    title: z.string(),
    category: z.enum(['general', 'scenariomaking', 'system']),
    parent: z.string().optional(),
    order: z.number().default(0),
    publishedAt: z.date(),
  }),
});

const blogCollection = defineCollection({
  type: 'content',
  schema: z.object({
    title: z.string(),
    category: z.enum(['general', 'game', 'dev', 'home', 'plants', 'travel', 'science']),
    tags: z.array(z.string()).default([]),
    publishedAt: z.date(),
  }),
});

const reviewCollection = defineCollection({
  type: 'content',
  schema: z.object({
    title: z.string(),
    category: z.enum(['gadget', 'book']),
    rating: z.number().min(1).max(5),
    officialUrl: z.string().url().optional(),
    amazonUrl: z.string().url().optional(),
    isbn: z.string().optional(),
    recommendFor: z.string().optional(),
    notRecommendFor: z.string().optional(),
    goodPoints: z.string().optional(),
    badPoints: z.string().optional(),
    publishedAt: z.date(),
  }),
});

export const collections = {
  labo: laboCollection,
  blog: blogCollection,
  review: reviewCollection,
};
