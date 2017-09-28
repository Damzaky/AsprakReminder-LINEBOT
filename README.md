# AsprakReminder-LINEBOT
A bot that reminds DAP asprak group 2017 about their schedules

## Installation
```
composer require google/apiclient:^2.0
```

## Make the LINE bot account
Just make the bot here https://developers.line.me/console/register/messaging-api/provider/

## Editing the files
1. push.php, change the TOKEN to the TOKEN and SECRET to channel secret that you obtain from your bot account on LINE developer site, also change the `USER ID / ROOM ID / GROUP ID YANG DITUJU` to your line account ID (not bot account ID)
2. getsheet.php, change the sheet id to the desired sheet id (optional), change the /client_secret.json to file that you download from google app engine, also change the access token to that exists inside the client_secret.json

## Automation
I personally use cron job from my hosting site to automate this everyday at 05.00 in the morning

## Testing
Just open the push.php file, if your line account received a message, then you've done everything (probably) right :)
