<?php

use Illuminate\Support\HtmlString;

if (! function_exists('vite_assets')) {
    function vite_assets(): HtmlString
    {
        $manifestPath = public_path('build/manifest.json');

        if (! file_exists($manifestPath)) {
            return new HtmlString('');
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);
        $js = $manifest['resources/js/app.js']['file'] ?? null;
        $css = $manifest['resources/js/app.js']['css'] ?? [];

        $html = '';

        foreach ($css as $file) {
            $html .= '<link rel="stylesheet" href="' . asset('build/' . $file) . '">';
        }

        if ($js) {
            $html .= '<script type="module" src="' . asset('build/' . $js) . '"></script>';
        }

        return new HtmlString($html);
    }
}
