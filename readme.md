# Laravel Tweets

Laravel test app `(v5.4)` - Twitter API - Caching - Custom Paginators

## Installation

Pull the project from github. Don't forget to run `composer` after pulling the project from github !

## Usage

Laravel Tweets is based on another PHP component that can be pulled via composer (included in this project) `composer require asabanovic/twittersearch`. It has one route `/` powered by `HomeController` to show 50 tweets with the following search query `#London filter:safe`. It also paginates the results showing 10 tweets per page. https://www.screencast.com/t/VBApstp1

## Unit test

Project includes two passing tests. Both tests can be found in `TwitterTest` class. The first test will pass to confirm and handle a positive Twitter response. The second test will pass to confirm and handle a Twitter negative response (error of any kind).
