# Filter plugin for CakePHP

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```
composer require darxide-pl/cakephp-filter
```

## Intro 

In real life applications, filtering queries by user input can quickly growth into enormous queries controlled by tons of inputs. 

The main idea of this plugin is keep the code clean and readable. 

Every query can have many filters as separated methods in `App\Model\Filter` namespace, and queries are passed into these filters as parameters, so filters are easy to test and maintain.

Plugin allows you to filtering queries using get variables, post variables, json input. 

Plugin has also implemented "memory" of filter in session (optional) and has easily extendable interfaces to help You with write your own implementations.

There are also `FilterForm` Helper which helps with building forms with filters.


## Quick tour

