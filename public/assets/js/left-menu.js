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
/******/ 	return __webpack_require__(__webpack_require__.s = 34);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/left-menu.js":
/*!******************************************!*\
  !*** ./resources/assets/js/left-menu.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  "use strict"; //Active Class

  $(".app-sidebar a").each(function () {
    var pageUrl = window.location.href.split(/[?#]/)[0];

    if (this.href == pageUrl) {
      $(this).addClass("active");
      $(this).parent().parent().parent().parent().parent().parent().parent().parent().addClass("active"); // add active to li of the current link

      $(this).parent().parent().parent().parent().parent().parent().parent().parent().addClass("resp-tab-content-active"); // add active to li of the current link

      $(this).parent().parent().parent().parent().parent().prev().addClass("active"); // add active class to an anchor

      $(this).parent().parent().prev().click(); // click the item to make it drop
    }
  });
  $(".side-menu a").each(function () {
    var pageUrl = window.location.href.split(/[?#]/)[0];

    if (this.href == pageUrl) {
      $(this).addClass("active");
      $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().addClass("active"); // add active to li of the current link

      $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().addClass("resp-tab-content-active"); // add active to li of the current link

      $(this).parent().parent().parent().parent().parent().prev().addClass("active"); // add active class to an anchor

      $(this).parent().parent().prev().click(); // click the item to make it drop
    }
  });
  $(".submenu-list li a").each(function () {
    var pageUrl = window.location.href.split(/[?#]/)[0];

    if (this.href == pageUrl) {
      $(this).addClass("active");
      $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().addClass("active"); // add active to li of the current link

      $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().addClass("resp-tab-content-active"); // add active to li of the current link

      $(this).parent().parent().parent().parent().parent().prev().addClass("active"); // add active class to an anchor

      $(this).parent().parent().prev().click(); // click the item to make it drop
    }
  });
  $('.slide.submenu.is-expanded').addClass("active");
  $(document).ready(function () {
    if ($('.dashboard-admin.active').hasClass('active')) $('li.dashboard-admin').addClass('active');
    if ($('.crypto-admin.active').hasClass('active')) $('li.crypto-admin').addClass('active');
    if ($('.apps-admin.active').hasClass('active')) $('li.apps-admin').addClass('active');
    if ($('.maps-tables-admin.active').hasClass('active')) $('li.maps-tables-admin').addClass('active');
    if ($('.element-admin.active').hasClass('active')) $('li.element-admin').addClass('active');
    if ($('.advanceui-admin.active').hasClass('active')) $('li.advanceui-admin').addClass('active');
    if ($('.icons-admin.active').hasClass('active')) $('li.icons-admin').addClass('active');
    if ($('.forms-admin.active').hasClass('active')) $('li.forms-admin').addClass('active');
    if ($('.charts-admin.active').hasClass('active')) $('li.charts-admin').addClass('active');
    if ($('.pages-admin.active').hasClass('active')) $('li.pages-admin').addClass('active');
    if ($('.ecommerce-admin.active').hasClass('active')) $('li.ecommerce-admin').addClass('active');
    if ($('.utilities-admin.active').hasClass('active')) $('li.utilities-admin').addClass('active');
    if ($('.custompages-admin.active').hasClass('active')) $('li.custompages-admin').addClass('active');
  }); // VerticalTab

  $('#sidemenu-Tab').easyResponsiveTabs({
    type: 'vertical',
    width: 'auto',
    fit: true,
    closed: 'accordion',
    tabidentify: 'hor_1',
    activate: function activate(event) {
      var $tab = $(this);
      var $info = $('#nested-tabInfo2');
      var $name = $('span', $info);
      $name.text($tab.text());
      $info.show();
    }
  });
  var ps13 = new PerfectScrollbar('.first-sidemenu', {
    useBothWheelAxes: true,
    suppressScrollX: true
  });
  var ps14 = new PerfectScrollbar('.second-sidemenu', {
    useBothWheelAxes: true,
    suppressScrollX: true
  });

  var toggleSidebar = function toggleSidebar() {
    var w = $(window);

    if (w.outerWidth() <= 1024) {
      $("body").addClass("sidebar-gone");
      $(document).off("click", "body").on("click", "body", function (e) {
        if ($(e.target).hasClass('sidebar-show') || $(e.target).hasClass('search-show')) {
          $("body").removeClass("sidebar-show");
          $("body").addClass("sidebar-gone");
          $("body").removeClass("search-show");
        }
      });
    } else {
      $("body").removeClass("sidebar-gone");
    }
  };

  toggleSidebar();
  $(window).resize(toggleSidebar);
})(jQuery);

/***/ }),

/***/ 34:
/*!************************************************!*\
  !*** multi ./resources/assets/js/left-menu.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! F:\Lan Messenger Received Files\Laravel\LTR\resources\assets\js\left-menu.js */"./resources/assets/js/left-menu.js");


/***/ })

/******/ });