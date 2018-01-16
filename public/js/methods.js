function changeTable(value) {
    if (value == 'Month') {
        document.getElementById("dayTableDiv").style.display = "none";
        document.getElementById("weekTableDiv").style.display = "none";
        document.getElementById("monthTableDiv").style.display = "inline-table";
        document.getElementById("monthTableDiv").style.width = "100%";
        if(document.getElementById("floatingHeader") != null) {
            document.getElementById("floatingHeader").style.width = "100%";
        }
    } else if (value == 'Week') {
        document.getElementById("dayTableDiv").style.display = "none";
        document.getElementById("weekTableDiv").style.display = "inline-table";
        document.getElementById("weekTableDiv").style.width = "100%";
        if(document.getElementById("floatingHeader") != null) {
            document.getElementById("floatingHeader").style.width = "100%";
        }
        document.getElementById("monthTableDiv").style.display = "none";
    } else if (value == 'Day') {
        document.getElementById("dayTableDiv").style.display = "inline-table";
        document.getElementById("dayTableDiv").style.width = "100%";
        if(document.getElementById("floatingHeader") != null) {
            document.getElementById("floatingHeader").style.width = "100%";
        }
        document.getElementById("weekTableDiv").style.display = "none";
        document.getElementById("monthTableDiv").style.display = "none";
    }
}

function error(e){
    alert(e);
}

(function () {
    var row;
    $(document).ready(function(){
        if ( $(window).width() < 992) {
            $('.link', 'tr').click(function(e) {
                e.preventDefault();
                $(".overlay").show();
                row = $(this).closest('tr');
                proceed();
            });
            $("button.nextRow").click(proceed);
            $("button.exit").click(function(){
                $(".overlay").hide();
            });
        }
    });

    function proceed() {
        var nextRow = row.closest('tr').next('tr');
        $("#topName").text($(row.children('.nameAndLinks')).text());
        $("#topSimilar").attr( "href", "https://www.similarweb.com/website/" + $(row.children('.nameAndLinks')).text());
        $("#topAlexa").attr( "href", "https://www.alexa.com/siteinfo/" + $(row.children('.nameAndLinks')).text());
        $("#topRank").text($(row.children('.rank')).text());
        $("#topDiff").text($(row.children('.diff')).text());
        if (parseInt($("#topDiff").text()) > 0) {
            $("#topDiff").addClass("label-success").removeClass("label-danger label-default");
        } else if (parseInt($("#topDiff").text()) < 0) {
            $("#topDiff").addClass("label-danger").removeClass("label-success label-default");
        } else if (parseInt($("#topDiff").text()) === 0) {
            $("#topDiff").addClass("label-default").removeClass("label-success label-danger");
        }
        $("#bottomName").text($(nextRow.children('.nameAndLinks')).text());
        $("#bottomSimilar").attr( "href", "https://www.similarweb.com/website/" + $(nextRow.children('.nameAndLinks')).text());
        $("#bottomAlexa").attr( "href", "https://www.alexa.com/siteinfo/" + $(nextRow.children('.nameAndLinks')).text());
        $("#bottomRank").text($(nextRow.children('.rank')).text());
        $("#bottomDiff").text($(nextRow.children('.diff')).text());
        if (parseInt($("#bottomDiff").text()) > 0) {
            $("#bottomDiff").addClass("label-success").removeClass("label-danger label-default");
        } else if (parseInt($("#bottomDiff").text()) < 0) {
            $("#bottomDiff").addClass("label-danger").removeClass("label-success label-default");
        } else if (parseInt($("#bottomDiff").text()) === 0) {
            $("#bottomDiff").addClass("label-default").removeClass("label-success label-danger");
        }
        $("#mainFrame").attr("src", "http://"+$(row.children('.nameAndLinks')).text().trim());
        row = nextRow;
    }
})();