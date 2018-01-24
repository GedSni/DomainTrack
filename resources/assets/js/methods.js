(function () {
    var row;
    $(document).ready(function () {
        $("#loading-wrapper").remove();
        $("#tables").change(function () {
            changeTable(this.value);
        });
        $(window).resize(function(){
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
            }
        });
        $(window).resize();
        $("a.domainTooltip").tooltip();
    });

    function proceed() {
        $('#loader').show();
        var nextRow = row.closest('tr').next('tr');
        var topDiff = $("#topDiff");
        $("#topName").text($(row.children('.nameAndLinks')).text()).attr("href", "http://" + $(row.children('.nameAndLinks')).text().trim());
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
        $("#bottomName").text($(nextRow.children('.nameAndLinks')).text()).attr("href", "http://" + $(nextRow.children('.nameAndLinks')).text().trim());
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

    function error(e) {
        alert(e);
    }
})();