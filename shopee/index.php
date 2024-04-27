<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('location: ../login/');
} else {
    $_SESSION['loggedin'];
    $_SESSION['userId'];
    $_SESSION['userEmail'];
    $_SESSION['userName'];
}
$activeMenu = 'dashboard';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome:</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>
    <div class="container main position-relative">
        <div class="position-sticky top-0 bg-white container-fluid pb-2" style="--bs-bg-opacity: .9;">
            <?php
            include '../partials/_header.php';
            ?>
        </div>
        <div class="container">
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Perferendis eius odio eos nostrum itaque aut magnam, omnis odit alias, vitae dolorem minus hic, iusto at. Quisquam temporibus aperiam culpa explicabo animi, magnam sit aliquid recusandae excepturi eligendi perspiciatis numquam impedit sed labore fuga cum ab? Laudantium maxime, hic voluptas in fugiat magni fuga accusantium repudiandae quod. Sequi reprehenderit sapiente atque laboriosam assumenda nobis ab minima itaque eveniet provident eius a vero soluta qui, voluptatem harum deserunt laborum est? Fugit voluptatibus veniam dicta voluptatum unde quod doloremque illo placeat ad, enim itaque repellat harum corporis? Beatae eum earum inventore placeat rerum maiores sequi aliquid, neque dolorem magni, alias asperiores fugit velit veritatis est nam recusandae esse iusto vitae corrupti libero suscipit quia illum! Voluptates sunt animi optio architecto dolor velit laborum quos possimus vero tempore veniam ea veritatis aut laboriosam aperiam similique eaque repellat odio impedit, sequi ducimus eum alias? Cumque optio veritatis harum dolores temporibus, sapiente nihil laborum laboriosam, ex facere dolorum deleniti doloribus aperiam? Quam odit harum distinctio, ipsum enim corrupti facilis voluptatum voluptates in laboriosam vitae sapiente provident sint officiis officia nulla aliquam maxime blanditiis natus omnis voluptate pariatur dignissimos impedit. Dicta, eius aspernatur doloribus distinctio deserunt voluptatibus tempora laborum iure ipsum officiis optio cupiditate expedita sunt. Consectetur dolor consequuntur est voluptates dolores enim reprehenderit quaerat architecto suscipit nobis omnis facere nihil cum, maxime, at aspernatur quam corrupti tenetur velit exercitationem natus. Explicabo deleniti tempora id. Sunt ratione, nam enim sint voluptatum, repellat totam nulla quod praesentium, quo facilis quidem corporis quibusdam iusto aperiam! Rem nostrum ut error illo, nemo vel tempore deserunt suscipit reiciendis quas atque sit nulla qui architecto voluptates et. Vitae facere voluptatibus autem tenetur tempora. Dignissimos unde, excepturi molestias aliquam aut similique labore repellat. Aliquid beatae magnam assumenda nam similique consectetur amet dolorem, recusandae cum nemo ut at, illum excepturi laborum voluptatum possimus nisi nulla? Minus modi laborum provident quisquam assumenda itaque? Beatae molestiae incidunt nesciunt, voluptatibus ullam rerum deleniti repudiandae corrupti neque fugiat delectus iusto earum saepe at veritatis esse, quo exercitationem. Sapiente enim saepe vel qui deleniti odio dolores ab! Modi quasi dignissimos, cumque in eligendi veniam cum ad. Provident minus vel hic dolor sunt, atque aperiam velit temporibus, maiores dignissimos dolorum rem debitis voluptates? Ea architecto laborum veritatis odit odio assumenda, accusantium blanditiis placeat, optio quidem soluta similique vel at minus beatae atque repellendus! Ratione doloremque dignissimos autem, nostrum nesciunt perspiciatis, quis tempore dolorem reiciendis asperiores quo, aut consequatur maiores odio. Odit maiores architecto asperiores esse facilis exercitationem repudiandae corrupti odio. Ipsa beatae blanditiis distinctio pariatur veritatis eaque. Iste harum et provident minus necessitatibus, quasi accusamus repellat dicta dolorum, quod unde molestias. In officia maiores nemo facere ut, dicta dolorum pariatur! Esse adipisci aspernatur quod in provident libero, consequatur quaerat dolor totam repellat hic sed tenetur. Sapiente, doloremque! Labore nihil quod cum libero dolorum exercitationem itaque. Nesciunt voluptatibus perspiciatis saepe, consectetur libero possimus tempora explicabo asperiores reiciendis consequatur ea officia dolorem eum neque sapiente, officiis provident deserunt dolor voluptates, sint eveniet?
        </div>
        <footer style="width:100%" class="">

            <?php
            include '../partials/_footer.php';
            ?>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>