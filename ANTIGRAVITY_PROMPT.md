# CRITICAL FIX: AgriSense 360 — Paths, Navigation & Role-Based Routing

This Symfony project runs on XAMPP at: http://localhost/AGRESENSE/PUBLIC/
The front controller is at: C:\xampp\htdocs\AGRESENSE\PUBLIC\index.php

## PROBLEM 1: BROKEN ASSET PATHS

Because the app runs in a subfolder (/AGRESENSE/PUBLIC/), ALL assets and links MUST use Symfony's Twig helpers. Never hardcode paths starting with `/`.

WRONG (breaks in subfolder):
```html
<link rel="stylesheet" href="/css/style.css">
<img src="/images/logo.png">
<a href="/login">Login</a>
<script src="/js/app.js"></script>
```

CORRECT (works everywhere):
```twig
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<img src="{{ asset('images/logo.png') }}" alt="Logo">
<a href="{{ path('app_login') }}">Login</a>
<script src="{{ asset('js/app.js') }}"></script>
```

**ACTION:** Search the ENTIRE templates/ directory for any `href="/`, `src="/`, `action="/`, or `url(/` that doesn't use `{{ asset() }}` or `{{ path() }}`. Fix every single one. Check these files especially:
- templates/base.html.twig
- templates/home.html.twig
- templates/partials/sidebar.html.twig
- templates/partials/sidebar_styles.html.twig
- templates/user/login.html.twig
- templates/user/register.html.twig
- ALL templates in templates/admin/, templates/gerant/, templates/farm/, templates/ouvrier/

For CSS `url()` inside `<style>` blocks in Twig, use:
```css
/* WRONG */
background: url('/images/bg.jpg');

/* CORRECT */
background: url('{{ asset("images/bg.jpg") }}');
```

---

## PROBLEM 2: base.html.twig MISSING BLOCKS

The base template needs these blocks so child templates can inject their JS and CSS:

```twig
<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>(function(){var t=localStorage.getItem('agri-theme')||'dark';document.documentElement.setAttribute('data-theme',t);})();</script>
    <title>{% block title %}AgriSense 360{% endblock %}</title>
    {% block stylesheets %}{% endblock %}
    {% block styles %}{% endblock %}
    {% block importmap %}{% endblock %}
</head>
<body>
    {% block navbar %}{% endblock %}
    {% block body %}{% endblock %}
    {% block javascripts %}{% endblock %}
</body>
</html>
```

**ACTION:** Open base.html.twig. Add `{% block stylesheets %}{% endblock %}`, `{% block importmap %}{% endblock %}`, and `{% block javascripts %}{% endblock %}` if they are missing. Keep all existing CSS that's already in base.html.twig.

---

## PROBLEM 3: ROLE-BASED REDIRECTIONS AFTER LOGIN

The login redirect in SecurityController.php (src/Controller/user/SecurityController.php) MUST follow this exact order:

```php
private function redirectToUserHome($user): Response
{
    $roles = $user->getRoles();
    if (in_array('ROLE_ADMIN', $roles))   return $this->redirectToRoute('admin_dashboard');
    if (in_array('ROLE_OWNER', $roles))   return $this->redirectToRoute('farm_dashboard');
    if (in_array('ROLE_GERANT', $roles))  return $this->redirectToRoute('gerant_home');
    if (in_array('ROLE_OUVRIER', $roles)) return $this->redirectToRoute('ouvrier_home');
    return $this->redirectToRoute('ouvrier_farms'); // ROLE_PENDING
}
```

And HomeController.php must have the same logic in `redirectBasedOnRole()`. Verify both files match.

The exact route-to-URL-to-template mapping is:

| Role | Route Name | URL | Template File |
|---|---|---|---|
| ROLE_ADMIN | admin_dashboard | /admin/utilisateurs | admin/dashboard.html.twig |
| ROLE_OWNER | farm_dashboard | /farm/dashboard | farm/dashboard.html.twig |
| ROLE_GERANT | gerant_home | /gerant | gerant/home.html.twig |
| ROLE_OUVRIER | ouvrier_home | /ouvrier | ouvrier/home.html.twig |
| ROLE_PENDING | ouvrier_farms | /ouvrier/farms | (farm browser) |

