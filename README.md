This is a sample PHP Composer Package which contains a small library for making requests to the V1 Lucit Drive api for export pulls and pingbacks.

The full documentation for the Lucit Drive API is located at : https://lucit.cc/lucit-drive-api/

#### Installing this library
```
composer require lucit/lucit-layout-drive-api
````

#### What you will need to use this library
- The full URL to the Lucit V1 Api - Currently this is : `https://layout.lucit.cc/api/v1/`
- A V1 Api Token (you will be provided this by Lucit)
- An export id (you will be provided this by Lucit)
- A LOCATION_ID / Digital Display Id (This is your internal ID that our campaign is scheduled to run on)

#### How to fetch a creative

```php

use \Lucit\LucitDrive;

$LUCIT_DRIVE_URI = "https://layout.lucit.cc/api/v1/":
$LUCIT_DRIVE_TOKEN = "***";

$ld = LucitDrive::Init( $LUCIT_DRIVE_URI,  $LUCIT_DRIVE_TOKEN );

$response = $ld->getItem($EXPORT_ID,$LOCATION_ID);


```

The following is a sample response

```php
Array
(
    [creative_datetime] => 2020-07-18T18:03:54+00:00
    [id] => 12345
    [name] => 16926A 2017 Ford F-150
    [slug] => 16926a_2017_ford_f_150
    [src] => https://theimagehost.home/the/path/1/318/img_5f13398aad2d4_d755bcb77855ce7ef665.png
    [width] => 1856
    [height] => 576
    [weight] => 10
    [weight_pct] => 0.25
)


```


#### How to ping playback statistics

```php

use \Lucit\LucitDrive;


$LUCIT_DRIVE_URI = "https://layout.lucit.cc/api/v1/":
$LUCIT_DRIVE_TOKEN = "***";
$DIGITAL_DISPLAY_ID = "DISPLAY-LUC-1-NF";
$DATE_UTC_ISO8601 = "2020-06-28T18:42:26Z"; //UTC TIME
$PLAY_DURATION_SECONDS = 8;

$ITEM_ID = GetTheItemIdFromLastPullResponse();      //This might be like `12345`

$ld = LucitDrive::Init( $LUCIT_DRIVE_URI,  $LUCIT_DRIVE_TOKEN );

$response = $ld->pingback( $ITEM_ID, $DIGITAL_DISPLAY_ID, $DATE_UTC_ISO8601, $PLAY_DURATION_SECONDS);


```

If this is successful you will recieve an OK response

```php
Array
(
    [ok] => 1
)
```


#### Testing this composer library
If you wish to test using this library itself before including it in another application, or, just to use this library to test your provided credentials, export id, and display id

1.  Clone this repo to a local directory
2.  Run `composer install`
3.  Copy `tests/.env.sample.php` to `tests/.env`
4.  Update `.env` with the required settings
5.  Run the command `php tests/test.php` and you should see valid output


