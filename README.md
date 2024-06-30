# VolkswAIgen

Remember the huge scandal around Vokswagen and other car manufactures
where they had software included in their engines that made sure that
the engines were performing differently when on a test-run to make
sure that the legal regulations were met?

This is the same for AI

The library makes sure that AI bots will get a special treatment
when visiting your website.

## Why?

Sadly AI bots do not play nicely and ignore the industry standard
"robots.txt" files and regardless parse your websites content.

So if one wants to at least make it harder for AI bots to grab
your content one has to implement some other measures.

One is to try to identify a bot when they visit your application
by their user-agent and/or their IP-address and then feed them
"something else"

**This will not prohibit AI bots from visit your site!**

It is very important to understand this! Implementing this in your
site will **not** 100% assure that your content will never find
its way into an AIs training data.

As this relies upon IP-Addresses and user-agents and both are
easy to change this is a bit of a Whack-A-Mole but it will for sure
make it harder for AI to get your data

## How?

This library uses a list of user-agents and/or IP-addresses that are
used by AI Bots and when a request to your website is registered
that matches these conditions it will allow you to configure a decent
response that you seem fitting.

There will be some implementations for the most used Frameworks that
can readily be used without much effort.

The list of user-agents and IP-adresses will be fetched at regular
intervals from a separate location to make it possible to update the
list independentyl from this lib.

The results will be cached for 24 hours usually so that there will
not be too many requests for that external resources.

## Installation

VolkswAIgen is best installed via composer

```bash
composer require volkswaigen/volkswaigen
```

## Usage

```php

$volkswaigen = new \VolkswAIgen\VolkswAIgen\Main(
	new \VolkswAIgen\VolkswAIgen\ListFetcher(
		$psr6CachePoolImplementation
	)
);

if ($volkswaigen->isAiBot($userAgent, $ipAddress)) {
	// Do whatever you want to do with a request from an AI bot
}
```
