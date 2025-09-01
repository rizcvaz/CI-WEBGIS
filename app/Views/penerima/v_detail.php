<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title m-0"><?= $judul ?></h3>
            
        </div>

        <div class="card-body">
            <div>
                <button class="btn btn-sm btn-outline-primary" onclick="showMap()">Tampilkan Peta</button>
                <button class="btn btn-sm btn-outline-secondary" onclick="showImage()">Tampilkan Foto</button>
            </div>
            
            <div class="mb-4">
                <div id="map-container" style="display: block;">
                    <div id="map" style="width: 100%; height: 500px; border-radius: 8px;"></div>
                </div>
            </div>

            <div class="mb-4">
                <div id="image-container" style="display: none;">
                    <img src="<?= base_url('foto/' . $rumah['foto']) ?>" class="img-fluid rounded" style="width: 100%; height: 500px; object-fit: cover;">
                </div>
            </div>

            <table class="table table-bordered">
                <tr>
                    <th>Nama rumah</th>
                    <th width="30px">:</th>
                    <td><?= $rumah['nama_rumah'] ?></td>
                </tr>
                <tr>
                    <th>Nomor KTP Rumah</th>
                    <th>:</th>
                    <td><?= $rumah['nomor_ktp'] ?></td>
                </tr>
                <tr>
                    <th>Alamat rumah</th>
                    <th>:</th>
                    <td><?= $rumah['alamat'] ?>, <?= $rumah['nama_kecamatan'] ?>, <?= $rumah['nama_kabupaten'] ?>, <?= $rumah['nama_provinsi'] ?></td>
                </tr>
                <tr>
                    <th>Jenis Atap</th>
                    <th>:</th>
                    <td><?= $rumah['jenis_atap'] ?></td>
                </tr>
                <tr>
                    <th>Jenis Dinding</th>
                    <th>:</th>
                    <td><?= $rumah['jenis_dinding'] ?></td>
                </tr>
                <tr>
                    <th>Jenis Lantai</th>
                    <th>:</th>
                    <td><?= $rumah['jenis_lantai'] ?></td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <th>:</th>
                    <td><?= $rumah['keterangan'] ?></td>
                </tr>
                <tr>
                    <th>Jenis Bantuan</th>
                    <th>:</th>
                    <td><?= $rumah['jenis_bantuan'] ?></td>
                </tr>
            </table>

            <div class="mt-3 text-end">
                <a href="<?= base_url('Rumah') ?>" class="btn btn-success btn-flat">Kembali</a>
            </div>
            
        </div>
    </div>
</div>

<script>
    function showMap() {
        document.getElementById("map-container").style.display = "block";
        document.getElementById("image-container").style.display = "none";
        setTimeout(() => {
            map.invalidateSize(); 
        }, 200);
    }

    function showImage() {
        document.getElementById("map-container").style.display = "none";
        document.getElementById("image-container").style.display = "block";
    }
</script>

<script>
    var peta1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    var peta2 = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Tiles style by <a href="https://www.hotosm.org/" target="_blank">Humanitarian OpenStreetMap Team</a> hosted by <a href="https://openstreetmap.fr/" target="_blank">OpenStreetMap France</a>'
    });

    var peta3 = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
    });

    var peta4 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://carto.com/">CartoDB</a>',
        subdomains: 'abcd',
        maxZoom: 19
    });

    var peta5 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, Earthstar Geographics',
        maxZoom: 19
    });

    var peta6 = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://carto.com/">CartoDB</a>',
        subdomains: 'abcd',
        maxZoom: 19
    });

	var map = L.map('map', {
		center: [<?= $rumah['coordinat'] ?>],
		zoom: [<?= $web['zoom_view'] ?>],
		layers: [peta1]
	});

	var baseMaps = {
        'Streets': peta1,
        'OpenStreetMap.HOT': peta2,
        'OpenTopoMap': peta3,
        'Carto Light': peta4,
        'Esri Satellite': peta5,
        'Carto Dark': peta6
    };

    L.geoJSON(<?= $rumah['geojson'] ?>, {
        fillColor: '<?= $rumah['warna'] ?>',
        fillOpacity: 0.5,
    })
    .bindPopup("<b><?= $rumah['nama_wilayah'] ?></b>")
    .addTo(map);

    var icon = L.icon({
    iconUrl: '<?= base_url('marker/' . $rumah['marker'])?>',
    iconSize:     [30, 40], 
});
    L.marker([<?= $rumah['coordinat'] ?>], {
        icon:icon
    }).addTo(map);

</script>
