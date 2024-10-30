<?php

// Prepopulate CF7 options
$cf7_zoho_cmpg = get_option( CF7_ZOHOCMP_PREFIX . $args->id(), array() );

// Get zoho lists
if ( isset( $cf7_zoho_cmpg[ 'api' ] ) ) {
    // Get instance of zoho api
    $zoho_connection = new CF7_Zoho_CMPG_API( $cf7_zoho_cmpg[ 'api' ] );
    // Get the lists
    $zoho_lists = $zoho_connection->get_mailing_lists();
}


?>

<h2>Zoho Extension</h2>

<p>Zoho campaigns extension for integrating zoho's email marketing software</p>

<p>
    <small style="color: darkgreen; font-style: italic;">Instructions: Please use [your-name] and [your-email] tags
    for your contact form. The current version of Zoho Campaigns extension relies on those in order to send proper api
    request. Once you fill in the correct API auth token, you should see the available list keys below the status.</small>
</p>

<div>

    <p class="mail-field">
        <label for="cf7_zoho_cmpg_list"><?php echo esc_html( __( 'Zoho List:', 'wpcf7' ) ); ?> </label><br/>
        <input type="text" id="cf7_zoho_cmpg_list" name="cf7_zoho_cmpg[list]" class="wide" size="70" placeholder=" "
               value="<?php echo ( isset( $cf7_zoho_cmpg[ 'list' ] ) ) ? esc_attr( $cf7_zoho_cmpg[ 'list' ] ) : ''; ?>"/>
        <small class="description"> Your Zoho list id</small>
    </p>


    <p class="mail-field">
        <label for="cf7_zoho_cmpg_api"><?php echo esc_html( __( 'Zoho API Key:', 'wpcf7' ) ); ?></label><br/>
        <input type="text" id="cf7_zoho_cmpg_api" name="cf7_zoho_cmpg[api]" class="wide" size="70" placeholder=" "
               value="<?php echo ( isset( $cf7_zoho_cmpg[ 'api' ] ) ) ? esc_attr( $cf7_zoho_cmpg[ 'api' ] ) : ''; ?>"/>
        <small class="description"> Zoho API key</small>
    </p>

    <?php if ( $zoho_lists && isset( $zoho_lists[ 'list_of_details' ] ) ) : ?>
    <p>
        <label for="cf7_zoho_cmpg_status"><?php echo esc_html( __( 'Account Status:', 'wpcf7' ) ); ?></label><br/>
        <small class="description" style="color: green;">Connected</small>
    </p>
        <p>
            <label><?php echo esc_html( __( 'Available Mailing Lists:', 'wpcf7' ) ); ?></label><br/>
            <?php foreach ( $zoho_lists[ 'list_of_details' ] as $list ) : ?>
                <small class="description" style="color: green;"><?php echo $list['listname'] . ' -> listkey: ' . $list['listkey']; ?></small><br/>
            <?php endforeach; ?>

        </p>
    <?php else : ?>
        <p>
            <label for="cf7_zoho_cmpg_status"><?php echo esc_html( __( 'Account Status:', 'wpcf7' ) ); ?></label><br/>
            <small class="description" style="color: red;">Not Connected </small>
        </p>
    <?php endif; ?>


</div>





