import os
import json
import twitter
from flask import Flask, request, make_response
from secrets import *
from scripts.pattern_matching import bm_algo, kmp_algo, regex


# Create Flask app
app = Flask(__name__)


# API Endpoints
@app.route('/api', methods=['GET'])
def show_spam_tweets():
    # Get queries
    username = request.args.get('username', type=str)
    keywords = request.args.get('keywords', type=str)
    algorithm = request.args.get('algorithm', type=int)
    case_sensitive = request.args.get('case_sensitive', type=bool)
    whole_word = request.args.get('whole_word', type=bool)

    # Parse keywords (unless regex)
    print (keywords);
    if (algorithm != 2):
        keywords = keywords.replace("@", "").replace(" ", "").split(",")
    else:
        keywords = [keywords]

    # Request user tweets from Twitter API
    statuses = api.GetUserTimeline(screen_name=username)
    
    # Make tweet dicts
    tweets = []
    for status in statuses:
        tweet = {}
        tweet['name'] = status.user.name
        tweet['username'] = status.user.screen_name
        tweet['profile_image_url'] = status.user.profile_image_url
        tweet['text'] = status.text
        tweet['created'] = status.created_at
        tweet['spam_keywords'] = keywords

        # Use algorithm to filter tweets for spam
        # Bayer-Moore
        tweet['spam'] = False

        if algorithm == 0:
            for keyword in keywords:
                result = bm_algo(tweet['text'], keyword, case_sensitive, whole_word)
                if result != -1:
                    tweet['spam'] = True
                    tweet['text'] = result
                    break
        # KMP
        elif algorithm == 1:
            for keyword in keywords:
                result = kmp_algo(tweet['text'], keyword, case_sensitive, whole_word)
                if result != -1:
                    tweet['spam'] = True
                    tweet['text'] = result
                    break
        # REGULAR EXPRESSIONS
        elif algorithm == 2:
            for keyword in keywords:
                result = regex(tweet['text'], keyword)
                if result != -1:
                    tweet['spam'] = True
                    tweet['text'] = result
                    break

        tweets.append(tweet)
    
    # Return json
    return json.dumps(tweets)


if __name__ == '__main__':
    # Init Twitter API
    api = twitter.Api(consumer_key=CONSUMER_KEY,
                      consumer_secret=CONSUMER_SECRET,
                      access_token_key=ACCESS_TOKEN,
                      access_token_secret=ACCESS_TOKEN_KEY)

    # Run app
    app.run(debug=True, port=4445, threaded=True)
