<?php
class AUSteve_OpenHours_Widget extends WP_Widget {

    private static $displayFormats = array("0" => "24 hour format (17:53)", 
        "1" => "12 hour uppercase (05:53PM)", 
        "2" => "12 hour lowercase (05:53pm)");
         
	function __construct() {
        parent::__construct(
        // Base ID of your widget
        'austeve_openhours_widget', 

        // Widget name will appear in UI
        __('Open Hours', 'austeve_openhours_widget_domain'), 

        // Widget description
        array( 'description' => __( 'Set and display your open hours here', 'austeve_openhours_widget_domain' ), ) 
        );
        
	}

	function widget( $args, $instance ) {

        $daysOfWeek = array("0" => array("Monday", "Mon"),
            "1" => array("Tuesday", "Tue"), 
            "2" => array("Wednesday", "Wed"), 
            "3" => array("Thursday", "Thu"), 
            "4" => array("Friday", "Fri"), 
            "5" => array("Saturday", "Sat"), 
            "6" => array("Sunday", "Sun"));
          

		// Widget output
        $title = apply_filters( 'widget_title', $instance['title'] );
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        // This is where you run the code and display the output
        $widgetOutput = "";
        $widgetOutput .= "<div class='container openhours-widget'>";

        $widgetOutput .= "<h4 class='title'>".$title."</h4>";

        $hoursObj = json_decode($instance[ 'hours' ], true);
        $lz = $instance['leadingzero'] == '1';
        $widgetOutput .= "<div><span class='day'>".$daysOfWeek[0][0].":</span> <span class='hours'>".formatTime($hoursObj["monday"]["from"], $instance[ 'displayformat' ], $lz)." - ".formatTime($hoursObj["monday"]["to"], $instance[ 'displayformat' ], $lz)."</span></div>";
        $widgetOutput .= "<div><span class='day'>".$daysOfWeek[1][0].":</span> <span class='hours'>".formatTime($hoursObj["tuesday"]["from"], $instance[ 'displayformat' ], $lz)." - ".formatTime($hoursObj["tuesday"]["to"], $instance[ 'displayformat' ], $lz)."</span></div>";
        $widgetOutput .= "<div><span class='day'>".$daysOfWeek[2][0].":</span> <span class='hours'>".formatTime($hoursObj["wednesday"]["from"], $instance[ 'displayformat' ], $lz)." - ".formatTime($hoursObj["wednesday"]["to"], $instance[ 'displayformat' ], $lz)."</span></div>";
        $widgetOutput .= "<div><span class='day'>".$daysOfWeek[3][0].":</span> <span class='hours'>".formatTime($hoursObj["thursday"]["from"], $instance[ 'displayformat' ], $lz)." - ".formatTime($hoursObj["thursday"]["to"], $instance[ 'displayformat' ], $lz)."</span></div>";
        $widgetOutput .= "<div><span class='day'>".$daysOfWeek[4][0].":</span> <span class='hours'>".formatTime($hoursObj["friday"]["from"], $instance[ 'displayformat' ], $lz)." - ".formatTime($hoursObj["friday"]["to"], $instance[ 'displayformat' ], $lz)."</span></div>";
        $widgetOutput .= "<div><span class='day'>".$daysOfWeek[5][0].":</span> <span class='hours'>".formatTime($hoursObj["saturday"]["from"], $instance[ 'displayformat' ], $lz)." - ".formatTime($hoursObj["saturday"]["to"], $instance[ 'displayformat' ], $lz)."</span></div>";
        $widgetOutput .= "<div><span class='day'>".$daysOfWeek[6][0].":</span> <span class='hours'>".formatTime($hoursObj["sunday"]["from"], $instance[ 'displayformat' ], $lz)." - ".formatTime($hoursObj["sunday"]["to"], $instance[ 'displayformat' ], $lz)."</span></div>";

        $widgetOutput .= "</div>"; //div.container
        
        echo __( $widgetOutput, 'austeve_openhours_widget_domain' );
        echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {

		// Save widget options
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['hours'] = ( ! empty( $new_instance['hours'] ) ) ? strip_tags( $new_instance['hours'] ) : '';
        $instance['displayformat'] = ( ! empty( $new_instance['displayformat'] ) ) ? strip_tags( $new_instance['displayformat'] ) : '0';
        $instance['leadingzero'] = ( isset( $new_instance['leadingzero'] ) ) ? '1' : '0';
        return $instance;
	}

	function form( $instance ) {

        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Open Hours:', 'austeve_openhours_widget_domain' );
        }

        if ( isset( $instance[ 'hours' ] ) ) {
            $hours = $instance[ 'hours' ];
        }
        else {
            $hours = __( '{"monday":{"open":"true","from":"0100","to":"1700"},"tuesday":{"open":"true","from":"0900","to":"1700"},"wednesday":{"open":"true","from":"0900","to":"1700"},"thursday":{"open":"true","from":"0900","to":"1700"},"friday":{"open":"true","from":"0900","to":"1700"},"saturday":{"open":"false","from":"0900","to":"1700"},"sunday":{"open":"false","from":"0900","to":"1700"}}', 'austeve_openhours_widget_domain' );
        }
        $hoursObj = json_decode($hours, true);

        if ( isset( $instance[ 'displayformat' ] ) ) {
            $displayformat = $instance[ 'displayformat' ];
        }
        else {
            $displayformat = __( 'Display format:', 'austeve_openhours_widget_domain' );
        }

        if ( isset( $instance[ 'leadingzero' ] ) ) {
            $leadingzero = $instance[ 'leadingzero' ];
        }
        else {
            $leadingzero = __( 'Leading zero:', 'austeve_openhours_widget_domain' );
        }


		// Output admin widget options form
		?>

        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
        <label for="<?php echo $this->get_field_id( 'hours' ); ?>"><?php _e( 'Hours:' ); ?></label><br/>
        <input class="widefat" id="<?php echo $this->get_field_id( 'hours' ); ?>" name="<?php echo $this->get_field_name( 'hours' ); ?>" data-name="json-hours" type="hidden" value="<?php echo esc_attr( $hours ); ?>" />
        <label class="hour-warning">Enter all hours in 24 hour format eg. '0900' for 9AM</label>
        </p>

        <table>
            <tr>
                <th></th>
                <th>Open?</th>
                <th>From</th>
                <th>Until</th>
            </tr>
            <tr>
                <td>Monday:</td>
                <td><input class="austeve-oh monday open" name="open" type="checkbox" checked="checked"></td>
                <td><input class="austeve-oh monday hours start" name="start" type="text" placeholder="9am" value="<?php echo $hoursObj["monday"]["from"]; ?>"></td>
                <td><input class="austeve-oh monday hours end" name="end" type="text" placeholder="5pm" value="<?php echo $hoursObj["monday"]["to"]; ?>"></td>
            </tr>
            <tr>
                <td>Tuesday:</td>
                <td><input class="austeve-oh tuesday open" name="open" type="checkbox" checked="checked"></td>
                <td><input class="austeve-oh tuesday hours start" name="start" type="text" placeholder="9am" value="<?php echo $hoursObj["tuesday"]["from"]; ?>"></td>
                <td><input class="austeve-oh tuesday hours end" name="end" type="text" placeholder="5pm"  value="<?php echo $hoursObj["tuesday"]["to"]; ?>"></td>
            </tr>
            <tr>
                <td>Wednesday:</td>
                <td><input class="austeve-oh wednesday open" name="open" type="checkbox" checked="checked"></td>
                <td><input class="austeve-oh wednesday hours start" name="start" type="text" placeholder="9am" value="<?php echo $hoursObj["wednesday"]["from"]; ?>"></td>
                <td><input class="austeve-oh wednesday hours end" name="end" type="text" placeholder="5pm" value="<?php echo $hoursObj["wednesday"]["to"]; ?>"></td>
            </tr>
            <tr>
                <td>Thursday:</td>
                <td><input class="austeve-oh thursday open" name="open" type="checkbox" checked="checked"></td>
                <td><input class="austeve-oh thursday hours start" name="start" type="text" placeholder="9am" value="<?php echo $hoursObj["thursday"]["from"]; ?>"></td>
                <td><input class="austeve-oh thursday hours end" name="end" type="text" placeholder="5pm" value="<?php echo $hoursObj["thursday"]["to"]; ?>"></td>
            </tr>
            <tr>
                <td>Friday:</td>
                <td><input class="austeve-oh friday open" name="open" type="checkbox" checked="checked"></td>
                <td><input class="austeve-oh friday hours start" name="start" type="text" placeholder="9am" value="<?php echo $hoursObj["friday"]["from"]; ?>"></td>
                <td><input class="austeve-oh friday hours end" name="end" type="text" placeholder="5pm" value="<?php echo $hoursObj["friday"]["to"]; ?>"></td>
            </tr>
            <tr>
                <td>Saturday:</td>
                <td><input class="austeve-oh saturday open" name="open" type="checkbox" checked="checked"></td>
                <td><input class="austeve-oh saturday hours start" name="start" type="text" placeholder="9am" value="<?php echo $hoursObj["saturday"]["from"]; ?>"></td>
                <td><input class="austeve-oh saturday hours end" name="end" type="text" placeholder="5pm" value="<?php echo $hoursObj["saturday"]["to"]; ?>"></td>
            </tr>
            <tr>
                <td>Sunday:</td>
                <td><input class="austeve-oh sunday open" name="open" type="checkbox" checked="checked"></td>
                <td><input class="austeve-oh sunday hours start" name="start" type="text" placeholder="9am" value="<?php echo $hoursObj["sunday"]["from"]; ?>"></td>
                <td><input class="austeve-oh sunday hours end" name="end" type="text" placeholder="5pm" value="<?php echo $hoursObj["sunday"]["to"]; ?>"></td>
            </tr>
        </table>

        <p>
        <label for="<?php echo $this->get_field_id( 'displayformat' ); ?>"><?php _e( 'Display format:' ); ?></label> 
        <select class="widefat" id="<?php echo $this->get_field_id( 'displayformat' ); ?>" name="<?php echo $this->get_field_name( 'displayformat' ); ?>" type="text" value="<?php echo esc_attr( $displayformat ); ?>" >
            <?php
            foreach (self::$displayFormats as $key => $value)
            {
                echo "<option value='$key'";
                if ($displayformat == $key)
                    echo " selected='selected'";
                echo ">$value</option>";
            }
            ?>
        </select>
        </p>

        <p>
        <label for="<?php echo $this->get_field_id( 'leadingzero' ); ?>"><?php _e( 'Display leading zero (if < 10am/pm):' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'leadingzero' ); ?>" name="<?php echo $this->get_field_name( 'leadingzero' ); ?>" type="checkbox" <?php if ($leadingzero == '1') echo "checked='checked'"; ?> />
        </p>

		<?php
	}
}

