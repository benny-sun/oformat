<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//rubaxa.github.io/Sortable/Sortable.js"></script>

    <style>

        .dynamicTile .col-lg-3.col-xs-3{
            padding:5px;
        }

        .dynamicTile .col-lg-6.col-xs-6{
            padding:5px;
        }

        #tile1{
            background: rgb(0,172,238);
        }

        #tile2{
            background: rgb(243,243,243);
        }

        #tile3{
            background: rgb(71,193,228);
        }

        #tile4{
            background-image: url('http://handsontek.net/demoimages/tiles/facebook.png');
            background-size: cover;
        }

        #tile5{
            background: rgb(175,26,63);
        }

        #tile6{
            background: rgb(62,157,215);
        }

        #tile7{
            background: white;
        }

        #tile8{
            background: rgb(209,70,37);
        }

        #tile9{
            background: rgb(0,142,0);
        }

        #tile10{
            background: rgb(0,93,233);
        }

        img {
            width: 100%;
        }

        .tilecaption{
            position: relative;
            top: 50%;
            transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            margin:0!important;
            text-align: center;
            color:white;
            font-family: Segoe UI;
            font-weight: lighter;
        }

    </style>

    <script>
        $( document ).ready(function() {
            /*  ===============css setting==============  */
            $(".tile").height($("#tile1").width());
            $(".carousel").height($("#tile1").width());
            $(".item").height($("#tile1").width());

            $(window).resize(function() {
                if(this.resizeTO) clearTimeout(this.resizeTO);
                this.resizeTO = setTimeout(function() {
                    $(this).trigger('resizeEnd');
                }, 10);
            });

            $(window).bind('resizeEnd', function() {
                $(".tile").height($("#tile1").width());
                $(".carousel").height($("#tile1").width());
                $(".item").height($("#tile1").width());
            });
            /* ==================================== */
            var items = Sortable.create(test, {
                animation: 150,
                onUpdate: function () {
                    $.ajax({
                        url: "updateSort.php",
                        method: "POST",
                        data: { v2: JSON.stringify(items.toArray()) },
                        success: function () {
                            console.log("order change");
                        }
                    });
                }
            });
            /* ==================================== */
            $.get("getSort.php?v2=3", function (data) {
                items.sort(JSON.parse(data));
            });
        });

    </script>
</head>
<body>
<div class="container-fluid dynamicTile">
    <div id="test" class="row">
        <div data-id="1" class="col-lg-3 col-xs-3">
            <div id="tile1" class="tile">

                <div class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="http://handsontek.net/demoimages/tiles/twitter1.png" class="img-responsive"/>
                        </div>
                        <div class="item">
                            <img src="http://handsontek.net/demoimages/tiles/twitter2.png" class="img-responsive"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div data-id="2" class="col-lg-3 col-xs-3">
            <div id="tile2" class="tile">

                <div class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="http://handsontek.net/demoimages/tiles/hot.png" class="img-responsive"/>
                        </div>
                        <div class="item">
                            <img src="http://handsontek.net/demoimages/tiles/hot2.png" class="img-responsive"/>
                        </div>
                        <div class="item">
                            <img src="http://handsontek.net/demoimages/tiles/hot3.png" class="img-responsive"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div data-id="3" class="col-lg-3 col-xs-3">
            <div id="tile3" class="tile">

                <div class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="http://handsontek.net/demoimages/tiles/weather2.png" class="img-responsive"/>
                        </div>
                        <div class="item">
                            <img src="http://handsontek.net/demoimages/tiles/weather.png" class="img-responsive"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div data-id="4" class="col-lg-3 col-xs-3">
            <div id="tile4" class="tile">

                <div class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="http://handsontek.net/demoimages/tiles/facebook3.png" class="img-responsive"/>
                        </div>
                        <div class="item">
                            <img src="http://handsontek.net/demoimages/tiles/facebook2.png" class="img-responsive"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div data-id="5" class="col-lg-3 col-xs-3">
            <div id="tile5" class="tile">

                <div class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="http://handsontek.net/demoimages/tiles/neews.png" class="img-responsive"/>
                        </div>
                        <div class="item">
                            <img src="http://handsontek.net/demoimages/tiles/neews2.png" class="img-responsive"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div data-id="6" class="col-lg-3 col-xs-3">
            <div id="tile6" class="tile">

                <div class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="http://handsontek.net/demoimages/tiles/skype.png" class="img-responsive"/>
                        </div>
                        <div class="item">
                            <img src="http://handsontek.net/demoimages/tiles/skype2.png" class="img-responsive"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div data-id="7" class="col-lg-6 col-xs-6">
            <div id="tile7" class="tile">

                <div class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="http://handsontek.net/demoimages/tiles/gallery.png" class="img-responsive"/>
                        </div>
                        <div class="item">
                            <img src="http://handsontek.net/demoimages/tiles/gallery2.png" class="img-responsive"/>
                        </div>
                        <div class="item">
                            <img src="http://handsontek.net/demoimages/tiles/gallery3.png" class="img-responsive"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div data-id="8" class="col-lg-3 col-xs-3">
            <div id="tile8" class="tile">

                <div class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="http://handsontek.net/demoimages/tiles/music.png" class="img-responsive"/>
                        </div>
                        <div class="item">
                            <img src="http://handsontek.net/demoimages/tiles/music2.png" class="img-responsive"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div data-id="9" class="col-lg-3 col-xs-3">
            <div id="tile9" class="tile">

                <div class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="http://handsontek.net/demoimages/tiles/calendar.png" class="img-responsive"/>
                        </div>
                        <div class="item">
                            <img src="http://handsontek.net/demoimages/tiles/calendar2.png" class="img-responsive"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div data-id="10" class="col-lg-6 col-xs-6">
            <div id="tile10" class="tile">

                <div class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <h3 class="tilecaption"><i class="fa fa-child fa-4x"></i></h3>
                        </div>
                        <div class="item">
                            <h3 class="tilecaption">Customize your tiles</h3>
                        </div>
                        <div class="item">
                            <h3 class="tilecaption">Text, Icons, Images</h3>
                        </div>
                        <div class="item">
                            <h3 class="tilecaption">Combine them and create your metro style</h3>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>

</script>

</body>
</html>