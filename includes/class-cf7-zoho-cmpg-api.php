<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0
 * @author     Nesho Sabakov <code@neshable.com>
 */
class CF7_Zoho_CMPG_API {
    private $methods = array();

    private $api_token;

    private $api_url = 'https://campaigns.zoho.com/api/';

    private $scope = 'CampaignsAPI';


    /**
     * CF7_Zoho_CMPG_API constructor.
     *
     * @param $api_token
     */
    public function __construct(  $api_token ) {

        $this->api_token = $api_token;

    }

    /**
     * Add subscriber to a list
     *
     * @param $email
     * @param $list_id
     *
     * @return array
     */
    public function add_lists_subscriber( $fname, $email, $list_id ) {
        $status = wp_remote_post( $this->generate_add_lists_subscriber_url( $fname, $email, $list_id ), array(
            'headers' => array("Content-type" => "application/json")
        ) );

        // Available elements - status, code, listname
        return json_decode( $status['body'], true );
    }

    /**
     * Get available mailing lists from Zoho
     *
     * @return array
     */
    public function get_mailing_lists() {
        $status = wp_remote_post(
            $this->api_url . 'getmailinglists?authtoken=' . $this->api_token . '&scope=' . $this->scope . '&resfmt=JSON'
        );

        // Available elements - status, code, list_of_details -> listname and listkey
        return json_decode( $status['body'], true );
    }

    /**
     * @param $email
     * @param $list_id
     *
     * @return string
     */
    public function generate_add_lists_subscriber_url( $fname = 'User', $email, $list_id ) {
        return $this->api_url . 'json/listsubscribe?authtoken=' . $this->api_token . '&scope=' . $this->scope . '&version=1&resfmt=JSON&listkey=' . $list_id . '&contactinfo={First Name:' . $fname . ',Contact Email:' . $email . '}&sources=WP';
    }

    public static function filter_based_on_code( array $response ) {
        if ( !$response ) return;

        if ( $response[ 'status' ] == 'success' || $response[ 'code' ] == '0' ) {
            return $response[ 'message' ];
        } else {
            return $response[ 'code' ] . ':' . $response[ 'message' ];
        }

    }


    public function get_status() {

    }
}