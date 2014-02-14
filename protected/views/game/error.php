<?php
if (!empty($error)) {
    echo "<h1>Error</h1><pre>";
    echo $error;
    echo "<br />\n</pre>";
} else
    echo 'no error string specified';
