#News Scrape

Version 1.0
Status: Under development
Author: Philip Brown
Email: sir.philip.brown@gmail.com

Current Usages:

$ php NewsScrape.php {url} {contentType}

Examples:

$ php NewsScrape.php https://slashdot.org/ html

$ php NewsScrape.php https://hacker-news.firebaseio.com/v0/item/8863.json json

$ php NewsScrape.php http://feeds.bbci.co.uk/news/technology/rss.xml xml

This Application is still under development, the final solution will be a CLI symfony application which will write to
a database, have unit tests, validation class and more modular and robust approach.
