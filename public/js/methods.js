    $(document).ready(function () {
        $('table.table').floatThead();
    });

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
        var $table = $('table.table');
        $table.floatThead('reflow');
    }