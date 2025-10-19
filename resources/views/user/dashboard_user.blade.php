@extends('partials.main')
@section('MainContent')
    <div class="page-heading">
        <h3>Dashboard User</h3>
        <p>Halo, Selamat datang {{ Auth::user()->username }}!</p>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <strong>Standar Operasional Prosedur (SOP) Alat Musik UKMBSM ITERA</strong>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            
                                            <h4>Prosedur Penyewaan Alat Studio Musik ITERA</h4>
                                            <ol>
                                                <li>Setiap penyewaan alat musik harus menghubungi narahubung divisi Studio dan Inventaris UKMBSM ITERA maksimal **H-5 sebelum hari pemakaian**. (No. WA: 089505177202 a/n Yafi Ahdi atau 081218449390 a/n Margaretha) .</li>
                                                <li>Maksimal penyewaan alat adalah **2 hari** (terhitung 48 jam sejak peminjaman sampai pengembalian alat).</li>
                                                <li>Setiap pengambilan dan pengembalian alat musik tidak melebihi pukul **17.00 WIB**.</li>
                                                <li>Setiap penyewaan harus menyerahkan **jaminan berupa KTP/SIM** setiap meminjam alat studio musik ITERA.</li>
                                                <li>Setiap **kerusakan** pada alat studio harus diganti dengan spesifikasi yang sama. Apabila tidak ada itikad baik atau pertanggungjawaban dari pihak penyewa yang melakukan kerusakan, maka akan diberikan sanksi berupa **blacklist** dari segala bentuk pemakaian studio maupun alat musik.</li>
                                                <li>Alat musik hanya bisa disewa dalam lingkup **sivitas akademika ITERA**.</li>
                                                <li>Setiap penyewaan alat harus diketahui oleh Kepala Divisi Studio dan Inventaris UKMBSM ITERA dan disetujui oleh Ketua Umum UKMBSM ITERA.</li>
                                                <li>Setiap penyewaan alat dikenakan **biaya perawatan**.</li>
                                            </ol>

                                            <hr>

                                            <h4>Tabel Biaya Perawatan Alat</h4>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Alat</th>
                                                            <th>Satuan</th>
                                                            <th>Biaya Perawatan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr><td>1</td><td>Alat full set</td><td>1 set</td><td>Rp.500.000,00</td></tr>
                                                        <tr><td>2</td><td>Gitar elektrik</td><td>1 buah</td><td>Rp.30.000,00</td></tr>
                                                        <tr><td>3</td><td>Bass elektrik</td><td>1 buah</td><td>Rp.30.000,00</td></tr>
                                                        <tr><td>4</td><td>Cajon</td><td>1 buah</td><td>Rp. 15.000,00</td></tr>
                                                        <tr><td>5</td><td>Mixer 6 port</td><td>1 buah</td><td>Rp.50.000,00</td></tr>
                                                        <tr><td>6</td><td>Speaker</td><td>1 buah</td><td>Rp.50.000,00</td></tr>
                                                        <tr><td>7</td><td>Speaker monitor</td><td>1 buah</td><td>Rp.60.000,00</td></tr>
                                                        <tr><td>8</td><td>Amplifire gitar/ DI box</td><td>1 buah</td><td>Rp.50.000,00</td></tr>
                                                        <tr><td>9</td><td>Amplifire Bass / DI box</td><td>1 buah</td><td>Rp.50.000,00</td></tr>
                                                        <tr><td>10</td><td>Amplifire keyboard</td><td>1 buah</td><td>Rp.50.000,00</td></tr>
                                                        <tr><td>11</td><td>Keyboard</td><td>1 buah</td><td>Rp.150.000,00</td></tr>
                                                        <tr><td>12</td><td>Drum akustik</td><td>1 set</td><td>Rp.250.000,00</td></tr>
                                                        <tr><td>13</td><td>Drum elektrik</td><td>1 set</td><td>Rp.200.000,00</td></tr>
                                                        <tr><td>14</td><td>Mic</td><td>1 buah</td><td>Rp.10.000,00</td></tr>
                                                        <tr><td>15</td><td>Stand micbook/</td><td>1 buah</td><td>Rp.5.000,00</td></tr>
                                                        <tr><td>16</td><td>Kabel jack/XLR/AUX</td><td>1 buah</td><td>Rp.5.000,00</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <strong>Sejarah Studio Musik ITERA</strong>
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <strong>Studio Musik ITERA diresmikan pada tanggal 22 Februari 2018 oleh
                                                Alm. Prof. Ir. Ofyar Z Tamin, M.Sc., Ph.D., IPU., yang kala itu menjadi
                                                rektor ITERA.
                                                Studio Musik ITERA dibangun sebagai fasilitas kampus yang menunjang kegiatan
                                                non-akademik seluruh civitas akedemika ITERA. Berlokasi di Gedung D Lantai
                                                3,
                                                tepat di ruangan ujung lantai.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    </div>
            </div>
        </section>
    </div>
@endsection