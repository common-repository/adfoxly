<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://adfoxly.com/
 * @since      1.0.0
 *
 * @package    Adfoxly
 * @subpackage Adfoxly/admin/partials
 */

$settings = get_option( 'adfoxly_settings' );
//echo '<div id="app">';
//    echo '<section class="section">';
//		if ( isset( $settings[ 'adfoxly-navbar' ] ) && ! empty( $settings[ 'adfoxly-navbar' ] ) && $settings[ 'adfoxly-navbar' ] === 'true' ) {
			$navbar = new AdfoxlyAdminNavbarController();
			$navbar->render();
//		}
//	echo '</section>';
//echo '<div>';

if ( ! function_exists( 'plugins_api' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
}

function verifyPopupCookie() {
	$banners         = new AdfoxlyBannerModel();
	if (
		(
			! isset( $_GET[ 'view' ] )
			|| empty( $_GET[ 'view' ] )
			|| $_GET[ 'view' ] !== 'first'
		)
		&& (
			( ! isset( $_COOKIE[ "adfoxly_first_open" ] ) || $_COOKIE[ "adfoxly_first_open" ] !== 'true')
			&& ( $banners->countAds() === 0 )
		)
	) {
		$redirect = admin_url( 'admin.php?page=adfoxly&view=first' );
		echo '<script>window.location.href = "' . $redirect . '";</script>';
	}
}

verifyPopupCookie();

function adfoxly_dashboard_faq() { ?>

<div class="card-header">
	<h4><?php _e("FAQ", "adfoxly") ?></h4>
</div>
<div class="card-body">
    <div id="accordion">
		<div class="accordion">
			<div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
			  <h4>How to start with AdFoxly?</h4>
			</div>
			<div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
			  <p class="mb-0">Start with adding a new ad. You don’t have to configure a campaign or a place. First, upload a banner or a Google AdSense code. Then choose a place to show the ad. Simple as that.</p>
			</div>
		</div>
		<div class="accordion">
			<div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-2">
			  <h4>Ad - what is it?</h4>
			</div>
			<div class="accordion-body collapse" id="panel-body-2" data-parent="#accordion">
			  <p class="mb-0">An ad is a banner, Google AdSense ad, or a custom HTML ad</p>
			</div>
		</div>
		<div class="accordion">
			<div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-3">
			  <h4>Campaign - what is it?</h4>
			</div>
			<div class="accordion-body collapse" id="panel-body-3" data-parent="#accordion">
			  <p class="mb-0">The Campaign is a set of options to group your ads. The Campaign lets you configure max ad views or clicks, also start and end dates. PRO version enables you to limit the Campaign to defined countries or set specific weekdays and time of the day. Also, you can set max views for one user per ad.</p>
			</div>
		</div>
		<div class="accordion">
			<div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-4" aria-expanded="false">
				<h4>Campaign - do I need to use it?</h4>
			</div>
			<div class="accordion-body collapse" id="panel-body-4" data-parent="#accordion" style="">
				<p class="mb-0">No. It’s just a way to group a few banners into some project. You can use campaigns while working with your advertisement partners.</p>
			</div>
		</div>
		<div class="accordion">
			<div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-5" aria-expanded="false">
				<h4>Place - what is it?</h4>
			</div>
			<div class="accordion-body collapse" id="panel-body-5" data-parent="#accordion" style="">
				<p class="mb-0">Place lets you configure ads behavior for different places of your ads (such as Before or After Post). You set places to rotate ads: on a page refresh or after some time without refreshing a page (e.g. 10 seconds). </p>
			</div>
		</div>
		<div class="accordion">
			<div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-6" aria-expanded="false">
				<h4>Places - do I need to configure them?</h4>
			</div>
			<div class="accordion-body collapse" id="panel-body-6" data-parent="#accordion" style="">
				<p class="mb-0">No. You can use places without configuring them. While configuring a new ad, simply choose a place or places in which you want your ads to be displayed.</p>
			</div>
		</div>
	    <div class="accordion">
		    <div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-10" aria-expanded="false">
			    <h4>AdSense - how to earn money?</h4>
		    </div>
		    <div class="accordion-body collapse" id="panel-body-10" data-parent="#accordion" style="">
			    <p class="mb-0">You need to sign up for an AdSense account. Once you configure it, you can paste your code to a new ad in AdFoxly.</p>
		    </div>
	    </div>
	    <div class="accordion">
		    <div class="accordion-header collapsed" role="button" data-toggle="collapse" data-target="#panel-body-11" aria-expanded="false">
			    <h4>AdSense Ad displays in wrong place?</h4>
		    </div>
		    <div class="accordion-body collapse" id="panel-body-11" data-parent="#accordion" style="">
			    <p class="mb-0">Check how generate AdSense code properly. First you need to remember to DO NOT choose a "Auto Ads", but create a own Ad Unit. Look at the image below. <br/><img src="<?php echo plugins_url( 'img/adunits.png', dirname( dirname( __FILE__ ) ) ); ?>" alt="AdSense Configuration" style="max-width: 100%"/></p>
		    </div>
	    </div>
    </div>
</div>

<?php } ?>

<div class="content-wrapper">
	<div class="row">
		<div class="col-12">
			<div class="adfoxly-notices-wrapper"></div>
		</div>
	</div>

    <?php if ( isset( $_GET ) && isset( $_GET[ 'subpage' ] ) && ! empty( $_GET[ 'subpage' ] ) && $_GET['subpage'] === 'faq' ): ?>

    <?php else: ?>
        <?php if ( isset( $_GET ) && isset( $_GET[ 'view' ] ) && ! empty( $_GET[ 'view' ] ) && $_GET['view'] === 'first' ): ?>

            <!-- Modal -->
            <div class="modal fade" id="blockerInfo" tabindex="-1" role="dialog" aria-labelledby="blockerInfo" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"><?php _e('Oh snap! Ad blocking software detected.', 'adfoxly') ?></h5>
                        </div>
                        <div class="modal-body">
                            <?php _e('AdFoxly is that kind of software, which don\'t like with ad blockers. Please disable all ad blockers, because your user experience may be degraded, which may affect the performance of the plugin. Thanks!', 'adfoxly') ?>
                        </div>
                        <div class="modal-footer bg-whitesmoke">
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><?php _e('I understand', 'adfoxly') ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="bootstrap4-card">
                        <div class="card-header">
                            <h4><?php _e('We\'re excited that you are adding your first ad!', 'adfoxly') ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="clearfix">
                                <div class="float-left" style="width: 100px;">
                                    <img src="<?php echo plugins_url( 'img/developer.jpg', dirname( dirname( __FILE__ ) ) ); ?>" alt="Rafał Osiński - AdFoxly Founder and Developer" style="border-radius: 50%; max-width: 100%">
                                </div>
                                <div class="float-right" style="width: calc(100% - 120px);">
                                    <?php _e('Hello, I am Rafał, AdFoxly Founder and Developer.', 'adfoxly') ?><br><br>
                                    <?php _e('I want to say few words. First of all I want to thank you, for choosing AdFoxly. Our mission is to create the easiest WordPress Ads Manager Plugin. In next step you will see our wizard. Please click below on the button and create your first advertisement on your website.', 'adfoxly') ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="<?php echo admin_url( 'admin.php?page=adfoxly-new' ) ?>" class="btn btn-primary" data-set-cookie="first_open">
                                <i class="fas fa-plus-square"></i> <?php _e( 'Create first advert', 'adfoxly' ) ?>
                            </a>
                        </div>
                    </div>

                    <div class="bootstrap4-card">
                        <div class="card-header">
                            <h4><?php _e('Look on video how to add your first advert', 'adfoxly') ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="summary">
                                <style>
                                    .video-container {
                                        position: relative;
                                        padding-bottom: 56.25%;
                                    }

                                    .video-container iframe {
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        width: 100%;
                                        height: 100%;
                                    }
                                </style>
                                <div class="video-container">
                                    <iframe src="https://www.youtube.com/embed/b4UoqW5iLcE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>

            <?php if ( ! adfoxly_wa_fs()->is__premium_only() ): ?>
                <div class="row">
                    <div class="col-lg-6 grid-margin stretch-card">
                        <div class="bootstrap4-card height-minus30">
                            <?php adfoxly_dashboard_faq() ?>
                        </div>
                    </div>
                    <div class="col-lg-6 grid-margin stretch-card">
                        <div class="bootstrap4-card card-statistics bg-green-gradient height-minus30">
                            <div class="card-body">
                                <div>
                                    <img src="<?php echo plugins_url( 'img/wizard.gif', dirname( dirname( __FILE__ ) ) ); ?>" alt="Wizard Tutorial" style="max-width: 100%; margin-top: 20px;" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">

                    <?php

                    if ( isset( $_GET[ 'stats-last-days' ] ) && is_numeric( $_GET[ 'stats-last-days' ] ) ) {
                        $chartDays = $_GET[ 'stats-last-days' ];
                        if ( $chartDays < 2 ) {
                            $chartDays = 2;
                        }
                    } else {
                        $chartDays = 14;
                    }

                    $statisticsModel = new AdfoxlyStatisticsModel();
                    $views      = $statisticsModel->getViewsPerDayArray( $chartDays );
                    $clicks     = $statisticsModel->getClicksPerDayArray( $chartDays );

                    $points       = '';
                    $labels       = '';
                    $labelsClicks = '';
                    $pointsClicks = '';

                    foreach ( $views as $key => $value ) {
                        $labels .= $key . ',';
                        $points .= $value . ',';
                    }

                    foreach ( $clicks as $key => $value ) {
                        $labelsClicks .= $key . ',';
                        $pointsClicks .= $value . ',';
                    }

                    $labels       = substr( $labels, 0, - 1 );
                    $points       = substr( $points, 0, - 1 );
                    $labelsClicks = substr( $labelsClicks, 0, - 1 );
                    $pointsClicks = substr( $pointsClicks, 0, - 1 );
                    $max          = max( $views );
                    $maxClicks    = max( $clicks );
                    ?>

                    <div class="bootstrap4-card">
                        <div class="card-header">
                            <h4><?php _e('Ads Statistics', 'adfoxly') ?></h4>
                            <!--					<div class="card-header-action">-->
                            <!--						<a href="#summary-chart" data-tab="summary-tab" class="btn active">Chart</a>-->
                            <!--						<a href="#summary-text" data-tab="summary-tab" class="btn">Text</a>-->
                            <!--					</div>-->
                        </div>
                        <div class="card-body">
                            <div class="summary">
                                <div class="summary-info" data-tab-group="summary-tab" id="summary-text">
                                    <h4>$1,858</h4>
                                    <div class="text-muted">Sold 4 items on 2 customers</div>
                                    <div class="d-block mt-2">
                                        <a href="#">View All</a>
                                    </div>
                                </div>
                                <div class="summary-chart active" data-tab-group="summary-tab" id="summary-chart">
                                    <div class="chartjs-size-monitor"
                                         style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                        <div class="chartjs-size-monitor-expand"
                                             style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                            <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink"
                                             style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                            <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                        </div>
                                    </div>
                                    <canvas id="dashboard-area-chart" height="80" width="471" class="chartjs-render-monitor" data-max="<?php echo $max ?>" data-labels="<?php echo $labels ?>" data-clicks="<?php echo $pointsClicks ?>"
                                            data-views="<?php echo $points ?>" style="display: block; width: 471px; height: 282px;"></canvas>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 grid-margin stretch-card">
                    <div class="bootstrap4-card">
                        <div class="card-header">
                            <h4><?php _e('System Status', 'adfoxly') ?></h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>PHP Version</td>
                                    <td><?php echo phpversion() ?></td>
                                    <td>
                                        <?php
                                        if ( phpversion() >= '7.1' ) {
                                            $class = 'success';
                                            $label = 'OK';
                                        } else {
                                            $class = 'warning';
                                            $label = 'UPDATE';
                                        }
                                        ?>
                                        <label class="badge badge-<?php echo $class ?>"><?php echo $label ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                    global $wp_version;
                                    if ( version_compare( $wp_version, '4.9.8', '>=' ) ) {
                                        $class = 'success';
                                        $label = 'OK';
                                    } else {
                                        $class = 'warning';
                                        $label = 'UPDATE';
                                    }
                                    ?>
                                    <td>WordPress Version</td>
                                    <td><?php echo $wp_version ?></td>
                                    <td>
                                        <label class="badge badge-<?php echo $class ?>"><?php echo $label ?></label>
                                    </td>
                                </tr>

                                <?php
                                $server_request_uri = $_SERVER[ 'HTTP_HOST' ];
                                if ( strpos( $server_request_uri, '.local' ) === false && strpos( $server_request_uri, '.dev' ) === false && strpos( $server_request_uri, 'localhost' ) === false ) {
                                    $args     = array(
                                        'slug'   => 'adfoxly',
                                        'fields' => array(
                                            'version' => true,
                                        )
                                    );
                                    $call_api = plugins_api( 'plugin_information', $args );
                                    if ( is_wp_error( $call_api ) ) {
                                        $api_error = $call_api->get_error_message();
                                    } else {
                                        if ( ! empty( $call_api->version ) ) {
                                            $adfoxly_latest_version = $call_api->version;
                                        }
                                    }
                                }
                                if ( isset( $adfoxly_latest_version ) ) {
                                    if ( ADFOXLY_VERSION >= $adfoxly_latest_version ) {
                                        $class = 'success';
                                        $label = 'OK';
                                    } else {
                                        $class = 'warning';
                                        $label = 'UPDATE';
                                    }

                                    ?>
                                    <tr>
                                        <td>Plugin Version</td>
                                        <td><?php echo $adfoxly_latest_version ?></td>
                                        <td>
                                            <label class="badge badge-<?php echo $class ?>"><?php echo $label ?></label>
                                        </td>
                                    </tr>

                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php if ( adfoxly_wa_fs()->is__premium_only() ): ?>
                    <div class="col-lg-6 grid-margin stretch-card">
                        <div class="bootstrap4-card">
                            <?php adfoxly_dashboard_faq() ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-lg-6 grid-margin stretch-card">
                        <div class="bootstrap4-card">
                            <div class="card-header">
                                <h4 class="card-title">Advertisement</h4>
                            </div>
                            <div class="card-body">
                                <a target="_blank" href="https://shareasale.com/r.cfm?b=680030&amp;u=1927069&amp;m=41388&amp;urllink=&amp;afftrack="
                                   style="display: block; text-align: left; float: left; max-width: 50%; padding: 5px;"><img
                                            src="<?php echo plugins_url( 'assets/images/700x500-300dpi-3.jpg', dirname( dirname( dirname( __FILE__ ) ) ) ) ?>" border="0" alt="WP Engine hosting"
                                            style="max-width: 100%; max-height: 300px;"/></a>
                                <a target="_blank" href="http://www.infolinks.com/join-us?aid=3248738" style="display: block; text-align: right; float: right; max-width: 50%; height: 100%; padding: 5px;"><img src="<?php echo plugins_url( 'assets/images/300X250.jpg', dirname( dirname( dirname( __FILE__ ) ) ) ) ?>" border="0" alt="InfoLinks"
                                                                                                                                                                                                                 style="max-width: 100%; max-height: 300px;"/></a>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        <?php endif; ?>
    <?php endif; ?>


</div>
