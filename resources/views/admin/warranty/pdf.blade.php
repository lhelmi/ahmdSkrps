
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Detail Garansi</h4>
	</center>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
                <th>Nama</th>
                <th>Produk</th>
                <th>Kontak</th>
                <th>Tanggal Pembelian</th>
                {{-- <th>Persyaratan Pembelian</th>
                <th>Bukti Pembelian</th> --}}
                <th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			@php
                $no = 1;
            @endphp
            @foreach ($data as $warranty)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $warranty->nama_user }}</td>
                    <td>{{ $warranty->nama_product }}</td>
                    <td>{{ $warranty->contact }}</td>
                    <td>{{ $warranty->purchase_date }}</td>
                    {{-- <td>
                        <img src="{{ '/'.$warranty->requirements }}" width="150px" height="154px" id="image">
                    </td>
                    <td>
                        <img src="{{ '/'.$warranty->receipt }}" width="150px" height="154px" id="image">
                    </td> --}}
                    <td>{{ $warranty->status }}</td>
                </tr
            @endforeach

		</tbody>
	</table>

</body>
</html>
