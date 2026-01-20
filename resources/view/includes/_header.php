<?php
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Hacene Ouserir's portfolio showcases web development skills, experience, latest projects, and blog posts. Available for collaboration and consultation.">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="canonical" href="https://www.haceneouserir.me">
  <!-- Open Graph -->
  <meta property="og:title" content="Hacene Ouserir | Portfolio">
  <meta property="og:description" content="Hacene Ouserir's portfolio showcases web development skills, experience, latest projects, and blog posts. Available for collaboration and consultation.">
  <meta property="og:image" content="https://www.haceneouserir.me/assets/icons/icon_512x512.png">
  <meta property="og:url" content="https://www.haceneouserir.me">
  <meta property="og:type" content="website">
  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Hacene Ouserir | Portfolio">
  <meta name="twitter:description" content="Hacene Ouserir's portfolio showcases web development skills, experience, latest projects, and blog posts. Available for collaboration and consultation.">
  <meta name="twitter:image" content="https://www.haceneouserir.me/assets/icons/icon_512x512.png">

  <title>Hacene Ouserir | Portfolio</title>
  <!-- App CSS -->
  <link rel="stylesheet" href="/css/app.min.css">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="/favicon.ico">
  <!-- Apple Touch Icons -->
  <link rel="apple-touch-icon" href="/assets/icons/152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/180x180.png">
  <link rel="apple-touch-icon" sizes="167x167" href="/assets/icons/167x167.png">
  <!-- Manifest -->
  <link rel="manifest" href="/manifest.json">
  <!-- Apply theme ASAP to prevent flash -->
  <script async>
    const $root = document.documentElement;
    const $key = 'hs_theme';
    let $saved = localStorage.getItem($key);
    const $prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    let $isDark = $saved ? $saved === 'dark' : $prefersDark;
    $root.classList.toggle('dark', $isDark);
  </script>
  <!-- Preconnect to Cloudflare Turnstile -->
  <link rel="preconnect" href="https://challenges.cloudflare.com">
  <!-- Cloudflare Turnstile -->
  <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
  <script>
    // Initialize Cloudflare Turnstile
    let turnstileWidgetId;
    const renderTurnstile = () => {
      // Render Turnstile widget if available
      if (window.turnstile && document.getElementById("cfTurnstile")) {
        if (turnstileWidgetId === undefined) {
          turnstileWidgetId = turnstile.render("#cfTurnstile", {
            sitekey: "0x4AAAAAACLUZydBc06cgvda",
            language: "en",
            theme: "light",
          });
        }
      } else {
        setTimeout(renderTurnstile, 50);
      }
    }
    document.addEventListener("DOMContentLoaded", () => {
      renderTurnstile();
    });
  </script>
</head>