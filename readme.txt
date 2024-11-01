=== Tin Can API Viewer ===
Contributors: vtrainingroom
Tags: tincanapi, tin, can, xapi, experience api, tin can api
Requires at least: 3.0.1
Tested up to: 3.5.1
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows users to connect to a Tin Can (Experience API) Learning Record Store and send statements.

== Description ==

This plugin allows users to connect to a Tin Can (Experience API) Learning Record Store and send statements about learning experiences. It has a configuration screen to set the Endpoint for statements and allows administrators to setup shortcodes that display Tin Can content, as well as send statements to a LRS.  You must have at least a free LRS account at vTrainingTracker.com to use this plugin.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `tincanviewer.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enter your credentials from your vTrainingTracker account under settings > TinCan LRS Settings
4. Place the shortcode in your pages

== FAQ ==

Q: Do I have to have an LRS account to use this plugin?

A: Yes, you must sign up for at least a free vTrainingTracker account to use this plugin.  You can sign up here: http://www.vtrainingtracker.com/

Q: What are the shortcode formats?

A:Shortcode Format:

[tincanviewer src='url' width='600px' height='480px' version='0.95']

Example 1: This shortcode will launch the page url http://vtrainingtracker.com/sample/story.html in a default size iframe:

[tincanviewer src='http://vtrainingtracker.com/sample/story.html'] 

Example 2: This shortcode will launch the page url http://vtrainingtracker.com/sample/story.html in a 900 X 600px iframe: 

[tincanviewer src='http://vtrainingtracker.com/sample/story.html' width='900px' height='600px']

Q: What are the shortcode parameters?

A: Parameters:

src: Required. URL of content

width: Optional. Default 960px.

height: Optional. Default 640px.

version: Optional. Default 0.95. If using 0.90 content, set the version to 0.90