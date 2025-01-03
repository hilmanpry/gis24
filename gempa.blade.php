<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Mengimpor stylesheet Leaflet untuk styling peta -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <style>
        /* Mengatur tinggi peta */
        #map { height: 450px; }
    </style>

    <!-- Mengimpor script Leaflet setelah CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body>
    <div style="text-align: center">
        <h1>Peta Gempa Bumi</h1>
        <h3>Sumber Data: BMKG</h3>
    </div>

    <!-- Elemen untuk menampilkan peta -->
    <div id="map"></div>

    <script>
        // Inisialisasi peta dengan koordinat awal dan level zoom
        var map = L.map('map').setView([-0.3155398750904368, 117.1371634207888], 5);

        // Menambahkan layer peta dari OpenStreetMap
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 5,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Mengambil data gempa terkini dari BMKG
        let files = {!! file_get_contents("https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json") !!};
        console.log(files); // Menampilkan data di konsol untuk debugging

        // Mengakses array gempa dari data yang diambil
        let gempas = files.Infogempa.gempa;

        // Menambahkan marker untuk setiap gempa di peta
        gempas.forEach(gempas => {
            let kordinat = gempas.Coordinates.split(","); // Memisahkan koordinat
            let lat = kordinat[0]; // Mendapatkan latitude
            let log = kordinat[1]; // Mendapatkan longitude

            // Membuat marker dan menambahkannya ke peta
            let marker = L.marker([lat, log]).addTo(map);

            // Menambahkan popup pada marker dengan informasi gempa
            marker.bindPopup(
                "Tanggal: " + gempas.Tanggal + "<br>" +
                "Jam: " + gempas.Jam + "<br>" +
                "Kekuatan: " + gempas.Magnitude + "<br>" +
                "Wilayah: " + gempas.Wilayah + "<br>" +
                "Potensi: " + gempas.Potensi
            );
        });
    </script>

    <!-- Informasi pemilik -->
    <footer>
        <p>Pemilik: 0110221279</p>
    </footer>
</body>
</html>
