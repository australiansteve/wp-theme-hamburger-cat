<?php
// Creating the widget 
class hamburgercat_header_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
        // Base ID of your widget
        'hamburgercat_header_widget', 

        // Widget name will appear in UI
        __('HamburgerCat Header Widget', 'hamburgercat_header_widget_domain'), 

        // Widget description
        array( 'description' => __( 'Header Image for the site', 'hamburgercat_header_widget_domain' ), ) 
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget( $args, $instance ) {

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        // This is where you run the code and display the output
        $widgetOutput = "";

        $widgetOutput .= "<div id='hc-header' class='container'>";

        $widgetOutput .= "<a href='".esc_url( home_url( '/' ) )."' rel='home'>";
                    
        $widgetOutput .= "<div class='header'><img id='header-image' src='".$instance['header_image']."'/></div>";
        
        $widgetOutput .= "</a>";
        $widgetOutput .= "</div>"; //div.container
        
        echo __( $widgetOutput, 'hamburgercat_header_widget_domain' );
        echo $args['after_widget'];
    }
        
    // Widget Backend 
    public function form( $instance ) {
        
        if ( isset( $instance[ 'header_image' ] ) ) {
            $header_image = $instance[ 'header_image' ];
        }
        else {
            $header_image = __( '%image url%', 'hamburgercat_header_widget_domain' );
        }

        // Widget admin form
?>
        <p>
        <label for="<?php echo $this->get_field_id( 'header_image' ); ?>"><?php _e( 'Header image:' ); ?></label> 
        <input class="widefat img" id="<?php echo $this->get_field_id( 'header_image' ); ?>" name="<?php echo $this->get_field_name( 'header_image' ); ?>" type="text" value="<?php echo esc_attr( $header_image ); ?>" />
        <input type="button" class="select-header-img" value="Select Image" />
        </p>
<?php 
    }
        
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['header_image'] = ( ! empty( $new_instance['header_image'] ) ) ? strip_tags( $new_instance['header_image'] ) : '';
        return $instance;
    }
} // Class hamburgercat_header_widget ends here


// Register and load the widget itself
function hamburgercat_header_load_widget() {
    register_widget( 'hamburgercat_header_widget' );

    register_sidebar( array(
        'name'          => 'Site header sidebar',
        'id'            => 'hamburgercat_header_sidebar',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );
}
add_action( 'widgets_init', 'hamburgercat_header_load_widget' );
?>
