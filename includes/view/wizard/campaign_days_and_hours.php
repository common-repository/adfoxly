<?php



class wizardCmpaignDaysAndHours {
	public function render( $output, $meta_field ) {
		if ( adfoxly_wa_fs()->is__premium_only() ) {

			if ( adfoxly_wa_fs()->can_use_premium_code() ) {

				if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) && is_numeric( $_GET[ 'edit' ] ) ) {
					$campaignID = $_GET[ 'edit' ];
				}

				if ( isset( $campaignID ) && ! empty( $campaignID ) ) {
					$adfoxlyCampaignDays          = get_post_meta( $campaignID, 'adfoxly-campaign-days', true );
					$adfoxlyCampaignSpecificHours = get_post_meta( $campaignID, 'adfoxly-campaign-specific-hours', true );
				}

				if ( isset( $meta_field[ 'group' ] ) && ! empty( $meta_field[ 'group' ] ) ) {
					$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . ' ad-format-group-' . $meta_field[ 'group' ] . '">';
				} else {
					$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . '">';
				}

				$output .= '<label class="col-sm-3 col-form-label">' . $meta_field[ 'label' ] . '</label>';
				$output .= '<div class="col-sm-9 col-form-label">';


				$days = array(
					'monday'    => 'Monday',
					'tuesday'   => 'Tuesday',
					'wednesday' => 'Wednesday',
					'thursday'  => 'Thursday',
					'friday'    => 'Friday',
					'saturday'  => 'Saturday',
					'sunday'    => 'Sunday'
				);
				foreach ( $days as $key => $day ) {

					$output .= '				
					<div style="display: flex; align-items: center; justify-content: left; justify-items: center;">
						<label class="col-3 custom-switch">
	                        <input type="checkbox" name="adfoxly-campaign-days[]" value="' . $key . '" class="custom-switch-input adfoxly-campaign-days adfoxly-campaign-day-' . $key . '" ';

					if ( isset( $adfoxlyCampaignDays ) && ! empty( $adfoxlyCampaignDays ) && in_array( $key, $adfoxlyCampaignDays ) ) {
						$output .= ' checked ';
					} else if ( ! isset( $adfoxlyCampaignDays ) ) {
						$output .= ' checked ';
					}

					$output .= '>
	                        <span class="custom-switch-indicator"></span>
	                        <span class="custom-switch-description">' . $day . '</span>
	                    </label>
	                    <label class="col-3 custom-switch">
	                        <input type="checkbox" name="adfoxly-campaign-specific-hours[]" value="' . $key . '" class="custom-switch-input adfoxly-campaign-days adfoxly-campaign-specific-hours-' . $key . '" data-adfoxly-day="' . $key . '" ';

					if ( isset( $adfoxlyCampaignSpecificHours ) && ! empty( $adfoxlyCampaignSpecificHours ) && in_array( $key, $adfoxlyCampaignSpecificHours ) ) {
						$output                                    .= ' checked ';
						$adfoxlyCampaignSpecificHoursStart[ $key ] = get_post_meta( $campaignID, 'adfoxly-campaign-specific-hour-start-' . $key, true );
						$adfoxlyCampaignSpecificHoursEnd[ $key ]   = get_post_meta( $campaignID, 'adfoxly-campaign-specific-hour-end-' . $key, true );
					}

					$output .= '>
	                        <span class="custom-switch-indicator"></span>
	                        <span class="custom-switch-description">Specific Hours</span>
	                    </label>
	                    <div class="col-3 input-group">	                       
                            <input type="text" name="adfoxly-campaign-specific-hour-start-' . $key . '" class="form-control adfoxly-timepicker adfoxly-campaign-days adfoxly-campaign-specific-hour-start-' . $key . '"';

					if ( isset( $adfoxlyCampaignSpecificHoursStart[ $key ] ) && ! empty( $adfoxlyCampaignSpecificHoursStart[ $key ] ) ) {
						$output .= ' value="' . $adfoxlyCampaignSpecificHoursStart[ $key ] . '" ';
					} else {
						$output .= ' value="12:00 AM" disabled ';
					}

					$output .= '>
                        </div>
                        <div class="col-3 input-group">	                       
                            <input type="text" name="adfoxly-campaign-specific-hour-end-' . $key . '" class="form-control adfoxly-timepicker adfoxly-campaign-days adfoxly-campaign-specific-hour-end-' . $key . '"';

					if ( isset( $adfoxlyCampaignSpecificHoursEnd[ $key ] ) && ! empty( $adfoxlyCampaignSpecificHoursEnd[ $key ] ) ) {
						$output .= ' value="' . $adfoxlyCampaignSpecificHoursEnd[ $key ] . '" ';
					} else {
						$output .= ' value="11:59 PM" disabled ';
					}

					$output .= '>
                        </div>
                    </div>                  
                      
                      ';

				}

				$output .= '</div>';
				$output .= '</div>';
			}

		}

		if ( ! adfoxly_wa_fs()->is__premium_only() ) {

			if ( isset( $_GET[ 'edit' ] ) && ! empty( $_GET[ 'edit' ] ) && is_numeric( $_GET[ 'edit' ] ) ) {
				$campaignID = $_GET[ 'edit' ];
			}

			if ( isset( $campaignID ) && ! empty( $campaignID ) ) {
				$adfoxlyCampaignDays          = get_post_meta( $campaignID, 'adfoxly-campaign-days', true );
				$adfoxlyCampaignSpecificHours = get_post_meta( $campaignID, 'adfoxly-campaign-specific-hours', true );
			}

			if ( isset( $meta_field[ 'group' ] ) && ! empty( $meta_field[ 'group' ] ) ) {
				$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . ' ad-format-group-' . $meta_field[ 'group' ] . '">';
			} else {
				$output .= '<div class="form-group row form-group-type-' . $meta_field[ 'type' ] . '">';
			}

			$output .= '<label class="col-sm-3 col-form-label" style="color: #aaa;">' . $meta_field[ 'label' ] . ' <small>(PRO)</small><br/><a href="' . admin_url( 'admin.php?billing_cycle=annual&trial=true&page=adfoxly-pricing' ) . '" class="pro-link" style="color: #aaa; font-size: 10px; line-height: 1;">This feature is available only in pro version. Start free 7-day trial. No hidden fees. No credit card required.</a></label>';
			$output .= '<div class="col-sm-9 col-form-label">';


			$days = array(
				'monday'    => 'Monday',
				'tuesday'   => 'Tuesday',
				'wednesday' => 'Wednesday',
				'thursday'  => 'Thursday',
				'friday'    => 'Friday',
				'saturday'  => 'Saturday',
				'sunday'    => 'Sunday'
			);
			foreach ( $days as $key => $day ) {

				$output .= '				
					<div style="display: flex; align-items: center; justify-content: left; justify-items: center;">
						<label class="col-3 custom-switch">
	                        <input type="checkbox" disabled value="' . $key . '" class="custom-switch-input adfoxly-campaign-days adfoxly-campaign-day-' . $key . '">
	                        <span class="custom-switch-indicator"></span>
	                        <span class="custom-switch-description">' . $day . '</span>
	                    </label>
	                    <label class="col-3 custom-switch">
	                        <input type="checkbox" disabled value="' . $key . '" class="custom-switch-input adfoxly-campaign-days adfoxly-campaign-specific-hours-' . $key . '" data-adfoxly-day="' . $key . '">
	                        <span class="custom-switch-indicator"></span>
	                        <span class="custom-switch-description">Specific Hours</span>
	                    </label>
	                    <div class="col-3 input-group">	                       
                            <input type="text" value="12:00 AM" disabled class="form-control adfoxly-timepicker adfoxly-campaign-days adfoxly-campaign-specific-hour-start-' . $key . '">
                        </div>
                        <div class="col-3 input-group">	                       
                            <input type="text" value="11:59 PM" disabled class="form-control adfoxly-timepicker adfoxly-campaign-days adfoxly-campaign-specific-hour-end-' . $key . '">
                        </div>
                    </div>                  
                      
                      ';

			}

			$output .= '</div>';
			$output .= '</div>';

		}


		return $output;
	}
}
