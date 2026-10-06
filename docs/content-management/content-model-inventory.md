# Content Model Inventory — Álmica Healing

> Audience: developers and future maintainers. This is the **as-built** inventory, written from the
> code on `main` on 2026-10-06. Where it disagrees with [`../content-model.md`](../content-model.md)
> (the pre-implementation proposal), **this file and the code win**. The client-facing guide built
> from this inventory is [`klaritty-content-management-guide.md`](klaritty-content-management-guide.md).
>
> Production state quoted below (counts, pages, menus, users, plugins) comes from a read-only WP-CLI
> query on 2026-10-06. It is a snapshot, not a contract.

## Where things are defined

| Concern | Location |
|---|---|
| CPT registration | `wp-content/plugins/almicahealing-core/includes/cpt/{servicio,curso,profesional,testimonio}.php` |
| Leads CPT ("Contactos") | `…/almicahealing-core/includes/contact/leads.php` |
| Field groups (SCF, registered in PHP via `acf_add_local_field_group()`) | `…/almicahealing-core/includes/fields/*.php` |
| Enumerations (modality, level, outcomes heading, benefit icons) | `…/almicahealing-core/includes/fields/bootstrap.php` |
| Options page "Ajustes de Álmica" + defaults | `…/fields/bootstrap.php`, `…/fields/ajustes.php` (`almicahealing_setting_defaults()`) |
| Field-read helpers (fallback logic) | `wp-content/themes/almicahealing/inc/fields.php` |
| Image sizes, menu locations | `wp-content/themes/almicahealing/inc/setup.php` |
| Templates | `wp-content/themes/almicahealing/*.php`, `template-parts/**` |
| Initial content | `…/almicahealing-core/includes/cli/{seed,seed-fields,import}.php`, `bin/migrations/2026-10-02-kw177-kw178.php` |

There is **no ACF JSON** and **no field group defined in the database**. Every group lives in PHP, so
the SCF "Field Groups" admin screen shows nothing editable for these groups — by design.

There are **no custom taxonomies**. Level and modality are select fields, not taxonomies. Built-in
Categories/Tags exist only on blog posts, which are not part of the content model.

## Production snapshot (2026-10-06)

| Item | State |
|---|---|
| Active plugins | `almicahealing-core`, `secure-custom-fields` 6.9.5, `breeze` (page cache), `object-cache-pro`; MU: analytics, environment |
| Servicios / Cursos / Profesionales / Testimonios | 11 / 3 / 6 / 3, all published |
| Contactos (leads) | 0 |
| Pages | Inicio (front page), Acerca de, Servicios, Cursos, Aviso de privacidad (Legal, set as WP privacy page), Términos y condiciones (Legal); plus **Sample Page** (published) and **Privacy Policy** (draft) — WordPress defaults |
| Posts | 1 — **"Hello world!"** (published) — WordPress default |
| Menus | "Menú principal" → `primary`: Inicio, Acerca de, Servicios, Cursos. "Menú de pie de página" → `footer`: Acerca de, Servicios, Cursos |
| Users | 1 administrator (Klaritty), 1 editor |

## Capability notes that shape the client guide

| Screen | Capability | Editor role can use it? |
|---|---|---|
| Servicios, Cursos, Profesionales, Testimonios, Páginas | `edit_posts` / `edit_pages` | Yes |
| Contactos (list, view, Exportar CSV) | `capability_type => page`, export needs `edit_posts`; `create_posts` disabled | Yes (view/export/trash only) |
| **Ajustes de Álmica** | `manage_options` | **No — Administrator only** |
| Apariencia → Menús | `edit_theme_options` | **No — Administrator only** |
| Ajustes → Generales (site title, tagline) | `manage_options` | **No — Administrator only** |

---

## 1. Servicio

| | |
|---|---|
| Admin label | **Servicios** (menu position 20; submenu "Servicios" + add-new). Edit screen: "Añadir servicio" / "Editar servicio" |
| Post type | `servicio` — public, no archive, rewrite `servicios` → `/servicios/{slug}/` |
| Supports | title, editor (block editor, `show_in_rest`), excerpt, thumbnail, page-attributes, custom-fields (hidden by the field group) |
| Purpose | One bookable individual session |
| Templates | `single-servicio.php` (detail); `template-parts/cards/servicio.php` (card) used by Home teaser (`sections/services.php`), Servicios page (`sections/services-catalog.php`), "Otros servicios" |
| Also feeds | Contact form "Servicio de interés" select (`contact/fields.php`) — every published service, by `menu_order` |
| Klaritty edits? | **Yes** |

