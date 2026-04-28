<?php
    function basePath(string $path): string {
        return BASE_PATH . '/' . $path;
    } 
    /** 
     * load a view
     * @param string $name
     * @return void
     */

    function loadView($name) {
        require basePath('views/' . $name . '.view.php');
    }

    /** 
     * load a partial
     * @param string $name
     * @return void
     */

    function loadPartial($name) {
        $partialPath = basePath('views/partials/' . $name . '.php');
        if (file_exists($partialPath)) {
            require $partialPath;
        } else {
            echo "Partial not found: " . $name;
        }
    }


?>