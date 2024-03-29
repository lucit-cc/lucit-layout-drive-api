<?php
namespace Lucit;

use GuzzleHttp\Client;

class LucitDrive {

    protected $uri = null;
    protected $token = null;
    protected $options = null;

    protected $timeout = 2.0;

    /**
     * $uri - Uri to the api endpoint
     * $token - Your api token
     * $options = []
     */
    public static function Init( string $uri, string $token, array $options = [] ) : LucitDrive
    {
        $ld = new LucitDrive();
        $ld->setUri( $uri );
        $ld->setToken( $token );
        $ld->setOptions( $options );

        return $ld;
    }

    public function setUri( string $uri )
    {
        $this->uri = $uri;
    }
    
    public function setToken( string $token )
    {
        $this->token = $token;
    }
    
    public function setOptions( array $options )
    {
        $this->options = $options;

        $this->timeout = $this->options["timeout"] ?? $this->timeout;
    }

    /**
     * $id is the export id in string lch-id format
     * $option is array of options
     *  - location_id specify a digital display id
     *  - show_all - Show all creatives (items) and do not randomly select one
     * 
     */
    public function pull( string $id, array $options = [] )
    {
        $client = new Client([
            'base_uri' => $this->uri,
            'timeout'  => $this->timeout,
        ]);

        $url = 'inventory-exports/'.$id.'/pull?api_token='.$this->token;

        $location_id = $options["location_id"] ?? "";
        $show_all = $options["show_all"] ?? "";

        if( $location_id )
            $url.="&location_id=".$location_id;
        
        if( $show_all )
            $url.="&show_all=".$show_all;

        $response = $client->request('GET', $url );

        $data = json_decode($response->getBody(),true);

        return $data;

    }

    /**
     * $id is the export id in string lch-id format
     * $locationId is the digital display id that you are fetching for
     * 
     */

    public function getItem( string $id, string $locationId )
    {
        $result = $this->pull($id,[
            "location_id" => $locationId
        ]);

        if( !$result 
            || !isset($result["lucit_layout_drive"]) 
            || !isset($result["lucit_layout_drive"]["item_sets"])
            || !isset($result["lucit_layout_drive"]["item_sets"][0])
            || !isset($result["lucit_layout_drive"]["item_sets"][0]["items"])
            || !isset($result["lucit_layout_drive"]["item_sets"][0]["items"][0])
            )
            return false;

        return $result["lucit_layout_drive"]["item_sets"][0];
    }

    public function validateItemHash( array $item ) : bool
    {
        $hash = $item["hash"];
        $hash_algo = $item["hash_algo"];

        if( $hash_algo !== "md5" )
        {
            throw new \Exception("hash_algo ".$hash_algo." is not supported by this library");
        }

        $contents = file_get_contents($item["src"] );

        if( !$contents )
        {
            throw new \Exception("Unable to retrieve ".$item["src"]." with file_get_contents");
        }

        if( md5($contents) === $hash )
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    
    /**
     * $creativeId is the creative_id
     * $digitalBoardId is the lucit_layout_digital_board_id that the creative ran on
     * $playDateTime is the play date time from your system in UTC format
     * $duration is the duration in seconds that the item was displayed for
     */
    public function play( string $creativeId, int $digitalBoardId, string $playDateTime, int $duration )
    {
        $client = new Client([
            'base_uri' => $this->uri,
            'timeout'  => $this->timeout,
        ]);

        $url = 'analytics/track/lucit-drive-play?api_token='.$this->token;
        $url.="&creative_id=".$creativeId;
        $url.="&lucit_layout_digital_board_id=".$digitalBoardId;
        $url.="&play_datetime=".$playDateTime;
        $url.="&duration=".$duration;

        $response = $client->request('GET', $url);

        $data = json_decode($response->getBody(),true);

        return $data;

    }
    
    /**
     * This will return true if we can reach the API
     */
    public function status()
    {
        $client = new Client([
            'base_uri' => $this->uri,
            'timeout'  => $this->timeout,
        ]);

        $url = 'status?api_token='.$this->token;
        
        $response = $client->request('GET', $url);

        $data = json_decode($response->getBody(),true);

        return $data;

    }


    


}