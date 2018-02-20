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
        if (window.location.hash === '#_=_') {
            history.replaceState ? history.replaceState(null, null, window.location.href.split('#')[0]) : window.location.hash = '';
        }
        tableChange($("#tables").val());
        datePicker();
        $('#datePickerButton').click(function () {
            $('#datePicker').datepicker('show');
        });
        $('.preview').click(function (e) {
            $("button.nextRow").show();
            overlay($(this), e);
        });
        $("#tables").change(function () {
            tableChange(this.value);
        });
        $("button.nextRow").click(proceed);
        $("button.exit").click(function () {
            $(".overlay").hide();
            $("body").css("overflow", "visible");
        });
        $(".followButton").click(function () {
            var id = $(this).attr('data-id');
            $(this).toggleClass("following");
            if ($(this).hasClass("following")) {
                $(".followButton").text('Following').removeClass('btn-outline-primary').addClass('btn-primary');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/favorite/" + id,
                    data: { id: id },
                    dataType: "JSON"
                });
            } else {
                $(".followButton").text('+ Follow').removeClass('btn-primary').addClass('btn-outline-primary');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/unfavorite/" + id,
                    data: { id: id },
                    dataType: "JSON"
                });
            }
        });
        $("#multipleFavoriteButton").click(function () {
            $(this).toggleClass("on");
            if ($(this).hasClass("on")) {
                $("#multipleFavoriteButton").removeClass('btn-outline-primary').addClass('btn-primary');
                $("#multipleFavoritesForm").toggle(true);
            } else {
                $("#multipleFavoriteButton").removeClass('btn-primary').addClass('btn-outline-primary');
                $("#multipleFavoritesForm").toggle(false);
            }
        });
        checkWidth();
        $(window).resize(function () {
            checkWidth();
        });
    });

    function checkWidth() {
        if ($(window).width() >= 1200 && ($(".dayTableDiv").hasClass('col-12') || $(".weekTableDiv").hasClass('col-12') || $(".monthTableDiv").hasClass('col-12'))) {
            $(".dayTableDiv").removeClass('col-12').addClass('col-4');
            $(".weekTableDiv").removeClass('col-12').addClass('col-4');
            $(".monthTableDiv").removeClass('col-12').addClass('col-4');
        } else if ($(window).width() < 1200 && ($(".dayTableDiv").hasClass('col-4') || $(".weekTableDiv").hasClass('col-4') || $(".monthTableDiv").hasClass('col-4'))) {

            $(".dayTableDiv").removeClass('col-4').addClass('col-12');
            $(".weekTableDiv").removeClass('col-4').addClass('col-12');
            $(".monthTableDiv").removeClass('col-4').addClass('col-12');
        }
    }

    function proceed() {
        $('#loader').show();
        var nextRow = row.closest('tr').next('tr');
        var topDiff = $("#topDiff");
        if ($(row.find('.statusImg')).length) {
            $("#topStatus").css("display", "table-cell");
        } else {
            $("#topStatus").hide();
        }
        $("#topName").text($(row.children('.name')).text()).attr("href", $(row.children('.name')).text().trim());
        $("#topRank").text($(row.children('.rank')).text());
        topDiff.text($(row.children('.diff')).text());
        if (parseInt(topDiff.text()) > 0) {
            topDiff.addClass("badge-success").removeClass("badge-danger badge-primary");
        } else if (parseInt(topDiff.text()) < 0) {
            topDiff.addClass("badge-danger").removeClass("badge-success badge-primary");
        } else if (parseInt(topDiff.text()) === 0) {
            topDiff.addClass("badge-primary").removeClass("badge-success badge-danger");
        }
        $("#bottomName").text($(nextRow.children('.name')).text()).attr("href", $(nextRow.children('.name')).text().trim());
        if ($(nextRow.find('.statusImg')).length) {
            $("#bottomStatus").show();
        } else {
            $("#bottomStatus").hide();
        }
        $("#mainFrame").attr("src", "http://" + $(row.children('.name')).text().trim()).on('load', function () {
            $('#loader').hide();
        });
        row = nextRow;
        if ($(row.children('.name')).text() === "") {
            $("button.nextRow").hide();
        }
    }

    function overlay(thisObj, e) {
        e.preventDefault();
        $(".overlay").show();
        $("body").css("overflow", "hidden");
        row = thisObj.closest('tr');
        proceed();
    }

    function datePicker() {
        $("#datePicker").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: new Date(Date.now() - 864e5),
            minDate: new Date(2017, 1, 1)
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