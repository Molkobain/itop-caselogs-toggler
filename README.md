👋 [Available on Molkobain I/O](https://www.molkobain.com/product/caselogs-toggler/)

# iTop extension: molkobain-caselogs-toggler
* [Description](#description)
* [Compatibility](#compatibility)
* [Downloads](#downloads)
* [Installation](#installation)
* [Configuration](#configuration)

## Description
Have a better user experience with caselogs by being able to open / close all entries at once.

This extension simply adds 2 buttons next to the caselog title, in both the console & portal.

*Note: Screenshots feature the **[Bubble caselogs](https://www.molkobain.com/product/bubble-caselogs/)** extension (which changes the caselog entries look & feel) but is not part of this one.*

![Description decoration](https://raw.githubusercontent.com/Molkobain/itop-caselogs-toggler/develop/docs/mct-portal-example-01.PNG)

![Description decoration](https://raw.githubusercontent.com/Molkobain/itop-caselogs-toggler/develop/docs/mct-portal-example-02.PNG)

## Compatibility
Compatible with iTop 2.4+

## Dependencies
* Module `molkobain-fontawesome5-pack/1.1.0`
* Module `molkobain-handy-framework/1.1.0`

*Note: All dependencies are included in the `dist/` folder, so all you need to do is follow the installation section below.*

## Downloads
Stable releases can be found either on the [releases page](https://github.com/Molkobain/itop-caselogs-toggler/releases) or on [Molkobain I/O](https://www.molkobain.com/product/caselogs-toggler/).

Downloading it directly from the *Clone or download* will get you the version under development which might be unstable.

## Installation
* Unzip the extension
* Copy the ``dist/molkobain-caselogs-toggler`` folder under ``<PATH_TO_ITOP>/extensions`` folder of your iTop
* Run iTop setup & select extension *Caselog entries toggler*

*Your folders should look like this*

![Extensions folder](https://raw.githubusercontent.com/Molkobain/itop-caselogs-toggler/develop/docs/mct-install.PNG)

## Configuration
No configuration needed.

### Parameters
Some configuration parameters are available from the Configuration editor of the console:
* ``enabled`` Enable / disable the extension without having to uninstall it. Value can be ``true`` or ``false``.
* ``open_all_icon`` CSS classes of the *open* icon, allows you to choose any FontAwesome icon. Value must be a string a CSS classes separated by a space (eg. ``'fas fa-book-open'``).
* ``close_all_icon`` CSS classes of the *close* icon, allows you to choose any FontAwesome icon. Value must be a string a CSS classes separated by a space (eg. ``'fas fa-book'``).
* ``icons_separator`` Separator of the 2 icons. Value must be a string (eg. ``'-'``).

## Contributors
I would like to give a special thank you to the people who contributed to this:
 - Bostoen, Jeffrey

## Licensing
This extension is under [MIT license](https://en.wikipedia.org/wiki/MIT_License).
