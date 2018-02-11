<?php
/**
 * @var \App\Entity\BlogPost $post
 * @var \Libs\RouterInterface $router
 */

require __DIR__.'/layout/header.html.php';
?>

<div id="container">
    <?php

        printf(
            '<h2>%s</h2><p><strong>%s</strong></p><p>%s</p><hr>',
            $post->getTitle(),
            $post->getLead(),
            $post->getContent()
        );
    ?>


    <a href="<?php echo $router->getUrl('default'); ?>">Vissza a főoldalra</a>
</div>

<?php
require __DIR__.'/layout/footer.html.php';
?>
