# Risky Business - a podcast

This is the source that generates the site at http://risky.biz.

It came about because [I](https://github.com/Unifex) had some time on my hands and was wanting wanting to learn [Jekyll](https://jekyllrb.com/). Patrick had also been wanting to migrate the site to a more secure system and due to the nature of the site there was no real need for a full blown CMS or even DB driven blog engine behind it. Jekyll seemed like a good compromise. The repos initial commit is the result of 3 days playing with Jekyll and a bit of python to scrape the original site.

While this site is geared towards podcasts it will serve nicely as a clean, stand alone blog. Regarding the podcasts, Patrick hosts his media on a separate CND so none of the larger files are in this repo.

## Editing...

The site is easy enough to maintain by hand, if you are comfortable with that sort of thing. However, that's not everone. I'm considering adding a simple php based editor designed to be run on a local machine. This will just look after edits of posts and is not intended to be used online. Git management will still be a manual process, but there are a lot of GUI's out there that look after that.

## Building the site

I've found the easiest way to work with Jekyll is with the docker container. Starting [here](https://github.com/jekyll/docker/wiki/Usage:-Running) you can be building the site in less than a few minutes. In short;

    cd /path/to/repo
    docker run --rm --label=jekyll --volume=$(pwd):/srv/jekyll -it -p 127.0.0.1:4000:4000 jekyll/jekyll:2.5.3

Then point a browser at http://127.0.0.1:4000

If you're uploading the generated site it will be in the `_site` directory.

## Configuration
In the \_data directory there are a number of YML files. These are used in providing various values to the FrontMatter used in the blog and podcasts layouts.

### authors.yml
These are used on the blog posts to present a consistant author name and the key can be used as a url slug in the future should we ever add something like ```/author/author-slug```.

### categories.yml
This was used to provide a few extra values to each category. The Categories are no longer used.

### rss.yml
This file contains values replaced in the RSS feeds.

### sponsors.yml
The layout for these are:
```
sponsor_key:
  name: Display name
  url: The url the user is sent to if clicked
  banner_url: path or URL to the browser
```

The sponsor key is not displayed. It just needs to be unique, a single string(no spaces(use underscores)), something related is good.

The banner_url can either be a fully formed URL or an absolute path. In the ```jekyll_src``` directory any directories that _do not_ with an underscore will be added to the compiled site. The ```static/img/sponsors``` directory is where I've been putting the images so to reference images in that directory the banner_url would be ```/static/img/sponsors/placeholder_sponsor_image.png```.

## Credits

* Jekyll: for the engine and for providing an awesome [docker instance](https://hub.docker.com/r/jekyll/jekyll/) that makes all the things easy.
* Base theme: [Stack Problems](http://jekyllthemes.org/themes/stack-problems/)
* Source scraped with [Python](https://www.python.org/): Because the people that write the languages we use don't get enough credit in the credits sections.
