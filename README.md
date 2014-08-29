closure-scope-merger
====================

SuperClosure extension which allows to extract to reconcile a scope with the resulting scope of an executed SuperClosure after it has been unserialized.

This allows to arbitrarily execute code anywhere, and import the resulting scope into your execution scope byeffectively overriding variables in the current scope with their counterparts in the executed closure's scope.

As such, it can be **dangerous** to use this library recklessly.

## Use

Look at the unit tests :p
