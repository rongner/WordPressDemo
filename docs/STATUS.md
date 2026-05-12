# WordPressDemo — Project Status

## Goal

Portfolio project demonstrating WordPress development skills for job applications.
Single repo with a shared Gutenberg block plugin consumed by two distinct themes.

---

## Requirements

### Plugin: `info-card-block`
- [x] `block.json` with apiVersion 3, all 8 attributes defined
- [x] Static `save()` — stores HTML in post content, shows full React save/edit pattern
- [x] `MediaUpload` / `MediaUploadCheck` image picker
- [x] `RichText` inline editing for heading, body, and button label
- [x] `InspectorControls` sidebar — button URL + color picker
- [x] Separate editor CSS (`index.css`) and frontend CSS (`style-style.css`)
- [x] `webpack.config.js` override for correct output naming
- [x] PHP plugin file using `register_block_type( __DIR__ )`

### Theme: `wp-restaurant`
- [x] Palette: charcoal / amber / brick / cream — Georgia serif
- [x] Fixed header with dark translucent backdrop
- [x] `front-page.php` sections: Hero → Menu Highlights → About → Reservations → Footer
- [x] Info Card block overrides (`wp-block-portfolio-info-card`) for restaurant styling
- [x] Responsive layout (mobile nav hidden, single-column cards)
- [ ] `screenshot.png` (1200×900) for wp-admin Themes page
- [ ] Hero background image (currently falls back to solid charcoal)
- [ ] Nav menu wired up in wp-admin (Appearance → Menus)

### Theme: `wp-droffice`
- [x] Palette: white / navy / teal / light bg — Helvetica sans-serif
- [x] Sticky white header with box-shadow + Book Appointment CTA
- [x] `front-page.php` sections: Hero (split-screen) → Services → About Doctor → Contact & Hours → Footer
- [x] Info Card block overrides for medical styling
- [x] Responsive layout
- [ ] `screenshot.png` (1200×900) for wp-admin Themes page
- [ ] Nav menu wired up in wp-admin
- [ ] End-to-end test with Info Card blocks

### CI / Repo
- [x] `.github/workflows/ci.yml` — PHPCS WordPress lint + JS build with artifact verification
- [x] `.gitignore` — excludes `node_modules/` and `build/`
- [x] `README.md` with install steps and symlink commands
- [x] Pushed to https://github.com/rongner/WordPressDemo

---

## Optional Enhancements

- [ ] `theme.json` for each theme — block editor color palette and font sizes (demonstrates modern WP knowledge)
- [ ] Second Gutenberg block — testimonial or staff card
- [ ] Widget / sidebar support in themes

---

## Local Dev Setup

- Tool: **Local by WP Engine** — site name `wordpress-demo`
- Symlinks created via `symlink.bat` (run as Administrator)
- Block already built — run `npm run start` in `plugins/info-card-block/` for watch mode
