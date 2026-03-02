=== Visited Pages Tracker for Contact Form 7 ===
Contributors: hidyk
Tags: contact form 7, cf7, visited pages, tracker, analytics
Requires at least: 6.6.1
Tested up to: 6.9.1
Stable tag: 1.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Track and display visited pages in your Contact Form 7 submissions to gain actionable insights.

== Description ==

Contact Form 7 Visited Pages Tracker is a WordPress plugin that enhances the Contact Form 7 plugin by tracking the pages a user has visited before submitting the form. This information is then included in the form submission email, allowing you to see which pages the user viewed before submitting the form.

Key features:
* Track the URLs of visited pages using sessionStorage.
* Automatically include the visited pages in the Contact Form 7 form submissions.
* Simple setup - just activate the plugin, add shortcode [visited-pages] it works with all your Contact Form 7 forms.
* Utilizes user browser data, leading to a simple, lightweight design that places minimal load on server performance.

This plugin allows you to track the behavior of highly valuable users who contact you through your forms. By identifying not only the landing pages but also the pages that heightened their motivation to submit the form, you can understand where their curiosity and needs were sparked. Having this information makes a significant difference in the quality of your response and service. It helps you identify key content that drives engagement and enhances the precision of personalized responses and customized service delivery based on actual user behavior.

== Important Notice ==

Please be aware: Depending on your location, especially within the EU, site owners using this plugin may need to comply with local data privacy laws and obtain user consent for data collection. If necessary, please ensure compliance to use this plugin responsibly.

== Installation ==

1. Upload the `contact-form-7-visited-pages-tracker` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Ensure you have Contact Form 7 installed and activated.
4. The plugin will automatically start tracking visited pages and include them in your form submissions.

== Frequently Asked Questions ==

Simply include the special mail tag `[visited-pages]` in your Contact Form 7 email template. The plugin will automatically replace this tag with a list of the pages the user visited before submitting the form.

= Can I control which pages are tracked? =

Currently, the plugin tracks all pages that the user visits on your site.

= What happens if a user visits the same page multiple times? =

The plugin will only store each unique URL once, so duplicate visits to the same page will not result in multiple entries in the list.


== Screenshots ==

1. open mail tab

2. Example of the `[visited-pages]` mail tag in a Contact Form 7 form email configuration.

Basically, add the [visited-pages] shortcode to the admin email, not the user auto-reply.

== Changelog ==

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.0 =
* Initial release.

== License ==
This plugin is licensed under the GPLv2 or later. You can find the full license text at the following URL: https://www.gnu.org/licenses/gpl-2.0.html