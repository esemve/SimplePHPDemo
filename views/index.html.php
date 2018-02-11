<?php
/**
 * @var \App\Entity\BlogPost[] $posts
 * @var \Libs\RouterInterface $router
 */

    require __DIR__.'/layout/header.html.php';
?>

<div id="container">
    <a href="<?php echo $router->getUrl('create'); ?>">Új hozzáadása</a>
    <hr>
<?php

    foreach ($posts AS $post) {
        printf(
            '<a href="%s"><h2>%s</h2></a><p>%s</p><a href="%s">Szerkesztés</a><hr>',
            $router->getUrl('show',['id' => $post->getId()]),
            $post->getTitle(),
            $post->getLead(),
            $router->getUrl('edit',['id'=>$post->getId()])
        );
    }
?>
</div>

<?php
    require __DIR__.'/layout/footer.html.php';
?>
