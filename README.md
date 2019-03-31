Snicker
=======

Snicker is the first and native FlatFile comment system for the Content Management System 
[Bludit](https://github.com/bludit/bludit). It allows to write and publish comments using basic 
HTML Syntax or Markdown. It also offers an extensive environment, many settings and possibilities 
and it is also completely compliant with the GDPR!

Attention
---------
This is the **unstable**, possibly **dangerous** and **incomplete** Repository Branch of the Snicker 
Comment Plugin. You should NEVER use this version on productive or working websites. This build is 
ONLY for development and testing purposes!

You've been warned!

Features
--------
-   Depth-Based Commenting with many settings
-   Configurable Strings and Frontend View
-   AJAX Support to prevent Page-Reloads
-   User-Management for Not-Logged-In Users
-   Moderatable Comments (Pending, Approved, Rejected, Spam)
-   Extensive Backend with many possibilities

Requirements
------------
-   PHP v5.6.0+
-   Bludit v3.5.0+

Dependencies
------------
-   Snicker use the awesome [Captcha PHP Library](https://github.com/Gregwar/Captcha) made by Grégoire Passault
-   The Avatars are served per default by [Gravatar](https://de.gravatar.com/), made by Automattic / WordPress
-   **But** you can also directly use [Identicons](http://identicon.net) instead...
-   ... where we use the [Identicon PHP Library](https://github.com/yzalis/Identicon) from Benjamin Laugueux
-   ... and the [Identicon JavaScript Library](https://github.com/stewartlord/identicon.js) from Stewart Lord
-   ... which itself depends on the [PNG JavaScript Library](https://www.xarg.org/2010/03/generate-client-side-png-files-using-javascript/) by Robert Eisele

Thanks for this awesome packages and projects!

Installation
------------
-   Download the [this Plugin](https://github.com/pytesNET/snicker/zipball/master)
-   Upload it to your `bl-plugins` folder of your Bludit Website
-   Visit the Bludit Administration and enable the "Snicker" Plugin through "Settings" > "Plugins"

Copyright & License
-------------------
Published under the MIT-License; Copyright &copy; 2019 SamBrishes, pytesNET
