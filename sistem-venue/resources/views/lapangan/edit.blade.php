<form action="{{ route('lapangan.update', $lapangan->id_lapangan) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Nama Lapangan</label>
        <input type="text" name="nama_lapangan" value="{{ $lapangan->nama_lapangan }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Jenis Permukaan</label>
        <input type="text" name="jenis_permukaan" value="{{ $lapangan->jenis_permukaan }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Ukuran</label>
        <input type="text" name="ukuran" value="{{ $lapangan->ukuran }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Status Lapangan</label>
        <select name="status_lapangan" class="form-control" required>
            <option value="Baik" {{ $lapangan->status_lapangan == 'Baik' ? 'selected' : '' }}>Baik</option>
            <option value="Perbaikan" {{ $lapangan->status_lapangan == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
</form>