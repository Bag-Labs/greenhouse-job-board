=== Plugin Name ===
Contributors: brownbagmarketing
Donate link: https://www.brownbagmarketing.com/
Tags: greenhouse, job board, api, resume, careers, hr, recruiter
Requires at least: 3.0
Tested up to: 4.3.1
Stable tag: 2.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin to pull a job board from greenhouse.io via their API.

== Description ==

Plugin to pull a job board from greenhouse.io via their API and display it on your WordPress site. Use a shortcode with your URL Token to pull the data. Find your URL token on <a href="https://app.greenhouse.io/configure/dev_center/config" target="_blank">this page</a> when you are logged into your greenhouse account. Place `[greenhouse url_token="your_url_token"]` in your page or post.

Requirements:

*	Must have a greenhouse account.
*	Enter your URL Token & API key.

Initial Setup:

*	For ease of use, setup your URL Token within Settings->Greenhouse. (NOTE: you can also set this inline with shortcode attributes.)
*	Add shortcode or use the wizard to add a job board to any page or post.

Know the code!

*	To post your job board on a page, simply add the shortcode: [greenhouse].  By default, this will display all of the postings you currently have, along with the forms for applying.  These forms are actually hosted at Greenhouse.io.

Current Features of the [greenhouse] shortcode:

Filter the jobs displayed. These filters can be combined to create complex filters.

Department Filtering

*	Want to filter results by department? Show only one deparment or a couple? Exclude a whole department?
*	Add the `department_filter` attribute: `[greenhouse department_filter="Value1|Value2"]`
*	supports single or multiple values, pipe-delimited
*	supports either using the department name OR the department id as the value.
*	supports negated values - Excludes department(s) and display others. (example: `department_filter="-Value3|-Value4"`)

Job Filtering

*	Want to filter results by job? display only specific jobs? Exclude specific jobs?
*	Add the `job_filter` attribute: `[greenhouse job_filter="Value1|Value2"]`
*	supports single or multiple values, pipe-delimited
*	supports either using the job title OR the job id as the value.
*	supports negated values - Excludes this job and show others. (example: `job_filter="-Value3|-Value4"`)

Office Filtering

*	Want to filter results by office? Show only jobs from a specific office or exclude a specific office?
*	Add the `office_filter` attribute: `[greenhouse office_filter="Value1|Value2"]`
*	supports single or multiple values, pipe-delimited
*	supports either using the office name OR the office id as the value.
*	supports negated values - Excludes office(s) and only display jobs from elsewhere. (example: `office_filter="-Value3"`)

Location Filtering

*	Want to filter results by location? Show only jobs from a specific location or exclude a specific location?
*	Add the `location_filter` attribute: `[greenhouse location_filter="Value1|Value2"]`
*	supports single or multiple values, pipe-delimited
*	supports location text value, since there is no id associated to locations in greenhouse.
*	supports negated values - Excludes location(s) and only display jobs from elsewhere. (example: `location_filter="-Value3"`)

Hiding Forms

*	If you don't want application forms to display and simply want to display listings, just add the `hide_forms` attribute
*	ex. `[greenhouse hide_forms="true"]`

Sort Jobs

*	Want to sort the jobs listed in your job board? 
*	Add the orderby attribute to the shortcode.
*	Values allowed:	title, date, id, department, office, location and random.
*	For example: `[greenhouse orderby="title"]`
*	Need to customize the order more? 
*	There is an order attribute as well, supported values: DESC (default) and ASC.
*	There is a sticky option as well, force a single job to the top or bottom of the board.
*	Sticky attribute format: 'top' or 'bottom' followed by a pipe '|' and then the id for the job to stick.
*	For example: `[greenhouse orderby="department" order="ASC" sticky="top|18590"]`

Group Jobs

