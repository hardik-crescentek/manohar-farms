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
/******/ 	return __webpack_require__(__webpack_require__.s = 15);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/check-all-mail.js":
/*!***********************************************!*\
  !*** ./resources/assets/js/check-all-mail.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  'use strict';

  $('#checkAll').on('click', function () {
    if ($(this).is(':checked')) {
      $('.main-mail-list .ckbox input').each(function () {
        $(this).closest('.main-mail-item').addClass('selected');
        $(this).attr('checked', true);
      });
      $('.main-mail-options .btn:not(:first-child)').removeClass('disabled');
    } else {
      $('.main-mail-list .ckbox input').each(function () {
        $(this).closest('.main-mail-item').removeClass('selected');
        $(this).attr('checked', false);
      });
      $('.main-mail-options .btn:not(:first-child)').addClass('disabled');
    }
  });
  $('.main-mail-item .main-mail-checkbox input').on('click', function () {
    if ($(this).is(':checked')) {
      $(this).attr('checked', false);
      $(this).closest('.main-mail-item').addClass('selected');
      $('.main-mail-options .btn:not(:first-child)').removeClass('disabled');
    } else {
      $(this).attr('checked', true);
      $(this).closest('.main-mail-item').removeClass('selected');

      if (!$('.main-mail-list .selected').length) {
        $('.main-mail-options .btn:not(:first-child)').addClass('disabled');
      }
    }
  });
  $('.main-mail-star').on('click', function (e) {
    $(this).toggleClass('active');
  });
  $('#btnCompose').on('click', function (e) {
    e.preventDefault();
    $('.main-mail-compose').show();
  });
  $('.main-mail-compose-header a:first-child').on('click', function (e) {
    e.preventDefault();
    $('.main-mail-compose').toggleClass('main-mail-compose-minimize');
  });
  $('.main-mail-compose-header a:nth-child(2)').on('click', function (e) {
    e.preventDefault();
    $(this).find('.fas').toggleClass('fa-compress');
    $(this).find('.fas').toggleClass('fa-expand');
    $('.main-mail-compose').toggleClass('main-mail-compose-compress');
    $('.main-mail-compose').removeClass('main-mail-compose-minimize');
  });
  $('.main-mail-compose-header a:last-child').on('click', function (e) {
    e.preventDefault();
    $('.main-mail-compose').hide(100);
    $('.main-mail-compose').removeClass('main-mail-compose-minimize');
  });
});

/***/ }),

/***/ 15:
/*!*****************************************************!*\
  !*** multi ./resources/assets/js/check-all-mail.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! F:\Lan Messenger Received Files\Laravel\LTR\resources\assets\js\check-all-mail.js */"./resources/assets/js/check-all-mail.js");


/***/ })

/******/ });