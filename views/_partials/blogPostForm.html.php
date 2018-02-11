<?php
/**
 * @var \App\Entity\BlogPost $entity
 * @var \Libs\Request $request
 */
?>
<a href="<?php echo $router->getUrl('default'); ?>">Vissza a főoldalra</a>
<hr>

<form action="" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $request->getCsrf(); ?>">
    Cím:<br>
    <input type="text" name="title" value="<?=$entity ? $entity->getTitle() : ''?>"><br>
    Bevezető:<br>
    <textarea name="lead"><?=$entity ? $entity->getLead() : ''?></textarea><br>
    Tartalom:<br>
    <textarea name="content"><?=$entity ? $entity->getContent() : ''?></textarea>
    <br>
    <input type="submit" value="OK">
</form>
