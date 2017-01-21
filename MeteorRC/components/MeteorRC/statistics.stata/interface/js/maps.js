$(window).load(function(){
$('a[data-coords]').each(function() {
    var elem = $(this);

    elem.qtip({
        content: {
            text: 'Loading map...',
            title: { button: true }
        },
        position: {
            my: 'left center',
            at: 'right center'
        },
        show: {
            event: 'click'
        },
        hide: {
            event: 'unfocus'
        },
        style: {
            classes: 'googlemap',
            width: 300
        },
        events: {
            render : function(event, api) {
                var tooltip = $(this),

                // Setup the map container and append it to the tooltip
                container = $('<div style="width:300px; height:200px;"></div>')
                    .appendTo(api.elements.content.empty());

                // Temporarily show the tooltip so we don't get rendering bugs in GMaps
                tooltip.show();

                // Create map object as api attribute for later use
                api.map = new google.maps.Map(container[0], {
                    zoom: 12, // Close zoom!
                    mapTypeId: google.maps.MapTypeId.ROADMAP // Use the classic roadmap
                });

                // Hide the tooltip again now we're done
                tooltip.hide();
            },
            show: function(event, api) {
                // Grab the map reference and target
                var map = api.map,
                    target = api.elements.target,
                    coords, latlong, map, marker, info;

                // Parse coordinates of event target
                coords = api.elements.target.data('coords').split(',');

                // Setup lat/long coordinates
                latlong = new google.maps.LatLng(parseFloat(coords[0]), parseFloat(coords[1]));

                // Create marker at the new location and center map there
                marker = new google.maps.Marker({
                    position: latlong,
                    map: map,
                    title: target.attr('alt') // Use the alt attribute of the target for the marker title
                });
                map.setCenter(latlong);
            }
        }
    });
})
.click(function(e){ e.preventDefault(); });
});