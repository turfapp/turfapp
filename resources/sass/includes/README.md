# The `includes/` folder

The `includes/` folder contains Sass tools and helpers that can be included (using `@use`) into other partials. Every variable, function, mixin and placeholder should be put in here. This folder should not output a single line of CSS when compiled on its own.

It differs from the other folders in two major ways:

1. It doesn't have an `index.scss` file. This has been done to discourage developers from including everything all the time, even when only a few modules are needed.
2. It is not included in the `main.scss` file, as this isn't necessary. The partials in this folder don't output any CSS when compiled and to be able to access the variables, functions and mixins a `@use` rule is needed in each stylesheet that needs them anyway.

This folder is akin to the familiar `abstracts/`.
