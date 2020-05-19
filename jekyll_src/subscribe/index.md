---
layout: page
title: Subscribe
rb-feed:
  - name: RSS
    url: https://risky.biz/feeds/risky-business
  - name: iTunes
    url: https://podcasts.apple.com/us/podcast/risky-business/id216478078
  - name: Spotify
    url: https://open.spotify.com/show/2jzD9zn7R2d6erZz2ULLeQ
rb2-feed:
  - name: RSS
    url: https://risky.biz/feeds/rb2
  - name: iTunes
    url: https://podcasts.apple.com/au/podcast/risky-business-2/id344988701
youtube-feed:
  - name: Risky Biz Video
    url: https://www.youtube.com/channel/UC-m3DvcXfcRLQgS4jFwXAxQ
---

### Newsletter: Seriously Risky Business

[Sign up for the official Risky Business newsletter](https://srslyriskybiz.substack.com/subscribe), prepared by Brett Winterford and Patrick Gray and hosted on Substack. It's your weekly digest and analysis of the big stories shaping cyber policy, prepared a day ahead of the podcast.

### Risky Business Podcast feeds
Subscribe to the main Risky Business podcast feed:
<ul>
{% for sub in page.rb-feed %}
  <li><a href="{{ sub.url }}">{{ sub.name }}</a></li>
{% endfor %}
</ul>

### The not so regular Risky Business Podcast feeds
Subscribe to the secondary (occasional) Risky Business podcast feed:
<ul>
{% for sub in page.rb2-feed %}
  <li><a href="{{ sub.url }}">{{ sub.name }}</a></li>
{% endfor %}
</ul>

### Risky Biz Video
Subscribe to [Risky Biz Video](https://www.youtube.com/channel/UC-m3DvcXfcRLQgS4jFwXAxQ) on YouTube.
