<?php
/**
 * @var \App\Entity\BlogPost[] $posts
 * @var \Libs\RouterInterface $router
 */

require __DIR__.'/layout/header.html.php';
?>

<div id="container">

    <h1>Szerkesztés</h1>

    <?php require __DIR__.'/_partials/blogPostForm.html.php'; ?>

</div>

<?php
require __DIR__.'/layout/footer.html.php';
?>
