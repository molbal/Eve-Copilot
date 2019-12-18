<!-- <p align="center"><img height="188" width="198" src="#"></p>-->
<h1 align="center">Eve Co-Pilot</h1>

## Introduction

...

## Supported commands

...


## Installation

### Prerequisites:

#### Mandatory
- Have Facebook Messenger bot auth info ready (FACEBOOK_TOKEN, FACEBOOK_VERIFICATION, FACEBOOK_APP_SECRET)
- Have Telegram bot auth info ready (TELEGRAM_TOKEN)
- Have your Eve Online 3rd party app credentials and scopes ready (EVE_CLIENT_ID, EVE_CLIENT_SECRET, EVE_CLIENT_SCOPES) 

### Optional (Recommended)
- Have a Laravel compatible caching mechanism in place (Memcached or Redis recommended, the default file system cache can work as well)

### Installation

- Create .env from the .env.example file. 
    - This includes all the database, caching, and credentials setup 
- Run `php artisan migrate` to set up the database
- Set the Facebook Messenger URL here: https://developers.facebook.com/apps/<your facebook app id>>/messenger/settings/
- Set the Telegram Messenger URL by running the `php artisan botman:telegram:register` command  
- Set the EVE Online 3rd party application callback URL: https://developers.eveonline.com/applications/details/<your eve online app id>

## Database scheme

## Cache scheme