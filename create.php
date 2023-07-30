<?php require __DIR__ . "/components/head.php"; ?>


<?php require __DIR__ . "/components/nav.php"; ?>

<div class="container">
    <h1>Nouveau film</h1>

    <div class="form-container">
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" name="name" class="form-control" id="name" />
            </div>

            <div class="form-group">
                <label for="actors">Acteur</label>
                <input type="text" name="actors" class="form-control" id="actors" />
            </div>

            <div class="form-group">
                <label for="review">Note sur 5</label>
                <input type="text" name="review" class="form-control" id="review" />
            </div>

            <div class="form-group">
                <input type="submit" name="review" class="btn btn-primary" />
            </div>
        </form>
    </div>

</div>

<?php require __DIR__ . "/components/footer.php"; ?>

<?php require __DIR__ . "/components/foot.php"; ?>