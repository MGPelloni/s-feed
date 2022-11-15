<img src="https://social-feed.tech/i/banner.png" style="display:block; margin:auto; width:100%; max-width:100%"/>

![PHP version](https://img.shields.io/badge/PHP-7.4+-4F5B93.svg?logo=php)
![WP version](https://img.shields.io/badge/WordPress-6.0+-0073aa.svg?&logo=wordpress)
[![GitHub release](https://img.shields.io/github/v/release/MGPelloni/s-feed.svg?logo=github)](https://github.com/MGPelloni/s-feed/releases/latest)
[![CI status](https://github.com/MGPelloni/s-feed/actions/workflows/ci.yml/badge.svg)](https://github.com/MGPelloni/s-feed/actions/workflows/ci.yml)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)
[![semantic-release: angular](https://img.shields.io/badge/semantic--release-angular-e10079?logo=semantic-release)](https://github.com/angular/angular/blob/main/CONTRIBUTING.md#-commit-message-format)

S-Feed allows web administrators to display their Instagram feeds on their website. This is achieved by utilizing a proxy server that downloads the administrator's Instagram data and serves the images to the end user through a unique REST API endpoint.

## Installation

To start, create your unique endpoint by authorizing access to your Instagram account on the [proxy server website](https://social-feed.tech/). You will need to [create an S-Feed account](https://social-feed.tech/wp-login.php?action=register) to associate the data with. Once successfully logged in to S-Feed and authorized through Instagram, the proxy server will generate an endpoint for you to use.

Next, install the [S-Feed plugin](https://social-feed.tech/releases/s-feed.zip) on your WordPress website. Once activated, the S-Feed menu option will show in the WordPress administration sidebar. Add the endpoint from the proxy server into the user input and your feed will display once saved. 

You can use the shortcode provided on the S-Feed administration panel to inject the feed into the website, or the `sfeed_get_user` PHP function to return the Instagram feed data.

## Accessibility

S-Feed administrators can write [alternative text](https://accessibility.psu.edu/images/alttext/) for Instagram images by accessing the [alt text editor](https://social-feed.tech/images/) available on the proxy server website. Once the alternative text is written, the data will be available within the endpoint response.