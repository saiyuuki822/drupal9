Vertical Hover Menu

# Code Layout

## Javascript

The JS file is laid out such that we iterate over every li.menu-item so we can attach an event to every single li item.
There are two events which can happen to a menu item:
 - Hover over (mouseenter)
 - Hover away (mouseleave)
Both situations will fire an event.  We also have two other event handlers for ancillary tasks.  The events:
 - Window resize
 - Orientation button click

I'll briefly discuss what happens in each event handler specified above.

### Hover Over
When this event is fired, we want to mask the effects/styles of an open menu on every other li element.  Then we want to
only show the open menu effect for the li element which is being hovered on.  We use setTimeout() functions to ensure
multiple function calls are not made by clearing out existing setTimeout()s at the beginning of every event fire.

### Hover Away
When this event is fired, we want to clear the open menu effect on the menu item that was hovered away from.  We also
clear timeout functions at the beginning of this event like we do above.

### Window Resize
When this event is fired, we want to recalculate the size of the window and also the menu items.  We need to know the
width of the window so we can tell if it's a mobile browser or not.  We need to know the size of the menu items so we
know how much to shift each menu level to the right when hovering.

### Orientation button click
When this event is fired, we clear any existing styles and classes from the menu so that they do not persist when switching
the orientation of the menu.  We only want our custom hover effects to kick in on vertical orientation, not horizontal.