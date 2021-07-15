<?php

include('database.php');

  include_once('tbs_class.php');

include_once('tbs_plugin_opentbs.php');



$pid = $_GET['pid'];

$did = $_GET['did'];

$sqloa = mysqli_query($con,"SELECT * FROM surat_masuk JOIN disposisi on disposisi.id_suratmasuk=surat_masuk.id LEFT JOIN pegawai on disposisi.pegawai=pegawai.id where surat_masuk.id = $pid and disposisi.id = $did");



$i=0;

while($row = mysqli_fetch_array($sqloa))

{

    $pengirimbag = $row['pengirimbag'];

    $noagenda = $row['noagenda'];

    $nosurat = $row['nosurat'];

    $disposisike = $row['nama'];

    $isidisposisi = $row['isidisposisi'];

    $perihal = $row['perihal'];

     $tglsurat = date('d-m-Y',strtotime($row['tglsurat']));

    $tglterima = date('d-m-Y',strtotime($row['tglditerima']));

}



$TBS = new clsTinyButStrong;

$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);

$TBS->LoadTemplate('lembardisposisi.docx');

$pengirimbag = $pengirimbag;

$noagenda = $noagenda;

$nosurat = $nosurat;

$disposisike = $disposisike;

$isidisposisi = $isidisposisi;

$perihal = $perihal;

$tglsurat = $tglsurat;

$tglterima = $tglterima;



  //$TBS->Show();

$TBS->Show(OPENTBS_DOWNLOAD, 'disposisi'.$id.'.docx');

?>