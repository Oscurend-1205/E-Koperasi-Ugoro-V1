<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Import Data Member & Simpanan</title>
    @include('admin.partials.layout_styles')
    @include('admin.partials.theme')
</head>
<body style="font-family: sans-serif; padding: 20px;">

    <h2>Upload Data Anggota (Excel)</h2>

    @if(session('success'))
        <div style="background: #dcfce7; color: #16a34a; padding: 10px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #dc2626; padding: 10px; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form Upload File -->
    <form action="{{ route('member.import.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 15px;">
            <label for="file">Pilih File (.xlsx, .xls, .csv):</label><br>
            <input type="file" name="file" id="file" required accept=".xlsx,.xls,.csv" style="margin-top: 5px;">
        </div>
        <button type="submit" style="background: #2563eb; color: white; border: none; padding: 8px 15px; cursor: pointer;">
            Mulai Import
        </button>
    </form>

</body>
</html>
