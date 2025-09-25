<?php
// ==================== Theme Handling ====================
// If the toggle button is clicked
if (isset($_GET['theme'])) {
    $theme = $_GET['theme'];
    // Set the cookie for 30 days
    setcookie('theme', $theme, time() + (30 * 24 * 60 * 60), "/"); // cookie will be available throughout the site
    // Reload the current page without the GET parameter
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Determine the current theme from the cookie
$theme_class = (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark') ? 'dark-theme' : '';
?>

<style>
    /* Light Theme (default) */
    body {
        background-color: #ffffff;
        color: #000000;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Dark Theme */
    body.dark-theme {
        background-color: #121212;
    }

    /* Theme Toggle Button */
    #theme-toggle {
        position: fixed;
        top: 100px;
        right: 20px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #2e7d32;
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        transition: background-color 0.3s ease;
        z-index: 9999;
    }

    #theme-toggle:hover {
        background-color: #1b5e20;
    }
</style>

<form method="GET" action="" style="display:inline;">
    <input type="hidden" name="theme" value="<?php echo ($theme_class === 'dark-theme') ? 'light' : 'dark'; ?>">
    <button id="theme-toggle" type="submit" title="Toggle Dark/Light Theme">🌓</button>
</form>

<script>
    document.body.classList.add("<?php echo $theme_class; ?>");
</script>


