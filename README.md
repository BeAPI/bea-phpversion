<a href="https://beapi.fr">![Be API Github Banner](/assets/banner-github.png)</a>

# BE API PHP Version #

## Description ##

Check current PHP version and optionally compare with your project's requirement.

## Screenshots

![Error if BEAPI_PHP_VERSION and current PHP version does not match](/assets/screen-error-front.png)
![success : display only php version](/assets/screen-ok-front.png)

## Installation

### WordPress

- Consider using it as [mu-plugin](https://codex.wordpress.org/Must_Use_Plugins), install it in `wp-content/mu-plugins`
- Nothing to do then !

### [Composer](http://composer.rarst.net/)

- Add repository source : `{ "type": "vcs", "url": "https://github.com/BeAPI/beapi-phpversion" }`.
- Include `"beapi/beapi-phpversion": "dev-master"` in your composer file for last master's commits or a tag released.
- Nothing to do then !

## Optional

By default it will only print current php version (tidy format) in the dashboard at glance and in admin footer text but if you add a constant in your wp-config (or dotenv) that defines the php version of your project (php version in production) :

	define( 'BEAPI_PHP_VERSION', '7.2' );

it will compare the two versions and if it does not match you will be alerted. It's especially useful when dealing with multiple environments.

## Filters

* _beapi_phpversion_is_allowed_ : default is `is_super_admin()` (which allows only administrators on single installations).
* _beapi_phpversion_success_inline_styles_
* _beapi_phpversion_error_inline_styles_
* _beapi_phpversion_inline_styles_ : global styles

## Contributing

Please refer to the [contributing guidelines](.github/CONTRIBUTING.md) to increase the chance of your pull request to be merged and/or receive the best support for your issue.

### Issues & features request / proposal

If you identify any errors or have an idea for improving the plugin, feel free to open an [issue](../../issues/new) or [create a pull request](../../compare). Please provide as much info as needed in order to help us resolving / approve your request.

## Who ?

Created by [Be API](https://beapi.fr), the French WordPress leader agency since 2009. Based in Paris, we are more than 30 people and always [hiring](https://beapi.workable.com) some fun and talented guys. So we will be pleased to work with you.

This plugin is only maintained, which means we do not guarantee some free support. Consider reporting an [issue](#issues--features-request--proposal) and be patient. 

If you really like what we do or want to thank us for our quick work, feel free to [donate](https://www.paypal.me/BeAPI) as much as you want / can, even 1€ is a great gift for buying cofee :)

## License

BEAPI - PHP version is licensed under the [GPLv3 or later](LICENSE.md).

## Changelog ##

### 0.1.2
* 20 June 2018
* Better approach, make the (alert) message shiny

### 0.1.1
* 20 June 2018
* fix missing hooks

### 0.1
* 19 June 2018
* Initial
