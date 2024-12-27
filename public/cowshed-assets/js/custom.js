/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 23);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/custom.js":
/*!***************************************!*\
  !*** ./resources/assets/js/custom.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

$(function () {
  'use strict'; // ______________ PAGE LOADING

  $("#global-loader").fadeOut("slow"); // ______________ Card

  var DIV_CARD = 'div.card'; // ______________ Function for remove card

  $(document).on('click', '[data-toggle="card-remove"]', function (e) {
    var $card = $(this).closest(DIV_CARD);
    $card.remove();
    e.preventDefault();
    return false;
  }); // ______________ Functions for collapsed card

  $(document).on('click', '[data-toggle="card-collapse"]', function (e) {
    var $card = $(this).closest(DIV_CARD);
    $card.toggleClass('card-collapsed');
    e.preventDefault();
    return false;
  }); // ______________ Card full screen

  $(document).on('click', '[data-toggle="card-fullscreen"]', function (e) {
    var $card = $(this).closest(DIV_CARD);
    $card.toggleClass('card-fullscreen').removeClass('card-collapsed');
    e.preventDefault();
    return false;
  }); // ______________Main-navbar

  if (window.matchMedia('(min-width: 992px)').matches) {
    $('.main-navbar .active').removeClass('show');
    $('.main-header-menu .active').removeClass('show');
  }

  $('.main-header .dropdown > a').on('click', function (e) {
    e.preventDefault();
    $(this).parent().toggleClass('show');
    $(this).parent().siblings().removeClass('show');
  });
  $('.mobile-main-header .dropdown > a').on('click', function (e) {
    e.preventDefault();
    $(this).parent().toggleClass('show');
    $(this).parent().siblings().removeClass('show');
  });
  $('.main-navbar .with-sub').on('click', function (e) {
    e.preventDefault();
    $(this).parent().toggleClass('show');
    $(this).parent().siblings().removeClass('show');
  });
  $('.dropdown-menu .main-header-arrow').on('click', function (e) {
    e.preventDefault();
    $(this).closest('.dropdown').removeClass('show');
  });
  $('#mainNavShow').on('click', function (e) {
    e.preventDefault();
    $('body').toggleClass('main-navbar-show');
  });
  $('#mainContentLeftShow').on('click touch', function (e) {
    e.preventDefault();
    $('body').addClass('main-content-left-show');
  });
  $('#mainContentLeftHide').on('click touch', function (e) {
    e.preventDefault();
    $('body').removeClass('main-content-left-show');
  });
  $('#mainContentBodyHide').on('click touch', function (e) {
    e.preventDefault();
    $('body').removeClass('main-content-body-show');
  });
  $('body').append('<div class="main-navbar-backdrop"></div>');
  $('.main-navbar-backdrop').on('click touchstart', function () {
    $('body').removeClass('main-navbar-show');
  }); // ______________Dropdown menu

  $(document).on('click touchstart', function (e) {
    e.stopPropagation();
    var dropTarg = $(e.target).closest('.main-header .dropdown').length;

    if (!dropTarg) {
      $('.main-header .dropdown').removeClass('show');
    }

    if (window.matchMedia('(min-width: 992px)').matches) {
      var navTarg = $(e.target).closest('.main-navbar .nav-item').length;

      if (!navTarg) {
        $('.main-navbar .show').removeClass('show');
      }

      var menuTarg = $(e.target).closest('.main-header-menu .nav-item').length;

      if (!menuTarg) {
        $('.main-header-menu .show').removeClass('show');
      }

      if ($(e.target).hasClass('main-menu-sub-mega')) {
        $('.main-header-menu .show').removeClass('show');
      }
    } else {
      if (!$(e.target).closest('#mainMenuShow').length) {
        var hm = $(e.target).closest('.main-header-menu').length;

        if (!hm) {
          $('body').removeClass('main-header-menu-show');
        }
      }
    }
  }); // ______________MainMenuShow

  $('#mainMenuShow').on('click', function (e) {
    e.preventDefault();
    $('body').toggleClass('main-header-menu-show');
  });
  $('.main-header-menu .with-sub').on('click', function (e) {
    e.preventDefault();
    $(this).parent().toggleClass('show');
    $(this).parent().siblings().removeClass('show');
  });
  $('.main-header-menu-header .close').on('click', function (e) {
    e.preventDefault();
    $('body').removeClass('main-header-menu-show');
  }); // ______________Tooltip

  $('[data-toggle="tooltip"]').tooltip(); // ______________Toast

  $(".toast").toast(); // ______________Back-top-button

  $(window).on("scroll", function (e) {
    if ($(this).scrollTop() > 0) {
      $('#back-to-top').fadeIn('slow');
    } else {
      $('#back-to-top').fadeOut('slow');
    }
  });
  $(document).on("click", "#back-to-top", function (e) {
    $("html, body").animate({
      scrollTop: 0
    }, 600);
    return false;
  }); // ______________Full screen

  $(document).on("click", ".fullscreen-button", function toggleFullScreen() {
    $('html').addClass('fullscreen');

    if (document.fullScreenElement !== undefined && document.fullScreenElement === null || document.msFullscreenElement !== undefined && document.msFullscreenElement === null || document.mozFullScreen !== undefined && !document.mozFullScreen || document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen) {
      if (document.documentElement.requestFullScreen) {
        document.documentElement.requestFullScreen();
      } else if (document.documentElement.mozRequestFullScreen) {
        document.documentElement.mozRequestFullScreen();
      } else if (document.documentElement.webkitRequestFullScreen) {
        document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
      } else if (document.documentElement.msRequestFullscreen) {
        document.documentElement.msRequestFullscreen();
      }
    } else {
      $('html').removeClass('fullscreen');

      if (document.cancelFullScreen) {
        document.cancelFullScreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
    }
  }); // ______________Cover Image

  $(".cover-image").each(function () {
    var attr = $(this).attr('data-image-src');

    if (_typeof(attr) !== ( true ? "undefined" : undefined) && attr !== false) {
      $(this).css('background', 'url(' + attr + ') center center');
    }
  }); // ______________Select2-Search

  $('.select2-no-search').select2({
    minimumResultsForSearch: Infinity,
    placeholder: 'All categories',
    width: '100%'
  }); // ______________Horizontal-menu Active Class

  function addActiveClass(element) {
    if (current === "") {
      if (element.attr('href').indexOf("#") !== -1) {
        element.parents('.main-navbar .nav-item').last().addClass('active');

        if (element.parents('.main-navbar .nav-sub').length) {
          element.parents('.main-navbar .nav-sub-item').last().addClass('active');
        }
      }
    } else {
      if (element.attr('href').indexOf(current) !== -1) {
        element.parents('.main-navbar .nav-item').last().addClass('active');

        if (element.parents('.main-navbar .nav-sub').length) {
          element.parents('.main-navbar .nav-sub-item').last().addClass('active');
        }
      }
    }
  }

  var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
  $('.main-navbar .nav li a').each(function () {
    var $this = $(this);
    addActiveClass($this);
  }); // ______________ SWITCHER-toggle ______________//

  /*Theme Layouts*/
  //$('body').addClass('theme-style');
  //$('body').addClass('light-theme');
  //$('body').addClass('dark-theme');

  /*Header Styles*/
  //$('body').addClass('color-header');
  //$('body').addClass('header-dark');

  /*Horizontal-menu Styles*/
  //$('body').addClass('light-horizontal');
  //$('body').addClass('color-horizontal');

  /*Left-menu Styles*/
  //$('body').addClass('light-leftmenu');
  //$('body').addClass('color-leftmenu');

  /*Leftmenu Icon-Style*/
  //$('body').addClass('icon-style');
});

/***/ }),

/***/ 23:
/*!*********************************************!*\
  !*** multi ./resources/assets/js/custom.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! F:\Lan Messenger Received Files\Laravel\LTR\resources\assets\js\custom.js */"./resources/assets/js/custom.js");


/***/ })

/******/ });