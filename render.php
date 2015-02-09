<?php
/*
 * Copyright 2015 Andrew Hutchings <andrew@linuxjedi.co.uk>
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain 
 * a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 *
 */
$path = pathinfo($_SERVER["SCRIPT_FILENAME"]);

function callback($match)
{
    /* strip out tilde markup */
    $match = $match[0];
    $match = str_replace("~", "", $match);
    /* if it is an include do the include */
    if (strncmp($match, "inc:", 4) == 0)
    {
        return file_get_contents(substr($match, 4));
    }
    /* otherwise we are a variable */
    $variables=parse_ini_file("replacements.ini");
    if (array_key_exists($match, $variables))
    {
        return $variables[$match];
    }
    /* Unknown variable */
    return "*UNKNOWN*";
}

/* Deal with "/" without html file */
if ($_SERVER["REQUEST_URI"] == "/")
{
    if (file_exists("index.htm"))
    {
        $_SERVER["SCRIPT_FILENAME"] = "index.htm";
        $path = pathinfo("index.htm");
    }
    else
    {
        $_SERVER["SCRIPT_FILENAME"] = "index.html";
        $path = pathinfo("index.html");
    }
}

if (strncmp($path["extension"], "htm", 3) == 0)
{
    $html = file_get_contents($_SERVER["SCRIPT_FILENAME"]);
    $html = preg_replace_callback("|~.*~|", "callback", $html);
    echo $html;
}
else
{
    readfile($_SERVER["SCRIPT_FILENAME"]);
}
?>
