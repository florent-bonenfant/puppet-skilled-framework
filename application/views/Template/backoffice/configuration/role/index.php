<?= $this->element(
    'crud/default_filter',
    [
        'filters' => $this->fetch('filters'),
        'pager' => $this->fetch('pager')->getResult()
    ]
) ?>

<?= $this->element(
   'crud/list',
   [
       'pager'  => $this->fetch('pager'),
       'displayed_fields' => [
           [
               'query_key' => 'name',
               'label' => 'lang:role_label_name',
           ],
           [
               'label' => '',
               'class' => 'center-align',
               'formater' => function ($item) {
                   return $this->block('list_actions', ['item' => $item]);
               }
            ],
        ],
    ]
);?>