---

## PROBLEM 4: GÉRANT SIDEBAR NAVIGATION

The sidebar is in templates/partials/sidebar.html.twig. It auto-detects the role and shows different links. For ROLE_GERANT, the sidebar must have these links:

| Label | Route Name | Controller | Template | activePage |
|---|---|---|---|---|
| Tableau de bord | gerant_home | GerantController | gerant/home.html.twig | dashboard |
| Ouvriers | gerant_ouvriers | GerantController | gerant/ouvriers.html.twig | ouvriers |
| Cultures | gerant_cultures | GerantController | gerant/cultures/index.html.twig (or culture_index) | cultures |
| Stockés | gerant_stockes | GerantController | gerant/stockes/index.html.twig | stockes |
| Équipements | gerant_equipements | GerantController | gerant/equipements/index.html.twig | equipements |
| Affectations | gerant_affectations | GerantController | gerant/affectations/index.html.twig | affectations |
| Animaux | gerant_animaux | GerantController | gerant/animaux/index.html.twig | animaux |

Each of these controller actions must exist in GerantController.php. If a route like `gerant_cultures` just redirects to `culture_index`, that's fine, but the sidebar link must use the correct route name.

---

## PROBLEM 5: HOW EVERY GÉRANT PAGE TEMPLATE MUST LOOK

Every page for the Gérant role MUST follow this structure:

```twig
{% extends 'base.html.twig' %}
{% set activePage = 'cultures' %}
{% set activeSection = 'main' %}
{% block title %}Cultures — AgriSense 360{% endblock %}

{% block navbar %}{% endblock %}

{% block styles %}
{% include 'partials/sidebar_styles.html.twig' %}
<style>
/* page-specific CSS using the dark/light CSS variables from sidebar_styles */
</style>
{% endblock %}

{% block body %}
<div class="layout">
  {% include 'partials/sidebar.html.twig' %}
  <main class="main">
    <!-- page content -->
  </main>
</div>
<script>
// sidebar toggle + theme toggle
</script>
{% endblock %}
```

**KEY RULES:**
- `{% block navbar %}{% endblock %}` SUPPRESSES the default public navbar (login/register buttons)
- `{% include 'partials/sidebar_styles.html.twig' %}` loads ALL the CSS variables for dark/light theme
- `{% include 'partials/sidebar.html.twig' %}` loads the role-aware sidebar
- `{% set activePage = 'cultures' %}` highlights the correct sidebar link

---

## EXECUTION PLAN

1. **First, fix base.html.twig** (add missing blocks)
2. **Search ALL templates for hardcoded paths** (`href="/`, `src="/`, `action="/`) and replace with `{{ asset() }}` or `{{ path() }}`
3. **Verify SecurityController and HomeController redirections** match the table above
4. **Open GerantController.php** — ensure routes exist for cultures, stockes, equipements, affectations, animaux
5. **Open templates/partials/sidebar.html.twig** — add missing sidebar links for the Gérant section
6. **For each Gérant feature template** (cultures, stockes, etc.), make it extend base.html.twig and include the sidebar following the pattern above
7. **Run** `php bin/console cache:clear`
8. **Test:** login as ROLE_GERANT → should land on /gerant → click Cultures → should show cultures index with sidebar still visible

---

## ADDITIONAL REFERENCE: Complete Role System

From config/packages/security.yaml:
```
ROLE_ADMIN   → inherits: ROLE_OWNER, ROLE_GERANT, ROLE_OUVRIER, ROLE_USER
ROLE_OWNER   → inherits: ROLE_USER
ROLE_GERANT  → inherits: ROLE_USER
ROLE_OUVRIER → inherits: ROLE_USER
ROLE_PENDING → only ROLE_USER (no special role yet, just registered)
```

Every protected controller action should have either:
- `#[IsGranted('ROLE_GERANT')]` at class level, OR
- `$this->denyAccessUnlessGranted('ROLE_GERANT')` in the method

Always check for `$farm = $user->getFarm();` before querying farm-related data.

---

Start by showing the current content of base.html.twig and GerantController.php, then fix them systematically.
