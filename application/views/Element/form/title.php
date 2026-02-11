<?php
$extra = ($this->fetch('extra')?:[]);
$level = !empty($this->fetch('level')) ? $this->fetch('level') : 2;
?>
<h<?= $level ?> <?= _attributes_to_string($extra) ?>><?= lang_libelle($this->fetch('label')) ?><?= set_required_symbol($this->fetch('field')) ?></h<?= $level ?>>
