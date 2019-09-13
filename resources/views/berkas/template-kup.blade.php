<table border="1">
    <thead>
        <tr>
            <td rowspan="2">NO</td>
            <td rowspan="2" colspan="2">Pengujian </td>
            <td rowspan="2">Jumlah Titik</td>
            <td colspan="2">Kondisi Peralatan</td>
            <td colspan="2">Kelengkapan Reagensia</td>
            <td colspan="2">Beban pekerjaan laboratorium</td>
            <td rowspan="2">Spesifikasi Metode</td>
        </tr>
        <tr>
            <td>Rusak</td>
            <td>Tidak Rusak</td>
            <td>Lengkap</td>
            <td>Tidak Lengkap</td>
            <td>Overload</td>
            <td>Tidak Overload</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengajuan['data_pengujian'] as $item => $value)
        <tr>
            <td>{{chr(65 + $item)}}</td>
            <td colspan="10">{{ $value['group'] }}</td>
        </tr>
            @foreach ($value['parameter'] as $key => $parameter)
            <tr>
                <td></td>
                <td >{{$key+1}}</td>
                <td >{{ $parameter['parameter'] }}</td>
                <td >{{ $parameter['jumlah_titik'] }}</td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>