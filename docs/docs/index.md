[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nystudio107/craft-disqus/badges/quality-score.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-disqus/?branch=v1) [![Code Coverage](https://scrutinizer-ci.com/g/nystudio107/craft-disqus/badges/coverage.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-disqus/?branch=v1) [![Build Status](https://scrutinizer-ci.com/g/nystudio107/craft-disqus/badges/build.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-disqus/build-status/v1) [![Code Intelligence Status](https://scrutinizer-ci.com/g/nystudio107/craft-disqus/badges/code-intelligence.svg?b=v1)](https://scrutinizer-ci.com/code-intelligence)

# Disqus plugin for Craft CMS 3.x

Integrates the Disqus commenting system into Craft 3 websites, including Single Sign On (SSO) and custom login/logout URLs

![Screenshot](./resources/img/plugin-logo.png)

Related: [Disqus for Craft 2.x](https://github.com/nystudio107/disqus)

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

To install Disqus, follow these steps:

1. Install with Composer via `composer require nystudio107/craft-disqus` from your project directory
2. Install the plugin via `./craft install/plugin disqus` via the CLI -or- in the Craft Control Panel under Settings > Plugins

You can also install Disqus via the **Plugin Store** in the Craft AdminCP.

## Configuring Disqus

First, make sure you have [set up a Disqus account](https://disqus.com/websites/).

Next in the Craft Control Panel, go to Settings->Plugins->Disqus and enter the Short Name for your Disqus site.  This is the only required setting for the Disqus plugin.

All settings are also configurable via the `config.php` file, which is a multi-environment friendly way to store the default settings.  Don’t edit this file, instead copy it to `craft/config` as `disqus.php` and make your changes there.

The **Lazy Load Disqus** settings lets you control whether the Disqus JavaScript will only be [lazily loaded](https://www.samclarke.com/lazy-loading-disqus/) when the user scrolls down to the comments. This is on my default for performance reasons, but you can disabled it to.

### Single Sign On (SSO)

The real usefulness of the Disqus plugin is that it takes care of the Single Sign On (SSO) integration with your Craft site.

Before you can use this, you’ll need to set up the Disqus SSO API as described on the [Integrating Single Sign-On](https://help.disqus.com/customer/portal/articles/236206-integrating-single-sign-on) web page.

Then copy and paste the API Key and API Secret into the Disqus plugin settings, and turn on the "User Single Sign On" lightswitch.

### Custom Login/Logout URLs

The Disqus plugin will also take care of the custom login/logout URLs, should you wish to use them.  Please see [Adding your own SSO login and logout links](https://help.disqus.com/customer/portal/articles/236206-integrating-single-sign-on#sso-login) for details.

You only need this is you want to have a custom login button displayed in the Disqus UI itself.  

`url` should be the address of your login page. The page will be opened in a new window and it must close itself after authentication is done. That is how we know when it is done and reload the page.

`logout` should be set to `http://example.com/actions/disqus/default/logout-redirect` to hit the Disqus controller that handles the logout and redirect.

## Using the Disqus plugin in your templates

### Embedding comments

All of these methods accomplish the same thing:

```twig
    {# Output the Disqus embed code using the 'disqusEmbed' function #}
    {{ disqusEmbed(DISQUS_IDENTIFIER, DISQUS_TITLE, DISQUS_URL, DISQUS_CATEGORY_ID, DISQUS_LANGUAGE, SCRIPT_ATTRIBUTES) }}

    {# Output the Disqus embed code using the 'disqusEmbed' filter #}
    {{ DISQUS_IDENTIFIER | disqusEmbed(DISQUS_TITLE, DISQUS_URL, DISQUS_CATEGORY_ID, DISQUS_LANGUAGE, SCRIPT_ATTRIBUTES) }}

    {# Output the Disqus embed code using the 'disqusEmbed' variable #}
    {{ craft.disqus.disqusEmbed(DISQUS_IDENTIFIER, DISQUS_TITLE, DISQUS_URL, DISQUS_CATEGORY_ID, DISQUS_LANGUAGE, SCRIPT_ATTRIBUTES) }}
```

All of the parameters except for `DISQUS_IDENTIFIER` are optional.  For more information on what these parameters are, please see [JavaScript configuration variables](https://help.disqus.com/customer/portal/articles/472098-javascript-configuration-variables)

Disqus ignores any settings that are empty strings, for example: `''`

The typical Twig tag you’ll use would look like this:

```twig
    {{ disqusEmbed(entry.slug, entry.title, entry.url) }}
```

...which will result in comments that are unique on a per-entry basis.

In its most basic case, this will result in output to your Craft template that looks like this:

```html
    <div id="disqus_thread"></div>
    <script data-cfasync="false" type="text/javascript">
        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
         */

        if (typeof disqus_config !== 'undefined') {
            var _old_disqus_config = disqus_config;
        }
        var disqus_config = function() {
            if (typeof _old_disqus_config !== 'undefined') {
                _old_disqus_config.apply(this);
            }
            this.page.url = 'DISQUS_URL';
            this.page.identifier = 'DISQUS_IDENTIFIER';
            this.page.title = 'DISQUS_TITLE';
            this.page.category_id = 'DISQUS_CATEGORY_ID';
            this.language = 'DISQUS_LANGUAGE';
        };

        (function() {  // REQUIRED CONFIGURATION VARIABLE: EDIT THE SHORTNAME BELOW
            var d = document, s = d.createElement('script');

            s.src = '//DISQUS_SHORTNAME.disqus.com/embed.js';  // IMPORTANT: Replace EXAMPLE with your forum shortname!

            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
```

The `DISQUS_SHORTNAME` setting is taken from the Control Panel or `config.php` settings, and the rest of the `DISQUS_*` settings are passed in as variables from the `disqusEmbed` Twig filter/function.

If you have turned on "Use Single Sign On" it will also output something like this in the above tag:

```js
    this.page.remote_auth_s3 = "eyJpZCI6IjEiLCJ1c2VybmFtZSI6IkFkbWluIiwiZW1haWwiOiJhbmRyZXdAbWVnYWxvbWFuaWFjLmNvbSJ9 c0e4b8f2eca3c0e995cdd64ba2dedd720820ab5b 1431214361";
    this.page.api_key = "GTX1r1JBbiJah3hzZkBO06hI71VxjyWxgdurckHYBWLiELkHDidVmnDkBW0XeROe";
```

Which, assuming you’ve set up the Disqus SSO properly, will allow your Craft users to be logged into Disqus using your Craft site credentials.

If you have "Use Custom Login/Logout URLs" turned on, it will also generate the `this.sso` settings for you, [as described here](https://help.disqus.com/customer/portal/articles/236206-integrating-single-sign-on#sso-login)

### Displaying Comment Counts

The Disqus plugin also allows you to display the number of comments a particular Disqus thread has received in your templates. All of these methods accomplish the same thing:

```twig
    {# Output the number of comments using the 'disqusCount' function #}
    {{ disqusCount(DISQUS_IDENTIFIER) }}

    {# Output the number of comments using the 'disqusCount' filter #}
    {{ DISQUS_IDENTIFIER | disqusCount }}

    {# Output the number of comments using the 'disqusCount' variable #}
    {{ craft.disqus.disqusCount(DISQUS_IDENTIFIER) }}
```
To access comment counts, you will need [register an API application](https://help.disqus.com/customer/portal/articles/787016-how-to-create-an-api-application) first to obtain your API keys. You then will need to enter your API keys into the Disqus plugin settings.

## Disqus Multi-lingual sites

By default, Disqus will use the language you have set in `Disqus Admin > Setup > Appearance`, however you can use it on [Multi-lingual sites](https://help.disqus.com/customer/portal/articles/466249-multi-lingual-websites) as well.

The `DISQUS_LANGUAGE` parameter you can provide to `disqusEmbed()` allows you to control the language that the Disqus embed is displayed in. The comments, however, will still be the same for all languages.

To have the comments themselves be different per-language, you can do something like:

```twig
    {{ disqusEmbed(entry.slug ~ "_" ~ entry.locale, entry.title, entry.url, '', entry.locale ) }}
```

This will result in comments that are different for each language, and the Disqus embed will be displayed in the same language as the comments.

## Additional `<script>` Attributes

To add additional attributes to the Disqus `<script>` that the Disqus plugin renders, you can do that via the `SCRIPT_ATTRIBUTES` parameter:

```twig
    {{ disqusEmbed(entry.slug ~ "_" ~ entry.locale, entry.title, entry.url, '', '', { class: "some-class" } ) }}
```

This will add the `class="some-class"` attribute to the rendered Disqus `<script>` tag.

This can be useful for GDPR compliance integrations.

Brought to you by [nystudio107](https://nystudio107.com)
