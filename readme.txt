=== WP sIFR ===
Contributors: Jake Snyder
Donate link: http://labs.jcow.com/donate/
Tags: sifr, scalable inman flash replacement, fonts, flash
Requires at least: 2.5
Tested up to: 2.7.1
Stable tag: 0.6.8.1

WP sIFR makes any font possible in your Wordpress installation in under five minutes.

== Description ==

0.6.8.1 Adds some much-needed functionality. It is now recommended that you move your fonts folder into your theme so that the fonts won't be overwritten when you upgrade. It also fixes a 0.6.8 problem with the header reference to the SWF files when you store them in your theme.

0.6.6 Fixed a small change that caused some servers to stop working. If things stopped working for you, please upgrade to the latest version.

**Important Upgrade Information**

If you use Wordpress' built-in upgrade system, it *will* delete your fonts, unless you move your fonts folder into your theme instead. WP sIFR will automatically see the new location and no settings should be lost. If you do overwrite the fonts, your settings will be deleted the next time you visit the settings page. If you accidentally delete your fonts, replace them before going to the settings page. This is one of our main concerns for the next version.

**WP sIFR**

WP sIFR was created to remove the complications from getting custom fonts on a Wordpress site. With WP sIFR, you only have to upload your SWF font file to the plugin directory and then login, activate it, and configure its styles all in the Settings panel.

**WP sIFR benefits**

*	Works on subpages
*	Simple backend code and setup
*	No customization necessary outside of Wordpress Admin
*	New fonts working on your site in under five minutes
*	Protection against Adblock on Macs using Firefox 3 (text is still shown)

**Font Settings and Deletion**

Currently, to simplify font addition and removal, WP sIFR removes all settings for the removed font when you delete it from the fonts folder. This is permanent. The addition and removal script runs on plugin activation and when the Settings Panel page is visited. Be careful deleting fonts, or you could lose your settings. This will change in the next major release.

**Firefox on Macs and Adblock**

WP sIFR has the ability to detect against Macs using Firefox 3 with an Adblock add-on. If it detects this configuration, it will disable sIFR on your site for that user. This means that your text will still be shown, but it will not be sIFR text, like when a user has javascript disabled. It *will not* interfere with other Mac users who are not using FF3 or are using FF3 without Adblock.

== Installation ==

1. Upload the `wp-sifr` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add fonts (SWF files) to the fonts folder
1. Optionally, you can move your fonts folder to your theme, so they are not deleted upon upgrade. This is recommended.
1. Set the options in the Admin Panel under `Settings` for your fonts

== Frequently Asked Questions ==

**It doesn't work... ?**

**First**. Does your template have a `<?php wp_head(); ?>` in the 'header.php' file? That one is important.

**Second**. Does your SWF file's filename have any funny characters in it? Spaces, dashes, and underscores should work now, but other characters could cause problems.

**Third**. Are you using Firefox on a Mac? sIFR works great on any browser, except when Adblock is messing up Flash functionality. For the time-being, we have disabled sIFR on Macs using Firefox 3 and Adblock. The method isn't fullproof though and sometimes Adblock may still gum up the works. When the detection works, you still see your HTML text, without sIFR. When the detection doesn't work, you won't see any text at all. It will not interfere with Mac Firefox that is not running Adblock. If you are on a Mac, with Firefox 3, and no Adblock add-on, everything should be hunky-dory for you.

**Fourth**. Be sure that you do not delete the wmode setting from the "Advanced Settings". It can be "opaque" or "transparent", but it has to be there for IE7.

**Fifth**. If you specify a CSS state for the font that you did not include in the SWF, the font will not show up. EXAMPLE: If you specify `font-weight: bold;` and you only included the normal and italic versions, nothing will show. The font will be hidden, but won't be replaced properly. Sometimes it is beneficial to leave out some states to reduce filesize.

**I heard you could make drop shadows?**

Yep. With 0.6.7 and above, you can use the "Advanced Settings" field. Paste code similar to this:

`filters: {
	DropShadow: {
		knockout: false,
		distance: 2,
		blurX: 2,
		blurY: 2,
		color: '#000000',
		strength: .15,
		angle: 90
	}
}`

Mess around with it and have fun.

