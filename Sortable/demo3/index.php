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
            font-size: 150%;
        }
        .badge {
            font-size: 50%;
        }
        .glyphicon-move {
            touch-action: none;
        }
        @keyframes blink {
            50% { color: #ff0000; border-color: #ff0000; }
        }
        .border-blink { /*or other element you want*/
            animation: blink .3s step-end infinite alternate;
        }
        @keyframes bg-blink {
            50% { background-color: #ff0000; }
        }
        .bgcolor-blink {
            animation: bg-blink .3s step-end infinite alternate;
        }

        .loader {
            border: 6px solid #f3f3f3;
            border-radius: 50%;
            border-top: 6px solid #444444;
            width: 40px;
            height: 40px;
            margin: auto;
            -webkit-animation: spin 1s linear infinite;
            animation: spin 1s linear infinite;
        }
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .ajax-loader {
            padding-bottom: 20px;
            style="display: none;"
        }

        .list-group-item {
            margin-bottom: 0;
        }
    </style>
</head>
<body>

<?php

require_once 'lib/Database.php';
require_once 'lib/utility.php';

$db = new Database();

$rows = $db->getRows('SELECT * FROM demo ORDER BY ord LIMIT 14');

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
<div class="ajax-loader text-center">
    <div class="loader"></div>
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
                data: { sort: JSON.stringify(demo.toArray())},
                success: function () {
                    console.log("order change");
                }
            });
        },
        onEnd: function (evt) {
            evt.item.className += " border-blink";
            evt.item.childNodes[1].className += " bgcolor-blink";
            setTimeout(function () {
                evt.item.classList.remove("border-blink");
                evt.item.childNodes[1].classList.remove("bgcolor-blink");
            },1000);
        }
    });

    var isDoing = false;
    $(window).scroll(function() {
        if(Math.ceil(window.pageYOffset)+window.innerHeight >= document.body.scrollHeight) {
            if (! isDoing) {
                $('.ajax-loader').show();
                loadMoreData();
            }
        }
    });

    var start = document.getElementsByClassName("list-group-item").length;
    var range = 16;
    function loadMoreData() {
        $.ajax({
            url: "ajax/getRecords.php?start="+start+"&range="+range,
            method: "GET",
            beforeSend: function () {
                isDoing = true;
                $('.ajax-loader').show();
            },
            success: function (data) {
                setTimeout(function () {
                    isDoing = false;
                    $('.ajax-loader').hide();
                    $("#listWithHandle").append(data);
                    start += range;
                },2000);
            },
            error: function (jqXHR) {
                setTimeout(function () {
                    switch (jqXHR.status) {
                        case 0:
                            errMsg();
                            break;
                        case 999:
                            $('.loader').hide();
                            $('.ajax-loader').html('到底了');
                            break;
                        default:
                            errMsg(jqXHR.status);
                            break;
                    }
                }, 2000);
            }
        });
    }
    function errMsg(code = null) {
        $('.loader').hide();
        var msg;
        if (code === null) {
            msg = '<h3 id="conn_error">連線失敗</h3>';
        } else {
            msg = '<h3 id="conn_error">錯誤代碼: '+code+'</h3>';
        }
        $('.ajax-loader').append(msg);
        var btn= $('<input id="reload" type="button" value="重試" onclick="reload()"/>');
        $('.ajax-loader').append(btn);
    }
    function reload() {
        $('#reload').remove();
        $('#conn_error').remove();
        $('.loader').show();
        loadMoreData();
    }
</script>

</body>
</html>