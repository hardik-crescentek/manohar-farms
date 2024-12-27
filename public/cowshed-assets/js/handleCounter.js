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
/******/ 	return __webpack_require__(__webpack_require__.s = 31);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/handleCounter.js":
/*!**********************************************!*\
  !*** ./resources/assets/js/handleCounter.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * handle counter
 */
;

(function () {
  'use strict';

  $.fn.handleCounter = function (options) {
    var $input, $btnMinus, $btnPlugs, minimum, maximize, writable, onChange, onMinimum, onMaximize;
    var $handleCounter = this;
    $btnMinus = $handleCounter.find('.counter-minus');
    $input = $handleCounter.find('input');
    $btnPlugs = $handleCounter.find('.counter-plus');
    var defaultOpts = {
      writable: true,
      minimum: 1,
      maximize: null,
      onChange: function onChange() {},
      onMinimum: function onMinimum() {},
      onMaximize: function onMaximize() {}
    };
    var settings = $.extend({}, defaultOpts, options);
    minimum = settings.minimum;
    maximize = settings.maximize;
    writable = settings.writable;
    onChange = settings.onChange;
    onMinimum = settings.onMinimum;
    onMaximize = settings.onMaximize;

    if (!$.isNumeric(minimum)) {
      minimum = defaultOpts.minimum;
    }

    if (!$.isNumeric(maximize)) {
      maximize = defaultOpts.maximize;
    }

    var inputVal = $input.val();

    if (isNaN(parseInt(inputVal))) {
      inputVal = $input.val(0).val();
    }

    if (!writable) {
      $input.prop('disabled', true);
    }

    changeVal(inputVal);
    $input.val(inputVal);
    $btnMinus.click(function () {
      var num = parseInt($input.val());

      if (num > minimum) {
        $input.val(num - 1);
        changeVal(num - 1);
      }
    });
    $btnPlugs.click(function () {
      var num = parseInt($input.val());

      if (maximize == null || num < maximize) {
        $input.val(num + 1);
        changeVal(num + 1);
      }
    });
    var keyUpTime;
    $input.keyup(function () {
      clearTimeout(keyUpTime);
      keyUpTime = setTimeout(function () {
        var num = $input.val();

        if (num == '') {
          num = minimum;
          $input.val(minimum);
        }

        var reg = new RegExp("^[\\d]*$");

        if (isNaN(parseInt(num)) || !reg.test(num)) {
          $input.val($input.data('num'));
          changeVal($input.data('num'));
        } else if (num < minimum) {
          $input.val(minimum);
          changeVal(minimum);
        } else if (maximize != null && num > maximize) {
          $input.val(maximize);
          changeVal(maximize);
        } else {
          changeVal(num);
        }
      }, 300);
    });
    $input.focus(function () {
      var num = $input.val();
      if (num == 0) $input.select();
    });

    function changeVal(num) {
      $input.data('num', num);
      $btnMinus.prop('disabled', false);
      $btnPlugs.prop('disabled', false);

      if (num <= minimum) {
        $btnMinus.prop('disabled', true);
        onMinimum.call(this, num);
      } else if (maximize != null && num >= maximize) {
        $btnPlugs.prop('disabled', true);
        onMaximize.call(this, num);
      }

      onChange.call(this, num);
    }

    return $handleCounter;
  }; //  handleCounter


  var options = {
    minimum: 1,
    maximize: 10,
    onChange: valChanged,
    onMinimum: function onMinimum(e) {
      console.log('reached minimum: ' + e);
    },
    onMaximize: function onMaximize(e) {
      console.log('reached maximize' + e);
    }
  };
  $('#handleCounter').handleCounter(options);
  $('#handleCounter1').handleCounter(options);
  $('#handleCounter2').handleCounter(options);
  $('#handleCounter3').handleCounter(options);
  $('#handleCounter4').handleCounter(options);
  $('#handleCounter5').handleCounter(options);

  function valChanged(d) {//   console.log(d)
  }
})(jQuery);

/***/ }),

/***/ 31:
/*!****************************************************!*\
  !*** multi ./resources/assets/js/handleCounter.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! F:\Lan Messenger Received Files\Laravel\LTR\resources\assets\js\handleCounter.js */"./resources/assets/js/handleCounter.js");


/***/ })

/******/ });