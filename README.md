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

Please take note of the 2 critical data points needed for issuing us play status

- `lucit_layout_digital_board_id` - The Lucit internal board id number that maps to your display\
- `creative_id` the encoded creative id number for this specific image

```php

Array
(
    [location_id] => SC_MH_2
    [location_name] => 1414 S. Holloway St.
    [lucit_layout_digital_board_id] => 19303
    [item_count] => 6
    [item_total_weight] => 60
    [item_selected_index] => 5
    [items] => Array
        (
            [0] => Array
                (
                    [creative_id] => C1-4C9D-LP-4PcU
                    [creative_datetime] => 2020-07-21T19:15:06+00:00
                    [id] => 51798
                    [object_class] => InventoryPhoto
                    [name] => 16914A 2012 Dodge Durango
                    [slug] => 16914a_2012_dodge_durango
                    [src] => ttps://theimagehost.home/the/path/1/318/img_5f13398aad2d4_d755bcb77855ce7ef665.png
                    [width] => 1856
                    [height] => 576
                    [weight] => 10
                    [weight_pct] => 0.16666667
                )

        )

)


```


#### How to send playback statistics

```php

use \Lucit\LucitDrive;


$LUCIT_DRIVE_URI = "https://layout.lucit.cc/api/v1/":
$LUCIT_DRIVE_TOKEN = "***";
$DATE_UTC_ISO8601 = "2020-06-28T18:42:26Z"; //UTC TIME
$PLAY_DURATION_SECONDS = 8;

$CREATIVE_ID = GetTheCreativeIdFromLastPullResponse();      //This might be like `C1-4C94-IP-4Cu4`   `creative_id`
$DIGITAL_BOARD_ID = GetTheDigitalBoardIdIdFromLastPullResponse();      //This might be like `12345`  `lucit_layout_digital_board_id`

$ld = LucitDrive::Init( $LUCIT_DRIVE_URI,  $LUCIT_DRIVE_TOKEN );

$response = $ld->play( $CREATIVE_ID, $DIGITAL_BOARD_ID, $DATE_UTC_ISO8601, $PLAY_DURATION_SECONDS);


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
3.  Copy `examples/.env.sample.php` to `examples/.env.php`
4.  Update `.env.php` with the required settings
5.  Run the command `php examples/example-pull.php` and you should see valid output