**How do I create fonts?**

To create a font, you can upload your TTF file to: sIFR Generator (<a href="http://www.sifrgenerator.com/">http://www.sifrgenerator.com/</a>). Or you can follow these directions: sIFR Wiki (<a href="http://wiki.novemberborn.net/sifr/How+to+use">http://wiki.novemberborn.net/sifr/How+to+use</a>). The Flash file used to create fonts is included in the "fonts/flash" folder. Be sure to remove any spaces from the file name or you will have trouble ("timesnewroman.swf" = GOOD | "times new roman.swf" = BAD).

**How do I add fonts?**

After fonts are created in Flash, upload them to the "fonts" directory in the plugin folder or to a "fonts" directory in your theme folder and they will show up in your Settings panel. Then you can activate and manage the font settings. We highly recommend using your theme to store your fonts folder, especially if you will be using Wordpress' built-in automatic upgrade.

**What version of sIFR does this use?**

WP sIFR uses the latest nightly which is **v3 r436**. Fonts created for sIFR v2.x or another version of 3 will most likely *not* work.

**Can I add multiple selectors to the same font?**
	
You *can* enter more than one selector, just seperate them with a comma.

The only issue with entering multiple selctors is that they will use the same styles. Sometimes this ok, but other times, it can be limiting. For instance, your "h1, h2, h3" tags, if listed on the same font, would all *have* to be the same size even though you usually would want the size to decrease through the headline tags.

**I have multiple selectors on the same font, but how do I style them separately?**

**Short Answer**: You can't.

Although we *are* working on a system to allow you to add selectors under a font that can then be styled separately. 

**Long Answer** (hack): The work-around currently is to create a copy of the font file with a different name. Then you could style a second selector for that font separately.

For example: Take a file named "futura.swf", make a copy named "futura_h1.swf". This would allow you to use separate selectors, styled differently. This is a complete hack though and causes the same font to have to be downloaded twice.

The next major version should have the new system in place.

== Screenshots ==

1. The WP sIFR Admin Panel
1. The WP sIFR Admin Panel with "Settings" expanded.
1. The WP sIFR Admin Panel with "Settings" and "Advanced Settings" expanded.

== Future Features ==

Number one priority from here is to save settings for all fonts even if the file gets deleted, and allow the user to delete a font that no longer exists.

Number two is to allow users to add multiple selectors that can be styled seperately!

== Change Log ==

**v0.6.8.1** - March 23, 2009

*	Small fix to bad header reference if fonts were stored in the theme folder

**v0.6.8** - March 19, 2009

*	Can now store fonts with theme
*	Slimmer design with "Settings" and "Advanced Setting" both hidden and toggled with jQuery

**v0.6.7** - March 16, 2009

*	Upgraded "Advanced Settings" to be a bit better for multi-line filters (drop shadows).

**v0.6.6** - March 13, 2009

*	Fixed stripslashes problem causing extra slashes in "Advanced Settings"

**v0.6.5** - March 12, 2009

*	Protection against Adblock on Macs using Firefox 3, so your text still shows up.

**v0.6.4** - March 12, 2009

*	Added the ability to change the order that fonts get loaded. Best to use single digits (-9 - 9)
*	Added advanced font settings
*	Fixed fonts so they show up in admin panel even when inactive
*	Fixed font referencing, so now you can use spaces, dashes, and underscores in the font file name
*	sIFR.useStyleCheck = true
	
**v0.6.1** - March 11, 2009

*	Added a browser/os detection to keep from adding to Firefox on Macs since sIFR is currently experiencing difficulty on that setup

**v0.6** - March 4, 2009

*	Fixed adding fonts issue, plugin did not allow addition of any fonts if it was ever activated without fonts in the fonts folder
*	Added two sample fonts from sIFR Vault as well for good measure

**v0.5.1** - March 4, 2009

*	Updated Options to be compatible with PHP 4

**v0.5** - March 4, 2009

*	Simplified header code

**v0.4** - March 2, 2009

*	Simplified updating fonts from the fonts folder into the database
*	Fixed adding fonts so that plugin reactivation is no longer required
*	Stopped deletion of settings when plugin is deactivated

**v0.3** - February 28, 2009

*	First Public Version