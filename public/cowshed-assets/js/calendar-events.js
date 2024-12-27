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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/calendar-events.js":
/*!************************************************!*\
  !*** ./resources/assets/js/calendar-events.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
// sample calendar events data


var curYear = moment().format('YYYY');
var curMonth = moment().format('MM'); // Calendar Event Source

var sptCalendarEvents = {
  id: 1,
  events: [{
    id: '1',
    start: curYear + '-' + curMonth + '-02T09:00:00',
    end: curYear + '-' + curMonth + '-02T13:00:00',
    title: 'Spruko Meetup',
    backgroundColor: '#00cccc',
    borderColor: '#00cccc',
    textColor: '#fff',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '2',
    start: curYear + '-' + curMonth + '-12T09:00:00',
    end: curYear + '-' + curMonth + '-12T17:00:00',
    title: 'Design Review',
    backgroundColor: '#9e3aef',
    borderColor: '#9e3aef',
    textColor: '#fff',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '3',
    start: curYear + '-' + curMonth + '-13T12:00:00',
    end: curYear + '-' + curMonth + '-13T18:00:00',
    title: 'Lifestyle Conference',
    backgroundColor: '#ff5733',
    borderColor: '#ff5733',
    textColor: '#fff',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '4',
    start: curYear + '-' + curMonth + '-21T07:30:00',
    end: curYear + '-' + curMonth + '-21T15:30:00',
    title: 'Team Weekly Brownbag',
    backgroundColor: '#0373f3',
    borderColor: '#0373f3',
    textColor: '#fff',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '5',
    start: curYear + '-' + curMonth + '-04T10:00:00',
    end: curYear + '-' + curMonth + '-06T15:00:00',
    title: 'Music Festival',
    backgroundColor: '#007bff',
    borderColor: '#007bff',
    textColor: '#fff',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '6',
    start: curYear + '-' + curMonth + '-23T13:00:00',
    end: curYear + '-' + curMonth + '-23T18:30:00',
    title: 'Attend Lea\'s Wedding',
    backgroundColor: '#560bd0',
    borderColor: '#560bd0',
    textColor: '#fff',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }]
}; // Birthday Events Source

var sptBirthdayEvents = {
  id: 2,
  backgroundColor: '#23bf08',
  borderColor: '#23bf08',
  textColor: '#fff',
  events: [{
    id: '7',
    start: curYear + '-' + curMonth + '-04T18:00:00',
    end: curYear + '-' + curMonth + '-04T23:30:00',
    title: 'Harcates Birthday',
    backgroundColor: '#23bf08',
    borderColor: '#23bf08',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '8',
    start: curYear + '-' + curMonth + '-28T15:00:00',
    end: curYear + '-' + curMonth + '-28T21:00:00',
    title: 'Jinnysin\'s Birthday',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }, {
    id: '9',
    start: curYear + '-' + curMonth + '-31T15:00:00',
    end: curYear + '-' + curMonth + '-31T21:00:00',
    title: 'Lee shin\'s Birthday',
    description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
  }]
};
var sptHolidayEvents = {
  id: 3,
  backgroundColor: '#f10075',
  borderColor: '#f10075',
  textColor: '#fff',
  events: [{
    id: '10',
    start: curYear + '-' + curMonth + '-05',
    end: curYear + '-' + curMonth + '-08',
    title: 'Festival Day'
  }, {
    id: '11',
    start: curYear + '-' + curMonth + '-18',
    end: curYear + '-' + curMonth + '-19',
    title: 'Memorial Day'
  }, {
    id: '12',
    start: curYear + '-' + curMonth + '-25',
    end: curYear + '-' + curMonth + '-26',
    title: 'Diwali'
  }]
};
var sptOtherEvents = {
  id: 4,
  backgroundColor: '#de9102',
  borderColor: '#de9102',
  textColor: '#fff',
  events: [{
    id: '13',
    start: curYear + '-' + curMonth + '-07',
    end: curYear + '-' + curMonth + '-09',
    title: 'My Rest Day'
  }, {
    id: '13',
    start: curYear + '-' + curMonth + '-29',
    end: curYear + '-' + curMonth + '-31',
    title: 'My Rest Day'
  }]
};

/***/ }),

/***/ 4:
/*!******************************************************!*\
  !*** multi ./resources/assets/js/calendar-events.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! F:\Lan Messenger Received Files\Laravel\LTR\resources\assets\js\calendar-events.js */"./resources/assets/js/calendar-events.js");


/***/ })

/******/ });