$.ajax({
                type: "GET",
                url: 'https://wry5yc9khl.execute-api.us-east-1.amazonaws.com/default/s3Final',
                success: function(data)
                {
                        console.log(data);
                        getMap(data);
                },
                error: function(error) 
                {
                        console.log(error);
                }
        });

function getMap(data) {
        let lat=39.51033;
        let lon=-84.741727;
        var map = L.map('mapid').setView([lat, lon], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        for (i = 0; i < data.length; i++) {
             L.marker([data[i]['lat'], data[i]['lon']]).addTo(map)
                .bindPopup(data[i]['city'])
                .openPopup();   
        }
}
