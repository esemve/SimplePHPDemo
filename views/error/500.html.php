<h1>Error 500</h1>
<h2><?php echo $exception->getMessage(); ?></h2>
<hr>
<h4>Trace:</h4>
<?php
var_dump($exception->getTrace());