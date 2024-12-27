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
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/chart.chartjs.js":
/*!**********************************************!*\
  !*** ./resources/assets/js/chart.chartjs.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(function () {
  var _ref, _ref2;

  /*LIne-Chart */
  var ctx = document.getElementById("chartLine").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ["Sun", "Mon", "Tus", "Wed", "Thu", "Fri", "Sat"],
      datasets: [(_ref = {
        label: 'Profits',
        data: [20, 420, 210, 354, 580, 320, 480],
        borderWidth: 2,
        backgroundColor: 'transparent',
        borderColor: '#6259ca'
      }, _defineProperty(_ref, "borderWidth", 3), _defineProperty(_ref, "pointBackgroundColor", '#ffffff'), _defineProperty(_ref, "pointRadius", 2), _ref)]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        xAxes: [{
          ticks: {
            fontColor: "#77778e"
          },
          display: true,
          gridLines: {
            color: 'rgba(119, 119, 142, 0.2)'
          }
        }],
        yAxes: [{
          ticks: {
            fontColor: "#77778e"
          },
          display: true,
          gridLines: {
            color: 'rgba(119, 119, 142, 0.2)'
          },
          scaleLabel: {
            display: false,
            labelString: 'Thousands',
            fontColor: 'rgba(119, 119, 142, 0.2)'
          }
        }]
      },
      legend: {
        labels: {
          fontColor: "#77778e"
        }
      }
    }
  });
  /* Bar-Chart1 */

  var ctx = document.getElementById("chartBar1").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
      datasets: [(_ref2 = {
        label: 'Sales',
        data: [200, 450, 290, 367, 256, 543, 345],
        borderWidth: 2,
        backgroundColor: '#9877f9',
        borderColor: '#9877f9'
      }, _defineProperty(_ref2, "borderWidth", 2.0), _defineProperty(_ref2, "pointBackgroundColor", '#ffffff'), _ref2)]
    },
    options: _defineProperty({
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        display: true
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            stepSize: 150,
            fontColor: "#77778e"
          },
          gridLines: {
            color: 'rgba(119, 119, 142, 0.2)'
          }
        }],
        xAxes: [{
          ticks: {
            display: true,
            fontColor: "#77778e"
          },
          gridLines: {
            display: false,
            color: 'rgba(119, 119, 142, 0.2)'
          }
        }]
      }
    }, "legend", {
      labels: {
        fontColor: "#77778e"
      }
    })
  });
  /* Bar-Chart2*/

  var ctx = document.getElementById("chartBar2");
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
      datasets: [{
        label: "Data1",
        data: [65, 59, 80, 81, 56, 55, 40],
        borderColor: "#6259ca",
        borderWidth: "0",
        backgroundColor: "#6259ca"
      }, {
        label: "Data2",
        data: [28, 48, 40, 19, 86, 27, 90],
        borderColor: "#53caed",
        borderWidth: "0",
        backgroundColor: "#53caed"
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        xAxes: [{
          ticks: {
            fontColor: "#77778e"
          },
          gridLines: {
            color: 'rgba(119, 119, 142, 0.2)'
          }
        }],
        yAxes: [{
          ticks: {
            beginAtZero: true,
            fontColor: "#77778e"
          },
          gridLines: {
            color: 'rgba(119, 119, 142, 0.2)'
          }
        }]
      },
      legend: {
        labels: {
          fontColor: "#77778e"
        }
      }
    }
  });
  /* Area Chart*/

  var ctx = document.getElementById("chartArea");
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
      datasets: [{
        label: "Data1",
        borderColor: "rgba(113, 76, 190, 0.9)",
        borderWidth: "1",
        backgroundColor: "rgba(113, 76, 190, 0.5)",
        data: [22, 44, 67, 43, 76, 45, 12]
      }, {
        label: "Data2",
        borderColor: "rgba(235, 111, 51 ,0.9)",
        borderWidth: "1",
        backgroundColor: "rgba(	235, 111, 51, 0.7)",
        pointHighlightStroke: "rgba(235, 111, 51 ,1)",
        data: [16, 32, 18, 26, 42, 33, 44]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      tooltips: {
        mode: 'index',
        intersect: false
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        xAxes: [{
          ticks: {
            fontColor: "#77778e"
          },
          gridLines: {
            color: 'rgba(119, 119, 142, 0.2)'
          }
        }],
        yAxes: [{
          ticks: {
            beginAtZero: true,
            fontColor: "#77778e"
          },
          gridLines: {
            color: 'rgba(119, 119, 142, 0.2)'
          }
        }]
      },
      legend: {
        labels: {
          fontColor: "#77778e"
        }
      }
    }
  });
  /* Pie Chart*/

  var datapie = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
    datasets: [{
      data: [20, 20, 30, 5, 25],
      backgroundColor: ['#6259ca', '#53caed', '#01b8ff', '#f16d75', '#29ccbb']
    }]
  };
  var optionpie = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    animation: {
      animateScale: true,
      animateRotate: true
    }
  };
  /* Doughbut Chart*/

  var ctx6 = document.getElementById('chartPie');
  var myPieChart6 = new Chart(ctx6, {
    type: 'doughnut',
    data: datapie,
    options: optionpie
  });
  /* Pie Chart*/

  var ctx7 = document.getElementById('chartDonut');
  var myPieChart7 = new Chart(ctx7, {
    type: 'pie',
    data: datapie,
    options: optionpie
  });
  /* Radar chart*/

  var ctx = document.getElementById("chartRadar");
  var myChart = new Chart(ctx, {
    type: 'radar',
    data: {
      labels: [["Eating", "Dinner"], ["Drinking", "Water"], "Sleeping", ["Designing", "Graphics"], "Coding", "Cycling", "Running"],
      datasets: [{
        label: "Data1",
        data: [65, 59, 66, 45, 56, 55, 40],
        borderColor: "rgba(113, 76, 190, 0.9)",
        borderWidth: "1",
        backgroundColor: "rgba(113, 76, 190, 0.5)"
      }, {
        label: "Data2",
        data: [28, 12, 40, 19, 63, 27, 87],
        borderColor: "rgba(235, 111, 51,0.8)",
        borderWidth: "1",
        backgroundColor: "rgba(235, 111, 51,0.4)"
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        display: false
      },
      scale: {
        angleLines: {
          color: '#77778e'
        },
        gridLines: {
          color: 'rgba(119, 119, 142, 0.2)'
        },
        ticks: {
          beginAtZero: true
        },
        pointLabels: {
          fontColor: '#77778e'
        }
      }
    }
  });
  /* polar chart */

  var ctx = document.getElementById("chartPolar");
  var myChart = new Chart(ctx, {
    type: 'polarArea',
    data: {
      datasets: [{
        data: [18, 15, 9, 6, 19],
        backgroundColor: ['#6259ca', '#53caed', '#01b8ff', '#f16d75', '#29ccbb'],
        hoverBackgroundColor: ['#6259ca', '#53caed', '#01b8ff', '#f16d75', '#29ccbb'],
        borderColor: 'transparent'
      }],
      labels: ["Data1", "Data2", "Data3", "Data4"]
    },
    options: {
      scale: {
        gridLines: {
          color: 'rgba(119, 119, 142, 0.2)'
        }
      },
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        labels: {
          fontColor: "#77778e"
        }
      }
    }
  });
});

/***/ }),

/***/ 6:
/*!****************************************************!*\
  !*** multi ./resources/assets/js/chart.chartjs.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! F:\Lan Messenger Received Files\Laravel\LTR\resources\assets\js\chart.chartjs.js */"./resources/assets/js/chart.chartjs.js");


/***/ })

/******/ });