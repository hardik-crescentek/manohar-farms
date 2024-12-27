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
/******/ 	return __webpack_require__(__webpack_require__.s = 26);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/form-editor.js":
/*!********************************************!*\
  !*** ./resources/assets/js/form-editor.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  'use strict';

  var icons = Quill["import"]('ui/icons');
  icons['bold'] = '<i class="la la-bold" aria-hidden="true"><\/i>';
  icons['italic'] = '<i class="la la-italic" aria-hidden="true"><\/i>';
  icons['underline'] = '<i class="la la-underline" aria-hidden="true"><\/i>';
  icons['strike'] = '<i class="la la-strikethrough" aria-hidden="true"><\/i>';
  icons['list']['ordered'] = '<i class="la la-list-ol" aria-hidden="true"><\/i>';
  icons['list']['bullet'] = '<i class="la la-list-ul" aria-hidden="true"><\/i>';
  icons['link'] = '<i class="la la-link" aria-hidden="true"><\/i>';
  icons['image'] = '<i class="la la-image" aria-hidden="true"><\/i>';
  icons['video'] = '<i class="la la-film" aria-hidden="true"><\/i>';
  icons['code-block'] = '<i class="la la-code" aria-hidden="true"><\/i>';
  var toolbarOptions = [[{
    'header': [1, 2, 3, 4, 5, 6, false]
  }], ['bold', 'italic', 'underline', 'strike'], [{
    'list': 'ordered'
  }, {
    'list': 'bullet'
  }], ['link', 'image', 'video']];
  var quill = new Quill('#quillEditor', {
    modules: {
      toolbar: toolbarOptions
    },
    theme: 'snow'
  });
  var quillModal2 = new Quill('#quillEditorModal2', {
    modules: {
      toolbar: toolbarOptions
    },
    theme: 'snow'
  });
  var toolbarInlineOptions = [['bold', 'italic', 'underline'], [{
    'header': 1
  }, {
    'header': 2
  }, 'blockquote'], ['link', 'image', 'code-block']];
  var quillInline = new Quill('#quillInline', {
    modules: {
      toolbar: toolbarInlineOptions
    },
    bounds: '#quillInline',
    scrollingContainer: '#scrolling-container',
    placeholder: 'Write something...',
    theme: 'bubble'
  });
  new PerfectScrollbar('#scrolling-container', {
    suppressScrollX: true
  });
  $('#summernote').summernote({
    placeholder: 'Hello bootstrap 4',
    tabsize: 3,
    height: 300
  });
});

/***/ }),

/***/ 26:
/*!**************************************************!*\
  !*** multi ./resources/assets/js/form-editor.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! F:\Lan Messenger Received Files\Laravel\LTR\resources\assets\js\form-editor.js */"./resources/assets/js/form-editor.js");


/***/ })

/******/ });