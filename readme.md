# Fubra DoubleClick for WordPress

---

Provides shortcode and widget for responsive DFP ads.
Modified from https://wordpress.org/plugins/doubleclick-for-wp/

***Basic shortcode:***

  [dfp ad="DFP_ad_unit_code"]

***Responsive options:***
In order for the plugin to serve different sizes, a default size/shape needs to be specified.
Defaults include:

leaderboard : ( small:320x50, medium: 468x60, large: 728x90 )
banner : ( small:180x150, medium: 250x250, large: 250x250 )
skyscraper : ( small:160x600, medium: 160x600, large: 160x600 ) - * Not responsive as skyscrapers can't go narrower

  [dfp ad="DFP_ad_unit_code" size="leaderboard"]


***Alternitively, a map of sizes can be defined:***
3 Sizes exist, small (mobile), medium (tablet) and large (desktop).
These sizes must be specified in that order as a comma-seperated list.

  [dfp ad="DFP_ad_unit_code" map="320x50,468x60,728x90"]
