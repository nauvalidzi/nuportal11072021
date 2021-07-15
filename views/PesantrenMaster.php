<?php

namespace PHPMaker2021\nuportal;

// Table
$pesantren = Container("pesantren");
?>
<?php if ($pesantren->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_pesantrenmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($pesantren->kode->Visible) { // kode ?>
        <tr id="r_kode">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->kode->caption() ?></td>
            <td <?= $pesantren->kode->cellAttributes() ?>>
<span id="el_pesantren_kode">
<span<?= $pesantren->kode->viewAttributes() ?>>
<?= $pesantren->kode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pesantren->nama->Visible) { // nama ?>
        <tr id="r_nama">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->nama->caption() ?></td>
            <td <?= $pesantren->nama->cellAttributes() ?>>
<span id="el_pesantren_nama">
<span<?= $pesantren->nama->viewAttributes() ?>>
<?= $pesantren->nama->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pesantren->propinsi->Visible) { // propinsi ?>
        <tr id="r_propinsi">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->propinsi->caption() ?></td>
            <td <?= $pesantren->propinsi->cellAttributes() ?>>
<span id="el_pesantren_propinsi">
<span<?= $pesantren->propinsi->viewAttributes() ?>>
<?= $pesantren->propinsi->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pesantren->kabupaten->Visible) { // kabupaten ?>
        <tr id="r_kabupaten">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->kabupaten->caption() ?></td>
            <td <?= $pesantren->kabupaten->cellAttributes() ?>>
<span id="el_pesantren_kabupaten">
<span<?= $pesantren->kabupaten->viewAttributes() ?>>
<?= $pesantren->kabupaten->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pesantren->telpon->Visible) { // telpon ?>
        <tr id="r_telpon">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->telpon->caption() ?></td>
            <td <?= $pesantren->telpon->cellAttributes() ?>>
<span id="el_pesantren_telpon">
<span<?= $pesantren->telpon->viewAttributes() ?>>
<?= $pesantren->telpon->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pesantren->nspp->Visible) { // nspp ?>
        <tr id="r_nspp">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->nspp->caption() ?></td>
            <td <?= $pesantren->nspp->cellAttributes() ?>>
<span id="el_pesantren_nspp">
<span<?= $pesantren->nspp->viewAttributes() ?>>
<?= $pesantren->nspp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pesantren->nspptglmulai->Visible) { // nspptglmulai ?>
        <tr id="r_nspptglmulai">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->nspptglmulai->caption() ?></td>
            <td <?= $pesantren->nspptglmulai->cellAttributes() ?>>
<span id="el_pesantren_nspptglmulai">
<span<?= $pesantren->nspptglmulai->viewAttributes() ?>>
<?= $pesantren->nspptglmulai->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pesantren->nspptglakhir->Visible) { // nspptglakhir ?>
        <tr id="r_nspptglakhir">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->nspptglakhir->caption() ?></td>
            <td <?= $pesantren->nspptglakhir->cellAttributes() ?>>
<span id="el_pesantren_nspptglakhir">
<span<?= $pesantren->nspptglakhir->viewAttributes() ?>>
<?= $pesantren->nspptglakhir->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pesantren->yayasan->Visible) { // yayasan ?>
        <tr id="r_yayasan">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->yayasan->caption() ?></td>
            <td <?= $pesantren->yayasan->cellAttributes() ?>>
<span id="el_pesantren_yayasan">
<span<?= $pesantren->yayasan->viewAttributes() ?>>
<?= $pesantren->yayasan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pesantren->_userid->Visible) { // userid ?>
        <tr id="r__userid">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->_userid->caption() ?></td>
            <td <?= $pesantren->_userid->cellAttributes() ?>>
<span id="el_pesantren__userid">
<span<?= $pesantren->_userid->viewAttributes() ?>>
<?= $pesantren->_userid->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pesantren->validasi->Visible) { // validasi ?>
        <tr id="r_validasi">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->validasi->caption() ?></td>
            <td <?= $pesantren->validasi->cellAttributes() ?>>
<span id="el_pesantren_validasi">
<span<?= $pesantren->validasi->viewAttributes() ?>>
<?= $pesantren->validasi->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pesantren->validator->Visible) { // validator ?>
        <tr id="r_validator">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->validator->caption() ?></td>
            <td <?= $pesantren->validator->cellAttributes() ?>>
<span id="el_pesantren_validator">
<span<?= $pesantren->validator->viewAttributes() ?>>
<?= $pesantren->validator->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pesantren->validasi_pusat->Visible) { // validasi_pusat ?>
        <tr id="r_validasi_pusat">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->validasi_pusat->caption() ?></td>
            <td <?= $pesantren->validasi_pusat->cellAttributes() ?>>
<span id="el_pesantren_validasi_pusat">
<span<?= $pesantren->validasi_pusat->viewAttributes() ?>>
<?= $pesantren->validasi_pusat->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($pesantren->validator_pusat->Visible) { // validator_pusat ?>
        <tr id="r_validator_pusat">
            <td class="<?= $pesantren->TableLeftColumnClass ?>"><?= $pesantren->validator_pusat->caption() ?></td>
            <td <?= $pesantren->validator_pusat->cellAttributes() ?>>
<span id="el_pesantren_validator_pusat">
<span<?= $pesantren->validator_pusat->viewAttributes() ?>>
<?= $pesantren->validator_pusat->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
