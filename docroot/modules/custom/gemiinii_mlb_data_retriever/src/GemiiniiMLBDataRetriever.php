<?php

namespace Drupal\gemiinii_mlb_data_retriever;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class GemiiniiMLBDataRetriever {
    //http://lookup-service-prod.mlb.com
    //$config = \Drupal::config('gemiinii_mlb_data_retriever.settings');

    public function get_player_number($id) {
        $config = \Drupal::config('gemiinii_mlb_data_retriever.settings');
        $api_url = $config->get('mlb_endpoint') . '/' . $config->get('player_lookup') . $id;
        $api_url = 'https://jsonplaceholder.typicode.com/todos/1';
        $client = \Drupal::httpClient();
        $output = $api_url;
        try {
        $res = $client->request($api_url);
        \Drupal::logger('gemiinii_mlb')->notice(print_r($res, TRUE));
        //$output .= $res->getHeader('content-type')[0];
            //$output = $res->getStatusCode();
        $output .= (string)$res->getBody();
        \Drupal::logger('gemiinii_mlb')->notice(print_r($res->getBody(), TRUE));
            //$output = json_decode($res->getBody(), true);
        }
        catch (Exception $e) {
            $output .= $e->getMessage();
        }
        return $output;
    }

}