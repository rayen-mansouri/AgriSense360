# AgriSense360 – CSS/Template/Controller Architecture Map

**Project**: AgriSense360 (Symfony + Twig)  
**Purpose**: Complete mapping of controllers, templates, and CSS dependencies for CSS refactoring  
**Status**: Production Gestion Module Implementation

---

## CSS Files Available
📁 Location: `public/css/`
- `app.css` – Global base styles (included in all pages via base.html.twig)
- `cards.css` – Card/box component styles (recommended for culture/parcelle cards)
- `home.css` – Dashboard-specific styles (used by HomeController)
- `sidebar.css` – Navigation sidebar styles (included globally)

---

## Controller → Template → CSS Mapping

### 1️⃣ **HomeController**
- **Route**: `/` (home)
- **Template**: `templates/home/index.html.twig`
- **Action**: `index()`
- **CSS Used**: `app.css`, `sidebar.css`, `home.css`
- **Features**: Admin dashboard with KPIs, surface stats, état counts, type counts
- **Notes**: Extends `base.html.twig`; uses CSS variables (--green-100, --text-dark, etc.)

---

### 2️⃣ **CultureController**
**Route Prefix**: `/culture`

| Method | Route | Template | CSS | Purpose |
|--------|-------|----------|-----|---------|
| `index()` | `/culture` | `culture/culture_index.html.twig` | `app.css`, `cards.css` | List all cultures with search/sort |
| `analytics()` | `/culture/analytics` | `culture/analytics.html.twig` | `app.css` | Harvest analytics & IA insights |
| `iaPreview()` | `/culture/{id}/ia-preview` | JSON response (AJAX) | N/A | AJAX endpoint for harvest modal |
| `create()` | `/culture/new` | `culture/new.html.twig` | `app.css`, `cards.css` | Create new culture form |
| `edit()` | `/culture/{id}/edit` | `culture/edit.html.twig` | `app.css`, `cards.css` | Edit culture form |
| `show()` | `/culture/{id}/show` | `culture/details.html.twig` | `app.css`, `cards.css` | Culture detail page |

---

### 3️⃣ **ParcelleController**
**Route Prefix**: `/parcelle`

| Method | Route | Template | CSS | Purpose |
|--------|-------|----------|-----|---------|
| `index()` | `/parcelle` | `parcelle/parcelle_index.html.twig` | `app.css`, `cards.css` | List all parcelles with search/sort |
| `show()` | `/parcelle/{id}` | `parcelle/show.html.twig` | `app.css`, `cards.css` | Parcelle detail (weather, active cultures) |
| `create()` | `/parcelle/new` | `parcelle/new.html.twig` | `app.css`, `cards.css` | Create new parcelle form |
| `edit()` | `/parcelle/{id}/edit` | `parcelle/edit.html.twig` | `app.css`, `cards.css` | Edit parcelle form |

---

### 4️⃣ **ParcelleHistoriqueController**
**Route Prefix**: `/parcelle/historique`

| Method | Route | Template | CSS | Purpose |
|--------|-------|----------|-----|---------|
| `show()` | `/parcelle/historique/{id}` | `parcelle/historique_page.html.twig` | `app.css` | Action history (Semis, Récolte, etc.) |
| `export()` | `/parcelle/historique/{id}/export` | N/A (Excel stream) | N/A | Export history as XLSX file |

---

### 5️⃣ **EmbedController**
**Routes**: `/agenda`, `/carte-parcelles`

| Method | Route | Template | CSS | Purpose |
|--------|-------|----------|-----|---------|
| `agenda()` | `/agenda` | `embed/agenda.html.twig` | `app.css`, custom JS | Embedded agenda (AgendaCulture.html wrapper) |
| `carte()` | `/carte-parcelles` | `embed/carte.html.twig` | `app.css`, custom JS | Embedded map (Map.html wrapper) |

---

### 6️⃣ **AiConseilController** *(New IA Consultation)*
**Route**: `POST /ai-conseil`
- **Template**: N/A (JSON response for AJAX)
- **CSS**: N/A
- **Purpose**: Groq AI proxy for farming advice

---

### 7️⃣ **ComingSoonController**
- **Route**: `/bientot`
- **Template**: N/A (redirect or static page)
- **CSS**: `app.css`, `sidebar.css`
- **Purpose**: Placeholder for future modules

