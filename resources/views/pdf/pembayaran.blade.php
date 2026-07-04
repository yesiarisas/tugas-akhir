<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pembayaran</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
    </style>
</head>
<body>

<h2>Riwayat Pembayaran</h2>
<p>Nama: {{ $anggota->nama }}</p>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Periode</th>
            <th>Nominal</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $d)
        <tr>
            <td>{{ $d->tanggal_bayar }}</td>
            <td>{{ $d->jenis }}</td>
            <td>{{ $d->periode }}</td>
            <td>Rp {{ number_format($d->nominal,0,',','.') }}</td>
            <td>{{ $d->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>