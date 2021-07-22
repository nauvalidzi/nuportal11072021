<?php

include('database.php');;
include('helper.php');
include_once('tbs_class.php');
include_once('tbs_plugin_opentbs.php');



$id = $_GET['id'];

$sqloa = mysqli_query($con,"SELECT p.kode as kode, p.nama as nama,p.jalan as jalan,kl.`name` as desa, kc.`name` as kecamatan, kb.`name` as kabupaten, pv.`name` as provinsi, p.kodepos as kodepos, pp.nama as pengasuh, p.tgl_validasi_pusat FROM `pesantren` p LEFT JOIN pengasuhpppria pp ON p.id = pp.pid LEFT JOIN kelurahans kl ON kl.id=p.desa LEFT JOIN kecamatans kc ON kc.id=p.kecamatan LEFT JOIN kabupatens kb ON kb.id=p.kabupaten LEFT JOIN provinsis pv ON pv.id=p.propinsi where p.id = $id LIMIT 1");

$i=0;

while($row = mysqli_fetch_array($sqloa))

{

    $no_anggota = $row['kode'];

    $nama_pesantren = $row['nama'];

    $alamat = $row['jalan']." ".$row['desa'];

    $kecamatan = $row['kecamatan'];

    $kabupaten = $row['kabupaten'];

    $provinsi = $row['provinsi'];

    $kodepos = $row['kodepos'];

    $pengasuh = $row['pengasuh'];

    $tgl_validasi_masehi = date('d-m-y',strtotime($row['tgl_validasi_pusat']));

    $tgl_validasi_hijriah = date_hijriah($row['tgl_validasi_pusat']);
}

$TBS = new clsTinyButStrong;

$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

$TBS->LoadTemplate('sertifikat.docx');

$no_anggota = $no_anggota;

$nama_pesantren = $nama_pesantren;

$alamat = $alamat;

$kecamatan = $kecamatan;

$kabupaten = $kabupaten;

$provinsi = $provinsi;

$kodepos = $kodepos;

$pengasuh = $pengasuh;

$tgl_validasi_masehi = $tgl_validasi_masehi;

$tgl_validasi_hijriah = $tgl_validasi_hijriah;

  //$TBS->Show();
$TBS->Show(OPENTBS_DOWNLOAD, 'sertifikat_'.$no_anggota.'.docx');

?>