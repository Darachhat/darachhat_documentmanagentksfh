<!-- Google Fonts - Noto Sans Khmer -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* Global font override for Filament */
    :root {
        --font-sans: 'Noto Sans Khmer', ui-sans-serif, system-ui, sans-serif;
    }

    /* Apply to all Filament components */
    .fi-main,
    .fi-sidebar,
    .fi-topbar,
    .fi-body,
    body {
        font-family: 'Noto Sans Khmer', ui-sans-serif, system-ui, sans-serif !important;
    }

    /* Khmer-specific text rendering */
    .khmer-text,
    [lang="km"] {
        font-family: 'Noto Sans Khmer', sans-serif !important;
        font-feature-settings: 'kern' 1;
        text-rendering: optimizeLegibility;
        line-height: 1.7;
    }
</style>
