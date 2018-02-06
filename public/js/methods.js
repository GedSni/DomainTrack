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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/methods.js":
/***/ (function(module, exports) {

(function () {

    var row;

    $(document).ready(function () {
        $("a.domainTooltip").tooltip();

        $('#datePickerButton').click(function () {
            datePicker();
            $('#datePicker').datepicker('show');
        });
        $('.link, .linkDate').click(function (e) {
            screenMode($(this), e);
        });
        $("#tables").change(function () {
            tableChange(this.value);
        });
    });

    function proceed() {
        $('#loader').show();
        var nextRow = row.closest('tr').next('tr');
        var topDiff = $("#topDiff");
        if ($(row.find('.domainTooltip')).length) {
            $("#topStatus").css("display", "table-cell");
        } else {
            $("#topStatus").hide();
        }
        $("#topName").text($(row.children('.nameAndLinks')).text()).attr("href", $(row.children('.nameAndLinks')).text().trim());
        $("#topSimilar").attr("href", "https://www.similarweb.com/website/" + $(row.children('.nameAndLinks')).text());
        $("#topAlexa").attr("href", "https://www.alexa.com/siteinfo/" + $(row.children('.nameAndLinks')).text());
        $("#topRank").text($(row.children('.rank')).text());
        topDiff.text($(row.children('.diff')).text());
        if (parseInt(topDiff.text()) > 0) {
            topDiff.addClass("badge-success").removeClass("badge-danger badge-primary");
        } else if (parseInt(topDiff.text()) < 0) {
            topDiff.addClass("badge-danger").removeClass("badge-success badge-primary");
        } else if (parseInt(topDiff.text()) === 0) {
            topDiff.addClass("badge-primary").removeClass("badge-success badge-danger");
        }

        $("#bottomName").text($(nextRow.children('.nameAndLinks')).text()).attr("href", $(nextRow.children('.nameAndLinks')).text().trim());
        if ($(nextRow.find('.domainTooltip')).length) {
            $("#bottomStatus").show();
        } else {
            $("#bottomStatus").hide();
        }
        $("#mainFrame").attr("src", "http://" + $(row.children('.nameAndLinks')).text().trim()).on('load', function () {
            $('#loader').hide();
        });
        row = nextRow;
    }

    function screenMode(thisObj, e) {
        if ($(window).width() < 1200) {
            e.preventDefault();
            $(".overlay").show();
            $("body").css("overflow", "hidden");
            row = thisObj.closest('tr');
            proceed();
            $("button.nextRow").click(proceed);
            $("button.exit").click(function () {
                $(".overlay").hide();
                $("body").css("overflow", "visible");
            });
        }
    }

    function datePicker() {
        $("#datePicker").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: new Date(Date.now() - 864e5),
            minDate: new Date(2017, 1, 1),
            onSelect: function onSelect() {
                var date = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/",
                    data: { date: date },
                    dataType: "JSON",
                    success: function success(data) {
                        $("#tablesDiv").html(data.view);
                        $("#tables").hide();
                        $("a.domainTooltip").tooltip();
                    },
                    error: function error() {
                        alert('Request failed');
                    }
                });
            }
        });
    }

    function tableChange(value) {
        if (value === 'Month') {
            $(".dayTableDiv").hide();
            $(".weekTableDiv").hide();
            $(".monthTableDiv").show();
        } else if (value === 'Week') {
            $(".dayTableDiv").hide();
            $(".weekTableDiv").show();
            $(".monthTableDiv").hide();
        } else if (value === 'Day') {
            $(".dayTableDiv").show();
            $(".weekTableDiv").hide();
            $(".monthTableDiv").hide();
        }
    }

    function error(e) {
        alert(e);
    }
})();

/***/ }),

/***/ "./resources/assets/sass/app.scss":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/assets/sass/style.scss":
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("./resources/assets/js/methods.js");
__webpack_require__("./resources/assets/sass/app.scss");
module.exports = __webpack_require__("./resources/assets/sass/style.scss");


/***/ })

/******/ });