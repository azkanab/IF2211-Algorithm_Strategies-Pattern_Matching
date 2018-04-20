<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hello World</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.1.0/lux/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="static/animation.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="display-4 text-center" style="padding-top: 40px">
            <span class="text-white bg-danger" id="spamTitle"></span>
            <span id="titleBox"></span>
            <span id="cursor" style='margin-left: -20px'>|</span>
        </h1>
        <p class="text-secondary text-center">
            Hello World! Let's find out who tweeted spams recently.
        </p>

        <!-- PHP script to show alert -->
        <?php
            if(isset($_GET["keywords"]) && isset($_GET["username"])) {
                if(!$_GET["keywords"] || !$_GET["username"]) {
                    echo "
                        <div class=\"alert alert-warning\" role=\"alert\">
                            Please fill out all the fields.
                        </div>
                    ";
                }
            }
        ?>

        <form action="<?php $_PHP_SELF ?>" method="GET" id="main-form">
            <div class="form-group">
                <label for="usernameInput">Twitter Username</label>
                <input type="text" class="form-control" id="usernameInput" name="username" placeholder="example: @realDonaldTrump" value="<?php echo $_GET["username"]; ?>">
            </div>

            <div class="form-group">
                <label for="keywordsTextArea" id="keywordsLabel">Spam Keywords</label>
                <textarea class="form-control" id="keywordsTextArea" name="keywords" rows="3" placeholder="example: fake, news, trump"><?php echo $_GET["keywords"]; ?></textarea>
            </div>

            <div class="form-group">
                <label for="algorithmSelect">Pattern-Matching Algorithm</label>
                <select class="form-control" id="algorithmSelect" name="algorithm">
                    <option <?php if($_GET["algorithm"] == '0') {echo("selected");}?> value="0">Boyer-Moore</option>
                    <option <?php if($_GET["algorithm"] == '1') {echo("selected");}?> value="1">KMP</option>
                    <option <?php if($_GET["algorithm"] == '2') {echo("selected");}?> value="2">Regular Expressions</option>
                </select>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="caseSensitiveCheck" name="case_sensitive" <?php if($_GET["case_sensitive"] == on) {echo("checked=\"checked\"");}?>>
                <label class="form-check-label" for="caseSensitiveCheck">Case sensitive</label>
            </div>

            <div class="form-group form-check" style="margin-top: -5px">
                <input type="checkbox" class="form-check-input" id="wholeWordCheck" name="whole_word" <?php if($_GET["whole_word"] == on) {echo("checked=\"checked\"");}?>>
                <label class="form-check-label" for="wholeWordCheck">Whole word</label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Go!</button>
        </form>
    </div>
    <br>
    <br>
    <div class="container">

        <!-- PHP script to show tweets -->
        <?php
            // API url
            $api_url = "http://0.0.0.0:4445/api";

            // Handle get request, check if necessary data is filled
            if(isset($_GET["keywords"]) && isset($_GET["username"])) {
                if($_GET["keywords"] && $_GET["username"]) {
                    get_api($api_url, $_GET);
                    exit();
                }   
            }

            function get_api($api_url, $request) {
                // Make query string
                $query_str = "?username=" . $request["username"] . "&keywords=" . $request["keywords"] . "&algorithm=" . $request["algorithm"] . "&case_sensitive=" . $request["case_sensitive"] . "&whole_word=" . $request["whole_word"];
                $query_str = preg_replace('/\s+/', '', $query_str);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $api_url . $query_str);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                
                // Make request
                $response = curl_exec($ch);
                
                // Close the connection, release resources used
                curl_close($ch);
                
                // Decode json response
                $tweets = json_decode($response);

                if ($tweets) {
                    echo "
                        <div class=\"card\">
                            <div class=\"card-body\">
                                <h3 style=\"padding-top: 15px\">Showing tweets from @". $tweets[0]->username ."</h3>
                    ";

                    if($request["case_sensitive"] == on) {
                        echo "<mark class=\"text-white bg-success\">Case sensitive</mark> ";
                    }

                    if($request["whole_word"] == on) {
                        echo "<mark class=\"text-white bg-success\">Whole word</mark>";
                    }

                    echo "<p style=\"margin-top: 10px\"><em>Spam keywords: </em>";

                    foreach ($tweets[0]->spam_keywords as $key => $keyword) {
                        echo "<mark class=\"text-white bg-danger\">". $keyword ."</mark> ";
                    }

                    echo "</p>
                            </div>
                        </div>
                        <br>
                    ";

                    echo "<div class=\"card-columns\">";
                    foreach ($tweets as $tweet) {
                        if ($tweet->spam) {
                            echo "
                                <div class=\"card border-danger\">
                                    <div class=\"card-header text-white bg-danger border-danger\">SPAM</div>
                                    <img class=\"rounded-circle float-left\" src=\"". $tweet->profile_image_url ."\" alt=\"Profile picture\" style=\"padding: 12px\">
                                    <div class=\"card-body\">
                                        <h5 style=\"padding-top: 7px\">@". $tweet->username ."</h5>
                                        <br>
                                        <div class=\"card-text\">". $tweet->text[0] ."";

                            for ($i = 1; $i < sizeof($tweet->text); $i++) {
                                if ($i % 2 != 0) {
                                    echo "<div class=\"text-white bg-danger border-danger\" style=\"display:inline\">". $tweet->text[$i] ."</div>";
                                }
                                else {
                                    echo "". $tweet->text[$i] ."";
                                }
                            }
                            echo "
                                        </div>
                                        <p class=\"card-text\"><small class=\"text-muted\">". $tweet->created ."</small></p>
                                    </div>
                                </div>
                            ";
                        } else {
                            echo "
                                <div class=\"card\">
                                    <img class=\"rounded-circle float-left\" src=\"". $tweet->profile_image_url ."\" alt=\"Profile picture\" style=\"padding: 12px\">
                                    <div class=\"card-body\">
                                        <h5 style=\"padding-top: 7px\">@". $tweet->username ."</h5>
                                        <br>
                                        <p class=\"card-text\">". $tweet->text ."</p>
                                        <p class=\"card-text\"><small class=\"text-muted\">". $tweet->created ."</small></p>
                                    </div>
                                </div>
                            ";
                        }
                    }
                    echo "</div>";
                } else {
                    echo "
                        <div class=\"alert alert-danger\" role=\"alert\">
                            No tweets available.
                        </div>
                    ";
                }
            }
        ?>

    </div>
</body>

</html>