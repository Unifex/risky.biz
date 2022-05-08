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
rbn-feed:
  - name: RSS
    url: https://risky.biz/feeds/risky-business-news
  - name: iTunes
    url: https://podcasts.apple.com/au/podcast/risky-business-news/id1621305970
  - name: Spotify
    url: https://open.spotify.com/show/0BdExoUZqbGsBYjt6QZl4Q
rb2-feed:
  - name: RSS
    url: https://risky.biz/feeds/rb2
  - name: iTunes
    url: https://podcasts.apple.com/au/podcast/risky-business-2/id344988701
youtube-feed:
  - name: Risky Biz Video
    url: https://www.youtube.com/channel/UC-m3DvcXfcRLQgS4jFwXAxQ
---
## The Risky Business News podcast and newsletter:

### The Risky Business podcast:
Subscribe to the primary Risky Business podcast feed to listen to the weekly show, plus the Snake Oilers and Soap Box podcasts:
<ul>
{% for sub in page.rb-feed %}
  <li><a href="{{ sub.url }}">{{ sub.name }}</a></li>
{% endfor %}
</ul>

### The Risky Business News podcast and newsletter:

Subscribe to the Risky Business News podcast. Prepared by Catalin Cimpanu, Risky Business News is published three times a week and gives listeners a rundown on the latest cybersecurity news stories. Risky Business News is also [available in written form](https://riskybiznews.substack.com/) as a Substack newsletter.
<ul>
{% for sub in page.rbn-feed %}
  <li><a href="{{ sub.url }}">{{ sub.name }}</a></li>
{% endfor %}
</ul>

### Risky Biz Product Demos:
Subscribe to the [Risky Biz product demo channel](https://www.youtube.com/channel/UCZzIaWixWHa96R7K4c40_Dg) on YouTube.

### For the policy crowd:
[Sign up for the Seriously Risky Business newsletter](https://srslyriskybiz.substack.com/subscribe), prepared by Tom Uren and hosted on Substack. It’s your weekly digest and analysis of the big stories shaping cyber policy.
