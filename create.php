<?php

session_start();

//  Si les données arrivent via la méthode POST
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    //echo "On s'arrête ici pour aujourd'hui";
    // Protéger le serveur contre les failles de type XSS une première fois (cybersécurité)

    $post_clean = [];
    $create_form_errors = [];

    foreach ($_POST as $key => $value) {
        $post_clean[$key] = strip_tags(trim($value));
    }



    // Valider les données du formulaire
    //Le nom du film

    if (isset($post_clean['name'])) {
        if (empty($post_clean['name'])) {

            $create_form_errors['name'] = "Le nom du film est obligatoire";
        } elseif (mb_strlen($post_clean['name']) > 255) {
            $create_form_errors['name'] = "Le nom du film ne doit pas dépasser 255 caractères";
        }
    }
    // var_dump($create_form_errors);
    // die(); // Pour arrêter l'execution du script

    //Le nom du ou des acteurs du film
    if (isset($post_clean['actors'])) {
        if (empty($post_clean['actors'])) {

            $create_form_errors['actors'] = "Le nom du ou des films est obligatoire";
        } elseif (mb_strlen($post_clean['actors']) > 255) {
            $create_form_errors['actors'] = "Le nom du ou des films ne doit pas dépasser 255 caractères";
        }
    }

    // la note du film 
    if (isset($post_clean['review'])) {
        if (is_string($post_clean['review']) && ($post_clean['review'] == '')) {
            $create_form_errors['review'] = "La note est obligatoire";
        } else if (empty($post_clean['review']) && ($post_clean['review'] != 0)) {
            $create_form_errors['review'] = "La note est obligatoire";
        } else if (!is_numeric($post_clean['review'])) {
            $create_form_errors['review'] = "Veuillez entrer un nombre.";
        } else if (($post_clean['review'] < 0) || ($post_clean['review'] > 5)) {
            $create_form_errors['review'] = "Veuillez entrer un nombre compris entre 0 et 5.";
        }
    }

    // var_dump($create_form_errors);
    // die(); // Pour arrêter l'execution du script


    // Si il y a des erreurs, on redirige l'utilisateur vers la page de
    // laquelle proviennent les informations puis on arrête l'exécution du script

    // S'il y a des erreurs, 
    if (count($create_form_errors) > 0) {
        // On redirige l'utilisateur vers la page de laquelle proviennent les informations puis on arrête l'exécution du script
        $_SESSION["old"] = $post_clean;
        $_SESSION['create_form_errors'] = $create_form_errors;
        return header("Location: " . $_SERVER['HTTP_REFERER']);
    }

    //  // Dans le cas contraire,
    //        // Protéger le serveur contre les failles de type XSS une seconde fois (cybersécurité)
    //         $final_post_clean = [];
    //         foreach ($_POST as $key => $value) 
    //         {
    //             $final_post_clean[$key] = htmlspecialchars($value);
    //         }

    // $name = $final_post_clean['name'];
    // $actors = $final_post_clean['actors'];
    // $review = $final_post_clean['review'];

    // //Arrondir le note à un chiffre après la virgule
    // $review_rounded = round($review, 1);

    //         // Dans le cas contraire,
    //         // Protéger le serveur contre les failles de type XSS une seconde fois (cybersécurité)

    //         // Etablir une connexion avec la base de données

    //         require __DIR__ ."/db/connection.php";
    //  // Effectuer la requête d'insertion des données dans la table "film" de la base données

    // $req = $db->prepare("INSERT INTO film (name, actors, review, created_at, updated_at) VALUES (:name, :actors, :review, now(), now()) ");

    //         //Associer chaque valeur à son paramètre
    // $req->bindValue(":name", $name);
    // $req->bindValue(":actors", $actors);
    // $req->bindValue(":review", $review);

    // //Exécuter la requête*
    // $req->execute();

    // //Fermeture de la connexion établie avec la base de données (non obligatoire)
    //        $req->closeCursor();

    //     // Rediriger l'utilisateur vers la page d'accueil et arrèter l'exécution du script
    //     return header("Location: index.php");

}
?>

<?php $title = "Nouveau film"; ?>

<?php require __DIR__ . "/components/head.php" ?>

<?php require __DIR__ . "/components/nav.php" ?>

<div class="container">
    <h1>Nouveau film</h1>

    <?php if (isset($_SESSION['create_form_errors']) && !empty($_SESSION['create_form_errors'])) : ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php foreach ($_SESSION['create_form_errors'] as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach ?>
            </ul>
        </div>
        <?php unset($_SESSION['create_form_errors']); ?>
        <!-- pour supprime les valeur session -->
    <?php endif ?>


    <div class="form-container">
        <form method="post">
            <div class="form-group">
                <label for="name">Nom :</label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($_SESSION['old']['name']) ? $_SESSION['old']['name'] : '';
                                                                                        unset($_SESSION['old']['name']); ?>">

            </div>
            <div class="form-group">
                <label for="actors">Acteur(s) :</label>
                <input type="text" name="actors" id="actors" class="form-control" value="<?php echo isset($_SESSION['old']['actors']) ? $_SESSION['old']['actors'] : '';
                                                                                            unset($_SESSION['old']['actors']); ?>">

            </div>
            <div class="form-group">
                <label for="review">Note sur 5 :</label>
                <input type="text" name="review" id="review" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary">

            </div>
        </form>

    </div>
</div>

<?php require __DIR__ . "/components/footer.php" ?>

<?php require __DIR__ . "/components/foot.php" ?>