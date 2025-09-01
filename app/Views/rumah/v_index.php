<div class="col-md-12">
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title"><?= $judul ?></h3>
      <div class="card-tools">
        <a href="<?= base_url('Rumah/Input') ?>" class="btn btn-flat btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah
        </a>
      </div>
    </div>
    <div class="card-body">

      <!-- Menampilkan pesan setelah aksi (Insert, Update, Delete) -->
      <?php if (session()->getFlashdata('insert')): ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> <?= session()->getFlashdata('insert') ?></h5>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('update')): ?>
        <div class="alert alert-primary alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> <?= session()->getFlashdata('update') ?></h5>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('delete')): ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> <?= session()->getFlashdata('delete') ?></h5>
        </div>
      <?php endif; ?>

      <!-- Tabel Data Rumah -->
      <table id="example2" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th width="50px">No</th>
            <th>Nama KK</th>
            <th>Nomor KTP</th>
            <th>Alamat</th>
            <th>Koordinat</th>
            <th>Jenis Bantuan</th>
            <th>Wilayah</th>
            <th>Foto</th>
            <th width="100px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($rumah as $value): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($value['nama_kk']) ?></td>
              <td><?= htmlspecialchars($value['nomor_ktp']) ?></td>
              <td><?= htmlspecialchars($value['alamat']) ?></td>
              <td><?= htmlspecialchars($value['coordinat']) ?></td>
              <td><?= htmlspecialchars($value['jenis_bantuan']) ?></td>
              
              <!-- Menampilkan Wilayah Administrasi -->
              <td>
                <?php
                  // Mencari nama wilayah berdasarkan id_wilayah
                  $wilayah_name = '';
                  foreach ($wilayah as $wilayah_data) {
                      if ($wilayah_data['id_wilayah'] == $value['id_wilayah']) {
                          $wilayah_name = $wilayah_data['nama_wilayah'];
                          break;
                      }
                  }
                  echo htmlspecialchars($wilayah_name);
                ?>
              </td>

              <!-- Menampilkan Foto Rumah -->
              <td>
                <?php if ($value['foto']): ?>
                  <img src="<?= base_url('foto/' . $value['foto']) ?>" alt="Foto Rumah" width="100">
                <?php else: ?>
                  <span>No Photo</span>
                <?php endif; ?>
              </td>

              <td class="text-center">
                <a href="<?= base_url('Rumah/Edit/' . $value['id_rumah']) ?>" class="btn btn-sm btn-warning btn-flat" title="Edit">
                  <i class="fas fa-pencil-alt"></i>
                </a>
                <a href="<?= base_url('Rumah/Delete/' . $value['id_rumah']) ?>" onclick="return confirm('Yakin Hapus Data...?')" class="btn btn-sm btn-danger btn-flat" title="Hapus">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </div>
  </div>
</div>

<div class="col-md-12">
  <div id="map" style="width: 100%; height: 600px;"></div>
</div>

<script>
  // Tile Layers for background maps
  var peta1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  });

  var peta2 = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors, Tiles style by Humanitarian OpenStreetMap Team hosted by OpenStreetMap France'
  });

  var peta3 = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; OpenStreetMap contributors, SRTM | Map style &copy; OpenTopoMap (CC-BY-SA)'
  });

  var peta4 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; CartoDB',
    subdomains: 'abcd',
    maxZoom: 19
  });

  var peta5 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Tiles &copy; Esri — Source: Esri, Earthstar Geographics',
    maxZoom: 19
  });

  var peta6 = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; CartoDB',
    subdomains: 'abcd',
    maxZoom: 19
  });

  // Initialize the map
  var map = L.map('map', {
    center: [<?= $web['coordinat_wilayah'] ?>],  // Coordinates for initial view
    zoom: <?= $web['zoom_view'] ?>,  // Zoom level
    layers: [peta1]  // Initial tile layer
  });

  var baseMaps = {
    'Streets': peta1,
    'OpenStreetMap.HOT': peta2,
    'OpenTopoMap': peta3,
    'Carto Light': peta4,
    'Esri Satellite': peta5,
    'Carto Dark': peta6
  };

  L.control.layers(baseMaps).addTo(map);

  // Add GeoJSON data for regions (wilayah)
  <?php foreach ($wilayah as $value): ?>
    var geojsonData = <?= json_encode($value['geojson']) ?>;
    var regionColor = '<?= $value['warna'] ?>';  // Color for the region from the database
    
    try {
      // Add the GeoJSON region with the specified color
      L.geoJSON(JSON.parse(geojsonData), {
        style: function (feature) {
          return {
            fillColor: regionColor,  // Use the color from the 'warna' field
            color: regionColor,  // Border color
            weight: 1,
            opacity: 1,
            fillOpacity: 0.5
          };
        }
      })
      .bindPopup("<b><?= htmlspecialchars($value['nama_wilayah']) ?></b>")
      .addTo(map);
    } catch (error) {
      console.error("Error parsing GeoJSON for <?= htmlspecialchars($value['nama_wilayah']) ?>:", error);
    }
  <?php endforeach; ?>

  // Add markers for houses (rumah)
  <?php foreach ($rumah as $value): ?>
    var coords = <?= json_encode(explode(',', $value['coordinat'])) ?>;
    var lat = parseFloat(coords[0]);
    var lng = parseFloat(coords[1]);

    // Get id_keterangan from rumah data
    var idKeterangan = <?= json_encode($value['id_keterangan']) ?>;

    // Determine marker icon based on id_keterangan
    var markerImage = '';
    if (idKeterangan == 1) {  // id_keterangan 1 is SV.png (Verified)
      markerImage = 'SV.png';
    } else if (idKeterangan == 2) {  // id_keterangan 2 is MV.png (Not Verified)
      markerImage = 'MV.png';
    }

    var markerUrl = '<?= base_url('marker/') ?>' + markerImage;  // Marker image URL

    // Add marker with the correct icon
    L.marker([lat, lng], {
      icon: L.icon({
        iconUrl: markerUrl,
        iconSize: [35, 41],  // Marker size
        iconAnchor: [12, 41],  // Marker anchor point
        popupAnchor: [1, -34]  // Popup position
      })
    })
    .addTo(map)
    .bindPopup("<b><?= htmlspecialchars($value['nama_kk']) ?></b><br><?= htmlspecialchars($value['alamat']) ?><br><?= htmlspecialchars($value['jenis_bantuan']) ?>");
  <?php endforeach; ?>

</script>

<script>
  $(function () {
    $('#example2').DataTable({
      paging: true,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true,
    });
  });
</script>

