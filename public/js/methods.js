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
        $("#loading-wrapper").hide();
        $("#datePicker").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: new Date(),
            minDate: new Date(2017, 1, 1),
            onSelect: function onSelect() {
                $("#loading-wrapper").show();
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
                        $(window).resize();
                        $("a.domainTooltip").tooltip();
                        $("#loading-wrapper").hide();
                    },
                    error: function error() {
                        alert('Request failed');
                        $("#loading-wrapper").hide();
                    }
                });
            }
        });
        $('#back').on('click', function (e) {
            window.history.back();
        });
        $('#datePickerButton').click(function () {
            $('#datePicker').datepicker('show');
        });
        $('#toHome').click(function () {
            document.location.href = "/";
        });
        $("#tables").change(function () {
            changeTable(this.value);
        });
        $(window).resize(function () {
            if ($(window).width() < 1200) {
                $('.link', 'tr').click(function (e) {
                    e.preventDefault();
                    $(".overlay").show();
                    $("body").css("overflow", "hidden");
                    row = $(this).closest('tr');
                    proceed();
                });
                $("button.nextRow").click(proceed);
                $("button.exit").click(function () {
                    $(".overlay").hide();
                    $("body").css("overflow", "visible");
                });
            } else if ($(window).width() >= 1200) {
                $('.link', 'tr').off('click');
                window.onscroll = function () {
                    scrollFunction();
                };
                $("#toTop").click(function () {
                    topFunction();
                });
            }
        });
        $(window).resize();
        $("a.domainTooltip").tooltip();
    });

    function proceed() {
        $('#loader').show();
        var nextRow = row.closest('tr').next('tr');
        var topDiff = $("#topDiff");
        $("#topName").text($(row.children('.nameAndLinks')).text()).attr("href", $(row.children('.nameAndLinks')).text().trim());
        $("#topSimilar").attr("href", "https://www.similarweb.com/website/" + $(row.children('.nameAndLinks')).text());
        $("#topAlexa").attr("href", "https://www.alexa.com/siteinfo/" + $(row.children('.nameAndLinks')).text());
        $("#topRank").text($(row.children('.rank')).text());
        topDiff.text($(row.children('.diff')).text());
        if (parseInt(topDiff.text()) > 0) {
            topDiff.addClass("label-success").removeClass("label-danger label-default");
        } else if (parseInt(topDiff.text()) < 0) {
            topDiff.addClass("label-danger").removeClass("label-success label-default");
        } else if (parseInt(topDiff.text()) === 0) {
            topDiff.addClass("label-default").removeClass("label-success label-danger");
        }
        if ($(row.find('.status')).length) {
            $("#topStatus").css("display", "table-cell");
        } else {
            $("#topStatus").hide();
        }
        $("#bottomName").text($(nextRow.children('.nameAndLinks')).text()).attr("href", $(nextRow.children('.nameAndLinks')).text().trim());
        if ($(nextRow.find('.status')).length) {
            $("#bottomStatus").css("display", "table-cell");
        } else {
            $("#bottomStatus").hide();
        }
        $("#mainFrame").attr("src", "http://" + $(row.children('.nameAndLinks')).text().trim()).on('load', function () {
            $('#loader').hide();
        });
        row = nextRow;
    }

    function changeTable(value) {
        if (value === 'Month') {
            document.getElementById("dayTableDiv").style.display = "none";
            document.getElementById("weekTableDiv").style.display = "none";
            document.getElementById("monthTableDiv").style.display = "inline-table";
            document.getElementById("monthTableDiv").style.width = "100%";
            if (document.getElementById("floatingHeader") != null) {
                document.getElementById("floatingHeader").style.width = "100%";
            }
        } else if (value === 'Week') {
            document.getElementById("dayTableDiv").style.display = "none";
            document.getElementById("weekTableDiv").style.display = "inline-table";
            document.getElementById("weekTableDiv").style.width = "100%";
            if (document.getElementById("floatingHeader") != null) {
                document.getElementById("floatingHeader").style.width = "100%";
            }
            document.getElementById("monthTableDiv").style.display = "none";
        } else if (value === 'Day') {
            document.getElementById("dayTableDiv").style.display = "inline-table";
            document.getElementById("dayTableDiv").style.width = "100%";
            if (document.getElementById("floatingHeader") != null) {
                document.getElementById("floatingHeader").style.width = "100%";
            }
            document.getElementById("weekTableDiv").style.display = "none";
            document.getElementById("monthTableDiv").style.display = "none";
        }
    }

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("toTop").style.display = "block";
        } else {
            document.getElementById("toTop").style.display = "none";
        }
    }

    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
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