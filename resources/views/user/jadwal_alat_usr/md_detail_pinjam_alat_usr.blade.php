{{-- DETAIL JASA --}}
<div class="modal fade" id="detail_alat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Pesanan Pinjam Alat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fs-6" id="tgl_pengajuan"></p>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Peminjam</th>
                                <th>Tanggal & Jam Pinjam</th>
                                
                                <th>Keperluan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td id="nama_user1"></td>
                                <td id="tanggal"></td>
                                <td id="catatan"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive m-3">
                    <table>
                        <thead>
                            <tr>
                                <td>Status Persetujuan</td>
                                <td>:</td>
                                <td id="status_persetujuan"></td>
                            </tr>
                            
                            <tr>
                                <td>Status Peminjaman</td>
                                <td>:</td>
                                <td id="status_pinjam"></td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="form-group">
                    <label for="catatan_admin">Keterangan Admin :</label>
                    <textarea class="form-control" name="catatan_admin" id="catatan_admin" cols="30" rows="3" readonly></textarea>
                </div>


                <div class="table-responsive">
                    <table class="table table-bordered" id="tbLampiran">
                        <thead>
                            <tr>
                                <th>Jaminan</th>
                                <th>KONDISI ALAT SEBELUM DIGUNAKAN</th>
                                <th>KONDISI ALAT SETELAH DIGUNAKAN</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <a id="link-foto-jaminan" target="_blank" href="" class="my-3">
                                        <img id="foto_jaminan1" style="max-width:200px;max-height:200px"/>
                                    </a>
                                </td>

                                <td id="show_kondisi_awal" style="display:none;">
                                    <a id="link-img-kondisi-awal" target="_blank" href="" class="my-3">
                                        <img id="img_kondisi_awal" style="max-width:200px;max-height:200px"/>
                                    </a>
                                </td>
                                <td id="show_form_kondisi_awal">
                                  <form id="form_kondisi_awal" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="kondisi_awal" id="input_kondisi_awal" class="form-control" required>
                                    <p class="my-3">
                                      <img id="img_kondisi_awal_preview" style="display:none;max-width:200px;max-height:200px"/>
                                    </p>
                                    <button type="button" class="btn btn-success" id="btn_simpan_awal">Simpan</button>
                                  </form>
                                </td>

                                <td id="show_kondisi_akhir" style="display:none;">
                                    <a id="link-img-kondisi-akhir" target="_blank" href="" class="my-3">
                                        <img id="img_kondisi_akhir" style="max-width:200px;max-height:200px"/>
                                    </a>
                                </td>                                
                                <td id="show_form_kondisi_akhir">
                                  <form id="form_kondisi_akhir" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="kondisi_akhir" id="input_kondisi_akhir" class="form-control" required>
                                    <p class="my-3">
                                      <img id="img_kondisi_akhir_preview" style="display:none;max-width:200px;max-height:200px"/>
                                    </p>
                                    <button type="button" class="btn btn-success" id="btn_simpan_akhir">Simpan</button>
                                  </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- <div class="form-group" id="hasil_review" style="display: none">
                    <label for="rating">Review Anda :</label>
                    <h5><span id="show_rating">
                            <div class="rating">
                                <input type="radio" id="star55" name="rating2" value="5" />
                                <label for="star5" title="5 stars">&#9733;</label>
                                <input type="radio" id="star44" name="rating2" value="4" />
                                <label for="star4" title="4 stars">&#9733;</label>
                                <input type="radio" id="star33" name="rating2" value="3" />
                                <label for="star3" title="3 stars">&#9733;</label>
                                <input type="radio" id="star22" name="rating2" value="2" />
                                <label for="star2" title="2 stars">&#9733;</label>
                                <input type="radio" id="star11" name="rating2" value="1" />
                                <label for="star1" title="1 star">&#9733;</label>
                            </div>
                            - <span id="show_review"></span>
                        </span>
                    </h5>
                </div> -->
                <div class="form-group" id="review_view" style="display:none">
                  <label class="mb-2">Review Anda:</label>
                  <div id="review_stars" class="mb-2" style="font-size:20px; color:#f6c000;"></div>
                  <div id="review_text_view" class="text-light"></div>
                </div>

                <div class="form-group" id="form_review" style="display:none">
                    <label class="mb-2">Beri Penilaian:</label>
                    <div class="rating mb-2">
                        <input type="radio" id="rv5" name="rating" value="5"><label for="rv5">&#9733;</label>
                        <input type="radio" id="rv4" name="rating" value="4"><label for="rv4">&#9733;</label>
                        <input type="radio" id="rv3" name="rating" value="3"><label for="rv3">&#9733;</label>
                        <input type="radio" id="rv2" name="rating" value="2"><label for="rv2">&#9733;</label>
                        <input type="radio" id="rv1" name="rating" value="1"><label for="rv1">&#9733;</label>
                    </div>
                    <textarea id="review_text" class="form-control mb-2" rows="2" placeholder="Tulis kesan/masukan (opsional)"></textarea>
                    <button type="button" class="btn btn-primary" id="btn_save_review">Simpan Review</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success d-none" id="btn_selesai">Selesai</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function($){
  if (!$.fn.repeater) { $.fn.repeater = function(){ return this; }; }

  let harga;
  let no_wa = null;
  window.id_pesanan_alat = null;

  const $dok = $(document);

  function previewImg(input, outSel) {
    const f = input?.files?.[0]; if (!f) return;
    const r = new FileReader();
    r.onload = e => $(outSel).attr('src', e.target.result).show();
    r.readAsDataURL(f);
  }

  $dok.on('change', '#input_kondisi_awal',  function(){ previewImg(this, '#img_kondisi_awal_preview');  });
  $dok.on('change', '#input_kondisi_akhir', function(){ previewImg(this, '#img_kondisi_akhir_preview'); });

  $dok.on('submit', '#form_kondisi_awal, #form_kondisi_akhir', e => { e.preventDefault(); });

  function setUploadEndpoint(id) {
    $('#form_kondisi_awal, #form_kondisi_akhir').attr({ action: '#', 'data-pid': id });
  }

  window.show_byID = function (id) {
    window.id_pesanan_alat = id;

    $('#show_form_kondisi_awal, #show_form_kondisi_akhir').hide();

    $.getJSON("{{ route('pinjam-alat.detail',['id'=>'__ID__']) }}".replace('__ID__', id))
      .done(function (res) {
        $("#tgl_pengajuan").text("Pengajuan pada : " + (res.tgl_pinjam || "-"));
        $("#nama_user1").text(res.username || "-");
        $("#tanggal").text(`${res.tgl_pinjam || "-"} / ${res.waktu_mulai || "-"} - ${res.waktu_selesai || "-"}`);
        $("#catatan").text(res.ket_keperluan || "-");
        $("#catatan_admin").val(res.ket_admin || "");

        const sPers = res.status_persetujuan==='Y' ? ['Disetujui','success']
                    : res.status_persetujuan==='N' ? ['Ditolak','danger']
                    : ['Pengajuan','warning'];
        $("#status_persetujuan").html(`<span class="badge bg-${sPers[1]}">${sPers[0]}</span>`);
        const sPinj = res.status_pengembalian==='Y' ? ['Telah Selesai','success'] : ['Proses','warning'];
        $("#status_pinjam").html(`<span class="badge bg-${sPinj[1]}">${sPinj[0]}</span>`);

        if (res.url_foto_jaminan) {
          $("#foto_jaminan1").attr("src", res.url_foto_jaminan).show();
          $("#link-foto-jaminan").attr("href", res.url_foto_jaminan).show();
        } else {
          $("#foto_jaminan1, #link-foto-jaminan").attr("src","").attr("href","").hide();
        }

        if (res.url_kondisi_awal) {
          $("#img_kondisi_awal").attr("src", res.url_kondisi_awal).show();
          $("#link-img-kondisi-awal").attr("href", res.url_kondisi_awal).show();
          $("#show_kondisi_awal").show();
        } else {
          $("#img_kondisi_awal").attr("src","").hide();
          $("#link-img-kondisi-awal").attr("href","").hide();
          $("#show_kondisi_awal").hide();
        }

        if (res.url_kondisi_akhir) {
          $("#img_kondisi_akhir").attr("src", res.url_kondisi_akhir).show();
          $("#link-img-kondisi-akhir").attr("href", res.url_kondisi_akhir).show();
          $("#show_kondisi_akhir").show();
        } else {
          $("#img_kondisi_akhir").attr("src","").hide();
          $("#link-img-kondisi-akhir").attr("href","").hide();
          $("#show_kondisi_akhir").hide();
        }

        const isReturned = res.status_pengembalian === "Y";
        const hasReview  = (res.rating != null) || (res.review && res.review.trim().length > 0);

        $("#form_review").toggle(isReturned && !hasReview);
        $("#review_view").toggle(isReturned && hasReview);

        if (hasReview) {
          const n = Number(res.rating || 0);
          $("#review_stars").html('&#9733;'.repeat(n) + '&#9734;'.repeat(5-n));
          $("#review_text_view").text(res.review || '(tanpa komentar)');
        } else {
          $('input[name="rating"]').prop('checked', false);
          $('#review_text').val('');
        }

        bootstrap.Modal.getOrCreateInstance(document.getElementById('detail_alat')).show();
      })
      .fail(function(){
        Swal.fire({icon:'error', title:'Oops...', text:'Gagal memuat data'});
      });
  };

  // ==== SIMPAN KONDISI (awal/akhir) ====
  function simpanKondisi(formId, btnId){
    const pid = window.id_pesanan_alat;
    if (!pid) return alert('ID pesanan tidak valid.');
    return alert('Upload kondisi hanya bisa dilakukan oleh UKMBS.');
    const fd = new FormData(document.getElementById(formId));
    fd.append('_token', "{{ csrf_token() }}");

    $(btnId).prop('disabled', true).text('Menyimpan...');
    $.ajax({ url, method:'POST', data:fd, processData:false, contentType:false })
      .done(() => { $(btnId).prop('disabled', false).hide(); show_byID(pid); })
      .fail(xhr => { alert('Gagal: ' + (xhr.responseJSON?.message || xhr.statusText)); $(btnId).prop('disabled', false).text('Simpan'); });
  }

  $dok.on('click', '#btn_simpan_awal',  e => { e.preventDefault(); simpanKondisi('form_kondisi_awal',  '#btn_simpan_awal');  });
  $dok.on('click', '#btn_simpan_akhir', e => { e.preventDefault(); simpanKondisi('form_kondisi_akhir', '#btn_simpan_akhir'); });

  document.getElementById('detail_alat').addEventListener('hidden.bs.modal', function () {
    $('#img_kondisi_awal_preview, #img_kondisi_akhir_preview').attr('src','').hide();
  });

  $dok.on('click', '#btn_selesai', function(){
    const pid = window.id_pesanan_alat;
    $.post("{{ route('pinjam-alat.selesai', ['id'=>'__ID__']) }}".replace('__ID__', pid),
      {_token:"{{ csrf_token() }}"},
      () => show_byID(pid)
    );
  });

  $dok.on('click', '#btn_save_review', function(){
    const $btn = $(this);
    const pid = window.id_pesanan_alat;
    const rating = $('input[name="rating"]:checked').val();
    const review = $('#review_text').val();

    if (!rating) return Swal.fire({icon:'warning',title:'Pilih rating dulu ya.'});

    $btn.prop('disabled', true).text('Menyimpan...');

    $.post("{{ route('pinjam-alat.review', ['id'=>'__ID__']) }}".replace('__ID__', pid),
      {_token:"{{ csrf_token() }}", rating, review}
    ).done(() => {
        Swal.fire({icon:'success', title:'Terima kasih!', text:'Review kamu sudah tersimpan.'});
        show_byID(pid);
    }).fail(xhr => {
        Swal.fire({icon:'error', title:'Gagal', text: (xhr.responseJSON?.message || 'Server error')});
    }).always(() => {
        $btn.prop('disabled', false).text('Simpan Review');
    });
  });

})(jQuery);
</script>
@endpush