### Fields

| Admin label | Name | Type | Req. | Constraints | Rendered where / notes |
|---|---|---|---|---|---|
| Title | `post_title` | native | ✔ | — | Card title, hero H1, "Otros servicios" cards, contact-form option, testimonial labels that point at it |
| Slug | `post_name` | native | ✔ | — | URL. Changing it changes the public URL (no redirects exist) |
| Content | `post_content` | block editor | (✔ by convention) | Paragraphs only, by convention | "Sobre este servicio" body (`the_content()`) |
| Excerpt | `post_excerpt` | native | – | — | Hero subtitle **only when "Frase del encabezado" is empty**; `<meta name="description">` / `og:description` (`inc/seo.php`). Not shown on cards |
| Featured image | thumbnail | native | (✔ by convention) | — | Card image (size `almicahealing-card`); hero background when "Imagen del encabezado" is empty |
| Order | `menu_order` | native | – | integer | Order in every listing, Home teaser, auto "Otros servicios" rotation, contact-form select |
| Frase del encabezado | `tagline` | text | – | maxlength 200 | Hero subtitle; falls back to excerpt |
| Imagen del encabezado | `hero_image` | image (ID) | – | — | Hero background (size `almicahealing-hero`, under a 70% green scrim); falls back to featured image |
| Precio | `price` | number | ✔ | min 0, step 0.01 | Inversión card, formatted `$1,150.00 MXN` (2 decimals, currency from Ajustes). Inversión card hidden only if empty |
| Base del precio | `price_basis` | text | – | maxlength 80 | Line under the price; falls back to Ajustes → `service_price_basis` |
| Duración (minutos) | `duration_minutes` | number | ✔ | 15–480, step 15, default 60 | Hero chip ("60 min") **and** Inversión card |
| Modalidad | `modality` | select | ✔ | `presencial` Presencial · `virtual` Virtual · `hibrida` Presencial y virtual; default presencial | Inversión card |
| Beneficios | `benefits` | repeater (block) | ✔ | 1–6 rows; button "Añadir beneficio" | "Lo que esta sesión puede ofrecerte" grid (`parts/benefit-grid.php`); section hidden if no rows |
| ↳ Icono | `icon` | select | ✔ | 10 slugs (below), default `corazon` | Inline SVG from `assets/img/icons/beneficio-{slug}.svg` |
| ↳ Título | `title` | text | ✔ | maxlength 90 | Tile title; a row with an empty title is skipped |
| ↳ Descripción | `description` | textarea | – | maxlength 180 | **If it starts with a lower-case letter it renders inline as a continuation of the title** (`almicahealing_starts_lowercase()`); otherwise as a separate paragraph |
| Quién imparte | `professionals` | relationship → profesional | – | max 3, search filter | "Quién imparte" — full block (photo, name, role, bio) per person. **Section hidden when empty** (decision D4) |
| Otros servicios | `related_services` | relationship → servicio | – | max 3 | Manual override. Empty ⇒ next 3 services by `menu_order`, wrapping (`almicahealing_related_services()`). If 1–2 are picked, only those show |
| Destacado en Inicio | `is_featured` | true/false (toggle) | – | default off | Home teaser: `meta_value = 1`, `posts_per_page 6`, by `menu_order`. >6 flagged ⇒ only the first 6 show. 0 flagged ⇒ **the whole Home services section is hidden** |
| Incluye cuadernillo | `includes_workbook` | true/false (toggle) | – | default off | Adds the line "Incluye cuadernillo descargable." under the description. No file delivery exists |

Benefit icon choices (`almicahealing_benefit_icon_choices()`): Corazón, Ondas, Brote, Ojo, Círculos,
Equilibrio, Espiral, Manos, Luna, Chispa. Per `assets/img/icons/README.md`, **Chispa, Equilibrio,
Espiral and Luna are still the older stroked drawings**; the other six are the designer's delivered
art, so mixing the two groups on one service shows two icon styles.

