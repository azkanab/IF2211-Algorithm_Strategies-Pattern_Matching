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
</head>

<body>
    <div class="container">
        <h1 class="display-4 text-center" style="padding-top: 40px">F*ck Spam</h1>
        <p class="text-secondary text-center">
            Hello World! Let's find out who tweeted spams recently.
        </p>

        <!-- PHP script to show alert -->
        <?php
            if(!$_GET["keywords"] || !$_GET["username"]) {
                echo "
                    <div class=\"alert alert-warning\" role=\"alert\">
                        Please fill out all the fields.
                    </div>
                ";
            }
        ?>

        <form action="<?php $_PHP_SELF ?>" method="GET" id="main-form">
            <div class="form-group">
                <label for="usernameInput">Twitter Username</label>
                <input type="text" class="form-control" id="usernameInput" name="username" placeholder="example: @realDonaldTrump">
            </div>

            <div class="form-group">
                <label for="keywordsTextArea">Spam Keywords</label>
                <textarea class="form-control" id="keywordsTextArea" name="keywords" rows="3" placeholder="example: fuck, shit, trump"></textarea>
            </div>

            <div class="form-group">
                <label for="algorithmSelect">Pattern-Matching Algorithm</label>
                <select class="form-control" id="algorithmSelect" name="algorithm">
                    <option value="0">Boyer-Moore</option>
                    <option value="1">KMP</option>
                </select>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="caseSensitiveCheck">
                <label class="form-check-label" for="caseSensitiveCheck">Case sensitive</label>
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
                $query_str = "?username=" . $request["username"] . "&keywords=" . $request["keywords"] . "&algorithm=" . $request["algorithm"];
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
                    echo "<div class=\"card-columns\">";
                    foreach ($tweets as $tweet) {
                        if ($tweet->spam) {
                            echo "
                                <div class=\"card border-danger\">
                                    <div class=\"card-header text-white bg-danger border-danger\">SPAM</div>
                                    <img class=\"rounded-circle float-left\" src=\"". $tweet->profile_image_url ."\" alt=\"Profile picture\" style=\"padding: 12px\">
                                    <div class=\"card-body\">
                                        <h4 style=\"padding-top: 4px\">". $tweet->username ."</h4>
                                        <br>
                                        <p class=\"card-text\">". $tweet->text ."</p>
                                        <p class=\"card-text\"><small class=\"text-muted\">". $tweet->created ."</small></p>
                                    </div>
                                </div>
                            ";
                        } else {
                            echo "
                                <div class=\"card\">
                                    <img class=\"rounded-circle float-left\" src=\"". $tweet->profile_image_url ."\" alt=\"Profile picture\" style=\"padding: 12px\">
                                    <div class=\"card-body\">
                                        <h4 style=\"padding-top: 4px\">". $tweet->username ."</h4>
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