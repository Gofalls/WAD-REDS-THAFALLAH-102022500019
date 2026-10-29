<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lapangan</title>
    <!-- Tailwind CSS CDN untuk styling otomatis -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Lapangan Baru</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lapangan.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Lapangan</label>
                <input type="text" name="nama_lapangan" class="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Contoh: Lapangan Futsal A">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Jenis Permukaan</label>
                <input type="text" name="jenis_permukaan" class="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Contoh: Rumput Sintetis">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Ukuran</label>
                <input type="text" name="ukuran" class="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Contoh: 25x15">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Status Lapangan</label>
                <select name="status_lapangan" class="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="Baik">Baik</option>
                    <option value="Perbaikan">Perbaikan</option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('lapangan.index') }}" class="text-gray-600 hover:underline">Kembali</a>
                <button type="submit" class="bg-blue-600 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-blue-700 transition">Simpan Data</button>
            </div>
        </form>
    </div>
</body>
</html>