Hard-coded on the template (not editable): "Volver a servicios", eyebrow "Servicios", "Sobre este
servicio", "Inversión", "Duración", "Modalidad", "Beneficios", "Lo que esta sesión puede ofrecerte",
"Quién imparte", "Otros servicios", "Ver más" (card), "Incluye cuadernillo descargable.".

Production: 11 services; 6 are featured (orders 1–6).

---

## 2. Curso

| | |
|---|---|
| Admin label | **Cursos** (menu position 21). "Añadir curso" / "Editar curso" |
| Post type | `curso` — public, no archive, rewrite `cursos` → `/cursos/{slug}/` |
| Supports | title, editor, excerpt, thumbnail, page-attributes |
| Purpose | A multi-week training programme |
| Templates | `single-curso.php`; `cards/curso.php` (full variant on Home + Cursos page with "01/02/03" counter; compact variant in "Otros programas") |
| Klaritty edits? | **Yes** |

| Admin label | Name | Type | Req. | Constraints | Rendered where / notes |
|---|---|---|---|---|---|
| Title | `post_title` | native | ✔ | — | Card, hero H1, compact card overlay, testimonial labels |
| Slug | `post_name` | native | ✔ | — | URL |
| Content | `post_content` | block editor | (✔) | — | "Sobre el curso" |
| Excerpt | `post_excerpt` | native | (✔ by convention) | — | **Card summary** (Home + Cursos page); hero subtitle when tagline empty; meta description |
| Featured image | thumbnail | native | (✔) | — | Card (4:5 box), compact card (4:3 box), hero fallback |
| Order | `menu_order` | native | – | — | Cursos page order + "01" counter; Home shows **first 3 only**; "Otros programas" order |
| Frase del encabezado | `tagline` | text | – | maxlength 250 | Hero subtitle; falls back to excerpt |
| Etiqueta del programa | `program_label` | text | ✔ | maxlength 80 | Pill above the hero title |
| Nivel | `level` | select | ✔ | `basico` Básico · `intermedio` Intermedio · `abierto` Abierto a todos | **Only** on compact "Otros programas" cards |
| Precio | `price` | number | – | min 0, step 1 | Inversión card, formatted `$5,900 MXN` (no decimals). **Empty ⇒ Inversión card hidden; card + contact card show Ajustes → `price_on_request_text`** |
| Duración | `duration` | text | – | maxlength 40 | Inside the Inversión card only — **not shown when Precio is empty** |
| Encabezado de la lista | `outcomes_heading` | select | ✔ | `objetivos` Objetivos · `beneficios` Beneficios · `temas` Temas | Heading of the numbered box |
| Puntos de la lista | `outcomes` | repeater (table) | ✔ | 1–10 rows; "Añadir punto" | Numbered `<ol>`; numbers are automatic |
| ↳ Texto | `text` | text | ✔ | maxlength 200 | |
| Facilitador/a | `facilitators` | relationship → profesional | (min 1) | 1–2 | Sidebar card per person — **compact: photo, name, role only (no bio)** |

Global copy on every course page (from Ajustes): contact card title/body, price-on-request text, contact email.

Hard-coded: "Volver a cursos", "Sobre el curso", "Inversión", "Facilitador/a", "Otros programas".
"Otros programas" is not a field: it is every other published course.

Production: 3 courses — Kriutunmi (1), Clantanra (2), Lo Que Nadie Nos Enseñó (3).

---

## 3. Profesional

| | |
|---|---|
| Admin label | **Profesionales** (menu position 23). "Añadir profesional" / "Editar profesional" |
| Post type | `profesional` — `public => false`, `show_ui`, `rewrite => false` — **no public page** |
| Supports | title, editor, thumbnail, page-attributes |
| Purpose | A therapist/facilitator/founder written once and referenced from services, courses and Acerca de |
| Template | `template-parts/parts/profesional.php` (full and compact variants) |
| Klaritty edits? | **Yes** |

