jQuery(document).ready(function($) {
    $("#pinmap_mapdiv").gmap3();

    $("#pinmap_btn_searchplace").click(function () {
        $("#pinmap_mapdiv").gmap3({
            getlatlng:{
                address:  "Paris, France",
                callback: function(results){
                    if ( !results ) return;
                    $(this).gmap3({
                        marker:{
                            latLng:results[0].geometry.location
                        }
                    });
                }
            }
        });
    });
});