@extends(
    Auth::user()->roles == 'admin' ? 'layout.admin' :
    (Auth::user()->roles == 'hewan' ? 'layout.hewan' : 'layout.default')
)

@section('title', 'Edit Data Hewan')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Data Hewan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('hewan.update', $dataHewan->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" maxlength="16" value="{{ old('nik', $dataHewan->nik) }}">
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $dataHewan->tempat_lahir) }}">
                @error('tempat_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $dataHewan->tanggal_lahir) }}">
                @error('tanggal_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                    <option value="laki-laki" {{ (old('jenis_kelamin', $dataHewan->jenis_kelamin) == 'laki-laki' ? 'selected' : '') }}>Laki-laki</option>
                    <option value="perempuan" {{ (old('jenis_kelamin', $dataHewan->jenis_kelamin) == 'perempuan' ? 'selected' : '') }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat', $dataHewan->alamat) }}">
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="no_kberobat">No. Kartu Berobat</label>
                <input type="text" name="no_kberobat" id="no_kberobat" class="form-control @error('no_kberobat') is-invalid @enderror" value="{{ old('no_kberobat', $dataHewan->no_kberobat) }}">
                @error('no_kberobat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="no_kbpjs">No. Kartu BPJS</label>
                <input type="text" name="no_kbpjs" id="no_kbpjs" class="form-control @error('no_kbpjs') is-invalid @enderror" value="{{ old('no_kbpjs', $dataHewan->no_kbpjs) }}">
                @error('no_kbpjs')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="scan_ktp">Scan KTP</label>
                <input type="file" name="scan_ktp" id="scan_ktp" class="form-control @error('scan_ktp') is-invalid @enderror">
                @error('scan_ktp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($dataHewan->scan_ktp)
                    <div class="mt-2">
                        <small class="text-muted">File yang sudah diunggah: 
                            <a href="{{ asset('storage/' . $dataHewan->scan_ktp) }}" target="_blank">Lihat KTP</a>
                        </small>
                    </div>
                @endif
            </div>
            
            <div class="form-group">
                <label for="scan_kberobat">Scan Kartu Berobat</label>
                <input type="file" name="scan_kberobat" id="scan_kberobat" class="form-control @error('scan_kberobat') is-invalid @enderror">
                @error('scan_kberobat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($dataHewan->scan_kberobat)
                    <div class="mt-2">
                        <small class="text-muted">File yang sudah diunggah: 
                            <a href="{{ asset('storage/' . $dataHewan->scan_kberobat) }}" target="_blank">Lihat Kartu Berobat</a>
                        </small>
                    </div>
                @endif
            </div>
            
            <div class="form-group">
                <label for="scan_kbpjs">Scan BPJS</label>
                <input type="file" name="scan_kbpjs" id="scan_kbpjs" class="form-control @error('scan_kbpjs') is-invalid @enderror">
                @error('scan_kbpjs')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($dataHewan->scan_kbpjs)
                    <div class="mt-2">
                        <small class="text-muted">File yang sudah diunggah: 
                            <a href="{{ asset('storage/' . $dataHewan->scan_kbpjs) }}" target="_blank">Lihat BPJS</a>
                        </small>
                    </div>
                @endif
            </div>
            
            <div class="form-group">
                <label for="scan_kasuransi">Scan Asuransi</label>
                <input type="file" name="scan_kasuransi" id="scan_kasuransi" class="form-control @error('scan_kasuransi') is-invalid @enderror">
                @error('scan_kasuransi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($dataHewan->scan_kasuransi)
                    <div class="mt-2">
                        <small class="text-muted">File yang sudah diunggah: 
                            <a href="{{ asset('storage/' . $dataHewan->scan_kasuransi) }}" target="_blank">Lihat Asuransi</a>
                        </small>
                    </div>
                @endif
            </div>
            
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
                @if (Auth::user()->roles == 'hewan')
                <a href="{{ route('hewan.show', $dataHewan->id) }}" class="btn btn-secondary">Batal</a>
                @endif
                @if (Auth::user()->roles == 'admin' || Auth::user()->roles == 'petugas')
                <a href="{{ route('hewan.index') }}" class="btn btn-secondary">Batal</a>
                @endif
            </div>
        </form>
    </div>
</div>

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}",
        });
    });
</script>
@endif

@endsection

@include('sweetalert::alert')