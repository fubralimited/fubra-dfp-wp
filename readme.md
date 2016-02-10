# Fubra DoubleClick for WordPress

---

Provides shortcode, function & widget for responsive DFP ads.
Modified from https://wordpress.org/plugins/doubleclick-for-wp/

***Basic usage:***

In order for the plugin to serve different sizes, a default size/shape needs to be specified.
Defaults include:
<br/>
<br/>
leaderboard : ( small:320x50, medium: 468x60, large: 728x90 )<br/>
banner : ( small:320x100, medium: 250x250, large: 300x250 )<br/>
skyscraper : ( small:160x600, medium: 160x600, large: 160x600 ) - * Not responsive as skyscrapers can't go narrower

***Shortcode:***

    [dfp ad="DFP_ad_unit_code" type="leaderboard"]

***Function:***

    <?= dfp( "DFP_ad_unit_code", "leaderboard" ) ?>

***Alternitively, a map of sizes can be defined:***
3 Sizes exist, small (mobile), medium (tablet) and large (desktop).
These sizes must be specified in that order as a comma-seperated list.

    [dfp ad="DFP_ad_unit_code" map="320x50,468x60,728x90"]

    <?= dfp( "DFP_ad_unit_code", false, "320x50,468x60,728x90" ) ?>
