(function () {

    var row;

    $(document).ready(function () {
        tableChange($("#tables").val());
        $("a.domainTooltip").tooltip();
        datePicker();
        $('#datePickerButton').click(function() {
            $('#datePicker').datepicker('show');
        });
        $('.preview').click(function (e) {
            overlay($(this), e);
        });
        $("#tables").change(function () {
            tableChange(this.value);
        });
        $('#back').click(function () {
            window.history.back();
        });
        $("button.nextRow").click(proceed);
        $("button.exit").click(function () {
            $(".overlay").hide();
            $("body").css("overflow", "visible");
        });
    });

    function proceed()
    {
        $('#loader').show();
        var nextRow = row.closest('tr').next('tr');
        var topDiff = $("#topDiff");
        if ($(row.find('.domainTooltip')).length) {
            $("#topStatus").css("display", "table-cell");
        } else {
            $("#topStatus").hide();
        }
        $("#topName").text($(row.children('.name')).text()).attr("href", $(row.children('.name')).text().trim() );
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
        if ($(nextRow.find('.domainTooltip')).length) {
            $("#bottomStatus").show();
        } else {
            $("#bottomStatus").hide();
        }
        $("#mainFrame").attr("src", "http://" + $(row.children('.name')).text().trim()).on('load', function () {
            $('#loader').hide();
        });
        row = nextRow;
    }

    function overlay(thisObj, e)
    {
        e.preventDefault();
        $(".overlay").show();
        $("body").css("overflow", "hidden");
        row = thisObj.closest('tr');
        proceed();
    }

    function datePicker()
    {
        $("#datePicker").datepicker({
            dateFormat: "yy-mm-dd",
            maxDate: new Date(Date.now() - 864e5),
            minDate: new Date(2017, 1, 1),
        });
    }

    function tableChange(value)
    {
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

    function error(e)
    {
        alert(e);
    }
})();

