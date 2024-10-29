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

class AdfoxlyStatisticsModel {

	private $db;

	public function __construct() {
		global $wpdb;

		$this->db[ 'views' ]  = $wpdb->prefix . "adfoxly_statistics_views";
		$this->db[ 'clicks' ] = $wpdb->prefix . "adfoxly_statistics_clicks";
        if( adfoxly_wa_fs()->can_use_premium_code__premium_only() ) {
            $this->db['ad_views'] = $wpdb->prefix . "adfoxly_statistics_ad_views";
        }
	}

	public function getBannerName( $id ) {

		$result = get_the_title( $id );

		return $result;
	}

	public function removeClicks( $id ) {

		global $wpdb;

		$sql = 'DELETE FROM `'. $this->db[ 'clicks' ] . '` WHERE `banner_id` = ' . $id . ';';

		try {
			$wpdb->query( $sql );

			return true;
		} catch (Exception $e) {
			return 'Error! '. $wpdb->last_error;
		}

	}

	public function removeViews( $id ) {

		global $wpdb;

		$sql = 'DELETE FROM `'. $this->db[ 'views' ] . '` WHERE `banner_id` = ' . $id . ';';

		try {
			$wpdb->query( $sql );

			return true;
		} catch (Exception $e) {
			return 'Error! '. $wpdb->last_error;
		}

	}

	public function saveView( $id, $fingerprint ) {
		global $wpdb;
		$wpdb->insert(
			$this->db[ 'views' ],
			array(
				'banner_id'   => $id,
				'fingerprint' => $fingerprint,
			)
		);
	}


    public function saveSingleAdView( $id, $fingerprint ) {
        if( adfoxly_wa_fs()->can_use_premium_code__premium_only() ) {
            global $wpdb;
            $wpdb->insert(
                $this->db['ad_views'],
                array(
                    'banner_id' => $id,
                    'fingerprint' => $fingerprint,
                )
            );
        }
	}

    public function getAdClicksByID( $id ) {
        global $wpdb;
        $dbStatisitcs = $wpdb->prefix . 'adfoxly_statistics' . '_clicks';

        $result = $wpdb->get_var( "SELECT count(id) FROM $dbStatisitcs WHERE banner_id = $id" );

        return $result;
    }

    public function getSingleAdViewByID( $id ) {
        global $wpdb;
        $dbStatisitcs = $wpdb->prefix . 'adfoxly_statistics' . '_ad_views';

        $result = $wpdb->get_var( "SELECT count(id) FROM $dbStatisitcs WHERE banner_id = $id" );

        return $result;
    }

	public function getPlaceViewsByID( $id ) {
		global $wpdb;
		$dbStatisitcs = $wpdb->prefix . 'adfoxly_statistics' . '_views';

		$result = $wpdb->get_var( "SELECT count(id) FROM $dbStatisitcs WHERE banner_id = $id" );

		return $result;
	}

	public function getClicksPerDay( $days = 7 ) {
		global $wpdb;
		$dbStatisitcs = $wpdb->prefix . 'adfoxly_statistics' . '_clicks';

		$today = date( 'Y-m-d H:i:s' );
		$date  = date_create( $today );

		$date = date_modify( $date, "-$days day" );
		$date = $date->format( 'Y-m-d' );

		$result = $wpdb->get_results( "SELECT DATE_FORMAT(`date`, '%Y-%m-%d') as date, count(id) as number FROM $dbStatisitcs WHERE `date` >= '$date' GROUP BY DAY(`date`) ORDER BY `date` ASC", OBJECT_K );

		return $result;
	}

	public function getViewsPerDay( $days = 7 ) {
		global $wpdb;
		$dbStatisitcs = $wpdb->prefix . 'adfoxly_statistics' . '_views';

		$today = date( 'Y-m-d H:i:s' );
		$date  = date_create( $today );

		$date = date_modify( $date, "-$days day" );
		$date = $date->format( 'Y-m-d' );

		$result = $wpdb->get_results( "SELECT DATE_FORMAT(`date`, '%Y-%m-%d') as date, count(id) as number FROM $dbStatisitcs WHERE `date` >= '$date' GROUP BY DAY(`date`) ORDER BY `date` ASC", OBJECT_K );

		return $result;
	}

	/**
	 * @param int $days
	 *
	 * @return null
	 */
	public function getClicksPerDayArray( $days = 7 ) {
		$model = new AdfoxlyStatisticsModel();

		$today     = date( 'Y-m-d H:i:s' );
		$todayDate = date_create( $today );
		$todayDate = date_modify( $todayDate, "-$days day" );

		$array = null;
		$views = $model->getClicksPerDay( $days );

		for ( $i = 0; $i < $days; $i ++ ) {

			$date = date_modify( $todayDate, "+1 day" );
			$date = $date->format( 'Y-m-d' );

			if ( isset( $views[ $date ] ) && ! empty( $views[ $date ] ) ) {
				$array[ $date ] = intval( $views[ $date ]->number );
			} else {
				$array[ $date ] = 0;
			}
		}

		return $array;
	}

