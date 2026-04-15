<?php
// function basePath(string $path): string {
//     return BASE_PATH . '/' . $path;
// // }

function basePath($path = '')
{
    return __DIR__.'/'. $path;
}

/**
 * load a view
 * 
 * @param string $name
 * @return void
 * 
 */
    function loadView($name){
        require basePath ("views/{$name}.views.php");
    }

    function loadPartials($name){
        require basePath ("views/partials/{$name}.php");
        $partialPath = basePath('views/partials/{$name}.php');
        if(file_exists($partialPath)){
            require $partialPath;
        }else{
            echo"Partial '{name}' not found!";
        
        }
    }

    

?> 