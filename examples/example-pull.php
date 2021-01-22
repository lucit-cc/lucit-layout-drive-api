<?php 
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

require_once '.env.php';

use Lucit\LucitDrive;

echo "URI : ".LUCIT_DRIVE_URI."\n";
echo "EXPORT : ".LUCIT_DRIVE_EXPORT_ID."\n";
echo "LOCATION : ".LUCIT_DRIVE_LOCATION_ID."\n";

$ld = LucitDrive::Init( LUCIT_DRIVE_URI, LUCIT_DRIVE_TOKEN );

echo "Fetching Item...\n";
echo "";

$response = $ld->getItem(LUCIT_DRIVE_EXPORT_ID,LUCIT_DRIVE_LOCATION_ID);

foreach( $response as $responseKey=>$responseValue)
{
    if( $responseKey !== "items" )
    {
        echo "   ".$responseKey." : \t\t".$responseValue."\n";
    }
}

$item = $response["items"][0];  //first item in set


foreach( $item as $itemKey=>$itemValue)
{   
    echo "   ".$itemKey." : \t\t".$itemValue."\n";
}


echo "\n\n";
echo "Testing Hash : \n";
echo "\n\n";
echo "You can perform this manually with the following command : \n";
echo "                  curl -s ".$item["src"]." | md5sum\n\n";
echo "\n\n";
echo "      Hash Is : ".$item["hash"]."\n";
echo "      Hash Algo Is : ".$item["hash_algo"]."\n";

$hashPasses = $ld->validateItemHash( $item );

if( $hashPasses )
{
    echo "Hash Matches Remote Image\n";
}
else
{
    echo "FAILED : Hash does not match Remote Image\n";

}


echo "\n\n";