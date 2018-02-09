<?php

function dd(...$value) {
    var_dump(...$value);
    die();
}

function dump(...$value) {
    var_dump(...$value);
}