	/**
	 * @param int $days
	 *
	 * @return null
	 */
	public function getViewsPerDayArray( $days = 7 ) {
		$model = new AdfoxlyStatisticsModel();

		$today     = date( 'Y-m-d H:i:s' );
		$todayDate = date_create( $today );
		$todayDate = date_modify( $todayDate, "-$days day" );

		$array = null;
		$views = $model->getViewsPerDay( $days );

		for ( $i = 0; $i < $days; $i ++ ) {

			$date = date_modify( $todayDate, "+1 day" );
			$date = $date->format( 'Y-m-d' );

			if ( isset( $views[ $date ] ) && ! empty( $views[ $date ] ) ) {
				$array[ $date ] = intval( $views[ $date ]->number );
			} else {
				$array[ $date ] = 0;
			}
		}

		return $array;
	}

	/**
	 * @param int $num
	 *
	 * @return mixed
	 */
	public function countTopClicks( $num = 10 ) {
		global $wpdb;
		$dbStatisitcs = $wpdb->prefix . 'adfoxly_statistics' . '_clicks';
		$dbPosts = $wpdb->prefix . 'posts';

		$result = $wpdb->get_results( "SELECT s.banner_id, p.ID as ad_id, p.post_title as post_title, count(s.id) as clicks FROM " . $dbStatisitcs . " s LEFT JOIN " . $dbPosts . " p ON p.ID = s.banner_id JOIN (SELECT count(id) as number, banner_id FROM $dbStatisitcs GROUP BY banner_id) s2 ON (s2.banner_id = s.banner_id) WHERE p.post_title is not null GROUP BY banner_id ORDER BY s2.number DESC LIMIT " . $num, OBJECT );

		return $result;
	}


	/**
	 * @param int $num
	 *
	 * @return mixed
	 */
	public function countTopViews( $num = 10 ) {
		global $wpdb;
		$dbStatisitcs = $wpdb->prefix . 'adfoxly_statistics' . '_views';
		$dbPosts = $wpdb->prefix . 'posts';

		$result = $wpdb->get_results( "SELECT s.banner_id, p.ID as ad_id, p.post_title as post_title, p.post_type as post_type, count(s.id) as adviews FROM " . $dbStatisitcs . " s LEFT JOIN " . $dbPosts . " p ON p.ID = s.banner_id JOIN (SELECT count(id) as number, banner_id FROM $dbStatisitcs GROUP BY banner_id) s2 ON (s2.banner_id = s.banner_id) WHERE p.post_title is not null AND p.post_type = 'adfoxly_places' GROUP BY banner_id ORDER BY s2.number DESC LIMIT " . $num, OBJECT );

		return $result;
	}

	/**
	 * @return mixed
	 */
	public function countAdsViews() {

		global $wpdb;
		$dbStatisitcs = $wpdb->prefix . 'adfoxly_statistics' . '_views';

		$result = $wpdb->get_var( "SELECT count(id) FROM $dbStatisitcs" );

		return $result;
	}

	/**
	 * @return mixed
	 */
	public function countAdsClicks() {

		global $wpdb;
		$dbStatisitcs = $wpdb->prefix . 'adfoxly_statistics' . '_clicks';

		$result = $wpdb->get_var( "SELECT count(id) FROM $dbStatisitcs" );

		return $result;
	}

	/**
	 * @param int $days
	 *
	 * @return mixed
	 */
	public function getViewsPerDayLabels( $days = 7 ) {
		global $wpdb;
		$dbStatisitcs = $wpdb->prefix . 'adfoxly_statistics' . '_views';

		$result = $wpdb->get_results( "SELECT `date` FROM $dbStatisitcs GROUP BY DAY(`date`) ORDER BY `id` ASC" );

		return $result;
	}

	public function insertTables() {
		global $wpdb;
		// db clicks statistics
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "adfoxly_statistics_clicks` ( `id` INT( 11 ) NOT NULL AUTO_INCREMENT,
			  `banner_id` INT( 11 ) NOT NULL,
			  `ad_id` INT( 11 ) NOT NULL,
			  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `ip` VARCHAR( 15 ) NULL,
			  `fingerprint` VARCHAR( 50 ) NOT NULL,
			  PRIMARY KEY( `id` )
			) ENGINE = InnoDB  DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;" );

        // db views statistics
        $wpdb->query( "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "adfoxly_statistics_views` ( `id` INT NOT NULL AUTO_INCREMENT,
				`banner_id` INT NOT NULL,
				`ad_id` INT NOT NULL,
				`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`ip` VARCHAR( 50 ) NULL,
				`fingerprint` VARCHAR( 50 ) NOT NULL,
				PRIMARY KEY( `id` )
			) ENGINE = InnoDB  DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;" );

        // db single ad views statistics
        if( adfoxly_wa_fs()->can_use_premium_code__premium_only() ) {
            $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "adfoxly_statistics_ad_views` ( `id` INT NOT NULL AUTO_INCREMENT,
				`banner_id` INT NOT NULL,
				`ad_id` INT NOT NULL,
				`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`ip` VARCHAR( 50 ) NULL,
				`fingerprint` VARCHAR( 50 ) NOT NULL,
				PRIMARY KEY( `id` )
			) ENGINE = InnoDB  DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;");
        }
	}
}

