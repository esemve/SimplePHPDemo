<?php
/**
 * @var \App\Entity\BlogPost[] $posts
 * @var \Libs\RouterInterface $router
 */

    require __DIR__.'/layout/header.html.php';
?>

<div id="container">
<?php
    foreach ($posts AS $post) {
        printf(
            '<a href="%s"><h2>%s</h2></a><p>%s</p><hr>',
            $router->getUrl('show',['id' => $post->getId()]),
            $post->getTitle(),
            $post->getLead()
        );
    }
?>
</div>

<?php
    require __DIR__.'/layout/footer.html.php';
?>
