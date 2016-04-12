Example REST application
============

[![Build status](https://travis-ci.org/newage/example.svg?branch=master)](https://travis-ci.org/newage/example)

This project uses [PSR-4](http://www.php-fig.org/psr/psr-4/) autoloading standard,
[PSR-2](http://www.php-fig.org/psr/psr-2/) coding style standard

##Install project

    composer install

Start a server

    composer server

##Execute a controller
All rows read

    GET: /

A row number 2 read

    GET: /2

A row add

    POST: ["Anton","1112220000","Kirova str."]

A row number 3 update

    PUT: /3 ["Andrey","5556660000","Minina str."]

A row number 3 delete

    DELETE: /3

##Important

This code a made from scratch for test task. This code can't show my refactoring steps.
Therefore I am making a code for this task in a new repository.
I am adding a description about mine refactoring steps every commits.
I finished.
[New repository](https://github.com/newage/extend-example).