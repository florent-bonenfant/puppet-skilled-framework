<?php
    $content = $this->fetch('content');
?>

<div style="background-color: #f0f0f0; padding: 15px;">
    <div style="max-width: 650px; margin: 0 auto; font-family: RobotoCondensed, arial, sans-serif; background-color: #fff; padding: 15px 30px; text-align: center;">
        <div style="margin-bottom: 30px;">
            <img src="<?= config_item('base_url').'/images/logo-gmc.png'; ?>" height="80" style="margin: 15px;" />
        </div>
        <div style="font-size: 12px; color: #222;">
            <?= $content; ?>
            <p style="margin-top: 30px;">Guinot - Mary Cohr</p>
        </div>
    </div>
</div>
