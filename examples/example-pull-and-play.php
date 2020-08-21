<?php 
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

require_once '.env.php';

use Lucit\LucitDrive;

echo "URI ".LUCIT_DRIVE_URI."\n";
echo "EXPORT ".LUCIT_DRIVE_EXPORT_ID."\n";
echo "LOCATION ".LUCIT_DRIVE_LOCATION_ID."\n";

$ld = LucitDrive::Init( LUCIT_DRIVE_URI, LUCIT_DRIVE_TOKEN );

echo "Fetching Item\n";

$response = $ld->getItem(LUCIT_DRIVE_EXPORT_ID,LUCIT_DRIVE_LOCATION_ID);

print_r($response);

$digitalBoardId = $response["lucit_layout_digital_board_id"];
$creativeId = $response["items"][0]["creative_id"];

$date = date('Y-m-d H:i:s', time() );
$duration = 8;

echo "Issuing Analytics Track Play for creative-id : ".$creativeId." on board id ".$digitalBoardId."\n";

$pingback = $ld->play( $creativeId, $digitalBoardId, $date, $duration);

print_r($pingback);