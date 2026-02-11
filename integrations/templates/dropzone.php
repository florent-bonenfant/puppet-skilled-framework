<?php view('templates/snippets/_header', ['current' => $current]) ?>


<form action="index.php?view=dropzone" class="dropzone" id="my-awesome-dropzone"></form>


<?php view('templates/snippets/_footer', [
    'dropzone' => true,
]) ?>
