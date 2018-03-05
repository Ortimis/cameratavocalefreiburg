<?php
/**
 * Generates and displays Google Map on Contact Page Template
 *
 * @package Eveny
 */

$map_color         = esc_attr( get_theme_mod( 'eveny_contact_map_color_picker_setting' ) );
$x_coord           = esc_attr( get_theme_mod( 'eveny_contact_map_x_coord' ) );
$y_coord           = esc_attr( get_theme_mod( 'eveny_contact_map_y_coord' ) );
$zoom_factor       = esc_attr( get_theme_mod( 'eveny_map_zoom_factor_setting' ) );
$marker_title      = esc_attr( get_theme_mod( 'eveny_map_marker_setting' ) );
$map_type_selected = esc_attr( get_theme_mod( 'eveny_map_type_setting' ) );
$map_icon          = esc_attr( get_theme_mod( 'eveny_map_marker_icon_setting' ) );

// Default Map Coordinates
if ( empty( $x_coord ) ) {
    $x_coord = '40.732480';
}
if ( empty( $y_coord ) ) {
    $y_coord = '-74.005450';
}
if ( empty( $zoom_factor ) ) {
    $zoom_factor = 15;
}

// Default Map type
if ( $map_type_selected == 'choice-1' ) {
	$map_type = 'HYBRID';
} elseif ( $map_type_selected == 'choice-3' ) {
	$map_type = 'SATELLITE';
} elseif ( $map_type_selected == 'choice-4' ) {
	$map_type = 'TERRAIN';
} else {
	$map_type = 'ROADMAP';
}

?>

<div class="map-wrapper">

    <figure class="map">
        <div id="map-canvas" class="contact-img"></div>
    </figure> <!-- /map -->

    <?php if ( ! empty( $map_color ) ) { ?>

        <script type="text/javascript">

            var map;

            function initialize() {
                var styles = [
                    {
                        "stylers": [
                            { "hue": "<?php echo esc_attr($map_color); ?>" }
                        ]
                    }
                ];

                var styledMap = new google.maps.StyledMapType( styles,
                    { name: "Styled Map" } );

                var latlng = new google.maps.LatLng( <?php echo esc_attr($x_coord) ?>, <?php echo esc_attr($y_coord) ?> );

                var myOptions = {
                    zoom: <?php echo esc_attr($zoom_factor) ?>,
                    center: latlng,
                    mapTypeControl: false,
                    streetViewControl: false,
                    overviewMapControl: false,
                    mapTypeId: google.maps.MapTypeId.<?php echo esc_attr($map_type) ?>,
                    scrollwheel: false
                };

                var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
                map.mapTypes.set('map_style', styledMap);
                map.setMapTypeId('map_style');

                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    <?php if( !empty($map_icon) ) { ?>
                    icon: {
                        url: "<?php echo esc_js( $map_icon ); ?>",
                        scaledSize: new google.maps.Size(80, 90),
                        anchor: new google.maps.Point(40, 90)
                    },
                    <?php } ?>
                    <?php if(!empty($marker_title)) { ?>
                    title:"<?php echo esc_attr($marker_title) ?>"
                    <?php }?>
                });

            }
            google.maps.event.addDomListener(window, 'load', initialize);
                google.maps.event.addDomListener(window, "resize", function() {
                var center = map.getCenter();
                google.maps.event.trigger(map, "resize");
                map.setCenter(center);
            });
        </script>

    <?php } else { ?>

        <script type="text/javascript">

            var mapa;

            function initialize() {
                var latlng = new google.maps.LatLng(<?php echo esc_attr($x_coord) ?>, <?php echo esc_attr($y_coord) ?>);
                var myOptions = {
                    zoom: <?php echo esc_attr($zoom_factor) ?>,
                    center: latlng,
                    mapTypeControl: false,
                    streetViewControl: false,
                    overviewMapControl: false,
                    mapTypeId: google.maps.MapTypeId.<?php echo esc_attr($map_type) ?>,
                    scrollwheel: false
                };

                var mapa = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

                    var marker = new google.maps.Marker({
                        position: latlng,
                        map: mapa,
                        <?php if( !empty($map_icon) ) { ?>
                        icon: {
                            url: "<?php echo esc_js( $map_icon ); ?>",
                            scaledSize: new google.maps.Size(80, 90),
                            anchor: new google.maps.Point(40, 90)
                        },
                        <?php } ?>
                        <?php if(!empty($marker_title)) { ?>
                            title:"<?php echo esc_js( $marker_title ); ?>"
                        <?php } ?>
                    });
            }
            google.maps.event.addDomListener(window, 'load', initialize);
                google.maps.event.addDomListener(window, "resize", function() {
                var center = mapa.getCenter();
                google.maps.event.trigger(mapa, "resize");
                mapa.setCenter(center);
            });

        </script>

    <?php } ?>

</div>
