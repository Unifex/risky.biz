---
layout: default
title: Risky Business
description: It's a jungle out there!
---
{% for cat in site.categories %}
  {% assign catposts = cat[1] %}
  {% if catposts.size > 0 %}
    {% assign catstub = cat[0] %}
    {% assign thiscat = site.data.categories.[catstub] %}
## {{ thiscat.title }}
{{ thiscat.description }}

[ View posts in this category ]( {{ catstub }}/ )
  {% endif %}
{% endfor %}
