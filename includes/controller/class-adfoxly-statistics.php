<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://adfoxly.com/
 * @since      1.0.0
 *
 * @package    Adfoxly
 * @subpackage Adfoxly/includes/controller
 */

class AdfoxlyStatisticsController {

	/**
	 * @var
	 */
	private $status;
	/**
	 * @var mixed
	 */
	private $settings;
	/**
	 * @var \StatisticsModel
	 */
	private $model;


	/**
	 * @var
	 */
	public $visitor;

	/**
	 * StatisticsController constructor.
	 */
	public function __construct() {
		$this->settings = get_option( 'adfoxly_settings' );
		if ( isset( $this->settings[ 'statistics-status' ] ) && ! empty( $this->settings[ 'statistics-status' ] ) ) {
			$this->setStatus( $this->settings[ 'statistics-status' ] );
		}
		$this->model = new AdfoxlyStatisticsModel();
	}

	/**
	 *
	 */
	public function setVisitor() {
		$this->visitor    = $this->getIpLocationJSON();
	}

	/**
	 * @return mixed
	 */
	public function getIpLocationJSON() {
		return json_decode( $this->getIpLocation() );
	}

	/**
	 * @return bool|mixed
	 */
	public function getIpLocation() {
		$ip          = Adfoxly::ip();

		if ( $ip === '::1' || $ip === '::' ) {
			$ip = '104.27.178.42';
		}
		$ipApi = wp_remote_get( 'http://ip-api.com/json/' . $ip . '?fields=status,message,country,countryCode,region,regionName,city,zip,timezone' );

		if ( isset( $ipApi ) && is_array( $ipApi ) && ( ! empty( $ipApi ) ) && isset( $ipApi[ 'body' ] ) && ! empty( $ipApi[ 'body' ] ) ) {
			return $ipApi[ 'body' ];
		}

		return false;
	}

	/**
	 * @param $status
	 */
	public function setStatus( $status ) {
		$this->status = $status;
	}

	/**
	 *
	 */
	public function insertTables() {
		$this->model->insertTables();
	}

	/**
	 * @return string
	 */
	public function getFingerPrint() {
		$ip          = Adfoxly::ip();

		if ( isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) && ! empty( $_SERVER[ 'HTTP_USER_AGENT' ] ) ) {
			$browser     = $_SERVER[ 'HTTP_USER_AGENT' ];
		} else {
			$browser     = 'NULL';
		}

