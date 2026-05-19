<?php

function basePath(string $path): string {
    return BASE_PATH . '/' . $path;
}

/**
 * Load a view
 */
function loadView(string $name, array $data = []): void {
    $viewPath = basePath("App/views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "View {$name} not found!";
    }
}

/**
 * Load a partial
 */
function loadPartial(string $name, array $data = []): void {
    $partialPath = basePath("App/views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        extract($data);
        require $partialPath;
    } else {
        echo "Partial not found: {$name}";
    }
}

/**
 * Inspect data
 */
function inspect(mixed $value): void {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

/**
 * Inspect data and stop execution
 */
function inspectAndDie(mixed $value): void {
    inspect($value);
    die();
}

/**
 * Format salary
 */
function formatSalary(float|int|string $salary): string {
    return '$' . number_format((float)$salary);
}

/**
 * Sanitize data
 * 
 * @param string $dirty
 * @return string 
 */

function sanitize($dirty)
{
    return filter_var(trim($dirty),     FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}
/**
 * 
 * @param string $url
 * @return void
 */
function redirect($url) {
    header("Location: {$url}");
    exit;
}