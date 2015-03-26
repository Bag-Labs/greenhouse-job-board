=== Plugin Name ===
Contributors: brownbagmarketing
Donate link: https://www.brownbagmarketing.com/
Tags: greenhouse, job board, api, resume
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin to pull a job board from greenhouse.io via their API.

== Description ==

Plugin to pull a job board from greenhouse.io via their API and display it on your WordPress site. Use a shortcode with your URL Token to pull the data. Find your URL token on this page https://app.greenhouse.io/configure/dev_center/config when you are logged into your greenhouse account. Place `[greenhouse url_token="your_url_token"]` in your page or post.

Requirements:

*   Must have a greenhouse account.
*	Use a shortcode with your URL Token to pull the data. Find your URL token on this page https://app.greenhouse.io/configure/dev_center/config when you are logged into your greenhouse account.

Requirements:

*	Must have a greenhouse account.
*	Know your URL Token

Initial Setup:

*	For ease of use, setup your URL Token within Settings->Greenhouse Job Board Settings. (NOTE that you can also set this inline within a shortcode)
*	API Key can also be set, but is not yet supported.

Know the code!

*	To post your job board on a page, simply add the shortcode: [greenhouse].  By default, this will display all of the postings you currently have, along with the forms for applying.  These forms are actually hosted at Greenhouse.io.

Current Features of the [greenhouse] shortcode:

Department Filtering

*	Want to filter results by department?  Add the departmentfilter attribute.
*	ex. [greenhouse departmentfilter="Value1|Value2"]
*	supports multiple values, pipe-delimited
*	supports single negated value - Excludes this department and shows all others. (example: departmentfilter="-Value3")

Hiding Forms

*	If you don't want application forms to show up and simply want to display listings, simply add the hideforms attribute
*	ex. [greenhouse hideforms="true"]


== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `greenhouse-job-board.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[greenhouse url_token="your_url_token"]` in your page or post.

== Changelog ==

= 1.2 =
* Adding support for department filter (include and exclude departments).
* Adding support for hiding forms from the job board.

= 1.1 =
* Adding settings page with global default settings.

= 1.0 =
* Initial release

== Screenshots ==

1. Shortcode in action.
2. View the job board list.
3. Click to view description of each job.
4. Click to apply for each job.


== Frequently Asked Questions ==

= Why no FAQ? =

No answers for no questions...