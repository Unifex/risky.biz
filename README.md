# Risky Business - a podcast

This is the source that generates the site at http://risky.biz.

It came about because [I](https://github.com/Unifex) had some time on my hands and was wanting wanting to learn [Jekyll](https://jekyllrb.com/). Patrick had also been wanting to migrate the site to a more secure system and due to the nature of the site there was no real need for a full blown CMS or even DB driven blog engine behind it. Jekyll seemed like a good compromise. The repos initial commit is the result of 3 days playing with Jekyll and a bit of python to scrape the original site.

While this site is geared towards podcasts it will serve nicely as a clean, stand alone blog. Regarding the podcasts, Patrick hosts his media on a separate CND so none of the larger files are in this repo.

## Building the site

I've found the easiest way to work with Jekyll is with the docker container. Starting [here](https://github.com/jekyll/docker/wiki/Usage:-Running) you can be building the site in less than a few minutes. In short;

    cd /path/to/repo
    docker run --rm --label=jekyll --volume=$(pwd):/srv/jekyll:2.5.3 -it -p 127.0.0.1:4000:4000 jekyll/jekyll

Then point a browser at http://127.0.0.1:4000

If you're uploading the generated site it will be in the `_site` directory.

## Credits

* Jekyll: for the engine and for providing an awesome [docker instance](https://hub.docker.com/r/jekyll/jekyll/) that makes all the things easy.
* Base theme: [Stack Problems](http://jekyllthemes.org/themes/stack-problems/)
* Source scraped with [Python](https://www.python.org/): Because the people that write the languages we use don't get enough credit in the credits sections.
