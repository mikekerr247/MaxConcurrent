# Piwik Max Concurrent User Plugin

## Description

This is a plugin for the Open Source Web Analytics platform Piwik. If enabled, it will add three new widgets that you can add to your dashboard.

At the moment the plugin defaults to maximum concurrent usage for every 5 minute time interval for the last 200 days. These numbers can be reconfigured in the plugin settings page of the user profile menu.

One widget gives a single number representing the maximum number of concurrent users that have ever occurred in the N time interval over the last M days.
The other two widgets are a line graph and a table showing the maximum concurrent visitors for each N time slice of 24 hours over the last M days.

The plugin borrows the code structure and an SQL query from the Barometer plugin built by [@halfdan](http://github.com/halfdan).

The plugin has also been translated into Ukrainian and Russian by twixi


## Documentation

1. Clone the plugin into the plugins directory of your Piwik installation.

   ```
   cd plugins/
   git clone https://github.com/mikekerr247/MaxConcurrent.git MaxConcurrent
   ```

2. Login as superuser into your Piwik installation and activate the plugin under Settings -> Plugins

3. You will now find the widgets under the Visitor section.

4. The plugin's time interval and calendar span can be configured by going to Personal Settings -> Plugin Settings

## Contribute 

If you are interested in contributing to this plugin, feel free to send pull requests!

## Support

Feel free to use the issues page in the github repository

https://github.com/mikekerr247/MaxConcurrent/issues

## Donate

If you felt this plugin helped you out and would like to keep the coffee flowing at my desk, please donate via Paypal

https://paypal.me/mikekerr247

## Special Thanks
Thank You to everyone who contributed on the Barometer plugin - I couldn't have made this without it!
