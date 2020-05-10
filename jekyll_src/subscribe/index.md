---
layout: page
title: Subscribe
---

## Seriously Risky Business


The official newsletter of Risky Business is hosted through Substack. Sign up for [Seriously Risky Business](https://srslyriskybiz.substack.com/) for additional news that isn't covered in the podcast prepared by Brett Winterford and Patrick Gray.

## Risky Business Podcast feeds
The regular weekly podcast
<ul>
{% for sub in site.data.subscription %}
  <li><a href="{{ sub.url }}">{{ sub.name }}</a></li>
{% endfor %}
</ul>

## The not so regular Risky Business Podcast feeds
We have a secondary feed of items that don't really fit into the regular feed. These items have no regular release schedule.
<ul>
{% for sub2 in site.data.subscription2 %}
  <li><a href="{{ sub2.url }}">{{ sub2.name }}</a></li>
{% endfor %}
</ul>