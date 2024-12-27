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
/******/ 	return __webpack_require__(__webpack_require__.s = 12);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/chart.sparkline.js":
/*!************************************************!*\
  !*** ./resources/assets/js/chart.sparkline.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  'use strict';
  /***************** LINE CHARTS *****************/

  $('#sparkline1').sparkline('html', {
    width: 100,
    height: 50,
    lineColor: '#6259ca ',
    fillColor: false,
    tooltipContainer: $('.main-content')
  });
  $('#sparkline2').sparkline('html', {
    width: 100,
    height: 50,
    lineColor: '#f3ca56',
    fillColor: false
  });
  $('#sparkline19').sparkline('html', {
    width: 100,
    height: 50,
    lineColor: '#f26eaf ',
    fillColor: false,
    tooltipContainer: $('.main-content')
  });
  $('#sparkline20').sparkline('html', {
    width: 100,
    height: 50,
    lineColor: '#70e8a5',
    fillColor: false
  });
  /************** AREA CHARTS ********************/

  $('#sparkline3').sparkline('html', {
    width: 120,
    height: 50,
    lineColor: '#6259ca',
    fillColor: 'rgba(113, 76, 190,0.2)'
  });
  $('#sparkline4').sparkline('html', {
    width: 120,
    height: 50,
    lineColor: '#53caed',
    fillColor: 'rgba(235, 111, 51,0.2)'
  });
  /******************* BAR CHARTS *****************/

  $('#sparkline5').sparkline('html', {
    type: 'bar',
    barWidth: 10,
    height: 50,
    barColor: '#6259ca',
    chartRangeMax: 12
  });
  $('#sparkline6').sparkline('html', {
    type: 'bar',
    barWidth: 10,
    height: 50,
    barColor: '#53caed',
    chartRangeMax: 12
  });
  /***************** STACKED BAR CHARTS ****************/

  $('#sparkline7').sparkline('html', {
    type: 'bar',
    barWidth: 10,
    height: 50,
    barColor: '#6259ca',
    chartRangeMax: 12
  });
  $('#sparkline7').sparkline([4, 5, 6, 7, 4, 5, 8, 7, 6, 6, 4, 7, 6, 4, 7], {
    composite: true,
    type: 'bar',
    barWidth: 10,
    height: 50,
    barColor: '#53caed',
    chartRangeMax: 12
  });
  $('#sparkline8').sparkline('html', {
    type: 'bar',
    barWidth: 10,
    height: 50,
    barColor: '#01b8ff',
    chartRangeMax: 12
  });
  $('#sparkline8').sparkline([4, 5, 6, 7, 4, 5, 8, 7, 6, 6, 4, 7, 6, 4, 7], {
    composite: true,
    type: 'bar',
    barWidth: 10,
    height: 50,
    barColor: '#f16d75',
    chartRangeMax: 12
  });
  /**************** PIE CHART ****************/

  $('#sparkline9').sparkline('html', {
    type: 'pie',
    width: 70,
    height: 50,
    sliceColors: ['#6259ca', '#53caed', '#01b8ff']
  });
  $('#sparkline10').sparkline('html', {
    type: 'pie',
    width: 70,
    height: 50,
    sliceColors: ['#6259ca', '#53caed', '#01b8ff', '#f16d75', '#29ccbb', '#f3ca56']
  });
});

/***/ }),

/***/ 12:
/*!******************************************************!*\
  !*** multi ./resources/assets/js/chart.sparkline.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! F:\Lan Messenger Received Files\Laravel\LTR\resources\assets\js\chart.sparkline.js */"./resources/assets/js/chart.sparkline.js");


/***/ })

/******/ });