		if ( isset( $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] ) && ! empty( $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] ) ) {
			$language    = $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ];
		} else {
			$language    = 'NULL';
		}

		$fingerprint = "$ip + $browser + $language";

		return md5( $fingerprint );
	}

	/**
	 * @param $id
	 */
	public function saveView( $id ) {
		$this->model->saveView( $id, $this->getFingerPrint() );
	}

    public function saveSingleAdView( $id ) {
        if( adfoxly_wa_fs()->can_use_premium_code__premium_only() ) {
            $this->model->saveSingleAdView($id, $this->getFingerPrint());
        }
    }

	/**
	 * @param null $id
	 *
	 * @return mixed
	 */
	public function render( $id = null ) {

		if ( $this->status === 'enabled' ) {

			if ( $this->settings[ 'statistics-type' ] === 'google-analytics' ) {

				if ( ! empty( $this->settings ) ) {
					if ( ! empty( $this->settings[ 'statistics-gaid-select' ] ) ) {
						$gaid = $this->settings[ 'statistics-gaid-select' ];
					} else if ( ! empty( $this->settings[ 'adfoxly-statistics-custom-gaid' ] ) ) {
						$gaid = $this->settings[ 'adfoxly-statistics-custom-gaid' ];
					}
				}

				if ( isset( $gaid ) && ! empty( $gaid ) ) {

					add_action( 'wp_footer', function() use( $id, $gaid )
					{
						$render = '<script type="text/javascript">';

						// isVisible
//						$render .= 'function isVisible($obj) {';
//						$render .= 'var top       = jQuery(window).scrollTop();';
//						$render .= 'var bottom    = top + jQuery(window).height();';
//						$render .= 'var objTop    = $obj.offset().top;';
//						$render .= 'var objBottom = objTop + $obj.height();';
//						$render .= 'if (objTop < bottom && objBottom > top) {';
//
//						// sending events
//						$render .= 'var activeAd = jQuery("#adfoxly-adzone-' . $id . '").find(".active").attr("data-adfoxly-banner-id");';
//						$render .= 'ga("send", "event", "adfoxly", "adzone_view", "' . $id . '");';
//						$render .= 'ga("send", "event", "adfoxly", "ad_view", activeAd);';
//
//						$render .= '}';
//						$render .= '};';
//
//						// ga settings
//						$render .= 'if (typeof ga !== "function") {';
//						$render .= 'window["GoogleAnalyticsObject"] = "ga";';
//						$render .= 'window["GoogleAnalyticsObject"] = "ga";';
//						$render .= 'window["ga"]                    = window["ga"] || function () {';
//						$render .= '(window["ga"].q = window["ga"].q || []).push(arguments)';
//						$render .= '};};';
//
//						// tracker ga
//						$render .= 'var isTracker = false;';
//						$render .= 'ga(function (tracker) {';
//						$render .= 'if (typeof tracker === "undefined") {';
//						$render .= 'ga("create", "' . $gaid . '", "auto");';
//						$render .= '};';
//
//						$render .= 'setInterval(function () {';
//						$render .= 'isVisible(jQuery("#adfoxly-adzone-' . $id . '"));';
//						$render .= '}, 1000);';
//
//						$render .= 'jQuery(".adfoxly-wrapper").click(function (e) {';
//						$render .= 'var $href = jQuery(this).find("a").attr("data-target");';
//						$render .= 'var $ad = jQuery(this).find("a").attr("data-adfoxly-banner-id");';
//						$render .= 'ga("send", "event", "adfoxly", "ad_click", $ad);';
//						$render .= 'ga("send", "pageview", $href);';
//						$render .= '});';
//
//
//						$render .= '});';
						$render .= '</script>';

						echo $render;

					} );
				}

			} else if ( $this->settings[ 'statistics-type' ] === 'piwik' ) {


				add_action( 'wp_footer', function() use( $id )
				{
					$render = '<script type="text/javascript">';

					// isVisible
//					$render .= 'function isVisible($obj) {';
//					$render .= 'var top       = jQuery(window).scrollTop();';
//					$render .= 'var bottom    = top + jQuery(window).height();';
//					$render .= 'var objTop    = $obj.offset().top;';
//					$render .= 'var objBottom = objTop + $obj.height();';
//					$render .= 'if (objTop < bottom && objBottom > top) {';
//
//					// sending events
//					$render .= 'var activeAd = jQuery("#adfoxly-adzone-' . $id . '").find(".active").attr("data-adfoxly-banner-id");';
//					$render .= '_paq.push(["trackEvent", "adfoxly", "adzone_view", "' . $id . '"]);';
//					$render .= '_paq.push(["trackEvent", "adfoxly", "ad_view", activeAd]);';
//
//					$render .= '}';
//					$render .= '};';
//
//					$render .= 'setInterval(function () {';
//					$render .= 'isVisible(jQuery("#adfoxly-adzone-' . $id . '"));';
//					$render .= '}, 1000);';
//
//					$render .= 'jQuery(".adfoxly-wrapper").click(function (e) {';
//					$render .= 'var $href = jQuery(this).find("a").attr("data-target");';
//					$render .= 'var $ad = jQuery(this).find("a").attr("data-adfoxly-banner-id");';
//					$render .= '_paq.push(["trackEvent", "adfoxly", "ad_click", $ad]);';
//					$render .= '_paq.push(["trackPageView"]);';

//				$render .= '_paq.push(["trackEvent", "adfoxly", "ad_click", $ad]);';
//				$render .= 'ga("send", "event", "adfoxly", "ad_click", $ad);';
//				$render .= 'ga("send", "pageview", $href);';
//					$render .= '});';


//				$render .= '});';
					$render .= '</script>';

					return $render;
				} );

			} else {

				add_action( 'wp_footer', function() use( $id )
				{
					$render = '<script type="text/javascript">';
//					$render .= 'function isVisible( id, $obj ) {var top = jQuery(window).scrollTop();var bottom = top + jQuery(window).height();var objTop = $obj.offset().top;var objBottom = objTop + $obj.height();if(objTop < bottom && objBottom > top) {';
//					$render .= 'saveViews(id)';
//					$render .= '}};';
//					$render .= 'setInterval(function () {';
//					$render .= 'isVisible(' . $id . ', jQuery("#adfoxly-adzone-' . $id . '"));';
//					$render .= '}, 1000);';
//					$render .= 'jQuery(".adfoxly-wrapper").click(function (e) {';
//					$render .= 'var $bannerId = jQuery(this).find("a").attr("data-adfoxly-banner-id");';
//				$render .= 'adfoxly("send", "click", $bannerId);';
//					$render .= '});';
					$render .= '</script>';

					echo $render;
				} );

			}

			if ( ! empty( $render ) ) {
				return $render;
			}
		}
	}
}

