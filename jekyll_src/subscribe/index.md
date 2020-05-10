---
layout: page
title: Subscribe
---

## Seriously Risky Business

The official newsletter of Risky Business is hosted through Substack. Sign up for [Seriously Risky Business](https://srslyriskybiz.substack.com/) for additional news that isn't covered in the podcast.

## Podcast feeds
<ul>
{% for sub in site.data.subscription %}
  <li><a href="{{ sub.url }}">{{ sub.name }}</a></li>
{% endfor %}
</ul>