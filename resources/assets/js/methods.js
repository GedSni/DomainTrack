(function () {

    var row;

    $(document).ready(function () {
        if (window.location.hash === '#_=_'){
            history.replaceState
                ? history.replaceState(null, null, window.location.href.split('#')[0])
                : window.location.hash = '';
        }
        tableChange($("#tables").val());
        datePicker();
        $('#datePickerButton').click(function() {
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
        $(".heart").click(function () {
            $(this).toggleClass("filled");
            var id = $("#domainId").text();
            if ($(this).hasClass("filled")) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/favorite/" + id,
                    data: {id: id},
                    dataType: "JSON"
                });
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/unfavorite/" + id,
                    data: {id: id},
                    dataType: "JSON"
                });
            }
        });
        checkWidth();
        $( window ).resize(function() {
            checkWidth();
        });
    });

    function checkWidth(){
        if ($( window ).width() >= 1200 &&  ($(".dayTableDiv").hasClass('col-12') || $(".weekTableDiv").hasClass('col-12') || $(".monthTableDiv").hasClass('col-12'))) {
            $(".dayTableDiv").removeClass('col-12').addClass('col-4');
            $(".weekTableDiv").removeClass('col-12').addClass('col-4');
            $(".monthTableDiv").removeClass('col-12').addClass('col-4');
        } else if($( window ).width() < 1200 && ($(".dayTableDiv").hasClass('col-4') || $(".weekTableDiv").hasClass('col-4') || $(".monthTableDiv").hasClass('col-4'))) {

            $(".dayTableDiv").removeClass('col-4').addClass('col-12');
            $(".weekTableDiv").removeClass('col-4').addClass('col-12');
            $(".monthTableDiv").removeClass('col-4').addClass('col-12');
        }
    }

    function proceed()
    {
        $('#loader').show();
        var nextRow = row.closest('tr').next('tr');
        var topDiff = $("#topDiff");
        if ($(row.find('.statusImg')).length) {
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

