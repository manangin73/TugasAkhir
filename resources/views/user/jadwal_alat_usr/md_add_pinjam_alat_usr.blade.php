{{-- TAMBAH JADWAL ALAT --}}
<div class="modal fade" id="add_pinjam_alat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_header"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-7">
                        <label for="id_user">Nama Peminjam</label>
                        <input type="text" class="form-control" name="nama_user" id="nama_user"
                            value="{{ Auth::user()->username }}" readonly required>
                    </div>
                    <div class="col-5">
                        <label for="no_wa">Nomor WhatsApp <small class="text-danger fst-italic"></label>
                        <input type="number" class="form-control" name="no_wa" id="no_wa"
                            value="{{ Auth::user()->no_wa }}" readonly required>
                    </div>


                    <input type="hidden" value="{{ Auth::user()->id_user }}" name="id_user" id="id_user">
                </div>

                <form class="repeater">
                    <div data-repeater-list="list_alat">
                        <div data-repeater-item>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="id_alat">Alat Yang Dipinjam</label>
                                    <select name="id_alat" class="form-control" onchange="selectAlat()">
                                        <option value="">Pilih Alat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="jumlah">Jumlah Dipinjam</label>
                                    <input type="number" id="jumlah" name="jumlah" class="form-control" onchange="selectAlat()">
                                        
                                    </input>
                                </div>
                            </div>
                            <input data-repeater-delete type="button" value="Delete"/>
                        </div>
                    </div>
                    <input data-repeater-create type="button" value="Tambah Alat"/>
                </form>

                <div class="form-group">
                    <label for="tgl_pinjam">Tanggal Peminjaman <small class="text-danger fst-italic">*harap pilih
                                alat dahulu</small></label>
                    <input type="date" class="form-control" id="tgl_pinjam" required >
                    <span id="alert_tgl"></span>
                </div>

                <div class="form-group">
                    <label for="tgl_kembali">Tanggal Dikembalikan <small class="text-danger fst-italic">*max 2 hari (48jam)</small></label>
                    <input type="date" class="form-control" id="tgl_kembali" required >
                    <span id="alert_tgl"></span>
                </div>

                <div class="form-group row">
                    <div class="col-6">
                        <label for="waktu_mulai">Waktu Mulai</label>
                        <select class="form-control" id="waktu_mulai" required></select>
                    </div>
                    <div class="col-6">
                        <label for="waktu_selesai">Waktu Selesai</label>
                        <select class="form-control" id="waktu_selesai" required></select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="ket_keperluan">Keperluan Peminjaman</label>
                    <textarea class="form-control" name="ket_keperluan" id="ket_keperluan" cols="30" rows="5" required></textarea>
                </div>

                <div class="form-group">
                    <label for="foto_jaminan">Jaminan (KTP/KTM) (Format: JPG/PNG) <small class="text-danger fst-italic">(max: 1
                                mb)</small></label>
                    <input type="file" class="image-preview-filepond form-control" id="foto_jaminan" **required**>
                    <p class="my-3 output"><img id="output"
                                style="display: none; max-width: 200px; max-height: 200px;" />
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="BtnJadwalAlat">Simpan</button>
                <span id="btnSimpanLoading" style="display:none;">
                    <img src="{{ asset('assets/img/loading.gif') }}" alt="Loading..." style="width:20px;" />
                </span>
            </div>
        </div>
    </div>
</div>

