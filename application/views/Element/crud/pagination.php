<?php
$pagerResult = $this->fetch('pager_result');
$currentPage = $pagerResult['page'];
$total = $pagerResult['pageCount']?: 1;
$baseUrl = $this->fetch('base_url') ?: current_base_url();
if (!($pagerResult['total'] < min($pagerResult['limit_choices']))) :
?>
<form class="btn-toolbar" action="<?= site_url($baseUrl) ?>" method="get">
    <div class="btn-group hidden-sm-down">
        <?= anchor(
            $baseUrl.'?page=1' . $this->fetch('anchor'),
            '<i class="material-icons">first_page</i>',
            [
                'class' => 'btn btn-secondary' . (($currentPage == 1 || $total == 1)? ' disabled' : ''),
                'title' => lang('general_label_pagination_first_page')
            ]
        ) ?>
        <?= anchor(
            $baseUrl.'?page='. ($currentPage-1) . $this->fetch('anchor'),
            '<i class="material-icons">navigate_before</i>',
            [
                'class' => 'btn btn-secondary' . (($currentPage == 1 || $total == 1)? ' disabled' : ''),
                'title' => lang('general_label_pagination_before')
            ]
        ) ?>
    </div>
    <div class="btn-group hidden-md-up">
        <?= anchor(
            $baseUrl.'?page='. ($currentPage-1) . $this->fetch('anchor'),
            '<i class="material-icons">navigate_before</i>',
            [
                'class' => 'btn btn-secondary' . (($currentPage == 1 || $total == 1)? ' disabled' : ''),
                'title' => lang('general_label_pagination_before')
            ]
        ) ?>
    </div>

    <div class="input-group ml-2 mr-2">
        <input type="text" name="page" class="form-control input-xs text-center js-focus-select js-live-submit" value="<?= $pagerResult['page'] ?>" pattern="^[0-9+]$" />
        <span class="input-group-addon">/ <?= $total ?></span>
    </div>

    <div class="btn-group hidden-md-up">
        <?= anchor(
            $baseUrl.'?page='. ($currentPage+1) . $this->fetch('anchor'),
            '<i class="material-icons">navigate_next</i>',
            [
                'class' => 'btn btn-secondary' . (($currentPage == $total || $total == 1)? ' disabled' : ''),
                'title' => lang('general_label_pagination_next')
            ]
        ) ?>
    </div>
    <div class="btn-group hidden-sm-down">
        <?= anchor(
            $baseUrl.'?page='. ($currentPage+1) . $this->fetch('anchor'),
            '<i class="material-icons">navigate_next</i>',
            [
                'class' => 'btn btn-secondary' . (($currentPage == $total || $total == 1)? ' disabled' : ''),
                'title' => lang('general_label_pagination_next')
            ]
        ) ?>
        <?= anchor(
            $baseUrl.'?page=' . $pagerResult['pageCount'] . $this->fetch('anchor'),
            '<i class="material-icons">last_page</i>',
            [
                'class' => 'btn btn-secondary' . (($currentPage == $total || $total == 1)? ' disabled' : ''),
                'title' => lang('general_label_pagination_last_page')
            ]
        ) ?>
    </div>

<?php if (count($pagerResult['limit_choices']) <= 1) : ?>
    <div class="btn-group ml-2">
        <button type="button" class="btn btn-secondary hidden-sm-down" disabled>
            <span class="hidden-sm-down">
                <?= sprintf(lang('general_label_pagination_limit'), $pagerResult['limit']) ?>
            </span>
            <span class="hidden-md-up">
                <?= $pagerResult['limit'] ?>
            </span>
        </button>
    </div>
<?php else : ?>
    <div class="btn-group <?= $this->fetch('dropup') ? 'dropup' : null ?> ml-2">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="hidden-sm-down">
                <?= sprintf(lang('general_label_pagination_limit'), $pagerResult['limit']) ?>
            </span>
            <span class="hidden-md-up">
                <?= $pagerResult['limit'] ?>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
<?php
foreach ($pagerResult['limit_choices'] as $limit) :
?>
            <?= anchor(
                $baseUrl.'?page=1&pagesize=' . $limit . $this->fetch('anchor'),
                $limit,
                [
                    'class' => 'dropdown-item' . ($pagerResult['limit'] == $limit ? ' active' : ''),
                ]
            ) ?>
<?php
endforeach;
?>
        </div>
    </div>
<?php endif ?>
</form>
<?php endif; ?>
