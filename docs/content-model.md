# Content Model

> Status: **proposal — nothing here is implemented yet.**
> Source analysed: Figma file *Álmica-Healing*, page **Website - MV1** (`node-id=146-30`), inspected 2026-09-18.
> Also consulted for context only: pages *Mapa de sitio* and *Website - MV2* (see [Open Questions](#open-questions)).
> Machine-readable companion: [`content-model.yaml`](content-model.yaml).

## Executive Summary

The MV1 page contains **20 frames**, but they are only **7 distinct layouts**. 16 of the 20 frames are
instances of 3 repeatable templates:

| Template | Frames | What varies between frames |
|---|---|---|
| Service detail | 11 | copy, price, images, number of benefits, therapist |
| Course detail | 3 | copy, price/duration, level, list heading |
| Legal document | 2 | copy, active tab |

The other 4 frames are unique pages: Home, Acerca de, the Servicios listing, and the Cursos listing.
In Figma the Cursos listing frame is misnamed "Set Typography Styles".

The design has four domain entities:

- **Servicio**: a bookable individual session (11 instances).
- **Curso**: a multi-week program (3 instances).
- **Profesional**: the person who delivers a service or course. Five names appear, one of them twice
  (as a therapist and as the founder).
- **Testimonio**: a client quote.

The theme already has `servicio`, `curso` and `testimonio` post types. The main gap is that
**Profesional doesn't exist as an entity yet**. In Figma the same therapist card (photo, name, role,
two-paragraph bio) is copied by hand onto up to five service frames. That copying has already produced
wrong data in the design: frames with the wrong name, the wrong photo or another therapist's bio. This
is the strongest argument for making Profesional a relationship target rather than repeating it inside
each service.

A fifth entity, **Producto** (candles and workbooks), appears only in the sitemap and in MV2. It's
documented here as provisional and is outside MV1 scope.

No taxonomy is needed for MV1. The one real taxonomy candidate is product category (MV2).

## Figma Pattern Analysis

### Page patterns

| Pattern | Kind | Frames | Notes |
|---|---|---|---|
| **Home** | Unique page | 1 | Hero, intro, services teaser (6 featured), "Tu proceso comienza aquí" (3 steps), quote interlude, courses teaser, testimonial slider, footer |
| **Acerca de** | Unique page | 1 | Hero, "Nosotros" history text, founder profile (Alma Solís), "Formación" credentials list |
| **Servicios** | Listing | 1 | Hero plus a grid of all 11 service cards (image, title, "Ver más") |
| **Cursos** ("Set Typography Styles") | Listing | 1 | Hero ("Formación / Programas para crecer desde adentro.") plus 3 course cards (image, level badge, title, summary, price and duration **or** "Escríbenos para conocer el precio", "Ver más") |
| **Servicio detail** | Instance template | 11 | See below |
| **Curso detail** | Instance template | 3 | See below |
| **Legal** | Instance template | 2 | Shared hero "Información legal y de privacidad." with two tabs (Aviso de Privacidad / Términos y Condiciones), intro line, numbered sections (title and body), contact note box |

### Servicio detail anatomy (identical across all 11 frames)

1. Header navigation (global)
2. Hero: "← Volver a servicios", eyebrow "SERVICIOS", **title**, **tagline**, **duration chip** ("60 min")
3. "SOBRE ESTE SERVICIO": **description** (2 paragraphs)
4. "INVERSIÓN" card: **price** ("$850.00 MXN"), "por sesión individual", Duración (**same value as the hero chip**), **Modalidad** ("Presencial")
5. "BENEFICIOS / Lo que esta sesión puede ofrecerte": **1–5 benefit tiles** (icon, title, optional description)
6. "QUIÉN IMPARTE": **therapist** (round photo, name, role line, 2-paragraph bio)
7. "OTROS SERVICIOS": 3 related service cards
8. Footer (global)

### Curso detail anatomy (identical across all 3 frames)

1. Header navigation ("Cursos" active)
2. Hero: **program label pill** ("CURSO INTERMEDIO DE CANALIZACIÓN Y SANACIÓN"), **title**, **tagline**
3. "SOBRE EL CURSO": **description** (2 paragraphs)
4. Numbered list box. **The heading varies**: "OBJETIVOS" (Clantanra), "BENEFICIOS" (Riutunmi), "TEMAS" (Lo Que Nadie Nos Enseñó)
5. Sidebar: "INVERSIÓN" card (**price** and **duration**, e.g. "$5,900 MXN / 2 meses"), omitted when the price is on request (Clantanra); "FACILITADOR/A" card (**professional** photo and name); "¿TE INTERESA ESTE PROGRAMA?" card (**global** copy and the courses email)
6. "OTROS PROGRAMAS": the other courses (image, level, title)
7. Footer (global)

### Site-wide components (not content types)

- **Header**: logo plus the primary menu (Inicio, Acerca de, Servicios, Cursos; MV2 adds Tienda).
- **Footer**: logo and blurb; NAVEGACIÓN (Acerca de, Servicios, Cursos, Tienda, Contáctanos); LEGAL (Términos y condiciones, Aviso de privacidad); CONTACTO (email, phone, "México · sesiones virtuales", IG/FB/TK); copyright; tagline "El equilibrio que da origen a todo".
- **Service card**: used by the Home teaser, the Servicios grid and "Otros servicios".
- **Course card**: used by the Home teaser, the Cursos grid and "Otros programas".

### Semantic duplication found in the UI (stored once in the model)

| UI appears in… | Single field |
|---|---|
| Service hero chip "60 min" **and** Inversión › Duración | `servicio.duration_minutes` |
| Service card title, hero title, "Otros servicios" card, contact-form "Servicio de interés" option | `post_title` |
| Service card image and "Otros servicios" image | featured image |
| Therapist block repeated on every service they deliver | one `profesional` post |
| Founder on Acerca de **and** "Facilitador/a" on every course | one `profesional` post (Alma Solís) |
| Course level badge on listing cards, "Otros programas" cards, Home teaser | `curso.level` |
| Courses email on 3 course pages | global `courses_email` |
| Footer contact block on every frame | global settings |

## Domain Model

```mermaid
erDiagram
    SERVICIO }o--|{ PROFESIONAL : "impartido por"
    CURSO    }o--|{ PROFESIONAL : "facilitado por"
    SERVICIO ||--|{ BENEFICIO  : "ofrece (repeater)"
    CURSO    ||--|{ PUNTO_PROGRAMA : "objetivos/beneficios/temas (repeater)"
    PROFESIONAL ||--o{ CREDENCIAL : "formación (repeater)"
    TESTIMONIO }o--o| SERVICIO : "sobre"
    TESTIMONIO }o--o| CURSO : "sobre"
    PAGINA_ACERCA_DE }o--|| PROFESIONAL : "fundadora"
    SERVICIO }o--o| PRODUCTO : "incluye cuadernillo (provisional)"
    PRODUCTO }o--|| CATEGORIA_PRODUCTO : "provisional, MV2"
```

| Entity | Independent lifecycle | Reused | Own URL | Decision |
|---|---|---|---|---|
| Servicio | yes | cards in 3 places, contact form | yes | CPT (exists) |
| Curso | yes | cards in 3 places | yes | CPT (exists) |
| Profesional | yes (joins and leaves the practice) | yes: 1 → up to 5 services, 3 courses, Acerca de | not in MV1 | CPT, **not publicly queryable** |
| Testimonio | yes | Home slider | no | CPT (exists), not public |
| Beneficio | no, only meaningful inside one service | no (the texts differ per service) | no | repeater on Servicio |
| Punto de programa | no | no | no | repeater on Curso |
| Credencial | no | no | no | repeater on Profesional |
| Nivel de curso | n/a | 3 fixed values, no listing per level | no | select field, **not** a taxonomy |
| Modalidad | n/a | fixed values, no filtering | no | checkbox field |
| Producto | yes | shop listing, maybe linked from services | TBD | provisional CPT (MV2) |
| Categoría de producto | n/a | tab filter with counts | TBD | provisional taxonomy (MV2) |

Why these are fields rather than taxonomies: level and modality have a few fixed values, no archive
page, and nothing in the design filters by them. A taxonomy would add admin screens and term
management without any benefit. If the Cursos page ever gets filters, promote `level` to a taxonomy.

## Content Types

Conventions:

- Post-type keys stay **Spanish**, as already registered (`servicio`, `curso`, `testimonio`). Renaming
  them would orphan existing content and permalinks.
- Field names are **English snake_case semantic names**.
- "Rec. limit" means a layout-driven recommendation, not a business rule. Enforce it softly (character
  counter or warning), not as a hard block, unless marked otherwise.

### Servicio

Purpose: an individual session that can be booked. Shown as a card in listings and has its own detail
page. WordPress object: **CPT `servicio`** (exists). Editor-managed: yes. Reusable: yes.

| Field | Source | Type | Req. | Card. | Default | Validation / notes |
|---|---|---|---|---|---|---|
| title | `post_title` | text | ✔ | 1 | — | Rec. ≤ 60 chars. Some titles wrap to 2 lines in the hero, and the design allows that |
| slug | `post_name` | slug | ✔ | 1 | from title | Stable import ID. URL `/servicios/{slug}/` |
| summary | `post_excerpt` | textarea | ✔ | 1 | — | Rec. ≤ 160 chars. Hero subtitle unless `tagline` is set; also used as the meta description |
| tagline | ACF | text | – | 0..1 | falls back to `summary` | Hero subtitle override |
| description | `post_content` | rich text | ✔ | 1 | — | "Sobre este servicio", 1–3 paragraphs, no headings |
| card_image | featured image | image | ✔ | 1 | — | Service card and "Otros servicios". Min 800×1000, portrait crop |
| hero_image | ACF | image | – | 0..1 | falls back to featured image | Figma uses a different photo in the hero than on the card for several services |
| price | ACF | number | ✔ | 1 | — | ≥ 0, 2 decimals, MXN. Shown as "$1,150.00 MXN" |
| price_basis | ACF | text | – | 0..1 | global `service_price_basis` ("por sesión individual") | Override only when a service isn't priced per session |
| duration_minutes | ACF | number | ✔ | 1 | 60 | Integer 15–480. Rendered in **both** the hero chip and the Inversión card |
| modality | ACF | checkbox | ✔ | 1..2 | `presencial` | `presencial`, `virtual`. ⚠ see Open Questions Q3 |
| benefits | ACF | repeater | ✔ | 1..6 | — | See Beneficio. Observed 1–5 per service |
| professionals | ACF | relationship → `profesional` | ✔ | 1..3 | — | "Quién imparte". Observed exactly 1 per service. More than one renders stacked cards |
| related_services | ACF | relationship → `servicio` | – | 0..3 | automatic (see Q5) | "Otros servicios". Leave empty to fill automatically |
| is_featured | ACF | true/false | – | 1 | false | Shown in the Home teaser (6 slots). Replaces the existing `_almicahealing_featured` meta |
| includes_workbook | ACF | true/false | – | 1 | false | From the Figma sticky note. ⚠ Q6 |
| order | `menu_order` | number | – | 1 | 0 | Order in every listing |

**Beneficio** (repeater row, embedded)

| Field | Type | Req. | Validation |
|---|---|---|---|
| icon | select (from a fixed theme icon set) | ✔ | One of the icon slugs (see Q8). Editors never upload icons |
| title | text | ✔ | Rec. ≤ 70 chars |
| description | textarea | – | Rec. ≤ 140 chars. Empty in several frames (Futuros Posibles, Limpieza y Conexión con Personas / Emocional) and the tile must still work without it |

### Curso

Purpose: a multi-week training program led by a facilitator. WordPress object: **CPT `curso`** (exists).
Editor-managed: yes. Reusable: yes.

| Field | Source | Type | Req. | Card. | Default | Validation / notes |
|---|---|---|---|---|---|---|
| title | `post_title` | text | ✔ | 1 | — | |
| slug | `post_name` | slug | ✔ | 1 | — | URL `/cursos/{slug}/` |
| summary | `post_excerpt` | textarea | ✔ | 1 | — | Listing card and Home teaser text. Rec. ≤ 160 chars. **Differs** from the hero tagline in Figma |
| tagline | ACF | text | – | 0..1 | falls back to `summary` | Hero subtitle |
| description | `post_content` | rich text | ✔ | 1 | — | "Sobre el curso" |
| image | featured image | image | ✔ | 1 | — | Card, hero and "Otros programas" all use the same photo in Figma |
| program_label | ACF | text | ✔ | 1 | — | Hero pill, e.g. "Curso intermedio de canalización y sanación". Rec. ≤ 50 chars |
| level | ACF | select | ✔ | 1 | — | `basico` "Básico", `intermedio` "Intermedio", `abierto` "Abierto a todos". ⚠ Q9 |
| price | ACF | number | – | 0..1 | empty = "price on request" | ≥ 0, whole MXN. Shown as "$5,900 MXN". When empty, show the global `price_on_request_text` and hide the Inversión card |
| duration | ACF | text | ✔ if price set | 0..1 | — | Free text: "2 meses", "3 meses". Rec. ≤ 30 chars |
| outcomes_heading | ACF | select | ✔ | 1 | `objetivos` | `objetivos`, `beneficios`, `temas` |
| outcomes | ACF | repeater | ✔ | 1..10 | — | One `text` subfield (≤ 160 chars). Rendered as a numbered list. Numbers are generated automatically, never typed (Figma has a duplicated "4") |
| facilitators | ACF | relationship → `profesional` | ✔ | 1..2 | — | "Facilitador/a" card |
| order | `menu_order` | number | – | 1 | 0 | |

"Otros programas" isn't a field: it shows all other published courses (there are only 3).

### Profesional (new)

Purpose: a therapist, facilitator or founder, written once and referenced everywhere they appear.
WordPress object: **CPT `profesional`** with `public => false`, `show_ui => true` (MV1 has no profile
pages; see Q7). Editor-managed: yes. Reusable: yes (this is the main reason it exists).

| Field | Source | Type | Req. | Card. | Default | Validation / notes |
|---|---|---|---|---|---|---|
| name | `post_title` | text | ✔ | 1 | — | Full display name |
| slug | `post_name` | slug | ✔ | 1 | — | Stable import ID (e.g. `gabriela-dominguez`) |
| role | ACF | text | ✔ | 1 | — | Gold line under the name, e.g. "Terapeuta Holística. Especialista en Terapia Centrada en Soluciones". Rec. ≤ 100 chars |
| bio | `post_content` | rich text | ✔ | 1 | — | 1–3 paragraphs |
| photo | featured image | image | ✔ | 1 | — | Square, min 400×400, shown as a circle |
| credentials | ACF | repeater | – | 0..n | — | "Formación" on Acerca de. See Credencial |
| order | `menu_order` | number | – | 1 | 0 | |

**Credencial** (repeater row): `title` (text, ✔), `year` (number, 4 digits, –), `institution`
(text, –), `description` (textarea, –).

Instances observed in Figma: Alma Solís (founder, all 3 courses), Elizabeth de las Casas (Arteterapia),
Gabriela Domínguez (3 services), Tonathiu Muñoz (5 services), Perla Berrones (1 service; placeholder
data, see Q2).

### Testimonio

Purpose: a client quote on Home. WordPress object: **CPT `testimonio`** (exists; not public).

| Field | Source | Type | Req. | Card. | Notes |
|---|---|---|---|---|---|
| client_name | `post_title` | text | ✔ | 1 | Display form, e.g. "Valentina R.". Editorial rule: first name plus initial |
| quote | `post_content` | textarea | ✔ | 1 | Rec. ≤ 300 chars |
| about | ACF | post object → `servicio` \| `curso` | – | 0..1 | Label under the name comes from the related post's title. **Replaces** today's free-text excerpt ("Biodescodificación"), which drifts when a service is renamed |
| order | `menu_order` | number | – | 1 | |

### Pages (WordPress Page, not CPT)

| Page | Slug | Template | Page-level fields |
|---|---|---|---|
| Home | front page | `front-page.php` | `hero` (eyebrow, title, subtitle, image, CTA label and link), `intro` (title, body, image, CTA), `services_intro` (eyebrow, title, subtitle), `process_steps` repeater (title, body; 3 rows), `quote` (line 1, line 2, image), `courses_intro` (eyebrow, title, body), `testimonials_title` |
| Acerca de | `acerca-de` | `page-acerca-de.php` | `hero` (eyebrow, title, subtitle, image), "Nosotros" text = `post_content`, `founder` → `profesional` (Formación comes from the founder's `credentials`) |
| Servicios | `servicios` | `page-servicios.php` | `hero` (eyebrow, title, subtitle). The grid is a query, not a field |
| Cursos | `cursos` | `page-cursos.php` (new) | `hero` (eyebrow, title, subtitle). The grid is a query |
| Aviso de privacidad | `aviso-de-privacidad` | `page-templates/legal.php` | none. Intro and sections are `post_content` (H2 per section, numbered by CSS) |
| Términos y condiciones | `terminos-y-condiciones` | `page-templates/legal.php` | none |

The page `hero` is the same field group (eyebrow, title, subtitle, image) reused on every page, not
separate per-page fields. Legal sections are plain prose in `post_content`: a repeater would add no
value for long legal text and would make it harder to paste in text from a lawyer.

## WordPress Mapping

### Objects

| Entity | WP object | Key | Supports | Public / archive | Rewrite |
|---|---|---|---|---|---|
| Servicio | CPT | `servicio` (exists) | title, editor, excerpt, thumbnail, page-attributes | public, `has_archive=false` (Page is the listing) | `servicios` |
| Curso | CPT | `curso` (exists) | title, editor, excerpt, thumbnail, page-attributes | public, `has_archive=false` | `cursos` |
| Profesional | CPT | `profesional` (**new**) | title, editor, thumbnail, page-attributes | `public=false`, `show_ui=true` | none |
| Testimonio | CPT | `testimonio` (exists) | title, editor, page-attributes (drop `excerpt` after migration) | not public | none |
| Global settings | ACF options page | `almica-ajustes` | — | — | — |
| Nav menus | native menus | `primary`, `footer` (exist) | — | — | — |
| *(MV2)* Producto | CPT | `producto` | title, excerpt, thumbnail, page-attributes | TBD (Q10) | TBD |
| *(MV2)* Categoría | taxonomy | `categoria_producto` | — | TBD | TBD |

Having both a `servicios` Page and `servicio` singles under `/servicios/{slug}/` already works today,
and the same pattern applies to `cursos`.

### Native fields reused (not duplicated)

| Native field | Servicio | Curso | Profesional | Testimonio |
|---|---|---|---|---|
| `post_title` | title | title | name | client name |
| `post_name` | slug / import ID | slug / import ID | slug / import ID | slug / import ID |
| `post_excerpt` | summary (hero fallback, SEO) | summary (cards) | — | — |
| `post_content` | description | description | bio | quote |
| featured image | card image | image | photo | — |
| `menu_order` | listing order | listing order | order | slider order |

### ACF field groups

Register the field groups in code inside `almicahealing-core`, using `acf_add_local_field_group()` or
`acf-json/` committed to the repo. That keeps the schema versioned and deployable (see Q11 for which
ACF edition).

| Group | Location | Fields (ACF type) |
|---|---|---|
| `group_servicio` "Servicio" | post_type == servicio | `tagline` (text), `hero_image` (image, return ID), `price` (number, step 0.01, min 0), `price_basis` (text, placeholder = global), `duration_minutes` (number, min 15, max 480, step 15, default 60), `modality` (checkbox: presencial, virtual), `benefits` (repeater: `icon` select, `title` text, `description` textarea; min 1, max 6, layout block), `professionals` (relationship → profesional, min 1, max 3, return ID), `related_services` (relationship → servicio, max 3), `is_featured` (true_false, ui), `includes_workbook` (true_false) |
| `group_curso` "Curso" | post_type == curso | `tagline` (text), `program_label` (text), `level` (select), `price` (number, min 0), `duration` (text), `outcomes_heading` (select), `outcomes` (repeater: `text` text; min 1, max 10), `facilitators` (relationship → profesional, min 1, max 2) |
| `group_profesional` "Profesional" | post_type == profesional | `role` (text), `credentials` (repeater: `title` text, `year` number, `institution` text, `description` textarea) |
| `group_testimonio` "Testimonio" | post_type == testimonio | `about` (post_object → servicio, curso; allow null) |
| `group_page_hero` "Encabezado de página" | page template ∈ {front-page, acerca-de, servicios, cursos} | `hero_eyebrow` (text), `hero_title` (text), `hero_subtitle` (textarea), `hero_image` (image), `hero_cta_label` (text), `hero_cta_url` (link) |
| `group_home` "Inicio" | page == front page | `intro` (group), `services_intro` (group), `process_steps` (repeater, exactly 3), `quote` (group), `courses_intro` (group), `testimonials_title` (text) |
| `group_acerca_de` "Acerca de" | page template == acerca-de | `founder` (post_object → profesional, required) |
| `group_ajustes` "Ajustes de Álmica" | options page | see [Global Content](#global-content) |

**Relationship direction:** store the relationship on the side editors think from (service → its
professionals, course → its facilitators). The reverse direction ("which services does Gabriela
deliver?") is only needed in admin. It can be derived with a meta query and doesn't need to be stored
twice, so bidirectional sync isn't required.

**Migration from the current implementation:**

- `_almicahealing_featured` → `is_featured`
- `testimonio.post_excerpt` → `about`
- `curso.post_excerpt` currently holds the hero tagline, not the card summary. Move it to `tagline` and
  fill in the real summary.
- The hard-coded founder bio and "Formación" array in the theme become data on the `profesional` post
  for Alma Solís.
- `inc/brand.php` becomes the options page.

## Template Mapping

| Template | Status | Renders |
|---|---|---|
| `front-page.php` | exists (hard-coded copy) | Home. Switch copy to `group_page_hero` + `group_home` |
| `page-acerca-de.php` | exists (hard-coded) | Acerca de. Founder and Formación come from the related `profesional` |
| `page-servicios.php` | exists | Servicios listing (all `servicio` by `menu_order`) |
| `page-cursos.php` | **new** | Cursos listing (all `curso`) |
| `single-servicio.php` | **new** (today `single.php` is a generic fallback) | Service detail |
| `single-curso.php` | **new** | Course detail |
| `page-templates/legal.php` | exists (no hero or tabs yet) | Both legal pages. Shared hero and tab bar linking the two pages |
| `single-profesional.php` | not needed | profesional isn't public |
| `archive-servicio.php` / `archive-curso.php` | not needed | Pages provide the listings (editable hero). Revisit only if listings need pagination or filters |

Shared template parts:

- `card-servicio` (Home teaser, Servicios grid, Otros servicios)
- `card-curso` (Home teaser, Cursos grid; compact variant for Otros programas)
- `profesional-block` (Quién imparte, founder on Acerca de)
- `facilitator-chip` (course sidebar)
- `benefit-grid`
- `numbered-list`
- `page-hero`
- `legal-tabs`

## Figma → Content Model Mapping

Figma layer names are unreliable: several frames reuse another frame's name. The table uses the
**on-canvas title**, with the layer name shown in parentheses where it differs. The canvas order is
the order of Dev Mode's frame pager (1–20). Node IDs are listed where they were confirmed during
inspection.

| # | Figma frame (layer name) | Node | Model | Template | Kind | Separate dev ticket? |
|---|---|---|---|---|---|---|
| 1 | Home | 146-31 | Page (front) plus featured `servicio` ×6, `curso` ×3, `testimonio` | `front-page.php` | unique | yes (exists; field-ify) |
| 2 | Acerca de | 146-432 | Page plus `profesional` (Alma Solís) | `page-acerca-de.php` | unique | yes (exists; field-ify) |
| 3 | Servicios | 146-634 | Page plus `servicio` query | `page-servicios.php` | listing | yes (exists) |
| 4 | Cursos (**"Set Typography Styles"**) | — | Page plus `curso` query | `page-cursos.php` | listing | **yes (new)** |
| 5 | Curso Clantanra | 177-748 | `curso` instance: level Intermedio, price on request, list "Objetivos" | `single-curso.php` | **reference instance** | yes (builds the template) |
| 6 | Curso Riutunmi | — | `curso` instance: Básico, $5,900 / 2 meses, list "Beneficios" | `single-curso.php` | instance | no → content/QA |
| 7 | Curso Lo Que Nadie Nos Enseñó | 181-5149 | `curso` instance: Abierto a todos, $4,700 / 3 meses, list "Temas" | `single-curso.php` | instance | no → content/QA |
| 8 | Aviso de privacidad | — | Page (legal) | `legal.php` | **reference instance** | yes (hero and tabs) |
| 9 | Términos y condiciones | — | Page (legal) | `legal.php` | instance | no → content/QA |
| 10 | Arteterapia (Servicio - arteterapia) | 146-893 | `servicio`: $850, 60 min, 5 benefits, Elizabeth de las Casas | `single-servicio.php` | **reference instance** | yes (builds the template) |
| 11 | Biodecodificación (Servicio - biodecodificación) | 181-5706 | `servicio`: $1,200, 3 benefits, Gabriela Domínguez | `single-servicio.php` | instance | no → content/QA |
| 12 | Constelación Familiar para el Trabajo (Servicio - biodecodificación) | 218-2 | `servicio`: $1,100, 3 benefits, Gabriela Domínguez | `single-servicio.php` | instance | no |
| 13 | Armonización Energética Laboral y Bloqueos Relacionados (Servicio - biodecodificación) | — | `servicio`: $1,150, 3 benefits, Gabriela Domínguez | `single-servicio.php` | instance | no |
| 14 | Limpieza Energética de Lugares (Servicio - limpieza energética) | 245-2 | `servicio`: $1,800, 3 benefits, Tonathiu Muñoz | `single-servicio.php` | instance | no |
| 15 | Escaneo y Balance Energético en Personas (Servicio - limpieza energética) | — | `servicio`: $1,150, 2 benefits, Tonathiu Muñoz | `single-servicio.php` | instance | no |
| 16 | Conexión con Seres Trascendidos (Servicio - limpieza energética) | 245-473 | `servicio`: $1,300, 2 benefits, Tonathiu Muñoz | `single-servicio.php` | instance | no |
| 17 | Conexión con Registros | — | `servicio`: $1,300, 2 benefits, Tonathiu Muñoz | `single-servicio.php` | instance | no |
| 18 | Futuros Posibles (Servicio - limpieza energética) | — | `servicio`: $1,300, 2 benefits (title only), Tonathiu Muñoz | `single-servicio.php` | instance | no |
| 19 | Limpieza y Conexión con Personas (Servicio - limpieza energética) | 268-5817 † | `servicio`: $1,150, 2 benefits (title only), therapist ⚠ Q2 | `single-servicio.php` | instance | no |
| 20 | Limpieza y Conexión Emocional con Personas (Servicio - limpieza energética) | 268-6039 | `servicio`: $1,150, 3 benefits (title only), "Perla Berrones" ⚠ Q2 | `single-servicio.php` | instance | no |
| — | Sticky: "incluir que se descarga cuadernillo cuando contratan el servicio" | — | `servicio.includes_workbook` (Q6) | — | annotation | no → open question |
| — | Text ×3: "reemplazar foto terapeuta" | — | `profesional.photo` (content task) | — | annotation | no → content task |

† Node ID inferred from pager position (19 of 20), not read directly from the selected frame.

All 11 service frames share one hero duration value (60 min) and one modality ("Presencial").

**Totals:** 20 frames, 4 annotations.

- **16 frames are content instances** of 3 templates (11 servicio, 3 curso, 2 legal).
- **13** of those need no development ticket beyond the reference instance of their template.
- 4 frames are unique implementations.

### Variations inside the instance templates (template must handle; not separate tickets)

| Variation | Where | Handling |
|---|---|---|
| 1–5 benefit tiles (3-column grid; rows of 3 then 2, or a single tile) | services | Grid with auto-flow. No per-count layouts |
| Benefit without description | frames 18–20 | Description optional |
| Hero title wrapping to 2 lines | frames 13, 15, 20 | Normal text flow |
| Course without price → "Escríbenos para conocer el precio", no Inversión card | frame 5, and its listing card | `price` empty |
| List heading Objetivos / Beneficios / Temas | frames 5–7 | `outcomes_heading` |
| Active legal tab | frames 8–9 | Derived from the current page |
| Nav "Cursos" highlighted on course pages | frames 5–7 | `current-menu-*` classes on the primary menu |

### Content defects in Figma (fix during population and QA; don't implement them)

1. **Limpieza Energética de Lugares**: the description is a copy of Armonización Energética Laboral's text.
2. **Limpieza y Conexión con Personas**: the card is named "Elizabeth de las Casas", but it has Gabriela's photo, Tonathiu's bio and the role "Acompañante Terapéutico".
3. **Limpieza y Conexión Emocional con Personas**: the card is named "Perla Berrones", but it has Gabriela's photo and Tonathiu's bio.
4. **"Otros servicios"** shows the same 3 services on every page, including on the Biodecodificación page itself.
5. **Lo Que Nadie Nos Enseñó**: the hero pill says "Curso básico de canalización", but the level badge says "Abierto a todos". The Temas list numbers "4" twice.
6. Conexión con Seres Trascendidos, Conexión con Registros, Futuros Posibles and both Limpieza y Conexión frames reuse the same hero photo.
7. Layer names don't match frame content (frames 4, 12–16, 18–20).

## Editorial / Spreadsheet Model

### Principles

- **One sheet per entity, one row per entity instance.** The `slug` column is the stable identifier.
  The importer maps it to the existing `_almicahealing_seed_key` convention (`servicio-{slug}`) so that
  re-importing updates rows in place instead of creating duplicates.
- **Repeaters get their own sheet**, linked by the parent slug plus a `position` column. Wide
  `benefit_1_title…` columns aren't used.
- **Small many-to-many relationships** (a service's 1–3 professionals) go in one cell as
  pipe-separated slugs: `gabriela-dominguez|tonathiu-munoz`. They get their own sheet only if they
  start carrying attributes.
- **Images** are given as file names relative to a shared asset folder (`assets/servicios/arteterapia-card.jpg`).
  The importer uploads them and de-duplicates by file name.
- **Rich text** (description, bio) is plain text in the cell, with a blank line between paragraphs.
  The importer converts it to paragraphs.
- **Booleans** are `sí` / `no`. **Money** is a plain number with no currency symbol (`1150`).
- **Enumerations** use the machine value (`presencial`, `intermedio`), and each sheet has a
  data-validation dropdown for them.

### Sheets

**`servicios`**

| slug | title | order | is_featured | summary | tagline | description | price | price_basis | duration_minutes | modality | professionals | card_image | hero_image | includes_workbook | status |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| arteterapia | Arteterapia | 1 | sí | Un puente hacia lo que no siempre encuentra palabras, a través de la creación artística. | | Es una forma distinta… | 850 | | 60 | presencial | elizabeth-de-las-casas | arteterapia-card.jpg | arteterapia-hero.jpg | no | publish |

**`servicio_beneficios`**

| servicio_slug | position | icon | title | description |
|---|---|---|---|---|
| arteterapia | 1 | corazon | Favorece la expresión emocional | Da forma a lo que resulta difícil nombrar directamente. |
| arteterapia | 2 | ondas | Reduce el estrés y la ansiedad | El proceso creativo ofrece un espacio de calma y descarga. |

**`cursos`**

| slug | title | order | level | program_label | summary | tagline | description | price | duration | outcomes_heading | facilitators | image | status |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| riutunmi | Riutunmi | 2 | basico | Curso básico de canalización | Un espacio de formación enfocado en el desarrollo de la conciencia… | Un espacio de formación para el desarrollo de la conciencia y la conexión… | … | 5900 | 2 meses | beneficios | alma-solis | riutunmi.jpg | publish |

**`curso_puntos`**: `curso_slug`, `position`, `text`

**`profesionales`**: `slug`, `name`, `role`, `bio`, `photo`, `order`

**`profesional_formacion`**: `profesional_slug`, `position`, `title`, `year`, `institution`, `description`

**`testimonios`**: `slug`, `client_name`, `quote`, `about_type` (`servicio` | `curso` | empty), `about_slug`, `order`

**`ajustes`**: `key`, `value` (one row per global setting; see below)

*(MV2, provisional)* **`productos`**: `slug`, `title`, `category` (term slug), `intention_label`, `summary`, `price`, `image`, `order`

### Import order

`profesionales` → `profesional_formacion` → `servicios` → `servicio_beneficios` → `cursos` →
`curso_puntos` → `testimonios` → `ajustes`. Parents come before children, and relationship targets
before the posts that reference them. Rows that reference an unknown slug fail the whole import with
a report rather than importing partially.

## Global Content

Store these once on the options page **Ajustes de Álmica** (today most of them are hard-coded in
`inc/brand.php` or in templates). Section labels such as "Lo que esta sesión puede ofrecerte",
"Quién imparte" and "Otros servicios" stay **translatable theme strings**. They are part of the
design, not per-site content, and exposing them as fields invites inconsistency.

| Key | Type | Value seen in Figma | Used by |
|---|---|---|---|
| `contact_email` | email | ⚠ inconsistent (Q4) | Footer |
| `courses_email` | email | cursos@almica.mx | Course sidebar card |
| `privacy_email` | email | contacto@almica.mx | Legal pages |
| `phone` | text | ⚠ Figma footer and `brand.php` differ (Q4) | Footer |
| `whatsapp` | text/URL | — (mentioned in legal and MV2 shop copy) | Legal note, shop |
| `location_label` | text | México · sesiones virtuales | Footer |
| `social_instagram` / `social_facebook` / `social_tiktok` | URL | IG / FB / TK buttons, no URLs | Footer |
| `footer_blurb` | textarea | Bienestar integral para un proceso de conexión, claridad y transformación. | Footer |
| `footer_tagline` | text | El equilibrio que da origen a todo | Footer |
| `currency_label` | text | MXN | All prices |
| `service_price_basis` | text | por sesión individual | Service Inversión card |
| `price_on_request_text` | text | Escríbenos para conocer el precio | Course card and detail |
| `course_inquiry_title` / `course_inquiry_body` | text / textarea | ¿Te interesa este programa? / Escríbenos directamente y con gusto te damos más información. | Course sidebar |
| `legal_contact_note` | textarea | Para cualquier duda relacionada con este documento… | Legal pages |
| Primary / footer menus | native menus | Inicio, Acerca de, Servicios, Cursos (+ Tienda); footer adds Contáctanos | Header, footer |

## Open Questions

| # | Unknown | Why it matters | Recommended default | What changes |
|---|---|---|---|---|
| Q1 | **Is MV1 or MV2 the source of truth?** MV2 exists with Tienda frames and a longer Home (shop teaser "Herramientas para acompañar tu camino"). | Scope, entities (Producto) and the Home field list | Build MV1 now and treat MV2 additions as a later phase | If MV2 wins: add Producto + Categoría, a Tienda page, and a Home shop teaser before launch |
| Q2 | **Who delivers Limpieza y Conexión con Personas and Limpieza y Conexión Emocional con Personas?** Who is Perla Berrones? | The relationship data and the professional roster | Leave `professionals` empty and don't publish these two services until confirmed | Possibly a new `profesional` row |
| Q3 | **Modality.** Every service says "Presencial", but the brand copy says "clínica virtual" and "México · sesiones virtuales". | A field on every service; possibly a filter | Checkbox field, defaulting to what the client confirms per service | If some services are both → show "Presencial / Virtual". If it becomes filterable → promote to taxonomy |
| Q4 | **Canonical contact data.** Figma footers use different emails (hola@almica.mx on service frames, a Gmail address on others); `brand.php` has another email and a phone number that doesn't match the Figma footer. | Global settings | Ask the client for one list (general, courses, privacy, phone, WhatsApp) | Only the values change |
| Q5 | **How are "Otros servicios" chosen?** | Whether `related_services` is required | Automatic: 3 other services by `menu_order` (next 3, wrapping around), with an optional manual override | If the client wants curation → make the field required |
| Q6 | **Workbook ("cuadernillo") note.** What is downloaded, when, and by whom? | Could be a flag, a file field, or a link to a Producto (MV2 "Libretas") | `includes_workbook` true/false plus a display line; no file delivery | Delivering the file after purchase needs payments/booking (Q12). If it's a Producto → relationship field |
| Q7 | **Do professionals get public profile pages?** | CPT visibility, a template, SEO | `public=false` for now | Flip to public plus `single-profesional.php`, with no data migration needed |
| Q8 | **Benefit icon set.** Figma uses a small set of line icons (heart, waves, sprout, eye, rings…). | Validation of `benefits.icon` | A fixed list of ~10 SVGs shipped in the theme, chosen by slug | If editors need free icons → an image field (inconsistent style risk) |
| Q9 | **Course level vs program label.** Lo Que Nadie Nos Enseñó is "Abierto a todos" but its pill says "básico". | Whether `program_label` can be derived from `level` | Keep them as two fields | If the label is always "Curso {level} de {discipline}" → derive it and drop the field |
| Q10 | **Shop mechanics (MV2).** Orders are "coordinated by WhatsApp or email" per the MV2 copy. | Whether WooCommerce is needed | Catalog-only CPT with a WhatsApp/email CTA, no cart | A real checkout → WooCommerce products, which replaces the `producto` CPT |
| Q11 | **Custom-fields plugin.** No custom-fields plugin is installed. Repeaters and options pages need ACF Pro, or Secure Custom Fields (verify its current feature set). | Licensing and deployment | Pick one before Ticket 1 and register fields in code | Native `register_post_meta` + blocks is possible, but repeaters get costly |
| Q12 | **Booking and payment.** Home says "Reserva tu sesión — selecciona disponibilidad", but no service page shows a booking CTA. | A booking URL per service? External tool? | A global booking CTA (URL or WhatsApp) on every service; no booking entity | An external scheduler per service → add `booking_url` to Servicio |
| Q13 | **Contáctanos page.** It's in the sitemap and footer, but MV1 has no frame for it. The contact form already exists. | Whether a page/template is needed | A simple Page using the existing form partial | A dedicated design → its own ticket |
| Q14 | **Course schedule.** Start dates, sessions and modality aren't in the design. | Possible date fields and "upcoming" logic | Leave out; `duration` is free text | Adding cohorts → a repeater of editions on Curso |

## Implementation Recommendations

Not implemented; this is the proposed order.

1. **Decide Q1, Q11, Q4.** These block the schema and the globals.
2. **Field framework and options page.** Register field groups in `almicahealing-core` code, not the database.
3. **Profesional CPT and data.** Everything else references it.
4. **Servicio fields and the migration** of `_almicahealing_featured`. Extend `wp almicahealing seed` to migrate idempotently.
5. **`single-servicio.php`**, built against frame 10 (Arteterapia) and verified against frames 11–20.
6. **Curso fields, `single-curso.php`, and the `page-cursos.php` listing.** Point the "Cursos" menu item to `/cursos/` instead of `/#cursos`.
7. **Legal template** hero and tabs.
8. **Globals refactor**: header, footer and course sidebar read from the options page. Delete `inc/brand.php`.
9. **Page fields for Home and Acerca de.** Lowest priority: the copy rarely changes, and the current hard-coded version works.
10. **CSV importer** (`wp almicahealing import <dir>`), reusing the seed helpers (`almicahealing_seed_post`, `almicahealing_seed_thumbnail`).
11. **Content population** from the client spreadsheet, then per-instance QA against Figma.

## YouTrack Recommendations

Scope: project **KW**, Klaritty Client = **Almica**. These are suggestions only; no issues were created.

| # | Title | Purpose | Scope | Acceptance criteria |
|---|---|---|---|---|
| 1 | Custom fields framework and "Ajustes de Álmica" options page | Foundation for every structured field | Choose ACF Pro or SCF (Q11); register all field groups from `content-model.yaml` in `almicahealing-core`; options page with the global keys | Field groups are loaded from code; a fresh DB shows them without manual setup; options page saves and reads every global key |
| 2 | Profesional content type | A single source for therapist/facilitator data | Register `profesional` (non-public); `role` and `credentials` fields; seed the 5 known professionals | Admin can create, edit and order professionals; the seed is idempotent; the profile isn't reachable by URL |
| 3 | Servicio structured fields and migration | Replace hard-coded service data with fields | Add the `group_servicio` fields; migrate `_almicahealing_featured` → `is_featured`; the Home teaser reads `is_featured` | All 11 services editable; the Home teaser is unchanged after migration; the contact-form "Servicio de interés" still lists all services |
| 4 | Service detail template (`single-servicio.php`) | One template for all 11 service pages | Hero, back link, about and Inversión card, benefit grid (1–6), Quién imparte (1–3 professionals), Otros servicios (auto with optional override) | Matches Figma frame 10; renders frames 11–20 correctly with 1, 2, 3 and 5 benefits, benefits without descriptions, and 2-line titles; no layout breaks when optional fields are empty |
| 5 | Course detail template and fields | One template for all 3 course pages | `group_curso` fields; hero pill; numbered outcomes with a selectable heading; Inversión card hidden when there's no price; facilitator card; inquiry card from globals; Otros programas | Matches frame 5; renders frames 6–7; price-on-request state works |
| 6 | Cursos listing page | Missing page from Figma (the "Set Typography Styles" frame) | `page-cursos.php`, shared course card (level badge, summary, price/duration or on-request text); update the menu link | `/cursos/` renders 3 cards in `menu_order`; the Home teaser uses the same card partial |
| 7 | Legal template: hero and tabs | Shared legal layout | Hero "Información legal y de privacidad."; tab bar linking both legal pages with an active state; H2 sections numbered automatically; contact note from globals | Both legal pages render from `post_content` alone; the active tab matches the current page |
| 8 | Header/footer from global settings | Remove hard-coded brand data | Footer contact, social, blurb and tagline come from options; delete `inc/brand.php` | Changing a value in the options page updates every page; empty social URLs hide their buttons |
| 9 | Testimonio → service/course relationship | Keep testimonial labels in sync with service names | `about` field; migrate the existing excerpt label | The label under the name follows the related post's title; the existing testimonial is migrated |
| 10 | Editable Home and Acerca de copy | Editors can change page copy without a deploy | `group_page_hero`, `group_home`, `group_acerca_de`; the founder block and Formación come from the related professional | No visual regression against frames 1–2; all copy is editable in admin |
| 11 | Spreadsheet import command | Load client content in bulk, repeatably | `wp almicahealing import <dir>` for the sheets in this document; validates slugs; idempotent | Re-running changes nothing; an unknown slug aborts with a report; images are attached once |

### Content population and QA items (not development tickets)

These Figma frames need **content entry and a visual check** against the template, not new code:

- **Services (10):** Biodecodificación, Constelación Familiar para el Trabajo, Armonización Energética
  Laboral y Bloqueos Relacionados, Limpieza Energética de Lugares, Escaneo y Balance Energético en
  Personas, Conexión con Seres Trascendidos, Conexión con Registros, Futuros Posibles, Limpieza y
  Conexión con Personas, Limpieza y Conexión Emocional con Personas.
- **Courses (2):** Riutunmi, Lo Que Nadie Nos Enseñó.
- **Legal (1):** Términos y condiciones (plus the final legal copy for both pages from the client).
- **Content tasks:**
  - Fix the Figma defects listed above.
  - Confirm the therapists for 2 services (Q2).
  - Replace the placeholder therapist photos (the "reemplazar foto terapeuta" notes).
  - Give each service its own hero photo.

Suggested grouping: one **"Content: services (11)"** ticket, one **"Content: courses (3)"**, one
**"Content: professionals (5)"** and one **"Content: legal pages"**, each with a per-instance checklist.
Don't create one ticket per instance.

**Blocked, not yet ticketed:** Tienda / Producto (Q1, Q10), Contáctanos page (Q13), booking (Q12).