@push('script')

    <script src="{{ asset('assets/jquery.repeater/jquery.repeater.js') }}"></script>

    <script>
    $(document).ready(function () {
        $('.repeater').repeater({
        initEmpty: true,
        show: function () {
            const currentRow = $(this);

            $.ajax({
            url: `{{ url('list_data_alat') }}`,
            method: 'get',
            data: { "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function(response) {
                const select = currentRow.find('select');
                select.empty();
                select.append(`<option value="">-- Pilih Alat --</option>`);
                $.each(response, function(key, val) {
                select.append(`<option value="${val.id_alat}">${val.nama_alat}</option>`);
                });
            },
            });

            currentRow.slideDown();
        },
        hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
            $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: true
        });
    });
    </script>

    <script>
    async function cekSisaPeriode(start, end, mulai, selesai) {
        const qs = new URLSearchParams({
            start,
            end: end || start,
            mulai:  (mulai  || '00:00'),
            selesai:(selesai || '23:59')
        });
        const res = await $.getJSON(`{{ route('ketersediaan.data') }}?${qs.toString()}`);
        const map = {};
        (res.data || []).forEach(r => {
            const key = String(r.id_alat ?? r.id);
            map[key] = Number((r.sisa ?? r.sisa_periode ?? 0));
        });
        return map;
    }

    $(document).ready(function() {
        $.ajax({
            url: `{{ url('list_data_alat') }}`,
            method: 'get',
            data: { "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function(response) {
                $.each(response, function(key, val) {
                $("#id_alat").append(`<option value="${val.id_alat}">${val.nama_alat}</option>`)
                })
            },
        });

            function populateTimeOptions(elementId, startTime, endTime, intervalMinutes) {
            var $selectElement = $('#' + elementId);
            var currentTime = startTime;
            while (currentTime <= endTime) {
                var option = $('<option></option>').val(currentTime).text(currentTime);
                $selectElement.append(option);
                var [hours, minutes] = currentTime.split(':').map(Number);
                minutes += intervalMinutes;
                if (minutes >= 60) { hours += 1; minutes -= 60; }
                currentTime = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;
            }
        }
        populateTimeOptions('waktu_mulai', '08:00', '17:00', 10);
        populateTimeOptions('waktu_selesai', '08:00', '17:00', 10);
    });

    // function cek_tanggal_kosong() {
        //         // ... (kode di-comment)
        // }

    function selectAlat() {
        const selectedOption = $("#id_alat option:selected");
        const biaya_perawatan = selectedOption.data('harga');
        // $("#biaya_perawatan").val(biaya_perawatan);
    }

    $("#foto_jaminan").on("change", function() { previewImg(this, '#output'); });
    function previewImg(input, outputId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
            $(outputId).attr('src', e.target.result).css('display', 'block');
        }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function openModal(action, id_pesanan_pinjam_alat = null) {
        const modalEl = document.getElementById('add_pinjam_alat');
        const modal   = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();

        const $title   = $("#title_header");
        const $btnSave = $("#BtnJadwalAlat");

        const $tgl_pinjam  = $('#tgl_pinjam');
        const $tgl_kembali = $('#tgl_kembali');
        const $wMulai      = $('#waktu_mulai');
        const $wSelesai    = $('#waktu_selesai');
        const $ket         = $('#ket_keperluan');
        const $foto        = $('#foto_jaminan');
        const $output      = $('#output');

        if (action === 'add') {
        $title.text("Tambah Pengajuan Jadwal Alat");
        $btnSave.text("Simpan");

        try { $('.repeater').repeaterVal({ 'list-alat': [] }); } catch(e) {}
        $('[data-repeater-item]').remove();
        $('[data-repeater-create]').trigger('click');

        $tgl_pinjam.val('');
        $tgl_kembali.val('');
        $wMulai.val('');
        $wSelesai.val('');
        $ket.val('');
        $foto.val('');
        $output.hide().attr('src','');

        $btnSave.off('click').on('click', function () {
            saveJadwalAlat('add');
        });
        } else if (action === 'edit') {
        $title.text("Edit Pengajuan Jadwal Alat");
        $btnSave.text("Ubah");

        show_byId_jadwalPesanan(id_pesanan_pinjam_alat);

        $btnSave.off('click').on('click', function () {
            saveJadwalAlat('edit', id_pesanan_pinjam_alat);
        });
        }
    }

    function populateTimeOptions(elementId, startTime, endTime, intervalMinutes) {
        var $select = $('#' + elementId);
        $select.empty().append('<option value="">-- pilih waktu --</option>');
        var currentTime = startTime;
        while (currentTime <= endTime) {
            $select.append($('<option></option>').val(currentTime).text(currentTime));
            var [h,m] = currentTime.split(':').map(Number);
            m += intervalMinutes; if (m >= 60) { h++; m -= 60; }
            currentTime = (h<10?'0':'')+h+':' + (m<10?'0':'')+m;
        }
    }

    function show_byId_jadwalPesanan(id_pesanan_pinjam_alat) {
        $.ajax({
            url: `{{ url('/showByid_pesanan_pinjam_alat/${id_pesanan_pinjam_alat}') }}`,
            method: 'POST',
            data: { "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function(response) {
                $('#tgl_pinjam').val(response.tgl_pinjam);
                $('#tgl_kembali').val(response.tgl_kembali);
                $("#waktu_mulai").val(response.waktu_mulai);
                $("#waktu_selesai").val(response.waktu_selesai);
                $("#ket_keperluan").val(response.ket_keperluan);
                // Menampilkan preview foto lama
                $('#output').attr('src', '{{ asset('storage/img_upload/pesanan_jadwal') }}/' + response.foto_jaminan).show();
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan saat memproses data.' });
            }
        });
    }

    // === versi menampilkan NAMA alat saat stok kurang
    async function saveJadwalAlat(action, id) {
        const id_user     = $('#id_user').val();
        const tgl_pinjam    = $('#tgl_pinjam').val();
        const tgl_kembali   = $('#tgl_kembali').val() || $('#tgl_pinjam').val();
        const waktu_mulai   = $('#waktu_mulai').val();
        const waktu_selesai = $('#waktu_selesai').val();
        const ket_keperluan = $('#ket_keperluan').val();
        const no_wa         = $('#no_wa').val();
        // Ambil file foto jaminan
        const foto_jaminan  = $('#foto_jaminan')[0]?.files[0] || null;

        const list_alat = [];
        const namaMap = {};

        $('[data-repeater-item]').each(function () {
            const $sel    = $(this).find('select[name$="[id_alat]"], select[name="id_alat"]');
            const id_alat = $sel.val();
            const nama    = ($sel.find('option:selected').text() || '').trim();
            const jumlah  = $(this).find('input[name$="[jumlah]"], input[name="jumlah"]').val();

            if (id_alat && jumlah && Number(jumlah) > 0) {
                const idStr = String(id_alat);
                list_alat.push({ id_alat: idStr, jumlah: Number(jumlah), nama });
                if (!namaMap[idStr]) namaMap[idStr] = nama || `Alat ID ${idStr}`;
            }
        });

        // 1. Validasi Field Wajib & Daftar Alat
        if (!list_alat.length || !tgl_pinjam || !waktu_mulai || !waktu_selesai || !ket_keperluan) {
            Swal.fire({ icon:'error', title:'Gagal simpan', text:'Lengkapi data & pilih minimal satu alat.' });
            return;
        }

        // 2. 🔥 VALIDASI FOTO JAMINAN (Wajib diisi saat 'add') 🔥
        if (action === 'add' && !foto_jaminan) {
            Swal.fire({ 
                icon: 'error', 
                title: 'Gagal simpan', 
                text: 'Foto Jaminan (KTP/KTM) wajib diisi untuk pengajuan baru.' 
            });
            return; // Hentikan proses jika validasi gagal
        }

        // Lanjutkan ke pengecekan stok/periode
        const sisaMap = await cekSisaPeriode(tgl_pinjam, tgl_kembali, waktu_mulai, waktu_selesai);

        const agregat = {};
        list_alat.forEach(it => {
            const sisa = Number(sisaMap?.[it.id_alat] ?? 0);
            if (it.jumlah > sisa) {
                if (!agregat[it.id_alat]) {
                    agregat[it.id_alat] = { nama: namaMap[it.id_alat] || `Alat ID ${it.id_alat}`, diminta: 0, sisa };
                }
                agregat[it.id_alat].diminta += it.jumlah;
                agregat[it.id_alat].sisa = sisa;
            }
        });

        const gagalList = Object.values(agregat);
        if (gagalList.length) {
            const rows = gagalList
            .map(g => `${g.nama} — sisa: ${g.sisa}, diminta: ${g.diminta}`)
            .join('<br>');
            Swal.fire({ icon:'error', title:'Stok tidak mencukupi', html: rows });
            return;
        }

        // Jika semua validasi lolos, submit form
        submitForm(action, id, {
            id_user, list_alat, tgl_pinjam, tgl_kembali, waktu_mulai, waktu_selesai, ket_keperluan, foto_jaminan, no_wa
        });
    }

    function submitForm(action, id, formDataObj) {
        $("#BtnJadwalAlat").hide();
        $("#btnSimpanLoading").show();

        const formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('id_user', formDataObj.id_user);
        formData.append('tgl_pinjam', formDataObj.tgl_pinjam);
        formData.append('tgl_kembali', formDataObj.tgl_kembali || formDataObj.tgl_pinjam);
        formData.append('waktu_mulai', formDataObj.waktu_mulai);
        formData.append('waktu_selesai', formDataObj.waktu_selesai);
        formData.append('ket_keperluan', formDataObj.ket_keperluan);
        formData.append('no_wa', formDataObj.no_wa);
        if (formDataObj.foto_jaminan) {
            formData.append('foto_jaminan', formDataObj.foto_jaminan);
        }
        (formDataObj.list_alat || []).forEach((row, i) => {
            formData.append(`list_alat[${i}][id_alat]`, row.id_alat);
            formData.append(`list_alat[${i}][jumlah]`, row.jumlah);
        });

        const ajaxUrl = action === "add"
        ? "{{ url('/add_pesanan_pinjam_alat') }}"
        : `{{ url('/edit_pesanan_pinjam_alat/${id}') }}`;

        $.ajax({
            url: ajaxUrl,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                const modalEl = document.getElementById('add_pinjam_alat');
                bootstrap.Modal.getInstance(modalEl)?.hide();
                $('#tableJadwalAlat').DataTable().ajax.reload();
                Swal.fire({ icon: "success", title: response.msg || "Berhasil", timer: 1500, showConfirmButton: false });
            },
            complete: function () {
                $("#BtnJadwalAlat").show();
                $("#btnSimpanLoading").hide();
            },
            error: function (xhr) {
                $("#BtnJadwalAlat").show();
                $("#btnSimpanLoading").hide();
                let msg = "Terjadi kesalahan saat menghubungi server.";
                if (xhr.responseJSON?.message) msg = xhr.responseJSON.message;
                else if (xhr.responseText) msg = xhr.responseText;
                // Cek jika errornya adalah error validasi (status 422)
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    const validationErrors = xhr.responseJSON.errors;
                    // Cek error spesifik untuk foto jaminan dari Server
                    if (validationErrors.foto_jaminan) {
                        msg = 'Error Server: Foto Jaminan ' + validationErrors.foto_jaminan.join(', ');
                    } else {
                        // Gabungkan semua pesan error validasi lainnya
                        msg = Object.values(validationErrors).flat().join('<br>');
                    }
                }
                Swal.fire({ icon: 'error', title: 'Oops...', html: `<pre style="text-align:left;white-space:pre-wrap">${msg}</pre>` });
            }
        });
    }

    document.getElementById('add_pinjam_alat').addEventListener('hidden.bs.modal', function () {
        const $m = $('#add_pinjam_alat');

        $m.find('input[type="date"], input[type="file"], textarea, select').val('');

        $m.find('input')
            .not('[readonly]')
            .not('[type="hidden"]')
            .not('[type="button"]')
            .not('[type="submit"]')
            .not('#nama_user')
            .not('#no_wa')
            .val('');

        $('#foto_jaminan').val('');
        $('#output').attr('src','').hide();
        try { $('.repeater').repeaterVal({ 'list-alat': [] }); } catch (e) {}
        $m.find('[data-repeater-create]').val('Tambah Alat');
        $m.find('[data-repeater-delete]').val('Delete');

        $("#BtnJadwalAlat").show();
        $("#btnSimpanLoading").hide();
    });
    </script>
@endpush