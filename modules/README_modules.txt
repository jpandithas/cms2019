Always use a folder to create your modules
The folder structure and the naming convention is as follows: 
\modules
    |
    \mod_name
        |
        mod_name.php
            |-function mod_name()

You should also register the module to the routes table
    action-> value at least here 
    type-> only if your action has a scope 
    id-> 0 or 1 
