<?php

namespace PHPMaker2021\nuportal;

// Table
$user = Container("user");
?>
<?php if ($user->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_usermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($user->namapesantren->Visible) { // namapesantren ?>
        <tr id="r_namapesantren">
            <td class="<?= $user->TableLeftColumnClass ?>"><?= $user->namapesantren->caption() ?></td>
            <td <?= $user->namapesantren->cellAttributes() ?>>
<span id="el_user_namapesantren">
<span<?= $user->namapesantren->viewAttributes() ?>>
<?= $user->namapesantren->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($user->namapendaftar->Visible) { // namapendaftar ?>
        <tr id="r_namapendaftar">
            <td class="<?= $user->TableLeftColumnClass ?>"><?= $user->namapendaftar->caption() ?></td>
            <td <?= $user->namapendaftar->cellAttributes() ?>>
<span id="el_user_namapendaftar">
<span<?= $user->namapendaftar->viewAttributes() ?>>
<?= $user->namapendaftar->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($user->hp->Visible) { // hp ?>
        <tr id="r_hp">
            <td class="<?= $user->TableLeftColumnClass ?>"><?= $user->hp->caption() ?></td>
            <td <?= $user->hp->cellAttributes() ?>>
<span id="el_user_hp">
<span<?= $user->hp->viewAttributes() ?>>
<?= $user->hp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($user->_email->Visible) { // email ?>
        <tr id="r__email">
            <td class="<?= $user->TableLeftColumnClass ?>"><?= $user->_email->caption() ?></td>
            <td <?= $user->_email->cellAttributes() ?>>
<span id="el_user__email">
<span<?= $user->_email->viewAttributes() ?>>
<?= $user->_email->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($user->_username->Visible) { // username ?>
        <tr id="r__username">
            <td class="<?= $user->TableLeftColumnClass ?>"><?= $user->_username->caption() ?></td>
            <td <?= $user->_username->cellAttributes() ?>>
<span id="el_user__username">
<span<?= $user->_username->viewAttributes() ?>>
<?= $user->_username->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($user->passsword->Visible) { // passsword ?>
        <tr id="r_passsword">
            <td class="<?= $user->TableLeftColumnClass ?>"><?= $user->passsword->caption() ?></td>
            <td <?= $user->passsword->cellAttributes() ?>>
<span id="el_user_passsword">
<span<?= $user->passsword->viewAttributes() ?>>
<?= $user->passsword->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($user->grup->Visible) { // grup ?>
        <tr id="r_grup">
            <td class="<?= $user->TableLeftColumnClass ?>"><?= $user->grup->caption() ?></td>
            <td <?= $user->grup->cellAttributes() ?>>
<span id="el_user_grup">
<span<?= $user->grup->viewAttributes() ?>>
<?= $user->grup->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
