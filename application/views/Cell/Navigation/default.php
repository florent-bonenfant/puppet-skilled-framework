<?php
$modules = $this->fetch('modules');
?>
<!-- Sidebar: account and menu -->
<input type="checkbox" id="sidenav-token">
<label for="sidenav-token" class="Sidenav-overlay"></label>
<section class="Sidenav">
    <header class="Sidenav-header">
        <img class="Sidenav-header-icon" src="<?=$this->asset->getImageLink('favicon.png')?>" alt="Application icon">
<?php /* LANGUAGE SELECTION ?>
<div class="Sidenav-header-lang dropdown">
<button class="btn btn-inverse btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<?= html_escape($this->fetch('languages')[$this->fetch('current_language')]) ?>
</button>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
<?php
foreach ($this->fetch('languages') as $key => $label) :
?>
<?= anchor('miscellaneous/changelanguage/'.$key, $label, ['class' => 'dropdown-item'. (($this->fetch('current_language') === $key)? ' active' : '')]) ?>
<?php
endforeach; */
?>
            </div>
        </div>
        <h2 class="Sidenav-header-title"><?=app()->config->item('name', 'site_settings')?></h2>
    </header>
    <aside class="Sidenav-account">
        <div class="Sidenav-account-wrap">
    <img class="Sidenav-account-logo" src="<?=$this->asset->getImageLink('logo-gmc.png')?>" alt="<?=lang('general_label_company_logo')?>">
            <div class="dropdown">
                <button class="Sidenav-account-name dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?=html_escape($this->fetch('user')->first_name . ' ' . $this->fetch('user')->last_name)?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?=anchor('frontoffice/profile', lang('navigation_account'), ['class' => 'dropdown-item'])?>
                    <?php if (route_is_accessible('backoffice.user.connect_as')): ?>
                        <div class="dropdown-divider"></div>
                        <?=anchor(config_item('front_base_url') . '/borrow_customer', lang('navigation_borrow_customer'), ['data-ajax-url' => site_url('miscellaneous/generateadmintoken'), 'class' => 'dropdown-item js-borrow-customer-link'])?>
                    <?php endif;?>
                    <div class="dropdown-divider"></div>
                    <?=anchor('authentication/logout', lang('navigation_logout'), ['class' => 'dropdown-item'])?>
                </div>
            </div>
        </div>
    </aside>
    <nav class="Sidenav-nav">

        <?php if (
    route_is_accessible('backoffice.configuration.*')
    ||
    route_is_accessible('backoffice.user.*')
    ||
    route_is_accessible('backoffice.customer.*')
    ||
    route_is_accessible($modules['log']->permission)
): ?>
        <h2><?=lang('navigation_backoffice')?></h2>
        <ul>
            <?php if (route_is_accessible('backoffice.configuration.*')): ?>
            <li>
                <h3><?=lang('navigation_backoffice_configuration')?></h3>
                <ul>
                    <?=navigation_anchor('backoffice/configuration/setting', lang('navigation_backoffice_setting'))?>
                    <?=navigation_anchor('backoffice/configuration/content_simple', lang('navigation_backoffice_content_simple'))?>
                    <?=navigation_anchor('backoffice/configuration/page', lang('navigation_backoffice_page'))?>
                    <?=navigation_anchor('backoffice/configuration/email', lang('navigation_backoffice_email'))?>
                    <?=navigation_anchor('backoffice/configuration/notification', lang('navigation_backoffice_notification'))?>
                    <?=navigation_anchor('backoffice/configuration/role', lang('navigation_backoffice_role'))?>
                    <?=navigation_anchor('backoffice/configuration/tooltip', lang('navigation_backoffice_tooltip'))?>
                    <?=navigation_anchor('backoffice/configuration/banner', lang('navigation_backoffice_banner'))?>
                    <?=navigation_anchor('backoffice/configuration/carrier', lang('navigation_backoffice_carrier'))?>
                    <?=navigation_anchor('backoffice/configuration/maintenance', lang('navigation_backoffice_maintenance'))?>
                </ul>
            </li>
            <?php endif;?>
            <?=navigation_anchor('backoffice/user', lang('navigation_backoffice_user'))?>
            <?=navigation_anchor('backoffice/customer', lang('navigation_backoffice_customer'))?>
            <?=navigation_anchor('backoffice/modules/log', $modules['log']->name, '', $modules['log']->permission)?>
        </ul>
        <?php endif;?>

        <?php if (route_is_accessible('backoffice.modules.*')): ?>
        <h2><?=lang('navigation_modules')?></h2>
        <ul>
            <li>
                <h3><?=$modules['order_invoices']->name?></h3>
                <ul>
                    <?=navigation_anchor('backoffice/modules/invoice', $modules['invoice']->name, '', $modules['invoice']->permission)?>
                    <?=navigation_anchor('backoffice/modules/order', $modules['order']->name, '', $modules['order']->permission)?>
                    <?=navigation_anchor('backoffice/modules/shipping', $modules['shipping']->name, '', $modules['shipping']->permission)?>
                    <?=navigation_anchor('backoffice/modules/shipping_slips', $modules['shipping_slips']->name, '', $modules['shipping_slips']->permission)?>
                    <?=navigation_anchor('backoffice/modules/tracking', $modules['tracking']->name, '', $modules['tracking']->permission)?>
                </ul>
                <?=navigation_anchor('backoffice/modules/payment', $modules['payment']->name, '', $modules['payment']->permission)?>
            </li>
            <li>
                <h3><?=$modules['contract']->name?></h3>
                <ul>
                    <?=navigation_anchor('backoffice/modules/contrat', $modules['contrat']->name, '', $modules['contrat']->permission)?>
                    <?=navigation_anchor('backoffice/modules/furniture', $modules['furniture']->name, '', $modules['furniture']->permission)?>
                </ul>
            </li>
            <?=navigation_anchor('backoffice/modules/cgv', $modules['cgv']->name, '', $modules['cgv']->permission)?>
            <?=navigation_anchor('backoffice/modules/commercial_condition', $modules['commercial_condition']->name, '', $modules['commercial_condition']->permission)?>
            <?=navigation_anchor('backoffice/modules/message', $modules['message']->name, '', $modules['message']->permission)?>
            <li>
                <h3><?=$modules['application']->name?></h3>
                <ul>
                    <?=navigation_anchor('backoffice/modules/affiliation', $modules['affiliation']->name, '', $modules['affiliation']->permission)?>
                    <?=navigation_anchor('backoffice/modules/application', lang('navigation_backoffice_application'), '', $modules['application']->permission)?>
                </ul>
            </li>
        </ul>
        <?php endif;?>

    </nav>
    <footer class="Sidenav-footer">
        <?php if (!empty($this->fetch('footer_nav'))): ?>
        <ul>
            <?php foreach ($this->fetch('footer_nav') as $nav): ?>
            <li>
                <?=anchor(
                    $nav['uri'],
                    lang_libelle($nav['label'])
                )?>
            </li>
            <?php endforeach;?>
        </ul>
        <?php endif;?>
        <p>© <?=date('Y')?> <a href="<?=app()->config->item('credits_website', 'site_settings')?>" rel="nofollow" target="_blank"><?=app()->config->item('name', 'site_settings')?></a></p>
        <p><?=sprintf(lang('general_made_by'), '<a href="https://www.globalis-ms.com" rel="nofollow" target="_blank">GLOBALIS</a>')?></p>
    </footer>
</section>
