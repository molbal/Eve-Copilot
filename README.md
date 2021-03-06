<p align="center"><img height="120"  src="https://co-pilot.eve-nt.uk/images/logo-color.png"></p>
<h1 align="center">EVE Co-Pilot</h1>

## Introduction

Co-Pilot for EVE Online: On Facebook Messenger and Telegram. Providing location, mailing, emergency and intelligence services

## Supported commands

Please see the website homepage for commands. (No reason for documenting them twice)

## Installation

### Prerequisites:

#### Mandatory
- Have Facebook Messenger bot auth info ready (`FACEBOOK_TOKEN`, `FACEBOOK_VERIFICATION`, `FACEBOOK_APP_SECRET`)
- Have Telegram bot auth info ready (`TELEGRAM_TOKEN`)
- Have your Eve Online 3rd party app credentials and scopes ready (`EVEONLINE_CLIENT_ID`, `EVEONLINE_CLIENT_SECRET`, `EVEONLINE_REDIRECT`, `EVEONLINE_CLIENT_SCOPES`) 

### Optional (Recommended)
- Have a Laravel compatible caching mechanism in place (Memcached or Redis recommended, the default file system cache can work as well)

### Installation

- Create .env from the .env.example file. 
    - This includes all the database, caching, and credentials setup 
- Run `php artisan migrate` to set up the database
- Set the Facebook Messenger URL here: https://developers.facebook.com/apps/<your facebook app id>>/messenger/settings/
- Set the Telegram Messenger URL by running the `php artisan botman:telegram:register` command  
- Set the EVE Online 3rd party application callback URL: https://developers.eveonline.com/applications/details/<your eve online app id>
- Some functions need scheduled tasks. To enable this, please have the following CRON job set up: (This is only needed on worker instances)
 ```
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

## Database scheme

### characters
This table contains basic character information and refresh token.
<table>
    <tr>
        <td><b>Column name</b></td>
        <td><b>Purpose</b></td>
        <td><b>Type</b></td>
        <td><b>Index</b></td>
    </tr>
    <tr>
        <td>ID</td>
        <td>Eve Character ID</td>
        <td>BIGINT (unsigned)</td>
        <td>Primary</td>
    </tr>
    <tr>
        <td>NAME</td>
        <td>Eve Character Name</td>
        <td>VARCHAR (256)</td>
        <td>Index</td>
    </tr>
    <tr>
        <td>REFRESH_TOKEN</td>
        <td>Eve OAuth2 Refresh Token Name</td>
        <td>VARCHAR (1000)</td>
        <td>-</td>
    </tr>
    <tr>
        <td>CONTROL_TOKEN</td>
        <td>This token must be provided in the chat to allow access to this character</td>
        <td>VARCHAR (32)</td>
        <td></td>
    </tr>
    <tr>
        <td>created_at</td>
        <td>Laravel created at column</td>
        <td>Timestamp</td>
        <td>-</td>
    </tr>
    <tr>
        <td>updated_at</td>
        <td>Laravel updated at column</td>
        <td>Timestamp</td>
        <td>-</td>
    </tr>
</table>

### link
This table links together chat user IDs to EVE User IDs, and has their password. 

<table>
    <tr>
        <td><b>Column name</b></td>
        <td><b>Purpose</b></td>
        <td><b>Type</b></td>
        <td><b>Index</b></td>
    </tr>
    <tr>
        <td>CHAT_ID</td>
        <td>Chat ID</td>
        <td>Varchar (64)</td>
        <td>Primary</td>
    </tr>
    <tr>
        <td>CHAR_ID</td>
        <td>Eve Character ID</td>
        <td>BIGINT (unsigned)</td>
        <td>Foreign key on CHARACTER.ID</td>
    </tr>
    <tr>
        <td>created_at</td>
        <td>Laravel created at column</td>
        <td>Timestamp</td>
        <td>-</td>
    </tr>
    <tr>
        <td>updated_at</td>
        <td>Laravel updated at column</td>
        <td>Timestamp</td>
        <td>-</td>
    </tr>
    <tr>
        <td>ACTIVE</td>
        <td>Marks the active character/conversation</td>
        <td>TINYINT</td>
        <td>Foreign key on CHARACTER.ID</td>
    </tr>
</table>

### forevercache
This table stores entries that should be cached, but would be too much to keep in Redis 

<table>
    <tr>
        <td><b>Column name</b></td>
        <td><b>Purpose</b></td>
        <td><b>Type</b></td>
        <td><b>Index</b></td>
    </tr>
    <tr>
        <td>ID</td>
        <td>EVE ID</td>
        <td>Unsigned bigint</td>
        <td>Primary</td>
    </tr>
    <tr>
        <td>Name</td>
        <td>Human readable name</td>
        <td>Varchar (256)</td>
        <td>-</td>
    </tr>
    <tr>
        <td>created_at</td>
        <td>Laravel created at column</td>
        <td>Timestamp</td>
        <td>-</td>
    </tr>
</table>

### charsettings
This table stores eve character related settings, like home location and emergency contact
<table>
    <tr>
        <td><b>Column name</b></td>
        <td><b>Purpose</b></td>
        <td><b>Type</b></td>
        <td><b>Index</b></td>
    </tr>
    <tr>
        <td>CHAR_ID</td>
        <td>EVE ID</td>
        <td>Unsigned bigint</td>
        <td>Composite: CHAR_ID+PARAM</td>
    </tr>
    <tr>
        <td>PARAM</td>
        <td>Key name</td>
        <td>Varchar (32)</td>
        <td>Composite: CHAR_ID+PARAM</td>
    </tr>
    <tr>
        <td>VALUE</td>
        <td>Setting value</td>
        <td>Varchar(512)</td>
        <td>-</td>
    </tr>
    <tr>
        <td>CREATED_AT</td>
        <td>Laravel created at column</td>
        <td>Timestamp</td>
        <td>-</td>
    </tr>
</table>

### route_checks
This table contains the active number of route checks

<table>
    <tr>
        <td><b>Column name</b></td>
        <td><b>Purpose</b></td>
        <td><b>Type</b></td>
        <td><b>Index</b></td>
    </tr>
    <tr>
        <td>CHAT_TYPE</td>
        <td>Chat type. Needed for where to contact the capsuleer.</td>
        <td>enum: fb-messenger, telegram</td>
        <td>-</td>
    </tr>
    <tr>
        <td>CHAT_ID</td>
        <td>CHAT ID</td>
        <td>string</td>
        <td>-</td>
    </tr>
    <tr>
        <td>CHAR_ID</td>
        <td>EVE Character ID</td>
        <td>bigInteger</td>
        <td>Primary</td>
    </tr>
    <tr>
        <td>TARGET_SYS_ID</td>
        <td>the target solar system</td>
        <td>bigInteger</td>
        <td>-</td>
    </tr>
    <tr>
        <td>created_at</td>
        <td>Time where the request was recorded</td>
        <td>timestamp</td>
        <td>-</td>
    </tr>
    <tr>
        <td>expires_at</td>
        <td>Time when the co-pilot stops checking the location. </td>
        <td>timestamp</td>
        <td>-</td>
    </tr>
</table>


## Cache scheme
- Eve ESI access tokens (each valid for 20m) are cached.
- Ongoing chats "session" variables are also cached 

## Wishes, bugs, contact

You can talk to me on Twitter (@veetor_in_eve) or open an issue here. If you find a security vulnerability please don't use the issue tracker but send me a mail at veetor@outlook.com.