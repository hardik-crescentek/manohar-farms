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
/******/ 	return __webpack_require__(__webpack_require__.s = 27);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/form-elements.js":
/*!**********************************************!*\
  !*** ./resources/assets/js/form-elements.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  'use strict'; // Toggle Switches

  $('.main-toggle').on('click', function () {
    $(this).toggleClass('on');
  }); // Input Masks

  $('#dateMask').mask('99/99/9999');
  $('#phoneMask').mask('(999) 999-9999');
  $('#phoneExtMask').mask('(999) 999-9999? ext 99999');
  $('#ssnMask').mask('999-99-9999'); // Color picker

  $('#colorpicker').spectrum({
    color: '#17A2B8'
  }); // transparency selection

  $('#showAlpha').spectrum({
    color: 'rgba(23,162,184,0.5)',
    showAlpha: true
  }); //Palettes selection 

  $('#showPaletteOnly').spectrum({
    showPaletteOnly: true,
    showPalette: true,
    color: '#DC3545',
    palette: [['#1D2939', '#fff', '#0866C6', '#23BF08', '#F49917'], ['#DC3545', '#17A2B8', '#6610F2', '#fa1e81', '#72e7a6']]
  }); // Fc-datepicker

  $('.fc-datepicker').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true
  }); // Datepicker no of months

  $('#datepickerNoOfMonths').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true,
    numberOfMonths: 2
  }); // Rangeslider1

  $('.rangeslider1').ionRangeSlider(); // Rangeslider2

  $('.rangeslider2').ionRangeSlider({
    min: 100,
    max: 1000,
    from: 550
  }); // Rangeslider3

  $('.rangeslider3').ionRangeSlider({
    type: 'double',
    grid: true,
    min: 0,
    max: 1000,
    from: 200,
    to: 800,
    prefix: '$'
  }); // Rangeslider4

  $('.rangeslider4').ionRangeSlider({
    type: 'double',
    grid: true,
    min: -1000,
    max: 1000,
    from: -500,
    to: 500,
    step: 250
  }); // Filebrowser

  $(document).on('change', ':file', function () {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  }); // We can watch for our custom `fileselect` event like this

  $(document).ready(function () {
    $(':file').on('fileselect', function (event, numFiles, label) {
      var input = $(this).parents('.input-group').find(':text'),
          log = numFiles > 1 ? numFiles + ' files selected' : label;

      if (input.length) {
        input.val(log);
      } else {
        if (log) alert(log);
      }
    });
  });
});

/***/ }),

/***/ 27:
/*!****************************************************!*\
  !*** multi ./resources/assets/js/form-elements.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! F:\Lan Messenger Received Files\Laravel\LTR\resources\assets\js\form-elements.js */"./resources/assets/js/form-elements.js");


/***/ })

/******/ });