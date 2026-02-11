<?php
    $name = $this->fetch('name');
    $defaults = [
        'name'  => $name,
        'class' => 'form-control js-wysiwyg-editor',
        'id'    => preg_replace('/[^A-Za-z0-9\_\-]/', '_', $name),
    ];
    $value = set_value($name, $this->fetch('default_value'));
    $extra = ($this->fetch('extra')?:[]);
    $defaults = $extra + $defaults;
    if (form_error($name)) {
        $defaults['class'] .= ' invalid';
    }
?>
<textarea <?= _attributes_to_string($defaults) ?>><?= $value ?></textarea>
<?= form_error($name, '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>') ?>

<?php
    $this->asset->enqueueScript('../plugins/trumbowyg/dist/trumbowyg.min.js');
    $this->asset->enqueueScript('../plugins/trumbowyg/dist/langs/fr.min.js');
    $this->asset->enqueueStyle('../plugins/trumbowyg/dist/ui/trumbowyg.min.css');
    $this->asset->enqueueInlineScriptStart();
?>
    <script>
    $(document).ready(function(){
        $('.js-wysiwyg-editor').trumbowyg({
            lang: 'fr',
            btns: ['bold', 'italic', 'underline', 'link'],
            autogrow: true,
            removeformatPasted: true
        });
    });
    </script>
<?php $this->asset->enqueueInlineScriptEnd(); ?>


