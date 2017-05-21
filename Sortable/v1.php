<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>JS Bin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"/>

    <!-- Latest Sortable -->
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
<!-- List with handle -->
<div id="listWithHandle" class="list-group">
    <?php

    for ($i = 0; $i < 25; $i++) {
        echo '<div data-id="',$i,'" class="list-group-item">';
        echo '    <span class="badge">',$i,'</span>';
        echo '    <span class="glyphicon glyphicon-move" aria-hidden="true"></span>';
        echo '&nbsp;&nbsp;&nbsp;&nbsp;',$i;
        echo '</div>';
    }

    ?>
</div>

<script>
    // List with handle
    var test = Sortable.create(listWithHandle, {
        handle: '.glyphicon-move',
        animation: 150,
        chosenClass: "chosen",
        onUpdate: function () {
            $.ajax({
                url: "updateSort.php",
                method: "POST",
                data: { sort: JSON.stringify(test.toArray()) },
                success: function () {
                    console.log("order change");
                }
            });
        }
    });

    $(document).ready(function () {
        $.get("getSort.php?v1=2", function (data) {
            test.sort(JSON.parse(data));
        });
    });
</script>



</body>
</html>