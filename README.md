# WordPressDemo

Portfolio project demonstrating WordPress development skills: a shared Gutenberg block plugin consumed by two distinct themes (Restaurant and Doctor's Office).

## Structure

```
WordPressDemo/
├── plugins/
│   └── info-card-block/        Gutenberg block (image + heading + body + CTA)
├── themes/
│   ├── wp-restaurant/          Warm serif restaurant theme
│   └── wp-droffice/            Clean sans-serif medical office theme
└── .github/workflows/ci.yml   PHPCS lint + JS build
```

## Local Setup

**Prerequisites:** WordPress installed locally, Node 20+, PHP 8.1+, Composer.

### 1. Clone the repo

```bash
git clone https://github.com/rongner/WordPressDemo.git
cd WordPressDemo
```

### 2. Symlink into WordPress

**macOS / Linux:**
```bash
ln -s "$PWD/plugins/info-card-block" /path/to/wp-content/plugins/info-card-block
ln -s "$PWD/themes/wp-restaurant"    /path/to/wp-content/themes/wp-restaurant
ln -s "$PWD/themes/wp-droffice"      /path/to/wp-content/themes/wp-droffice
```

**Windows (PowerShell as Administrator):**
```powershell
New-Item -ItemType SymbolicLink -Path "C:\path\to\wp-content\plugins\info-card-block" -Target "$PWD\plugins\info-card-block"
New-Item -ItemType SymbolicLink -Path "C:\path\to\wp-content\themes\wp-restaurant"    -Target "$PWD\themes\wp-restaurant"
New-Item -ItemType SymbolicLink -Path "C:\path\to\wp-content\themes\wp-droffice"      -Target "$PWD\themes\wp-droffice"
```

### 3. Build the block

```bash
cd plugins/info-card-block
npm install
npm run build
```

### 4. Activate in wp-admin

1. **Plugins → Info Card Block** — activate
2. **Appearance → Themes** — activate wp-restaurant (or wp-droffice)
3. **Settings → Reading** — set a static front page
4. Edit the front page → insert **Info Card** blocks from the Design category
5. Visit the site

## Development

```bash
# Watch mode — rebuilds block on every save
cd plugins/info-card-block && npm run start

# Lint JavaScript
npm run lint:js

# Lint CSS
npm run lint:css
```

## Themes

| Theme | Palette | Feel |
|-------|---------|------|
| `wp-restaurant` | Charcoal / Amber / Brick / Cream + Georgia serif | Warm, upscale dining |
| `wp-droffice` | White / Navy / Teal + Helvetica sans-serif | Clean, clinical, trustworthy |

Both themes override the shared `wp-block-portfolio-info-card` CSS class to apply their own card styling.

## CI

Every push and pull request runs two parallel jobs:

- **lint-php** — PHPCS with WordPress coding standards + `cs2pr` inline PR annotations
- **build-js** — `npm ci && npm run build` with artifact verification
