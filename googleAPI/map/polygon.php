<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Language" content="en"/>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="MSSmartTagsPreventParsing" content="true"/>
  <meta http-equiv="imagetoolbar" content="no"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <title>Map Polygon</title>
</head>
<body>
  <div style="width:1204px;">
    <div id="map" style="height: 900px;"></div>
  </div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFvi7WI-u6vUr4Zr4xjA6Wi_PM2Xv7crE&libraries=drawing,geometry&callback=setMapPolygon" async defer></script> 
  <script type="text/javascript">
    var map;
    var activeBoundary = [
      {lat: 25.774, lng: -80.190},
      {lat: 18.466, lng: -66.118},
      {lat: 32.321, lng: -64.757},
      {lat: 25.774, lng: -80.190}
    ];
  	var drawingManager;
  	var activePolygon;
  	var activeSelection;
  	var polyOptions = {
      strokeColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 1,
      fillColor: '#FF0000',
      fillOpacity: 0.35
    };
    
    function setMapPolygon(){
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 5,
        center: {lat: 24.886, lng: -70.268}
      });
      
      // Pre Defined Active Boundary
      if (activeBoundary) {
        if (activeBoundary.coordinates) {
          activePolygon = new google.maps.Polygon(polyOptions[activeBoundary.type]);
          activePolygon.setPaths(activeBoundary.coordinates);
          activePolygon.setMap(map);
          activePolygon.destination_id = activeBoundary.destination_id;
          activePolygon.setEditable(true);
          activeSelection = activePolygon;
          
          google.maps.event.addListener(activePolygon, 'click', function(){
            setActivePolygon(activePolygon);
          });
        }
      }
  		
  		// Drawing tools
      drawingManager = new google.maps.drawing.DrawingManager({
        drawingControl: true,
        drawingControlOptions: {
          position: google.maps.ControlPosition.TOP_CENTER,
          drawingModes: [google.maps.drawing.OverlayType.POLYGON,]
        },
        polygonOptions: polyOptions.new_selection,
        map:map
      });
      
      google.maps.event.addListener(drawingManager,'polygoncomplete',function(polygon) {
        setActivePolygon(polygon);
        google.maps.event.addListener(polygon, 'click', function(){
          setActivePolygon(polygon);
        });
      });
    }
    
    function setActivePolygon(polygon){
  		deactivePolygon();
  		polygon.setEditable(true);
  		activeSelection = polygon;
  	}
  	
  	function deactivePolygon(){
  		if (othersPolygon.length) {
  			othersPolygon.forEach(function(oPolygon, index){
  				oPolygon.setEditable(false);
  			});
  		}
  		
  		if (typeof activeSelection !== 'undefined' && activeSelection.setEditable) {
  			activeSelection.setEditable(false);
  		}
  	}
  </script>
</body>
</html>
