import os
import json
import twitter
from flask import Flask, request, make_response, render_template

# Constants
CONSUMER_KEY = 'dubyTnlKjsNfJeBxeqMoTWVBO'
CONSUMER_SECRET = '9e4rG2MFGx8t2HrCkqJxGtp9x0dueJc46syynOputmOVt4JnoZ'
ACCESS_TOKEN = '175577847-XxsaI8SszFJgxtx5VNa9mEeYoS5q3HliVkFqxvp1'
ACCESS_TOKEN_KEY = 'ePOk72RwuYf3tG2bqxLed5PmY6rAb2EClpDt1sdSebbSk'


# Create Flask app
app = Flask(__name__)


# API Endpoints
@app.route('/api', methods=['GET'])
def show_spam_tweets():
    user = request.args.get('user', type=str)
    statuses = api.GetUserTimeline(screen_name=user)
    # print([s.text for s in statuses])
    print(statuses)


if __name__ == '__main__':
    # Init Twitter API
    api = twitter.Api(consumer_key=CONSUMER_KEY,
                      consumer_secret=CONSUMER_SECRET,
                      access_token_key=ACCESS_TOKEN,
                      access_token_secret=ACCESS_TOKEN_KEY)

    # Run app
    app.run(debug=True, port=4445, threaded=True)