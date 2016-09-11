# Posts

Posts are made up of 3 main things. The filename, the Front Matter meta data, and the post content. They also live in the \_posts directory. Currently posts can either have a layout of podcasts (podcast) or blogs (blog).

## The filename

Jekyll is a "post" based system and the date of the post is taken from the filename. The filename template looks like this;

    YEAR-MONTH-DAY-title.MARKUP

The title is a reference for the person editing the files and not actually used anywhere. The actual title of the post is part of the Front Matter meta data.

## The Front Matter

The first section of the file content is the Front Matter meta data.  Many of the newer episodes have a full collection of the fields. This is where we add the data used to build the rest of a post that is outside of the content itself.

All posts have some basic parameters.

* *layout* : 'podcast' or 'blog' 
* *title* : The posts title
* *tagline* : An optional tagline
* *permalink* : The URL the post will live on.
* *excerpt_separator* : <!--excerpt-above--> - Any content above this separator will be used where ever the post presents a teaser. Lists of posts, etc.

### Podcast posts

* *categories* : Categories are defined in the \_data/categories.yml file. The values used here are the top level values in the post file.
* *sponsor* : Sponsors are defined in the \_data/sponsors.yml file. The values used here are the top level values in the post file.
* *media\_\** : Details about the media file.
* *show_notes* : Show notes are made up of 3 parameters. Each entry is prefixed with a hyphen and each parameter is a single line. The parameters are *title*, *link*, and *description*. Title and link are required.

### Blog posts

* *author* : A value from the data in \_data/authors.yml

## The post content

Jekyll will parse the content of posts (and other site pages) based on the filename extention. A .html file will be validated and linted. A .md file will be parsed for markdown and valid html generated.

The presence of the string defined in the *excerpt_separator* will split the content. The text above it will be used as the teaser where ever a short version of the post is needed. e.g. The text of the post in the list on the front page.

# Data

The \_data directory contains a number of files that contain additional data for use in other parts of the site.

## author.yml

Currently this provides the display name for the associated value.

## categories.yml

Categories are used in the podcast layout to place a podcast post into one of the feeds. Additional details about the feed is also provided here.

## rss.yml

A few values for the RSS feeds are set here.

## sponsors.yml

Sponsors can be added here. These entries are used in the podcast layout and provide the details for the sponsor logo in the podcast pages. The images live in the static/img/sponsors directory.