function formatTime($raw, $format, $leadingZero) {
    switch($format) {
        case "0":
            //24 hour time - insert : after second character
            return substr_replace($raw, ":", 2, 0);
        case "1":
            //12 hour uppercase - if < 12 = AM, else PM
            return to12HourTime($raw, true, $leadingZero);
        case "2":
            //12 hour lowercase - if < 12 = am, else pm
            return to12HourTime($raw, false, $leadingZero);
        default:
            return $raw;
    }
}

function to12HourTime($twentyFourTime, $uppercase, $leadingZero)
{
    $colonPos = 2;
    $twelveHourTime;
    if (intval($twentyFourTime) < 1200) {
        if (intval($twentyFourTime) < 1000)
            $colonPos = 1;
        $twelveHourTime = substr_replace(intval($twentyFourTime), ":", $colonPos, 0)."am";
    }
    elseif (intval($twentyFourTime) < 1300) {
        $twelveHourTime = substr_replace($twentyFourTime, ":", 2, 0)."pm";
    }
    else {
        $pmTime = intval($twentyFourTime) - 1200;
        if ($pmTime < 1000){
            $colonPos = 1;

            if ($leadingZero) {
                $pmTime = "0".$pmTime;
                $colonPos = 2;
            }
        }
        $twelveHourTime = substr_replace($pmTime, ":", $colonPos, 0)."pm";
    }

    if ($uppercase)
        return strtoupper($twelveHourTime);

    return $twelveHourTime;
}

function hamburgercat_register_widgets() {
	register_widget( 'AUSteve_OpenHours_Widget' );
}

add_action( 'widgets_init', 'hamburgercat_register_widgets' );

?>