---

### 8️⃣ **MailController**
- **Route**: `/mailer/**`
- **Template**: Email templates (not user-facing)
- **CSS**: N/A
- **Purpose**: Email service endpoints (internal)

---

## Base Layout Hierarchy

```
base.html.twig (Global)
├── CSS: app.css (global), sidebar.css (nav)
├── ✅ Sidebar Navigation (fixed left)
├── Main Content Block
│   └── Individual Page Templates
│       ├── home/index.html.twig → home.css
│       ├── culture/*.html.twig → cards.css
│       ├── parcelle/*.html.twig → cards.css
│       └── embed/*.html.twig → custom JS
```

---

## CSS Architecture

### app.css (Global)
- CSS variables (colors, spacing, typography)
- Button styles (`.btn`, `.btn-primary`, `.btn-secondary`)
- Form inputs, labels
- Page header (`.page-header`, `.page-title`, `.page-breadcrumb`)
- Modal styles (`.modal`, `.modal-content`)
- Responsive grid system

### sidebar.css
- Sidebar container (`.sidebar`)
- Navigation items (`.nav-item`, `.nav-section-label`)
- Brand styling (`.sidebar-brand`)
- Active state highlighting

### home.css
- Dashboard sections (`.dash-section`)
- KPI grid (`.kpi-grid`)
- Stats cards (`.stat-card`)
- Chart containers

### cards.css
- Card component (`.card`, `.card-header`, `.card-body`)
- Card with hover effects
- List item styling
- Recommended for culture/parcelle index pages

---

## Issues to Fix (CSS-Level)

**Scope**: Gestion Module (Culture + Parcelle)

1. **Culture Index Pages** (`culture_index.html.twig`, `parcelle_index.html.twig`)
   - Use `cards.css` for consistency
   - Fix table/list styling alignment
   - Ensure search/sort buttons align with design system

2. **Culture Detail Pages** (`details.html.twig`, `show.html.twig`)
   - Align form layouts (spacing, label widths)
   - Fix IA modal styling (responsive on mobile)
   - Ensure buttons follow `.btn` class conventions

3. **Historique Page** (`historique_page.html.twig`)
   - Timeline styling needs refinement
   - Action badges color consistency
   - Export button placement

4. **Responsive Mobile**
   - All pages must work on 320px+ screens
   - Sidebar should collapse on mobile
   - Cards should stack vertically

---

## Quick Reference: Template File Structure

```
templates/
├── base.html.twig ────────────── Global layout, includes app.css + sidebar.css
├── home/
│   └── index.html.twig ───────── Dashboard → home.css
├── culture/
│   ├── culture_index.html.twig ─ List → cards.css
│   ├── analytics.html.twig ───── Analytics → app.css
│   ├── details.html.twig ─────── Details → cards.css
│   ├── new.html.twig ────────── Form → app.css
│   └── edit.html.twig ────────── Form → app.css
├── parcelle/
│   ├── parcelle_index.html.twig ─ List → cards.css
│   ├── show.html.twig ───────── Details → app.css, cards.css
│   ├── new.html.twig ────────── Form → app.css
│   ├── edit.html.twig ────────── Form → app.css
│   └── historique_page.html.twig ─ History → app.css
└── embed/
    ├── agenda.html.twig ────────── Calendar → custom JS
    └── carte.html.twig ────────── Map → custom JS
```

---

## Key CSS Variables Used
```css
--green-100, --green-200, --green-700  /* Brand colors */
--text-dark, --text-light
--border-light, --shadow-sm
--spacing-xs, --spacing-sm, --spacing-md, --spacing-lg
```

---

## Implementation Notes for Antigravity

✅ **Use `app.css` as the base** – All pages inherit this  
✅ **Use `cards.css` for index pages** – Culture & Parcelle lists  
✅ **Use `home.css` only for dashboard** – Don't apply to other pages  
✅ **Extend `base.html.twig`** – Always inherit global layout  
✅ **Follow `.btn` class conventions** – Use `btn-primary`, `btn-secondary`  
✅ **Test responsive** – Mobile-first design approach  

---

**Last Updated**: May 4, 2026  
**Version**: 1.0 (Production Gestion Build)
