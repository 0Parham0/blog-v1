<?php
function validateInput($value)
{
    return htmlspecialchars(stripslashes(trim($value)));
}
