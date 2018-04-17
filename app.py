import os
import json
import twitter
from flask import Flask, request, make_response
from secrets import *


# Create Flask app
app = Flask(__name__)


# API Endpoints
@app.route('/api', methods=['GET'])
def show_spam_tweets():
    # Request user tweets from Twitter API
    username = request.args.get('username', type=str)
    statuses = api.GetUserTimeline(screen_name=username)
    
    # Get tweet texts
    tweets = []
    for status in statuses:
        tweet = {}
        tweet['name'] = status.user.name
        tweet['username'] = status.user.screen_name
        tweet['profile_image_url'] = status.user.profile_image_url
        tweet['text'] = status.text
        tweet['created'] = status.created_at

        # TODO: use algorithm to filter tweets for spam

        tweet['spam'] = True
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
