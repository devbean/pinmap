jQuery(document).ready(function($) {
//    $("#pinmap_btn_searchplace").click(function () {
//        var placeName = $("#pinmap_post_placename").val();
//        if (placeName.length > 0) {
//            $("#pinmap_mapdiv").gmap3({
//                getlatlng:{
//                    address:  placeName,
//                    callback: function(results){
//                        if ( !results ) return;
//                        $(this).gmap3({
//                            marker:{
//                                latLng:results[0].geometry.location
//                            }
//                        });
//                    }
//                }
//            });
//        }
//    });
    $( "#pinmap_post_placename" ).autocomplete({
        source: function (request, response) {
            $("#pinmap_mapdiv").gmap3({
                getaddress: {
                    address: request.term,
                    callback: function(results){
                        if (!results) {
                            return;
                        }
                        var addrs = [];
                        $.each(results, function (index, value) {
                            addrs.push(value["formatted_address"]);
                        });
                        response(addrs);
                    }
                }
            });
        },
        minLength: 2
    });
});