*	Want to group the jobs listed in your job board by department, office or location?
*	Add the group attribute to the shortcode.
*	Values accepted: department, office or location.
*	By default the group name will be used as a headline to seperate each group.
*	To omit group headlines, include shortcode attribute: group_headline="false".
*	For example: `[greenhouse group="department" group_headline="false"`


== Coming Soon ==

Roadmap

*	Add filter hooks for customizing output
*	Cleaner, smarter interface
*	Widget
*	Templating for your own layout


== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `greenhouse-job-board.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[greenhouse url_token="your_url_token"]` in your page or post.

== Changelog ==

= 2.0.2 =
* Update compatability notice.
* Check that new debug and analytics values are set properly.

= 2.0.1 =
* Load css conditionally - only on pages with the job board shortcode. (props - bsteinlo)

= 2.0 =
* Add filter for single job template. (ghjb_single_job_template_after_title)
* Add google analytics integration
* Add debugging option
* Update inline job submission script to be more compatible with current WordPress best practices. (props - bsteinlo)

= 1.9 =
* Load assets (css &  js) conditionally - only on pages with the job board shortcode. (props - bsteinlo)
* Check if cycle2 js library is already loaded and only load it if it's needed still.
* Add sorting options to job board.
* Add sticky option to have jobs stick to top or bottom when sorting.
* Ensure to only allow inline forms after API key is entered.
* Set cache expiration limits and clear cached data from Greenhouse API.
* Minor code clean up and documnetation updates.

= 1.8 =
* Fix minor bug in shortcode wizard for form type setting.
* Fix bug when submitting optional files.
* Allow multiple shortcodes on one page.

= 1.7 =
* Add cycle option for the job board layout.
* Add inline form option, no longer need to load an iframe (may take special setup and requires).
* Add custom css block.
* Various bug fixes.
* Cache greenhouse data for faster performance. 

= 1.6 =
* Adding options to customize display of job data: location, office, department and description.
* Also adding options to customize labels for each of the above.
* Minor Bug fixes.

= 1.5 =
* Adding add job board media button and wizard to help construct your shortcode.
* Bug fixes - compatability with ACF Pro.
* Bug fixes - unexpected output.
* Updates - requiring a url_token with user feedback on error.

= 1.4 =
* Adding support for location filter (include and exclude).
* Adding support for office filter by name/title or id(include and exclude).
* Adding another global settings for the text strings used on the job list.
* Cleaning up toggle scripts.

= 1.3 =
* Adding support for job filter (include and exclude).
* Adding support to filter by name/title or id.
* Adding global settings for the text strings used on the job list.

= 1.2 =
* Adding support for department filter (include and exclude departments).
* Adding support for hiding forms from the job board.

= 1.1 =
* Adding settings page with global default settings.

= 1.0 =
* Initial release

== Screenshots ==

1. Shortcode in action. Notice the 'Add Greenhouse Job Board' button.
2. View the job board list.
3. Click to view description of each job.
4. Click to apply for each job.
5. View the 'Add Greenhosuse Job Board' button modal wizard. This will allow you to easily configure your board with all the settings. It will insert the configured shortcode into the content editor.


== Frequently Asked Questions ==

= Any Requirements? =

Yes, this plugin requires that you have a greenhouse.io account. You will need to enter your url token as well as your API key.

= Server requirements =

If you desire inline forms rather than iframe forms, to submit applications to the greenhouse API the web server must support cURL since it is used for the proxy data submission as to not expose your API key to the public.

= Can I add my own styles? =

Yes, you can add your own custom CSS on the plugin options page.

= I made edits in my Greenhouse account, but I'm not seeing those edits on my website, what gives? =

This plugin connects to Greenhouse to retreive data and saves it locally in your WordPress database for a while so your site will load faster and not have to wait for Greenhouse API everytime your job board loads. Go to the settings page and check your cache expiration setting to see how long this temporary or transient data will be stored locally, and also notice the checkbox option to clear the cache. To force fresh data to your site, check this box and save changes.