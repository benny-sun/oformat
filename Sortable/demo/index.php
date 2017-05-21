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
            font-size: 180%;
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
    </style>
</head>
<body>

<?php

require_once 'lib/Database.php';
require_once 'lib/utility.php';

$db = new Database();

$sort = $db->getRow('SELECT sort FROM sortable WHERE id = 6');

$sort = $sort['sort'];

$sort = getSortPart($sort, 0, 10);

$rows = $db->getRows('SELECT * FROM demo WHERE id IN ( '.$sort.' ) ORDER BY FIELD(id,'.$sort.')');

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
//        var a = window.pageYOffset+window.innerHeight +" , "+document.body.scrollHeight;
//        var spans = document.getElementsByClassName( 'badge' );
//        [].slice.call( spans ).forEach(function ( sp ) {
//            sp.innerHTML = a;
//        });
        if(window.pageYOffset+window.innerHeight >= document.body.scrollHeight) {
            if (! isDoing) {
                $('.ajax-load').show();
                loadMoreData();
            }
        }
    });

    var start = document.getElementsByClassName("list-group-item").length;
    function loadMoreData() {
        $.ajax({
            url: "ajax/getRecords.php?start="+start,
            method: "GET",
            beforeSend: function () {
                isDoing = true;
                $('.ajax-load').show();
            },
            success: function (data) {
                setTimeout(function () {
                    isDoing = false;
                    $('.ajax-load').hide();
                    console.log(start);
                    $("#listWithHandle").append(data);
                    start += 10;
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