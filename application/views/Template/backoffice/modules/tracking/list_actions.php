<?= anchor(
    str_replace("%NUM_COLIS%", $this->fetch('item')->number, $this->fetch('item')->carrier->link),
    '<i class="material-icons">pageview</i>',
    [
        'class' => 'btn btn-sm btn-primary',
        'title' => $this->fetch('item')->carrier->label,
        'data-toggle' => "tooltip",
        'data-placement' => 'top',
        'target' => '_blank'
    ]
) ?>