| Admin label | Name | Type | Req. | Constraints | Rendered where |
|---|---|---|---|---|---|
| Title | `post_title` | native | ✔ | — | Name (all contexts); portrait `aria-label` |
| Content | `post_content` | block editor | (✔) | — | Bio, via `wpautop()` + `wp_kses_post()` — full variant only (service "Quién imparte", Acerca de founder). **Not shown in course sidebar** |
| Featured image | thumbnail | native | (✔) | — | Portrait, size `almicahealing-portrait` (400×400 hard crop) drawn as a 128 px circle (48 px in compact). Empty ⇒ plain circle |
| Order | `menu_order` | native | – | — | **Not used by any template** (relationship fields keep their own order) |
| Rol | `role` | text | ✔ | maxlength 140 | Gold line under the name |
| Formación | `credentials` | repeater (block) | – | 0..n; "Añadir formación" | **Only rendered for whoever is selected as "Fundadora" on Acerca de** (`sections/formacion.php`) |
| ↳ Título | `title` | text | ✔ | maxlength 160 | |
| ↳ Año | `year` | number | – | 1900–2100 | |
| ↳ Institución | `institution` | text | – | maxlength 160 | |
| ↳ Descripción | `description` | textarea | – | — | |

Production: 6 — Alma Solís, Elizabeth de las Casas, Gabriela Domínguez, Tonatiuh Muñoz, Perla Barrones,
Alberto Solís.

Note: `parts/profesional.php` checks `get_post_type()` but not post status. Whether a trashed
professional still renders where referenced depends on SCF's relationship formatting — **not
verified**. The client guide therefore tells editors to unlink a person before trashing them.

---

## 4. Testimonio

| | |
|---|---|
| Admin label | **Testimonios** (menu position 22). "Añadir testimonio" / "Editar testimonio" |
| Post type | `testimonio` — `public => true` but `rewrite => false`; no template uses a single view |
| Supports | title, editor, excerpt, page-attributes |
| Template | `template-parts/sections/testimonials.php` (Home slider, all published, by `menu_order`; dots when >1) |
| Klaritty edits? | **Yes** |

| Admin label | Name | Type | Req. | Notes |
|---|---|---|---|---|
| Title | `post_title` | native | ✔ | Client display name. Content-model convention: first name + initial ("Valentina R.") |
| Content | `post_content` | block editor | ✔ | Printed as **plain text** (`wp_strip_all_tags`) — formatting, links and paragraph breaks are dropped. Content model recommends ≤ 300 chars |
| Sobre | `about` | post object → servicio \| curso | – | Label under the name = that post's **current** title. Empty ⇒ no label |
| Order | `menu_order` | native | – | Slider order |
| Excerpt | `post_excerpt` | native | – | **Legacy, not rendered.** Superseded by `about` (KW-153); the seeder still writes it |

Section title comes from Inicio → "Testimonios (título)".

---

## 5. Pages

All pages use the block editor. Field group **"Encabezado de página"** (`group_page_hero`) is attached
to **every** page, but each template reads only some of its fields:

| Field (label) | Name | Type | Constraints |
|---|---|---|---|
| Antetítulo | `hero_eyebrow` | text | maxlength 60 |
| Título | `hero_title` | text | maxlength 120 |
| Subtítulo | `hero_subtitle` | textarea | — |
| Imagen de fondo | `hero_image` | image (ID) | — |
| Texto del botón | `hero_cta_label` | text | maxlength 60 |
| Enlace del botón | `hero_cta_url` | **text** (not URL/link) | output through `esc_url()` |

Empty hero fields fall back to the designed copy hard-coded in each template
(`almicahealing_hero_field()`), so **clearing a hero field restores the original text rather than
hiding it**.

| Page (slug) | Template | Hero fields actually used | Other editable content | `post_content` rendered? |
|---|---|---|---|---|
| Inicio (`inicio`, static front page) | `front-page.php` | all six (image fallback `home-hero.jpg`; CTA fallback "Conoce Álmica Healing" → `/acerca-de/`) | group **"Inicio"** (below) | **No** |
| Acerca de (`acerca-de`) | `page-acerca-de.php` | eyebrow, title, subtitle, image (fallback `acerca-de-hero.jpg`) | group **"Acerca de"** → Fundadora | **No** — see gap G1 |
| Servicios (`servicios`) | `page-servicios.php` | eyebrow, title, subtitle, image (no image fallback ⇒ plain green) | — (grid is a query) | **No** |
| Cursos (`cursos`) | `page-cursos.php` | eyebrow, title, subtitle, image (no fallback) | — | **No** |
| Aviso de privacidad (`aviso-de-privacidad`) | Template **Legal** (`page-templates/legal.php`) | **none** | — | **Yes** — the document. `<h2>` per section, auto-numbered by CSS counter |
| Términos y condiciones (`terminos-y-condiciones`) | Template **Legal** | **none** | — | **Yes** |
| Any other page | `page.php` | none | — | Yes, title + content, no hero, minimal styling |

