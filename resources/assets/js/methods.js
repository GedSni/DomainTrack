(function () {
    var row;
    $(document).ready(function () {
        $("#datePicker").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: new Date,
            minDate: new Date(2017, 1, 1),
            onSelect: function() {
                var date = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/",
                    data: {date: date},
                    dataType: "JSON",
                    success: function(data) {
                        $("#tablesDiv").html(data.view);
                        $("#tables").hide();
                        $(window).resize();
                        $("a.domainTooltip").tooltip();
                    },
                    error: function() {
                        alert('Request failed');
                    }
                });
            }
        });
        $('#back').on('click', function(e){
            window.history.back();
        });
        $('#datePickerButton').click(function() {
            $('#datePicker').datepicker('show');
        });
        $("#tables").change(function () {
            if (this.value === 'Month') {
                $(".dayTableDiv").hide();
                $(".weekTableDiv").hide();
                $(".monthTableDiv").show();
            } else if (this.value === 'Week') {
                $(".dayTableDiv").hide();
                $(".weekTableDiv").show();
                $(".monthTableDiv").hide();
            } else if (this.value === 'Day') {
                $(".dayTableDiv").show();
                $(".weekTableDiv").hide();
                $(".monthTableDiv").hide();
            }
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
        if ($(row.find('.domainTooltip')).length) {
            $("#topStatus").css("display", "table-cell");
        } else {
            $("#topStatus").hide();
        }
        $("#topName").text($(row.children('.nameAndLinks')).text()).attr("href", $(row.children('.nameAndLinks')).text().trim() );
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

    function error(e) {
        alert(e);
    }
})();

