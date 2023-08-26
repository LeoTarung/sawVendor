@extends('main')
@section('container')
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
        <div class="container-fluid border-bottom">
            <div class="row">
                <div class="col-6">
                    <h2 class=" d-flex justify-content-start">Data Kriteria</h4>
                </div>
                <div class="col-6 d-flex  justify-content-end h-50">
                    @if (Auth::user()->isManager())
                    @else
                        <button class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#tambah"
                            onclick="tambah()"><i class="fa fa-plus"></i> Tambah Data</h4>
                    @endif

                </div>
            </div>
        </div>

        <div class="container-fluid d-flex justify-content-center mt-3">
            <div class="card shadow-sm w-100">
                <div class="card-header bg-primary" style="color:wheat">
                    <i class="fa fa-paperclip"></i></i> Daftar Data Kriteria
                </div>
                <div class="table-responsive">

                    <table class="table m-3 ">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kode Kriteria</th>
                                <th scope="col">Jenis Kriteria</th>
                                <th scope="col">Bobot</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Status</th>
                                <th scope="col"> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($kriteria as $k)
                                <tr>
                                    <td><?= $no ?></td>
                                    <td>{{ $k->kode_kriteria }}</td>
                                    <td>{{ $k->jenis_kriteria }}</td>
                                    <td>{{ $k->bobot * 100 }}%</td>
                                    <td>{{ $k->keterangan }}</td>
                                    <td>{{ $k->status }}</td>
                                    <td>
                                        @if (Auth::user()->isManager())
                                            @if ($k->status == 'ACC')
                                            @else
                                                <button class="btn btn-success"
                                                    onclick="validasi('{{ $k->kode_kriteria }}')">ACC</button>
                                            @endif

                                            <button class="btn btn-info"
                                                onclick="notes('{{ $k->kode_kriteria }}')">Notes</button>
                                        @else
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit"
                                                onclick="edit('{{ $k->kode_kriteria }}')">Edit</button>
                                            <button class="btn btn-danger"
                                                onclick="deleteRecord('{{ $k->kode_kriteria }}')">Hapus</button>
                                        @endif
                                    </td>
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                </tr>
                                <?php $no++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah kriteria --}}
    <div class="modal fade" id="tambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md  ">
            <form action="/kriteria/tambah" method="POST" onSubmit="document.getElementById('submit').disabled=true;">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data</h5>
                        <button type="button" class="btn-danger rounded btn-close" data-bs-dismiss="modal"
                            aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 mb-3">
                                <div class="form-floating">
                                    <label for="kode_kriteria" class="w-50">KODE KRITERIA</label>
                                    <input type="text" class="w-100 w-100   rounded border-primary fw-bold"
                                        id="kode_kriteria" name="kode_kriteria" required readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 mb-3">
                                <div class="form-floating">
                                    <label for="jenis_kriteria " class="w-50">JENIS KRITERIA</label>
                                    <input type="text" class=" w-100    rounded border-primary fw-bold"
                                        id="jenis_kriteria" name="jenis_kriteria" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 mb-3">
                                <div class="form-floating">
                                    <div class="input-group">
                                        <label for="bobot " class="w-50">BOBOT</label>
                                        <input type="number" class=" w-75  rounded border-primary fw-bold"
                                            aria-label="Dollar amount (with dot and two decimal places)" id="bobot"
                                            name="bobot">
                                        <span class="W-25  rounded border-primary input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 mb-3">
                                <div class="form-floating">
                                    <label for="keterangan" class="w-50">KETERANGAN</label>
                                    <select class="form-select w-100  rounded border-primary fw-bold w-75"
                                        id="floatingSelect" aria-label="Floating label select example" id="keterangan"
                                        name="keterangan">
                                        <option selected>--Pilih Item--</option>
                                        <option value="BENEFIT">BENEFIT</option>
                                        <option value="COST">COST</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btn-cancel"
                            data-bs-dismiss="modal">Cancel</button>
                        {{-- <button type="submit" class="btn btn-primary" onclick="redirect()">Lanjutkan</button> --}}
                        <button type="submit" id="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit kriteria --}}
    <div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md  ">
            <form action="/kriteria/edit" method="POST" onSubmit="document.getElementById('submit').disabled=true;">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="staticBackdropLabel">Edit Data</h5>
                        <button type="button" class="btn-danger rounded btn-close" data-bs-dismiss="modal"
                            aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 mb-3">
                                <div class="form-floating">
                                    <label for="kode_kriteria" class="w-50">KODE KRITERIA</label>
                                    <input type="text" class="w-100 w-100   rounded border-primary fw-bold"
                                        id="kode_kriteria_edit" name="kode_kriteria" required readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 mb-3">
                                <div class="form-floating">
                                    <label for="jenis_kriteria " class="w-50">JENIS KRITERIA</label>
                                    <input type="text" class=" w-100    rounded border-primary fw-bold"
                                        id="jenis_kriteria_edit" name="jenis_kriteria" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 mb-3">
                                <div class="form-floating">
                                    <div class="input-group">
                                        <label for="bobot " class="w-50">BOBOT</label>
                                        <input type="number" class=" w-75  rounded border-primary fw-bold"
                                            aria-label="Dollar amount (with dot and two decimal places)" id="bobot_edit"
                                            name="bobot">
                                        <span class="W-25  rounded border-primary input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 mb-3">
                                <div class="form-floating">
                                    <label for="keterangan" class="w-50">KETERANGAN</label>
                                    <select class="form-select w-100  rounded border-primary fw-bold w-75"
                                        id="floatingSelect" aria-label="Floating label select example"
                                        id="keterangan_edit" name="keterangan">
                                        <option selected id="optionCore">BENEFIT </option>
                                        <option value="benefit">BENEFIT</option>
                                        <option value="cost">COST</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btn-cancel"
                            data-bs-dismiss="modal">Cancel</button>
                        {{-- <button type="submit" class="btn btn-primary" onclick="redirect()">Lanjutkan</button> --}}
                        <button type="submit" id="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Notes Fro --}}
    <div class="modal fade" id="ModalNotes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="ModalNotesjudul">Edit Data</h5>
                    <button type="button" class="btn-danger rounded btn-close" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <script>
        function tambah() {
            //buat nambah otomatis id nya
            let count = {{ $kriteria->count() }};
            // console.log(count);
            let id = document.getElementById('kode_kriteria');
            let x = "C" + (count + 1);
            console.log(x);
            id.value = x;
        }

        function edit(kode) {
            $.ajax({
                method: "GET",
                dataType: "json",
                url: "{{ url('/kriteria/edit') }}" + "/" + kode,
                success: function(data) {
                    let kodeEdit = document.getElementById('kode_kriteria_edit');
                    kodeEdit.value = kode;
                    console.log(data);
                    let option = document.getElementById('optionCore');
                    $("#jenis_kriteria_edit").val(data.jenis_kriteria);
                    // document.getElementById('jenis_kriteria_edit').value = data[0].jenis_kriteria;
                    $("#bobot_edit").val((data.bobot * 100));
                    option.innerHTML = data.keterangan;
                }
            })
        }

        function deleteRecord(kode) {
            console.log(kode);
            if (confirm('Apakah anda yakin akan menghapus ini?')) {
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch('/kriteria/' + kode, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-Token': csrfToken
                    }
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        console.log('Delete request failed.');
                    }
                });
            } else {

            }
        }

        function validasi(kode) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan Konfirmasi kriteria tersebut",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    fetch('/validasi/kriteria' + '/' + kode, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-Token': csrfToken
                        }
                    }).then(response => {
                        if (response.ok) {
                            location.reload();
                        } else {
                            console.log('Acc gagal');
                        }
                    });
                }
            })
        }

        function notes(kode) {
            $.get(
                "/partial/modal/notes" + "/" + kode, {},
                function(data) {
                    $("#ModalNotesjudul").html("Notes"); //Untuk kasih judul di modal
                    $("#ModalNotes").modal("show"); //kalo ID pake "#" kalo class pake "."
                    $('#ModalNotes .modal-body').load("/partial/modal/notes" + "/" + kode);
                }
            );
        }
    </script>
@endsection