### Group "Inicio" (`group_home`, location `page_type == front_page`)

| Label | Name | Type | Notes |
|---|---|---|---|
| Introducción | `intro` | group | |
| ↳ Título / Texto / Imagen / Texto del botón / Enlace del botón | `title`, `body` (WYSIWYG, basic toolbar, no media), `image`, `cta_label`, `cta_url` (text) | | Image rendered at `almicahealing-hero` size in an arched 2.5:3 frame (centre only visible). Empty `cta_label` hides the button |
| Servicios (encabezado) | `services_intro` | group: `eyebrow`, `title`, `subtitle` | Header of the featured-services teaser |
| Cómo funciona | `process_steps` | repeater, **exactly 3** rows: `title` ✔, `body` ✔ | Icons and 01/02/03 numbers come from the theme; heading "Procesos / Tu proceso comienza aquí" is hard-coded |
| Cita | `quote` | group: `line_1`, `line_2` (italic), `image` | Background under a flat 50% green wash |
| Cursos (encabezado) | `courses_intro` | group: `eyebrow`, `title`, `body` | Header of the courses teaser |
| Testimonios (título) | `testimonials_title` | text | Falls back to "Experiencias que dejan huella." |

Fallback subtlety: group sub-fields use `??`, which only catches `null`. Once a group has been saved
(the importer saved all of them on production), an **empty** sub-field renders **empty** (blank
heading, hidden button) instead of falling back — except `intro.body`, `intro.image` and
`quote.image`, which fall back on any falsy value. Net advice for editors: don't clear these to hide
things.

### Group "Acerca de" (`group_acerca_de`)

Located by **page ID resolved from slug `acerca-de` at runtime** (`almicahealing_page_location()`).
Renaming the slug makes the field group disappear.

