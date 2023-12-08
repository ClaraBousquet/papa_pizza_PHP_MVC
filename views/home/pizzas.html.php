<h1 class="title title-page">Notre Carte</h1>
<div class="d-flex justify-content-center">


    <div class="d-flex flex-row flex-wrap my-3 justify-content-center col-lg-10-align-self-center">
        <?php foreach ($pizzas as $pizza) : ?>
            <div class="card m-2" style="width: 18rem;">
                <a href="/pizza/<?= $pizza->id ?>">
                <img src="/assets/images/pizza/<?= $pizza->image_path ?>" alt="<?= $pizza->name ?>" class="card-img-top img-fluid img-pizza">
                </a>
                <div class="card-body">
                    <h3 class="card-title sub-title text-center"><?= $pizza->name ?></h3>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>