<?php 
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

require_once '.env.php';

use Lucit\LucitDrive;

echo "URI ".LUCIT_DRIVE_URI."\n";
echo "EXPORT ".LUCIT_DRIVE_EXPORT_ID."\n";
echo "LOCATION ".LUCIT_DRIVE_LOCATION_ID."\n";

$ld = LucitDrive::Init( LUCIT_DRIVE_URI, LUCIT_DRIVE_TOKEN );

echo "Fetching Status\n";

$response = $ld->status();

print_r($response);
