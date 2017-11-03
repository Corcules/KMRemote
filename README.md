# KMRemote

KMRemote is a single page webapp dedicated to build and use control boards to launch Keyboard Maestro macros remotely.
<br>
<br>
<span style="color:orange">**Note**</span> : KMRemote is a WordPress theme.
<br>
<br>
<span style="color:orange">**Note**</span>: Build for a tablet for my own use. At this time, this will not work properly on a phone or on desktop browser. This will be improved... see plan below.
<br>
<br>
<span style="color:orange">**Note**</span>: At this time, there is no security layer in KMRemote. Every one having access to you LAN would be abble to launch Keyboard Maestro macros on your Mac... This would be added as an option in future version... see Plan below.
<br>
<br>

>*Restricted area : beware that KMRemote will works on a very specific environment.*
<br>
<br>
>*You will need :*

>* *A mac computer*
>* *The fantastic [Keyboard Maestro](https://www.keyboardmaestro.com) app*
>* *A working install of [WordPress](https://wordpress.org) on the mac, accessible on LAN*
>* *A tablet device.*

### Main features

* Configure boards.
* Configure widgets on boards.
* Automatically switch to a particular board depending on which App or Finder folder is foreground on the mac.
* Launch Keyboard Maestro macro by taping on a widget.

## Browser support

Only tested on Safari IOS.
<br>
Altought should works fine on every modern mobile browsers.
<br>
Initially build for tablet screen. A more flexible version ( phone screens, desktop browsers) is considered...

## Installation and Access on Lan

Assuming that you have a working local install of WordPress running (with [MAMP PRO](https://www.mamp.info), [Local](https://local.getflywheel.com), build-in macOS AMP, ...) on the mac, you need to access to the webapp via LAN.
<br>
<br>
Just install and activate the KMRemote theme in WordPress as any other.
<br>
<br>
To access remotely to the webapp from LAN really depends on your local web environment. 

With [MAMP PRO](https://www.mamp.info), you can :
- use Xip.io ([info](https://documentation-3.mamp.info/en/documentation/mamp-pro/#4.2.1-General-Settings-Host), [Xip](http://xip.io))
- set IP/Port to */80 and add *yourcomputername.local* as alias. Use *yourcomputername.local* remotely.

This tools may be useful :

* [Squidman](http://squidman.net/squidman/) proxy server
* [Hosts](http://permanentmarkers.nl/software.html) preference pane to manage host file


## USAGE

KMRemote has 2 MODES, "edit" and "run".
<br>
In "edit" mode, you can compose your boards.
<br>
In "run" mode, you can launch macros.
<br>
By default, the app is in "run" mode.

### MENU

<img src="http://www.corcules.com/ressources/kmremote/kmr-menu-run.png" width="100%" style="border:1px solid #ccc"/>

Tap on the "gearing" icon on the right top corner to open the menu panel.
<br>
By default, the app is in "run" mode.
<br>in "run" mode, the menu show :
* a button to activate "edit" mode.
* a button to toggle "autoswitch"(see below)
* the list of boards in which you can navigate

<br>
Tap on "Edit" button to activate the "edit" mode.

<img src="http://www.corcules.com/ressources/kmremote/kmr-menu-edit.png" width="100%" style="border:1px solid #ccc"/>

On "edit" mode, menu let you :
* activate "run" mode"
* create new board
* edit current board
* delete current board (and it's widget)
* the list of boards in which you can navigate

### NEW BOARD
In "edit" modee, tap on "New board".

<img src="http://www.corcules.com/ressources/kmremote/kmr-board-panel.png" width="100%" style="border:1px solid #ccc"/>

* Several board infos
* Background color and icone for board (see "Pickers" below)

#### Board behaviour - AUTOSWITCH

Activate board when a specific application or a Finder location on mac goes foreground.

<img src="http://www.corcules.com/ressources/kmremote/kmr-board-panel-switch-app.png" style="border:1px solid #ccc"/>

To select the application, tap on the listen buttoon, bring the target app foreground on the mac, tap again on the listen button. You can also manually write the name of the application.
<br>
<br>
If the name of the application is "Finder", another option field appear to select a specific Finder location.


<img src="http://www.corcules.com/ressources/kmremote/kmr-board-panel-switch-path.png" style="border:1px solid #ccc"/>

> **Note** : if two boards are set with the same behaviour then only the first one will be activated when condition meet on the mac. But you can switch manually to other board with using the board list in the menu panel.


### NEW WIDGETS

When in "edit" mode, the current board show a grid. Slide on the grid to initiate a widget.

<img src="http://www.corcules.com/ressources/kmremote/kmr-widget-panel.png" width="100%" style="border:1px solid #ccc"/>


* **Action** : Select a Keyboard Maestro.
* **View** : Set up the appearance of the widget - Toggle some others options. (see "Pickers" below)
* **Position** : When in view "Both", icone + title, options appear to precise the relative position between them.

<img src="http://www.corcules.com/ressources/kmremote/kmr-widget-icone-position.png" style="border:1px solid #ccc"/>

### Pickers

Pickers on the app react the same way. Tap on an item to select. Tap on "Back" button to valid the selection or on "Cancel" to not.
<br>
Double tap on an item is a shorcut to select, valid and close the picker panel.


#### Color

<img src="http://www.corcules.com/ressources/kmremote/kmr-color-picker.png" style="border:1px solid #ccc"/>

#### Icones

<img src="http://www.corcules.com/ressources/kmremote/kmr-icon-picker.png" style="border:1px solid #ccc"/>

Icons use [Font Awesome list](http://fontawesome.io/icons/)
<br>
Icons are searchable.

#### Actions

<img src="http://www.corcules.com/ressources/kmremote/kmr-picker-macro.png" style="border:1px solid #ccc"/>

Picker "Action" will get the macro list from Keyboard Maestro. 
<br>
The list is initiated at KMRemote launch. If you create a new macro on Keyboard Maestro, your abble to refresh the list on the picker by tap on the refresh button on the right side of the search field.
<br>
Macros are searchable.


### Widgets manipulation

In "edit" mode, you can manipulate widget. Select the widget by tap-holding it.

<img src="http://www.corcules.com/ressources/kmremote/kmr-widget.png" style="border:1px solid #ccc"/>
<img src="http://www.corcules.com/ressources/kmremote/kmr-widget-selected.png" style="border:1px solid #ccc"/>

##### Drag
A selected widget is draggable on the grid.
##### Resize
Use resize handlers to resize it.
##### Edit
Tap a selected widget to edit it's properties.
##### Delete
For deleting a widget, open widget panel properties a scroll to the bottom of the form.

### Widget in Run Mode

In "run" mode, a tap on a widget call macro execution on the mac.
<br>
In "run" mode, a tap-hold on a widget will show a tooltip with title, note and macro name of the widget.

<img src="http://www.corcules.com/ressources/kmremote/kmr-widget-tooltip.png" style="border:1px solid #ccc"/>

## Used and thanks

### Server side
* [WordPress](https://wordpress.org) as a middleware

### Javascript:
* [JQuery](https://jquery.com) as main javasccript framework
* [JQuery UI](http://jqueryui.com) for drag'n drop and resizable features
* [jQuery UI Touch Punch](https://github.com/furf/jquery-ui-touch-punch) for adding to touch event to JQuery UI
* [JQuery Easing](http://www.gsgd.co.uk/sandbox/jquery/easing/) for animation improvement
* [FastClick](https://github.com/ftlabs/fastclick) for removing click delay on touch browsers
* [iNoBounce](https://github.com/lazd/iNoBounce/) for control bouncing scroll on IOS
* [jQuery Mobile Events](https://github.com/benmajor/jQuery-Touch-Events) for touch event as "tap", "taphold",...
* [TaffyDB](https://github.com/typicaljoe/taffydb) for a local javasccript database
* [TinyColor](https://github.com/bgrins/TinyColor) for color comparaison
* [Tooltipster](http://iamceege.github.io/tooltipster/) for nice and flexible tooltips

### Icon web font :
* [Font Awesome](http://fontawesome.io)

## Plan

* Adaptative for Phone screens and Desktop Browser
* Themes for boards
* Add security layer
* Inner wigdet action such as "Activate board xxx", "Toggle Autoswitch", 
* Launch KM Macro with parameter
* Multi mobile device connected to the mac but with differents boards
* Add global app preferences panel
* Redesign menu panel

## Licence

[MIT License](LICENSE.md). © 2017 [Corcules / Romain Jacquet](http://corcules.com).