The usage of this plugin is really simple.

Just start by opening the file controllerFile.php from theme-feature-controller/features/demo
You can find all the main hooks there, please note that in the "run" method,
you can add any wordpress plugin code except activation,deactivate,install,uninstall.
For those four methods, you have methods in the main class itself.

Define all the information about your class in the $pluginInformation variable, please don't forget to set an unique alias.
! If you don't set an unique alias, no worries, I've made it to still work perfectly, with the last alias found.

Other features :

In the theme-feature-controller/application/models/Information.php

You can find these 2 variables

$pluginName  = "Theme Controller";
$pluginAlias = "theme-controller";

Just change those according to your Wordpress theme name, for example "Safari Theme" or something similar.
I personally encourage you to change the plugin name & description to fit your needs, but specify that your theme uses this plugin.

Thanks again, and have fun coding with the help of this plugin

Cheers,
Robert
