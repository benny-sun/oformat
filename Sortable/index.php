<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>

    <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
<!--    <script type="text/javascript" src="http://www.pureexample.com/js/lib/jquery.ui.touch-punch.min.js"></script>-->

    <!-- CSS -->
    <style type="text/css">
        .list {
            background-color: pink;
            font-size: 30px;
            text-align: center;
            cursor: pointer;
            font-family: Geneva,Arial,Helvetica,sans-serif;
            border: 1px solid gray;
        }

        #items .ui-selected {
            background: red;
            color: white;
            font-weight: bold;
        }

        #items {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        #items li {
            float: left;
            margin: 2px;
            padding: 2px;
            width: 50px;
            height: 50px;
            line-height: 50px;
        }

        .highlight {
            border: 2px solid red;
            font-weight: bold;
            font-size: 50px;
            background-color: lightblue;
        }

        .opacity {
            opacity: 0.5;
        }

        .big {
            width: 110px !important;
        }
        .col-xs-3 {
            height: 250px;
            background-color: #3399ff;
            border: 2px white solid;
        }
        .col-xs-6 {
            height: 250px;
            background-color: #3A3A4D;
            border: 2px white solid;
        }
        div[class*="col-xs-"] > h1 {
            color: white;
        }
    </style>

</head>
<body>

<div class="container-fluid">
    <div class="row">
        <?php
            for ($i = 1; $i <= 16; $i++) {
                $part = 'col-xs-3';
                if ($i === 5 || $i === 14) { $part = 'col-xs-6'; }
                echo '<div id="item_',$i,'" class="',$part,'"><h1>',$i,'</h1></div>';
            }
        ?>
    </div>
</div>
<!--<div style="width:520px">-->
<!--    <ul id="items">-->
<!--        --><?php
//            for ($i = 1; $i <= 30; $i++) {
//                ($i == 3 || $i == 9 || $i == 22) ? $big = 'big' : $big = '';
//                echo '<li id="item_',$i,'" class="list ',$big,'">',$i,'</li>';
//            }
//        ?>
<!--    </ul>-->
<!--</div>-->
<div id="info" style="font-family:Geneva,Arial,Helvetica,sans-serif;font-size:20px;"></div>

<!-- Javascript -->
<script>
    jQuery(".row").sortable();
//    $(function () {
//        $(".row").sortable({
//            start: function (event, ui) {
//                ui.item.toggleClass("highlight");
//            },
//            stop: function (event, ui) {
//                ui.item.toggleClass("highlight");
//            },
//            update: function () {
//                var postData = $(this).sortable('serialize');
//                console.log(postData);
//            }
//        });
//        $(".row").disableSelection();
//        $("#items").sortable({
//            start: function (event, ui) {
//                ui.item.toggleClass("highlight");
//            },
//            stop: function (event, ui) {
//                ui.item.toggleClass("highlight");
//            },
//            update: function () {
//                var postData = $(this).sortable('serialize');
//                console.log(postData);
//            }
//        });
//        $("#items").disableSelection();
//    });
</script>

</body>
</html>