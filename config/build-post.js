const fs = require('fs');
const path = require('path');

const contentPath = path.join(__dirname, 'post-content-ligen-evolution.html');
const content = fs.readFileSync(contentPath, 'utf8');

const post = {
  id: '1',
  slug: 'best-electric-bicycle-daily-commute-india-2026-ligen-evolution-series',
  category: 'Electric Bicycles',
  title: 'Best Electric Bicycle for Daily Commute in India (2026) | LIGEN EVOLUTION SERIES',
  excerpt: 'Discover why LIGEN Evolution Series is the best electric bicycle for daily commute in India. License-free, affordable, eco-friendly & perfect for city roads.',
  meta_description: 'Discover why LIGEN Evolution Series is the best electric bicycle for daily commute in India. License-free, affordable, eco-friendly & perfect for city roads.',
  meta_keywords: 'electric bicycle India, LIGEN Evolution Series, daily commute, e-bike 2026, license-free, eco-friendly, Patna, Jamshedpur',
  date: 'January 30, 2026',
  date_iso: '2026-01-30',
  image: '/uploads/blog/featured-best-electric-bicycle-india-2026.png',
  author: 'Ligen Power® Mobility Team',
  content: content,
  published: true,
  created_at: new Date().toISOString(),
  updated_at: new Date().toISOString()
};

const data = {
  posts: [post],
  updated_at: new Date().toISOString()
};

fs.writeFileSync(path.join(__dirname, 'posts.json'), JSON.stringify(data, null, 2), 'utf8');
console.log('Post created successfully.');
