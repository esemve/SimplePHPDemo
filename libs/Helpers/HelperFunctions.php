<?php

/**
 * Dump and die
 * @param array ...$value
 */
function dd(...$value) {
    var_dump(...$value);
    die();
}

/**
 * Dump
 * @param array ...$value
 */
function dump(...$value) {
    var_dump(...$value);
}