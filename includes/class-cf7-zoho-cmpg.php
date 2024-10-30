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
 * @since      1.0.0
 * @package    CF7_Zoho_CMPG
 * @subpackage CF7_Zoho_CMPG/includes
 * @author     Nesho Sabakov <code@neshable.com>
 */
class CF7_Zoho_CMPG {


    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if ( defined( 'CF7_ZOHOCMP_EXT_VER' ) ) {
            $this->version = CF7_ZOHOCMP_EXT_VER;
        } else {
            $this->version = '1.0.0';
        }

        $this->plugin_name = 'cf7-zoho-campaign-extension';

    }

    public function run() {
        add_filter( 'wpcf7_editor_panels', array( $this, 'show_mch_metabox' ) );
        add_action( 'wpcf7_after_save', array( $this, 'cf7_zoho_cmpg_save_zoho' ) );
        add_filter( 'wpcf7_form_response_output', array( $this, 'cf7_zoho_cmpg_author_wpcf7' ), 40, 4 );
        add_action( 'wpcf7_before_send_mail', array( $this, 'cf7_zoho_cmpg_subscribe_remote' ) );
        add_filter( 'wpcf7_form_class_attr', array( $this, 'cf7_zoho_cmpg_class_attr' ) );
    }

    public function show_mch_metabox( $panels ) {

        $new_page = array(
            'Zoho-CMPG-Extension' => array(
                'title'    => __( 'Zoho Campaigns', 'contact-form-7' ),
                'callback' => array( $this, 'cf7_zoho_cmpg_add_zoho' ),
            ),
        );

        $panels = array_merge( $panels, $new_page );

        return $panels;

    }

    public function cf7_zoho_cmpg_save_zoho( $args ) {
        // $_post returns array Array ( [api] => 56666 [list] => 22 )
        if ( !empty( $_POST ) ) {
            // $args->id() returns the form ID - ex. 366
            update_option( CF7_ZOHOCMP_PREFIX . $args->id(), $_POST[ 'cf7_zoho_cmpg' ] );
        }

    }

    public function cf7_zoho_cmpg_author_wpcf7( $output, $class, $content, $args ) {

        return $output;

    }

    public function cf7_zoho_cmpg_class_attr( $class ) {

        // $class .= ' zoho-ext-' . SPARTAN_MCE_VERSION;
        return $class;

    }


    /**
     * Run on send form
     *
     * @param $obj WPCF7 native object
     */
    public function cf7_zoho_cmpg_subscribe_remote( $obj ) {
        // Init the API Class

        // Get form settings
        $cf7_zoho_cmpg = get_option( CF7_ZOHOCMP_PREFIX . $obj->id(), array() );


        // @todo create one more option for enable/disable zoho integration
        if ( $cf7_zoho_cmpg && isset( $cf7_zoho_cmpg[ 'api' ] ) ) {
            $submission_instance = WPCF7_Submission::get_instance();
            /**
             * Get instance of the posted data
             *
             * @return array with field names
             */
            $submission_data = $submission_instance->get_posted_data();

            $zoho_connection = new CF7_Zoho_CMPG_API( $cf7_zoho_cmpg[ 'api' ] );
            // @todo filter $submission_data to get variations of your-name and your-email
            $send_request = $zoho_connection->add_lists_subscriber( $submission_data[ 'your-name' ], $submission_data[ 'your-email' ], $cf7_zoho_cmpg[ 'list' ] );

            echo $zoho_connection::filter_based_on_code( $send_request );

        }

    }

    public function cf7_zoho_cmpg_add_zoho( $args ) {

        require_once plugin_dir_path( __FILE__ ) . 'views/admin-settings.php';

    }


    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }


    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
