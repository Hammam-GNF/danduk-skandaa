@extends('kepsek.layout.main')
@section('title', 'Daftar Kelas')
@section('content')

    <div class="container-fluid py-0 mt-4">
        <div class="row mt-3">
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-xl-12 col-sm-5 mb-xl-0 mb-4">
                        <div class="card" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-50">
                                        <div class="numbers">
                                            <h5 class="font-weight-bolder">DAFTAR KELAS</h5>
                                            <div class="card mt-3">
                                                <div class="card-body px-0 pt-0 pb-2">
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-bordered table-striped align-items-center"
                                                            id="daftarkelas">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th class="text-center">No</th>
                                                                    <th>Nama Kelas</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($kelas->whereIn('kelas_tingkat', ['X', 'XI', 'XII']) as $x)
                                                                    <tr>
                                                                        <td class="text-center">{{ $loop->iteration }}
                                                                        </td>
                                                                        <td>{{ $x->kelas_tingkat }} -
                                                                            {{ $x->jurusan->kode_jurusan }} -
                                                                            {{ $x->rombel }} ({{ $x->jurusan->nama_jurusan }} )</td>
                                                                    </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const thajaranSelects = document.querySelectorAll('.thajaran-select');

            thajaranSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const thajaranId = this.value;
                    const modalId = this.id.replace('thajaran', '');
                    const jurusanSelect = document.querySelector(`#jurusan_id${modalId}`);
                    // const wakelSelect = document.querySelector(`#wakel_id${modalId}`);

                    if (thajaranId) {
                        // Fetch Jurusan data
                        fetch(`/admin/datamaster/kelas/jurusan/${thajaranId}`)
                            .then(response => response.json())
                            .then(data => {
                                let options = '<option value="">--Pilih Jurusan--</option>';
                                data.jurusan.forEach(jurusan => {
                                    options +=
                                        `<option value="${jurusan.id}" ${jurusan.id == jurusanSelect.dataset.selected ? 'selected' : ''}>${jurusan.kode_jurusan} - ${jurusan.nama_jurusan}</option>`;
                                });
                                jurusanSelect.innerHTML = options;
                            })
                            .catch(error => console.error('Error fetching jurusan data:', error));

                        // Fetch Wakel data
                        fetch(`/admin/datamaster/kelas/wakel/${thajaranId}`)
                            .then(response => response.json())
                            .then(data => {
                                let options = '<option value="">--Pilih Wali Kelas--</option>';
                                data.wakel.forEach(wakel => {
                                    options +=
                                        `<option value="${wakel.id}" ${wakel.id == wakelSelect.dataset.selected ? 'selected' : ''}>${wakel.nama_wakel}</option>`;
                                });
                                wakelSelect.innerHTML = options;
                            })
                            .catch(error => console.error('Error fetching wakel data:', error));
                    } else {
                        // Clear Jurusan and Wakel if no thajaran_id selected
                        jurusanSelect.innerHTML = '<option value="">--Pilih Jurusan--</option>';
                        wakelSelect.innerHTML = '<option value="">--Pilih Wali Kelas--</option>';
                    }
                });

                // Trigger change event on page load to set initial values
                const initialThajaranId = select.value;
                if (initialThajaranId) {
                    select.dispatchEvent(new Event('change'));
                }
            });
        });
    </script>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#daftarkelas').DataTable();
    });
</script>
@endpush