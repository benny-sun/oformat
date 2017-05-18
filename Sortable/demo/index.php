<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>
    <script src="//rubaxa.github.io/Sortable/Sortable.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <style>
        .chosen { color: red;}
        div {
            font-size: 200%;
        }
        .badge {
            font-size: 50%;
        }
    </style>
</head>
<body>

<?php

$x = include('test1.php');
echo $x;

require_once 'lib/Database.php';
require_once 'lib/utility.php';

$db = new Database();

$rows = $db->getRows('SELECT * FROM demo LIMIT 18');

$last_id = $rows[sizeof($rows)-1]['id'];

$db->Disconnect();

echo '<div id="listWithHandle" class="list-group">';

foreach ($rows as $key => $row) {
    echo '<div data-id="',$row['id'],'" class="list-group-item">';
    echo '    <span class="badge">',$row['id'],'</span>';
    echo '    <span class="glyphicon glyphicon-move" aria-hidden="true"></span>';
    echo '    &nbsp;&nbsp;&nbsp;&nbsp;',$row['data'];
    echo '</div>';
}

echo '</div>';

?>

<div class="ajax-load text-center" style="display:none">
    <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading</p>
</div>

<script>
    var demo = Sortable.create(listWithHandle, {
        handle: '.glyphicon-move',
        animation: 150,
        chosenClass: "chosen",
        onUpdate: function () {
            $.ajax({
                url: "ajax/refreshSort.php",
                method: "POST",
                data: { sort: JSON.stringify(demo.toArray()), id: 6 },
                success: function () {
                    console.log("order change");
                }
            });
        }
    });

    $(document).ready(function () {
        $.get("ajax/getSort.php?id=6", function (data) {
            demo.sort(JSON.parse(data));
        });
    });

    var isDoing = false;
    $(window).scroll(function() {
        if(Math.ceil($(window).scrollTop()) + $(window).height() >= $(document).height()) {
            var last_id = $(".list-group-item:last").attr("data-id");
            if (! isDoing) {
                loadMoreData(last_id);
            }
        }
    });

    function loadMoreData(last_id) {

        $.ajax({
            url: "ajax/getRecords.php?last_id="+last_id,
            method: "GET",
            beforeSend: function () {
                isDoing = true;
                $('.ajax-load').show();
            },
            success: function (data) {
                setTimeout(function () {
                    isDoing = false;
                    $('.ajax-load').hide();
                    console.log(data);
                    $("#listWithHandle").append(data);
                },2000);
            },
            error: function (jqXHR, exception) {
                setTimeout(function () {
                    $('.ajax-load').hide();
                }, 2000);
                console.log(jqXHR);
            }
        });

    }
</script>

</body>
</html>