| Label | Name | Type | Req. | Notes |
|---|---|---|---|---|
| Fundadora | `founder` | post object → profesional | ✔ | Drives the founder block (photo, name, role, bio) **and** the "Formación" list (that person's `credentials`). Empty ⇒ both sections hidden |

Hard-coded on Acerca de: the entire **"Historia / Nosotros"** block (`sections/historia.php`), the
"Formación" heading.

### Slug-dependent behaviour (do not rename these pages)

| Slug | Depends on it |
|---|---|
| `acerca-de` | Acerca de field group location; Home hero/intro CTA fallbacks (`/acerca-de/`) |
| `servicios` | "Volver a servicios" link, "Ver todos los servicios" button (`almicahealing_page_url()`); service URLs share the prefix |
| `cursos` | "Volver a cursos" link; course URLs share the prefix |
| `aviso-de-privacidad`, `terminos-y-condiciones` | Legal tab bar; footer "Términos y condiciones" link (the "Aviso de privacidad" footer link uses the WP privacy-page setting) |
| `inicio` | Importer `paginas` mapping (front page itself is set by option, not slug) |
| `gracias` (does not exist) | Contact form redirects here if a page with this slug is ever created; otherwise to Home |

---

## 6. Global settings — "Ajustes de Álmica"

Options page `almica-ajustes`, menu position 24, **capability `manage_options` (Administrators only)**,
save button "Guardar ajustes". Field group `group_ajustes`. Every value falls back to
`almicahealing_setting_defaults()` when empty, so **clearing a field restores the default**, it does
not hide it (except where the default is itself empty).

| Tab | Label | Name | Type | Default | Rendered where |
|---|---|---|---|---|---|
| Contacto | Correo de contacto | `contact_email` | email | almicahealing@gmail.com | Footer (mailto), course contact card (mailto), legal note (mailto) |
| Contacto | Teléfono | `phone` | text | +52 81 7008 8058 | Footer, **plain text (not a `tel:` link)** |
| Contacto | WhatsApp | `whatsapp` | text | (empty) | **Not rendered anywhere** (field instructions say otherwise) |
| Contacto | Ubicación | `location_label` | text | México · sesiones virtuales | Footer |
| Redes sociales | Instagram | `social_instagram` | url | (empty) | Footer "IG" button; empty ⇒ links to `#` (button still shown) |
| Redes sociales | Facebook | `social_facebook` | url | (empty) | Footer "FB" button; empty ⇒ `#` |
| Redes sociales | TikTok | `social_tiktok` | url | (empty) | **Not rendered** — commented out in `footer/social.php` at the client's request |
| Pie de página | Descripción | `footer_blurb` | textarea | Bienestar integral… | Footer under the logo |
| Pie de página | Lema | `footer_tagline` | text | El equilibrio que da origen a todo | Footer bottom bar |
| Precios | Moneda | `currency_label` | text | MXN | Suffix on **every** price |
| Precios | Base del precio (servicios) | `service_price_basis` | text | por sesión individual | Service Inversión card, unless the service overrides it |
| Precios | Texto de precio a consultar | `price_on_request_text` | text | Escríbenos para conocer el precio | Course card + course contact card when a course has no price |
| Cursos | Título de la tarjeta de contacto | `course_inquiry_title` | text | ¿Te interesa este programa? | Every course sidebar |
| Cursos | Texto de la tarjeta de contacto | `course_inquiry_body` | textarea | Escríbenos directamente… | Every course sidebar |
| Legales | Nota de contacto | `legal_contact_note` | textarea | Para cualquier duda… | Bottom of both legal pages, followed by the contact email |

Other site-wide values outside Ajustes:

| Value | Where edited | Used for |
|---|---|---|
| Site title (`blogname`) | Ajustes → Generales (admin) | Footer © line, logo alt text, `<title>` |
| Tagline (`blogdescription`) | Ajustes → Generales (admin) | Fallback meta description (e.g. Home, which has no excerpt) |
| Primary menu | Apariencia → Menús (admin), location "Menú principal" | Header nav, `depth => 1` (no dropdowns) |
| Footer menu | Apariencia → Menús (admin), location "Menú de pie de página" | Footer "Navegación" column, `depth => 1` |
| Privacy page | Ajustes → Privacidad (admin) | Footer "Aviso de privacidad" link — currently the Aviso de privacidad page |

The footer "Legal" and "Contacto" columns are **not** menus; they are built by the template.

---

## 7. Contactos (leads) — read-only for editors

| | |
|---|---|
| Admin label | **Contactos** → "Todos los contactos" (menu position 26). "Add new" disabled |
| Post type | `almica_contacto` — not public |
| What editors can do | Read entries (meta box "Datos del contacto"), **Exportar CSV** button, trash |
| Retention | Weekly cron trashes entries older than **18 months** |
| Notification recipient | `ALMICAHEALING_NOTIFY_TO` constant or filter, default `almicahealing@gmail.com` — **independent of Ajustes → Correo de contacto**. The "From" address is the same value |
| Form fields | Nombre completo ✔, Correo electrónico ✔, Número de teléfono, País ✔ (default MX), Servicio de interés (all published services), Mensaje ✔ — all hard-coded in `contact/fields.php` |
| Placement | The form renders only via `template-parts/sections/contact.php`, which is included only by `single.php` (blog posts). On production the only post is the default "Hello world!". **Not placed on any page in the main navigation.** |

---

## 8. Content that exists but Klaritty should not normally modify

| Item | Why |
|---|---|
| Page slugs listed in §5 | Templates, links and a field-group location depend on them |
| Service/course slugs | Public URLs; no redirect handling exists |
| Template choice on legal pages ("Legal") | Removing it drops the hero, tabs and numbering |
| Ajustes → Lectura (static front page = Inicio) | Home fields are located by `front_page` |
| Contactos entries | Personal data; read/export only |
| Entradas (blog posts) | Not part of the design; the only post is the WP default |
| Sample Page, draft Privacy Policy | WP defaults left over from install |
| Plugins, SCF "Field Groups" screen, Apariencia → Editor/Personalizar | Structure/presentation |
| Testimonio "Extracto" | Legacy field, not rendered |
| Ajustes → WhatsApp, TikTok | No effect today; changing them won't change the site |

---

## 9. Initial-import tooling (history, not the ongoing workflow)

| Tool | What it does | Re-run risk |
|---|---|---|
| `wp almicahealing seed` (`cli/seed.php`) | Creates baseline pages, services, courses, testimonials, menus (menus only if empty), sets front page, privacy page, permalinks | Updates matched posts in place (by `_almicahealing_seed_key`, then by title) — **overwrites titles/order/excerpts edited in wp-admin** |
| `cli/seed-fields.php` | Seeds professionals and SCF fields, migrates legacy meta, repoints menus | Same: overwrites fields |
| `wp almicahealing import <file.xlsx> [--dry-run]` (`cli/import.php`, KW-155) | Validates then imports sheets `profesionales`, `profesional_formacion`, `servicios`, `servicio_beneficios`, `cursos`, `curso_puntos`, `testimonios`, `ajustes`, `paginas`. Images are matched by **file name already in the Media Library** (never uploaded) | Updates in place by seed key — **any wp-admin edit to an imported field is overwritten**. Repeaters are replaced wholesale |
| `bin/migrations/2026-10-02-kw177-kw178.php` | One-off renames, catalog order, service hero photos | Idempotent; one-off |

Workbooks in `docs/` (`almica-contenido*.xlsx`, `Información sitio ÁlmicaHealing.xlsx`) are the
historical source. **From handover on, WordPress is the source of truth.** Do not re-run the seeder
or importer against production after Klaritty starts editing unless the run is scoped and agreed,
or edits will be lost.

---

## 10. Image sizes (from `inc/setup.php` + CSS)

| Use | WP size requested | Display box | Notes for editors |
|---|---|---|---|
| Service card (featured image) | `almicahealing-card` 640×480 hard crop (4:3) | 3:4 portrait card, `object-cover` | Only the centre ~56% of the width is visible |
| Course card (featured image) | `almicahealing-card` 640×480 | 4:5 (full card), 4:3 (compact) | Centre-weighted |
| Detail heroes (service/course) | `almicahealing-hero` 1600×900 hard crop (16:9) | Full-width background, `bg-cover`, 70% green scrim | Image mostly a texture behind centred text |
| Page heroes (Inicio, Acerca de, Servicios, Cursos) | `almicahealing-hero` | Full-width background | Home: left-to-right dark gradient — subject reads best on the **right** |
| Home intro image | `almicahealing-hero` (16:9) | Arched 2.5:3 frame | Only the centre is visible |
| Home quote background | `almicahealing-hero` | Full-width, flat 50% green wash | |
| Professional portrait | `almicahealing-portrait` 400×400 hard crop | Circle 128 px / 48 px | Face centred, with margin |

If an upload is smaller than the requested size WordPress does not create that crop and serves the
original, so the hard crops above only apply to images at least that large. Nothing validates image
dimensions on upload.

---

## 11. Gaps and items needing verification

| # | Item | Status |
|---|---|---|
| G1 | Acerca de "Nosotros" text: the importer writes `paginas` → `Acerca de / nosotros` into `post_content`, but `page-acerca-de.php` renders the hard-coded `sections/historia.php` and never calls `the_content()`. Editing the page body has no effect | Gap — dev decision |
| G2 | Ajustes → WhatsApp: field instructions say "Vacío oculta las menciones a WhatsApp", but no template reads it | Gap |
| G3 | Contact form is only reachable from blog post singles; leads = 0 on production | Needs product decision |
| G4 | Default "Hello world!" post and "Sample Page" are published on production | Cleanup decision for Ian |
| G5 | wp-admin display language for each user (custom labels are Spanish in code; core WP labels follow the site/user locale). A WP-CLI dump on production returned English core labels | Needs verification |
| G6 | Exact text of the core "add new" button in the editors' locale | Needs verification |
| G7 | Breeze: whether the Editor role sees the purge-cache control, and whether saving a post purges the affected pages automatically | Needs verification |
| G8 | Behaviour of a trashed `profesional` still referenced by a relationship | Needs verification |
| G9 | Klaritty user roles: content editors are Editors (no Ajustes/Menús access) unless given Administrator | Needs verification |
| G10 | `phone` is printed as plain text — no click-to-call | By design or gap — dev decision |
| G11 | No CPT declares `revisions` in `supports`, so Servicios/Cursos/Profesionales/Testimonios have **no revision history**; only Pages do. The options page never has revisions | Known limitation — consider adding `revisions` support (dev decision) |
