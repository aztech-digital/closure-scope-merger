closure-scope-merger
====================

## Build status

[![Build Status](https://travis-ci.org/aztech-digital/closure-scope-merger.svg?branch=master)](https://travis-ci.org/aztech-digital/closure-scope-merger)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/aztech-digital/closure-scope-merger/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/aztech-digital/closure-scope-merger/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/aztech-digital/closure-scope-merger/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/aztech-digital/closure-scope-merger/?branch=master)

## About

SuperClosure extension which allows to extract to reconcile a scope with the resulting scope of an executed SuperClosure after it has been unserialized.

This allows to arbitrarily execute code anywhere, and import the resulting scope into your execution scope byeffectively overriding variables in the current scope with their counterparts in the executed closure's scope.

As such, it can be **dangerous** to use this library recklessly.

## Use

Look at the unit tests :p
