@extends('partials.main')

@section('MainContent')
  <div class="page-heading">
    <h3>Ketersediaan Alat</h3>
    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
      <i class="bi bi-arrow-left"></i> Kembali
    </button>
  </div>

  @php
      $totalStok = $totalDipinjam = $totalTerpesan = $totalSisa = 0;

      foreach ($ketersediaan as $row) {
          $stok     = (int) ($row->stok ?? $row->jumlah_alat ?? 0);
          $dipinjam = (int) ($row->dipinjam ?? 0);
          $terpesan = (int) ($row->terpesan ?? $row->jumlah_dipesan ?? 0);
          $sisa     = max($stok - $dipinjam, 0);

          $totalStok     += $stok;
          $totalDipinjam += $dipinjam;
          $totalTerpesan += $terpesan;
          $totalSisa     += $sisa;
      }
  @endphp

  {{-- ====== CARD RINGKASAN ====== --}}
  <div class="row mt-3">
      <div class="col-lg-3 col-md-6 col-12 mb-3">
          <div class="card h-100">
              <div class="card-body d-flex align-items-center">
                  <div class="stats-icon bg-primary text-white me-3">
                      <i class="bi bi-box-seam fs-4"></i>
                  </div>
                  <div>
                      <h6 class="text-muted mb-1">Total Stok</h6>
                      <h4 class="mb-0 fw-bold">{{ $totalStok }}</h4>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12 mb-3">
          <div class="card h-100">
              <div class="card-body d-flex align-items-center">
                  <div class="stats-icon bg-warning text-white me-3">
                      <i class="bi bi-arrow-left-right fs-4"></i>
                  </div>
                  <div>
                      <h6 class="text-muted mb-1">Sedang Dipinjam</h6>
                      <h4 class="mb-0 fw-bold">{{ $totalDipinjam }}</h4>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12 mb-3">
          <div class="card h-100">
              <div class="card-body d-flex align-items-center">
                  <div class="stats-icon bg-info text-white me-3">
                      <i class="bi bi-calendar-event fs-4"></i>
                  </div>
                  <div>
                      <h6 class="text-muted mb-1">Terpesan (Periode)</h6>
                      <h4 class="mb-0 fw-bold">{{ $totalTerpesan }}</h4>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-lg-3 col-md-6 col-12 mb-3">
          <div class="card h-100">
              <div class="card-body d-flex align-items-center">
                  <div class="stats-icon bg-success text-white me-3">
                      <i class="bi bi-check2-circle fs-4"></i>
                  </div>
                  <div>
                      <h6 class="text-muted mb-1">Sisa Tersedia</h6>
                      <h4 class="mb-0 fw-bold">{{ $totalSisa }}</h4>
                  </div>
              </div>
          </div>
      </div>
  </div>
  {{-- ====== /CARD RINGKASAN ====== --}}

  <div class="card mt-3">
    <div class="card-body table-responsive">
      <table class="table table-sm table-bordered">
        <thead>
          <tr>
            <th>Alat</th>
            <th>Stok</th>
            <th>Dipinjam</th>
            <th>Terpesan (Periode)</th>
            <th>Sisa</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($ketersediaan as $row)
              @php
                  $stok     = (int) ($row->stok ?? $row->jumlah_alat ?? 0);
                  $dipinjam = (int) ($row->dipinjam ?? 0);
                  $terpesan = (int) ($row->terpesan ?? $row->jumlah_dipesan ?? 0);
                  $sisaNow  = max($stok - $dipinjam, 0);
              @endphp

              <tr @class(['table-warning' => $sisaNow === 0])>
                  <td>{{ $row->nama_alat }}</td>
                  <td>{{ $stok }}</td>
                  <td>{{ $dipinjam }}</td>
                  <td>{{ $terpesan }}</td>
                  <td>{{ $sisaNow }}</td>
              </tr>
          @empty
              <tr>
                  <td colspan="5" class="text-center text-muted">Tidak ada data.</td>
              </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
