<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Lapangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Daftar Lapangan Olahraga</h1>
            <a href="{{ route('lapangan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Lapangan</a>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">No</th>
                    <th class="border border-gray-300 px-4 py-2">Nama Lapangan</th>
                    <th class="border border-gray-300 px-4 py-2">Jenis Permukaan</th>
                    <th class="border border-gray-300 px-4 py-2">Ukuran</th>
                    <th class="border border-gray-300 px-4 py-2">Status</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lapangans as $index => $item)
                <tr>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $index + 1 }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $item->nama_lapangan }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $item->jenis_permukaan }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $item->ukuran }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $item->status_lapangan }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <a href="{{ route('lapangan.edit', $item->id_lapangan) }}" class="text-blue-600 mr-2">Edit</a>
                        <form action="{{ route('lapangan.destroy', $item->id_lapangan) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="border border-gray-300 px-4 py-4 text-center text-gray-500">Belum ada data lapangan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>