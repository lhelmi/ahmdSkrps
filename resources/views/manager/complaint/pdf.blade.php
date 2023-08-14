
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
		<h5>Detail Keluhan</h4>
	</center>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
                <th>Nama</th>
                <th>Keluhan</th>
                <th>Kritik</th>
                <th>Saran</th>
			</tr>
		</thead>
		<tbody>
			@php
                $no = 1;
            @endphp
            @foreach ($data as $complaint)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $complaint->users_name }}</td>
                    <td>{{ $complaint->complaint }}</td>
                    <td>{{ $complaint->criticism }}</td>
                    <td>{{ $complaint->suggestions }}</td>
                </tr>
            @endforeach

		</tbody>
	</table>

</body>
</html>
