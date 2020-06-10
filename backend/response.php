<?php
function response($resp)
{
    for ($i = 0; $i < sizeof($resp); $i++) {
        if ($i == sizeof($resp) - 1)
            echo $resp[$i];
        else
            echo $resp[$i] . "&";
    }
}
