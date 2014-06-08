<?php

function generateRandomPassword($stringLength = 8) {
    $acceptableCharacters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxwz0123456789";
    for(;$stringLength > 0;$stringLength--) $newPassword .= $acceptableCharacters{rand(0,strlen($acceptableCharacters))};
    return str_shuffle($newPassword);
}

?>