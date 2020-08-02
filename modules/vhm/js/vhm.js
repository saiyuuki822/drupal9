(function($, Drupal) {

  Drupal.behaviors.verticalHoverMenu = {
    attach: function(context, settings) {
      var timeoutShow;
      var timeoutHide;
      var timeoutIsMobile;
      var timeoutClearInlineStyles;
      var timeoutClearClasses;
      var isMobile;
      var timeToShow = 250;
      var timeToHide = 750;

      function checkMobile() {
        isMobile = window.matchMedia("only screen and (max-width: 760px)").matches ? true : false;
      };

      function clearInlineStyles() {
        $('div#toolbar-administration ul.toolbar-menu li.menu-item').each(function(i) {
          $(this).parent().attr('style', '');
          $(this).attr('style', '');
        });
      }
      function clearClasses() {
        $('div#toolbar-administration ul.toolbar-menu li.menu-item').each(function(i) {
          $(this).removeClass('open');
          $(this).removeClass('menu-item--active-trail');
        });
      }

      function delayedHoverShow() {
        clearClasses();

        var menuWidth = $('#toolbar-item-administration-tray').css('width');
        var parent_menu_height = $(this).parent().css('height');
        var child_menu = $(this).parent().find('> ul.toolbar-menu');

        $(this).parent().siblings().each(function() {
          removeButtonStyle.call(this);
        });
        $(this).parent().find('> div.toolbar-box button.toolbar-icon').addClass('open');

        child_menu.css('display', 'block');
        child_menu.css('position', 'relative');
        child_menu.css('left', menuWidth);
        child_menu.css('width', menuWidth);
        child_menu.css('margin-top', "-" + parent_menu_height);

        $(this).parent().css('height', parent_menu_height ? parent_menu_height : '39px');
        $(this).parent().siblings().find('ul.toolbar-menu').css('display', 'none');

        $(this).parent().find('> ul.toolbar-menu').children().find('> ul.toolbar-menu').attr('style', '');
        $(this).parent().find('> ul.toolbar-menu').children().find('button.toolbar-icon').removeClass('open');

      }

      function delayedHoverHide() {
        clearInlineStyles();
        $('div#toolbar-administration ul.toolbar-menu li.menu-item').each(function() {
          removeButtonStyle.call(this);
        });
      }

      function removeButtonStyle() {
        $(this).find('> div.toolbar-box button.toolbar-icon').removeClass('open');
      }

      // Main
      $('div#toolbar-administration nav#toolbar-bar').once('verticalHoverMenuSetup').each(function(item) {
        checkMobile();

        if (!isMobile) {
          setTimeout(clearClasses, 4);
          setTimeout(function() {
            $('div#toolbar-administration ul.toolbar-menu li.menu-item').each(function() {
              removeButtonStyle.call(this);
            });
          }, 4);
        }

        $(window).resize(function() {
          clearTimeout(timeoutIsMobile);
          timeoutIsMobile = setTimeout(function() {
            checkMobile();
          }, 250);
        }.bind(isMobile));
      });

      $('div#toolbar-administration nav#toolbar-bar li.menu-item > div.toolbar-box').once("verticalHoverMenu").each(function(item) {

        $(this).on('mouseenter', function(event) {
          clearTimeout(timeoutHide);
          clearTimeout(timeoutClearInlineStyles);
          clearTimeout(timeoutClearClasses);

          if ($('#toolbar-item-administration-tray > nav > div.toolbar-toggle-orientation > div > button').val() === 'horizontal' && !isMobile) {
            clearTimeout(timeoutShow);
            timeoutShow = setTimeout(delayedHoverShow.bind(this), timeToShow);
          }
          else {
            clearInlineStyles();
          }
        }.bind(this));

        $(this).on('mouseleave', function(event) {
          clearTimeout(timeoutHide);
          clearTimeout(timeoutClearInlineStyles);
          clearTimeout(timeoutClearClasses);

          if ($('#toolbar-item-administration-tray > nav > div.toolbar-toggle-orientation > div > button').val() === 'horizontal' && !isMobile) {
            timeoutClearInlineStyles = setTimeout(clearInlineStyles, timeToHide);
            timeoutClearClasses = setTimeout(clearClasses, timeToHide);
            timeoutHide = setTimeout(delayedHoverHide, timeToHide);
          }
          else {
            clearInlineStyles();
          }
        });
      });

      // When the orientation button is clicked
      $('#toolbar-item-administration-tray > nav > div.toolbar-toggle-orientation > div > button').on('click', function(e) {
        clearInlineStyles();
        setTimeout(clearClasses, 100);
      });

    }
  };
})(jQuery, Drupal);