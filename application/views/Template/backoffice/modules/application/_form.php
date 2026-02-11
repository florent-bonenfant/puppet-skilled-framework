<?php
$preprendId = uniqid();
$item = $this->fetch('item');
$emptyUpdater = new stdClass();
$emptyUpdater->first_name = "";
$emptyUpdater->last_name = "";
$creator = clone $emptyUpdater;
$updator = clone $emptyUpdater;

if ($item) :
    if ($item->creator) {
        $creator = $item->creator;
    }
    if ($item->updator) {
        $updator = $item->updator;
    }
?>
    <div class="wrap-contributor">
        <p><?= sprintf(lang('application_contributor_add'), '<b>' . $creator->first_name ?? "" . '</b>', '<b>' . $creator->last_name ?? "" . '</b>', '<b>' . user_date_format($item->created_at, false) . '</b>') ?></p>
        <p><?= sprintf(lang('application_contributor_edit'), '<b>' . $updator->first_name ?? ""  . '</b>', '<b>' . $updator->last_name ?? "" . '</b>', '<b>' . user_date_format($item->updated_at, false) . '</b>') ?></p>
    </div>
<?php
endif;
?>
<?= form_open($this->fetch('validator'), current_url()) ?>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('application_label_content') ?></h2>
    <div class="card-block">
        <?= $this->element(
            'form/block_input',
            [
                'name' => 'label',
                'input_element' => 'form/input',
                'label' => 'lang:application_label_label',
                'id' => $preprendId . 'label',
                'default_value' => $item->label ?? null,
            ]
        ) ?>
</fieldset>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('application_label_links') ?></h2>
    <div class="card-block">
        <?php

        foreach ($this->fetch('platforms') as $platform) {

            echo $this->element(
                'form/title',
                [
                    'level' => 4,
                    'label' => 'lang:application_label_' . $platform,
                ]
            );

            foreach ($this->fetch('companies') as $company) {
                $company_name = strtolower(url_title($company->name, 'underscore'));

                echo $this->element(
                    'form/block_input',
                    [
                        'name'          => 'link_' . $platform . '_' . $company_name,
                        'input_element' => 'form/input',
                        'label'         => $company->name,
                        'id'            => 'label_' . $platform . '_' . $company_name,
                        'default_value' => $item->{'link_' . $platform . '_' . $company_name} ?? null,
                        'extra'         => [
                            'placeholder'   => lang('application_label_enter_url'),
                        ],
                    ]
                );
            }
        }
        ?>
    </div>
</fieldset>

<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('application_custom_links_label') ?></h2>
    <div class="card-block">

        <div class="form-group">
            <p><?= lang('application_link_delete_reminder') ?></p>

            <?php foreach ($this->fetch('companies') as $key => $company) : ?>
                <?php $company_name = strtolower(url_title($company->name, 'underscore')); ?>
                <div class="custom-row">
                    <?= $this->element(
                        'form/title',
                        [
                            'level' => 5,
                            'label' => $company->name,
                        ]
                    ) ?>

                    <?php
                    $k = 0;
                    foreach ($this->fetch('custom_links')[$company_name] as $key => $link) :
                    ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $this->element(
                                    'form/block_input',
                                    [
                                        'name' => 'custom_platforms_' . $company_name . '_' . $k,
                                        'input_element' => 'form/input',
                                        'label' => 'lang:application_label_custom_platforms',
                                        'id' => 'custom-platform-' . $company_name,
                                        'default_value' => $this->fetch('custom_links')[$company_name][$key]['platform'] ?? '',
                                        'extra' => [
                                            'placeholder' => lang('application_label_enter_plateform'),
                                        ]
                                    ]
                                ) ?>
                            </div>
                            <div class="col-sm-8">
                                <?= $this->element(
                                    'form/block_input',
                                    [
                                        'name' => 'custom_links_' . $company_name . '_' . $k,
                                        'input_element' => 'form/input',
                                        'label' => 'lang:application_label_custom_links',
                                        'id' => 'custom-link-' . $company_name,
                                        'default_value' => $this->fetch('custom_links')[$company_name][$key]['link'] ?? '',
                                        'extra' => [
                                            'placeholder' => lang('application_label_enter_url'),
                                        ]
                                    ]
                                ) ?>
                            </div>
                        </div>
                    <?php
                        $k++;
                    endforeach;
                    ?>

                </div>
                <div class="form-group text-right">
                    <input type="button" class="btn add-custom-links" value="<?= lang('application_add_custom_link') ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</fieldset>
<fieldset class="card mb-4">
    <h2 class="card-header bg-inverse text-white"><?= lang('application_label_public') ?></h2>
    <div class="card-block">
        <?php
        $error = '';
        $class_wrapper = 'form-group';
        if (($error = form_error('families[]', '<div class="form-control-feedback"><i class="material-icons">warning</i> ', '</div>'))) {
            $class_wrapper .= ' has-danger';
        }
        ?>
        <div class="<?= $class_wrapper ?>">
            <?php
            $default_values = [];
            if ($item) {
                foreach ($item->families as $fam) {
                    $default_values[] = $fam->id;
                }
            }
            ?>
            <?= $this->element(
                'form/label',
                [
                    'label' => 'lang:application_label_families',
                    'field' => 'families[]',
                    'extra' => ['for' => $preprendId . 'families']
                ]
            ) ?>
            <?= $this->element(
                'form/checkbox',
                [
                    'name' => 'families[]',
                    'default_value' => $default_values,
                    'options' => array_pluck($this->fetch('families'), 'name', 'id')
                ]
            ) ?>
        </div>
    </div>
</fieldset>

<?= $this->element('form/submit', ['label' => 'lang:general_action_save']) ?>
</form>
<?php
//$this->asset->enqueueStyle('flatpickr.css');
$this->asset->enqueueScript('locales.js');
