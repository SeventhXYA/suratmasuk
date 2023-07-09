@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Rencana Kerja</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $sub }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th style="width:1rem;">No</th>
                                    <th style="width:1rem;">Lihat</th>
                                    <th style="width:1rem;">Mulai Kegiatan</th>
                                    <th style="width:1rem;">Selesai Kegiatan</th>
                                    <th>Rencana</th>
                                    <th>Lokasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rencanakerja as $rk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <button type="button" class="btn btn-outline-secondary btn-icon btn-xs"
                                                data-bs-toggle="modal" data-bs-target="#lihatSurat-{{ $rk->id }}"><i
                                                    data-feather="eye" class="icon-sm"></i>
                                            </button>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($rk->start_date)->format('d-M-Y H:i') }}</td>
                                        {{-- <td>{{ $rk->tgl_surat }}</td> --}}
                                        <td>{{ \Carbon\Carbon::parse($rk->end_date)->format('d-M-Y H:i') }}</td>
                                        <td>
                                            <?php
                                            $num_char = 30;
                                            $text = $rk->rencana;
                                            if (strlen($text) > $num_char) {
                                                $text = substr($text, 0, $num_char) . '...';
                                            }
                                            echo $text;
                                            ?>
                                        </td>
                                        <td>{{ $rk->lokasi }}</td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="lihatSurat-{{ $rk->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalScrollableTitle">
                                                        Detail Rencana Kerja</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="btn-close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col mb-3">
                                                        <label class="form-label fw-bold">Mulai
                                                            Kegiatan</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ \Carbon\Carbon::parse($rk->start_date)->format('d-M-Y H:i') }}"
                                                            readonly style="background-color: #f5f5f5;" />
                                                    </div>
                                                    <div class="col mb-3">
                                                        <label class="form-label fw-bold">Selesai Kegiatan</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ \Carbon\Carbon::parse($rk->end_date)->format('d-M-Y H:i') }}"
                                                            readonly style="background-color: #f5f5f5;" />
                                                    </div>
                                                    <div class="col mb-3">
                                                        <label class="form-label fw-bold">Rencana</label>
                                                        <textarea class="form-control" maxlength="255" rows="8" readonly style="background-color: #f5f5f5;">{{ $rk->rencana }}</textarea>
                                                    </div>
                                                    <div class="col mb-3">
                                                        <label class="form-label fw-bold">Lokasi</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $rk->lokasi }}" readonly
                                                            style="background-color: #f5f5f5;" />
                                                    </div>
                                                    <div class="col mb-3">
                                                        <label class="form-label fw-bold">Kategori</label><br>
                                                        @if ($rk->kategori == 1)
                                                            <span class="badge bg-danger text-white">Luar Daerah Luar
                                                                Provinsi</span>
                                                        @elseif($rk->kategori == 2)
                                                            <span class="badge bg-primary text-white">Luar Daerah Dalam
                                                                Provinsi</span>
                                                        @elseif($rk->kategori == 3)
                                                            <span class="badge bg-success text-white">Dalam Daerah Dalam
                                                                Kabupaten</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script>
        @if (Session::has('success'))
            window.onload = () => showSwal('custom-position', '{{ Session::get('success') }}')
        @endif

        document.querySelectorAll('form[name="delete"]').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault()
                Swal.fire({
                    title: 'Apa anda yakin?',
                    text: "Setelah data dihapus, data tidak bisa dikembalikan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit()
                    }
                });
            });
        });
    </script>
@endpush
