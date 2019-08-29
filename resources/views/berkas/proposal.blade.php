<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Proposal</title>
</head>

<style>
    .b-a{
        border: solid black 1px;
    }

    .b-l{
        border-left: solid black 1px;
    }

    .b-r{
        border-right: solid black 1px;
    }

    .b-t{
        border-top: solid black 1px;
    }

    .b-b{
        border-bottom: solid black 1px;
    }
</style>

<body style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;font-size:11px">
    {{-- {{ dd($groupPengajuan) }} --}}
<div style="margin:0 auto;text-align: center;max-width:700px;font-size:13px"><b>RINCIAN BIAYA PENGUJIAN {{ strtoupper(implode($groupPengujian,', ').' '.$pengajuan['data_pemohon']['nama_perusahaan'].' '.$bulan.' '.$tahun ) }} </b></div>
<br>
<br>
<table class="b-a" border="0" style="width:95%;border-collapse:collapse">
    <thead>
        <tr>
            <td style="text-align:center" class="b-a"><b>NO</b></td>
            <td style="text-align:center" colspan="2" class="b-a"><b> JENIS PENGUJIAN </b></td>
            <td style="text-align:center" colspan="3" class="b-a"><b>JML/HARGA</b></td>
            <td style="text-align:center"  class="b-a"><b>NILAI</b></td>
            <td style="text-align:center" style="width:100px" class="b-a"><b>JUMLAH</b></td>
        </tr>
        <tr>
            <td style="text-align:center" class="b-a">1</td>
            <td style="text-align:center" colspan="2" class="b-a">2</td>
            <td style="text-align:center" colspan="3" class="b-a">3</td>
            <td style="text-align:center" class="b-a">4</td>
            <td style="text-align:center" class="b-a">5</td>
        </tr>
    </thead>
    <tbody>
        @php
            $jumlah_pengujian = 0;
        @endphp
        @foreach ($pengajuan['data_pengujian'] as $item => $value)
            <tr>
                <td class="b-r" style="width:5px"><b>{{chr(65 + $item)}}</b></td>
                <td class="b-r" colspan="2"><b>{{ $value['group'] }}</b></td>
                <td ></td>
                <td ></td>
                <td class="b-r"></td>
                <td class="b-r"></td>
                <td class="b-r"></td>
            </tr>
            @foreach ($value['parameter'] as $key => $parameter)
                <tr>
                    <td class="b-r"></td>
                    <td style="width:5px">{{$key+1}}</td>
                    <td class="b-r" style="width:200px" >{{ $parameter['parameter'] }}</td>
                    <td style="width:70px">titik sampling</td>
                    <td style="width:5px;text-align:center">{{ $parameter['jumlah_titik'] }} </td>
                    <td class="b-r" style="width:90px" >Rp. <span style="float:right;margin-right:5px">{{ number_format($parameter['biaya']) }}</span></td>
                    <td class="b-r" style="width:90px">Rp. <span style="float:right;margin-right:5px">{{ number_format($parameter['total']) }}</span></td>
                    <td></td>
                </tr>
            @endforeach
            <tr>
                <td class="b-r"></td>
                <td></td>
                <td class="b-r"></td>
                <td ></td>
                <td ></td>
                <td class="b-r"></td>
                <td class="b-r"></td>
                {{-- <td class="b-r"></td> --}}
                <td>Rp. <span style="float:right;margin-right:5px"><b>{{number_format($value['total'])}}</b></span></td>
            </tr>
            @php
                $jumlah_pengujian += $value['total'];
            @endphp
        @endforeach
        <tr>
            <td class="b-a" style="text-align:center" colspan="7"><b>Jumlah biaya pengujian</b></td>
            <td class="b-a" style="width:100px">Rp. <span style="float:right;margin-right:5px"><b>{{number_format($jumlah_pengujian)}}</b></span></td>
        </tr>
        @php
           $_item = $item;
           $jumlah_lain_lain = 0;
        @endphp
        @if ($pengajuan['biaya_tambahan'])
            <tr>
                <td class="b-r"><b>{{chr(65 + $_item + 1)}}</b></td>
                <td colspan="2" class="b-r"><b>BIAYA LAIN LAIN</b></td>
                <td ></td>
                <td></td>
                <td class="b-r"></td>
                <td class="b-r"></td>
                <td class="b-r"></td>
            </tr>
            @foreach ($pengajuan['biaya_tambahan']['daftar_biaya'] as $key => $item)
                <tr>
                    <td class="b-r"></td>
                    <td style="width:5px" >{{$key+1}}</td>
                    <td class="b-r">{{ $item['nama_biaya'].' '.$item['jumlah_orang'].' orang'}} <b>x</b> {{ $item['jumlah'].' hari'  }}</td>
                    <td>Orang/hari</td>
                    <td style="text-align:center">{{ $item['jumlah_orang'] * $item['jumlah'] }} </td>
                    <td class="b-r" >Rp. <span style="float:right;margin-right:5px">{{ number_format($item['biaya']) }}</span></td>
                    <td class="b-r" >Rp. <span style="float:right;margin-right:5px">{{ number_format($item['total']) }}</span></td>
                    <td></td>
                </tr>
                @php
                    $jumlah_lain_lain += $item['total'];
                @endphp
            @endforeach
        <tr>
            <td class="b-a" style="text-align:center" colspan="7"><b>Jumlah biaya lain - lain</b></td>
            <td class="b-a">Rp. <span style="float:right;margin-right:5px"><b>{{number_format($jumlah_lain_lain)}}</b></span></td>
        </tr>
        @endif
        <tr>
            <td class="b-a" style="text-align:center" colspan="7"><b>TOTAL BIAYA</b></td>
            <td class="b-a">Rp. <span style="float:right;margin-right:5px"><b>{{number_format($pengajuan['grand_total'])}}</b></span></td>
        </tr>
    </tbody>
</table>
<div style="margin-top:10px"><b><i>Terbilang : {{ terbilang($pengajuan['grand_total']) }} rupiah.-</i></b></div>
<div style="text-align: center;padding-left:70%">Makassar, {{ date('d') }} {{ namaBulan(date('m')) }} {{ date('Y') }}</div>
<div style="text-align: center;padding-left:70%"><b>Plh. Kabid Pelayanan Teknis, </b></div>
<br>
<br>
<br>
<br>
<div style="text-align: center;padding-left:70%"><b><u>{{ $kepalaBidang->nama_lengkap }} </u></b></div>
<div style="text-align: center;padding-left:70%"><b>NIP: {{ $kepalaBidang->nip }} </b></div>
</body>
</html>