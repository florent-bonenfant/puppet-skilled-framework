<?php view('templates/snippets/_header', ['current' => $current]) ?>


<section class="jumbotron">
    <h1 class="display-3">Hello, world!</h1>
    <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
    <hr class="my-4">
    <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
    <p class="lead">
        <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
    </p>
</section>


<section class="row">
    <div class="col-sm-6">
        <canvas width="100%" height="75%" data-chart="chart-1"></canvas>
        <script id="chart-1" type="application/json">
        {
            "type": "line",
            "data": {
                "labels": ["Trim. 1", "Trim. 2", "Trim. 3", "Trim. 4"],
                "datasets": [{
                    "label": false,
                    "data": [12, 19, 3, 5]
                }]
            },
            "options": {
                "legend": {
                    "display": false
                }
            }
        }
        </script>
    </div>
    <div class="col-sm-6">
        <canvas width="100%" height="75%" data-chart="chart-2"></canvas>
        <script id="chart-2" type="application/json">
        {
            "type": "line",
            "data": {
                "labels": ["Trim. 1", "Trim. 2", "Trim. 3", "Trim. 4"],
                "datasets": [{
                    "label": false,
                    "data": [18, 7, 25, 11]
                }]
            },
            "options": {
                "legend": {
                    "display": false
                }
            }
        }
        </script>
    </div>
</section>


<?php view('templates/snippets/_footer', ['charts' => true]) ?>
