# Álmica Healing Website — Content Management Guide

For the Klaritty team members who keep the Álmica Healing website up to date.

## 1. About this guide

The Álmica Healing website is built from **structured content**. Services, courses, professionals and testimonials aren't free-form pages. Each one is a set of labelled boxes, such as a title, a price, a list of benefits or a photo. The website's templates turn those boxes into finished, consistently designed pages.

In short: **you manage the information, and the website manages how it looks.**

This means:

- You never need to arrange layouts, choose fonts or set colours. Fill in the fields and the page is laid out for you.
- One change can appear in several places. For example, editing a professional's photo updates it on every service and course where they appear.
- If you need something the fields don't offer, that's a request for development (see [section 3](#3-what-requires-development)).

The website was first filled from a content spreadsheet. **That spreadsheet is no longer used.** From now on, the content in WordPress is the official version. Make all changes in WordPress, and don't edit the old spreadsheet expecting the website to follow.

### A note on admin language

The site's own menus and fields (Servicios, Cursos, Ajustes de Álmica, and so on) are always in Spanish. WordPress's built-in buttons follow the language set for your user account. This guide gives them in Spanish, with the English in parentheses the first time each one appears. See the table in [WordPress basics](#4-wordpress-basics).

> **Needs verification:** which admin language the Klaritty accounts use. Confirm before screenshots are taken, so the screenshots and text match.

## 2. What you can safely edit

You can create, edit and remove these yourself:

- **Services** (Servicios): titles, descriptions, prices, durations, modality, benefits, photos, who delivers each service, which services appear on the home page, and the order of the catalogue.
- **Courses** (Cursos): titles, descriptions, prices, durations, level, programme label, the numbered list, photos, facilitators and order.
- **Professionals** (Profesionales): names, roles, bios, portraits and the founder's training ("Formación").
- **Testimonials** (Testimonios): quotes, client names, which service or course each one is about, and their order.
- **Page text and images** on Inicio, Acerca de, Servicios and Cursos, in the fields provided.
- **The legal documents**: the text of Aviso de privacidad and Términos y condiciones.
- **Contact form messages** (Contactos): read, export and delete.

With an **Administrator** account you can also edit:

- **Global website content** (Ajustes de Álmica): contact email, phone, location, social links, footer text, price wording and the course contact card.
- **Navigation menus**: the header and footer link lists.

> **Needs verification:** which role each Klaritty user has. Editor accounts don't see **Ajustes de Álmica** or the menu screens.

## 3. What requires development

A simple rule:

> If you're changing **what something says**, it's probably a content change, and you can do it.
>
> If you're changing **what information exists**, **how something is structured** or **how something is displayed**, it's probably a development change.

Contact development for any of these:

- **A new field for every item.** For example, a "session schedule" or "booking link" on every service, or a start date on every course.
- **A new type of content.** For example, a shop, products, events or a blog section. (The online shop and service booking were deliberately left out of this version of the site.)
- **Changing a layout.** For example, moving the benefits above the description, showing more than 6 featured services on the home page, or changing card shapes.
- **Text that's built into the design.** Section labels such as "Sobre este servicio", "Inversión", "Quién imparte", "Otros servicios", "Sobre el curso", "Otros programas", "Tu proceso comienza aquí", "Ver más" and "Contáctanos" have no field.
- **The "Nosotros" history text on Acerca de.** It's built into the page and has no editable field yet.
- **The legal pages' header.** That covers the "Información legal y de privacidad." heading and the tab names.
- **New benefit icons.** You can choose only from the existing list.
- **New pages.** The site has no general-purpose page design. A new page would get a very plain layout.
- **The contact form**: its questions, its confirmation email, which address receives the notifications, or putting the form on another page.
- **WhatsApp or TikTok links.** The settings have fields for them, but the website doesn't display them yet.
- **Anything about plugins, analytics, the domain or email delivery.**
- **Changing the web address (URL) of a page, service or course.**

## 4. WordPress basics

### Logging in

Log in at the website's `/wp-admin` address with your own user account. The left-hand sidebar lists everything you can manage.

> 📷 **Screenshot needed:** The full wp-admin left sidebar for an Administrator, showing **Servicios**, **Cursos**, **Testimonios**, **Profesionales**, **Ajustes de Álmica**, **Contactos** and **Páginas**. Take a second capture from an Editor account to show what's missing there.

### The everyday workflow

1. **Open the section** in the left sidebar, for example **Servicios**.
2. **Find the item.** Click its title in the list, or use the search box at the top right of the list.
3. **Edit the fields.** The main text area is at the top of the editing screen. The site-specific fields are in a panel **below** it, titled after the content type (for example **Servicio**). Scroll down to find them.
4. **Preview** with **Vista previa** (*Preview*) if you're making a larger change.
5. **Save.** Click **Actualizar** (*Update*) for something already published, or **Publicar** (*Publish*) for something new. Use **Guardar borrador** (*Save draft*) to keep working later without showing it on the website.
6. **Check the public page.** Open it in a new tab and confirm the change looks right.

> 📷 **Screenshot needed:** A Service edit screen, scrolled so the main text area and the top of the **Servicio** field panel are both visible. Annotate "Main text" and "Service fields", and point out the right-hand settings sidebar.

### Fields marked with an asterisk

Fields marked with **\*** are required. Fill them in before publishing. A missing required field can stop the item from saving or leave a gap on the page.

### The settings sidebar

The panel on the right of the editing screen holds a few standard WordPress settings this site uses:

- **Imagen destacada** (*Featured image*): the main photo for services, courses and professionals.
- **Extracto** (*Excerpt*): a short summary. Services and courses use it. See each section for where it appears.
- **Orden** (*Order*): a number that controls the order of services, courses and testimonials. Lower numbers come first.
- **Plantilla** (*Template*): only matters on the legal pages.

### Drafts and trash

- Items saved as drafts don't appear anywhere on the website, including lists, the home page and the contact form.
- **Mover a la papelera** (*Move to trash*) removes an item from the website. Items stay in **Papelera** (*Trash*) and can be restored from there.

### Core WordPress labels: Spanish and English

| Spanish | English |
|---|---|
| Páginas | Pages |
| Medios | Media |
| Entradas | Posts |
| Apariencia → Menús | Appearance → Menus |
| Imagen destacada | Featured image |
| Extracto | Excerpt |
| Orden | Order |
| Plantilla | Template |
| Vista previa | Preview |
| Publicar / Actualizar | Publish / Update |
| Guardar borrador | Save draft |
| Mover a la papelera | Move to trash |
| Texto alternativo | Alternative text |

> **Needs verification:** depending on the WordPress version, the **Actualizar** button may read **Guardar** (*Save*), and the add-new button may read **Añadir** or **Añadir nuevo**. Match these to the live admin when screenshots are taken.

## 5. Managing Services

### What a Service is

A **Service** is one individual session that clients can book, such as Arteterapia or Biodescodificación. Each service has its own page. It also appears as a card in the services catalogue, possibly on the home page, and as an option in the contact form.

### Where to find Services

Click **Servicios** in the left sidebar. The list shows every service, published or not.

### Creating a Service

1. Go to **Servicios** and click the add-new button at the top of the list. The screen that opens is titled **Añadir servicio**.
2. Type the service name as the title.
3. Write the description in the main text area.
4. In the right-hand sidebar, set the **Imagen destacada** (*Featured image*), the **Extracto** (*Excerpt*) and the **Orden** (*Order*).
5. Scroll down to the **Servicio** panel and fill in the fields. All required fields are marked **\***.
6. Click **Guardar borrador** (*Save draft*), then **Vista previa** (*Preview*) to check it.
7. Click **Publicar** (*Publish*).

The new service then appears automatically in the **Servicios** catalogue and in the contact form's **Servicio de interés** dropdown. It appears on the home page only if you turn on **Destacado en Inicio**.

### Editing an existing Service

1. Go to **Servicios** and click the service's title.
2. Change the fields you need.
3. Click **Actualizar** (*Update*), then check the public page.

### Fields

> 📷 **Screenshot needed:** The **Servicio** field panel for Arteterapia, from **Frase del encabezado** down to **Beneficios**, with at least two benefits visible.

#### Title

The service name. It appears on the service card, as the large heading on the service page, in "Otros servicios" cards, in the contact form dropdown, and under any testimonial linked to this service. Renaming a service updates all of these at once.

Long names are fine. They wrap onto two lines in the page header.

#### Main text area (description)

The **"Sobre este servicio"** section of the service page. Write one to three plain paragraphs. Avoid headings, images and other blocks.

#### Extracto (Excerpt)

A one-sentence summary. It appears under the title in the page header **only when "Frase del encabezado" is empty**. Search engines may also show it as the page description. Aim for about 160 characters or fewer.

#### Imagen destacada (Featured image)

The photo on the service card. It's also used as the page header background when **Imagen del encabezado** is empty. The card shows a tall, narrow slice from the **centre** of the photo. See [Images and media](#12-images-and-media).

#### Orden (Order)

Controls the service's position in the catalogue, in the contact form dropdown and among the home page's featured services. It also decides which three services appear by default under "Otros servicios". Lower numbers come first.

#### Frase del encabezado

The sentence under the title in the page header. If empty, the **Extracto** is used instead. Up to 200 characters.

#### Imagen del encabezado

An optional, different photo for the page header. If empty, the featured image is used. The header lays a dark green tint over the photo so the text stays readable, so the photo works as a soft background.

#### Precio \*

The session price, as a **number only**: no "$", no "MXN", no commas. For example, `1150` is displayed as **$1,150.00 MXN**. The currency label comes from **Ajustes de Álmica**.

#### Base del precio

The small line under the price. **Leave it empty** for the standard wording ("por sesión individual", set in Ajustes de Álmica). Fill it in only if this service is priced differently, for example "por paquete de 3 sesiones". Up to 80 characters.

#### Duración (minutos) \*

The session length in minutes, in steps of 15, from 15 to 480. It appears in **two places**: the chip in the page header ("60 min") and the "Inversión" price box.

#### Modalidad \*

Choose **Presencial**, **Virtual** or **Presencial y virtual**. It's shown in the "Inversión" box.

#### Beneficios \*

The tiles under **"Lo que esta sesión puede ofrecerte"**. Add **between 1 and 6** with **Añadir beneficio**. Drag rows to reorder them. Each benefit has three parts:

- **Icono \***: choose from the list (Corazón, Ondas, Brote, Ojo, Círculos, Equilibrio, Espiral, Manos, Luna, Chispa). For a consistent look, prefer **Corazón, Ondas, Brote, Ojo, Círculos and Manos**. The other four are drawn in an older style.
- **Título \***: the benefit itself, up to 90 characters. For example, "Favorece la expresión emocional".
- **Descripción**: optional, up to 180 characters. How you start it changes how it's displayed:
  - Starting with a **capital letter** shows it as a separate supporting sentence under the title. For example, title "Reduce el estrés" and description "El proceso creativo ofrece un espacio de calma."
  - Starting with a **lowercase letter** shows it as the *continuation* of the title's sentence, in the same style. For example, title "Te ayuda a" and description "soltar lo que ya no te pertenece."

> 📷 **Screenshot needed:** A service page on the website, showing the benefit tiles. Include one tile with a capitalised description and, if one exists, one with a lowercase continuation, side by side.

#### Quién imparte

The professional(s) who deliver this service, up to 3. Search on the left and click a name to add it. Drag to reorder. Each person is shown with their portrait, name, role and bio, all taken from their **Profesionales** entry.

**If you leave this empty, the whole "Quién imparte" section is hidden.** Use that while the therapist isn't confirmed.

#### Otros servicios

Optional. Picks the (up to) 3 services shown at the bottom of the page. **Leave it empty** to show the next three services in catalogue order automatically, which gives every service a different set. If you pick fewer than 3, only the ones you picked are shown.

#### Destacado en Inicio

Turn this on to feature the service on the home page. The home page shows **up to 6** featured services, in catalogue order. If more than 6 are turned on, only the first 6 by **Orden** appear.

If **none** are turned on, the whole services section disappears from the home page.

#### Incluye cuadernillo

Turn this on to add the line "Incluye cuadernillo descargable." under the description. It's only a line of text. The website doesn't deliver a file.

### Publishing checklist — Services

- [ ] Title is spelled correctly.
- [ ] Description reads well and has no stray headings or images.
- [ ] Featured image is set, and the subject is in the centre.
- [ ] Price is a plain number; duration and modality are correct.
- [ ] 1–6 benefits, each with an icon and a title.
- [ ] "Quién imparte" lists the right person, or is empty on purpose.
- [ ] "Destacado en Inicio" is set as intended, and no more than 6 services are featured.
- [ ] **Orden** puts the service where you want it in the catalogue.
- [ ] Previewed, published, and checked on the website: the service page, the Servicios page and the home page.

## 6. Managing Courses

### What a Course is

A **Course** is a multi-week training programme, such as Kriutunmi or Clantanra. Each course has its own page. It also appears as a card on the **Cursos** page and on the home page, and in "Otros programas" at the bottom of the other course pages.

### Where to find Courses

Click **Cursos** in the left sidebar.

### Creating a Course

1. Go to **Cursos** and click the add-new button. The screen is titled **Añadir curso**.
2. Enter the title and description, and set the **Imagen destacada**, **Extracto** and **Orden** in the sidebar.
3. Fill in the **Curso** panel below the main text area.
4. Save a draft, preview, then **Publicar** (*Publish*).

Note that the home page shows only the **first 3 courses** by **Orden**. All courses appear on the **Cursos** page.

### Editing an existing Course

Go to **Cursos**, click the title, make your changes, click **Actualizar** (*Update*) and check the page.

### Fields

> 📷 **Screenshot needed:** The **Curso** field panel for Kriutunmi, showing **Etiqueta del programa**, **Nivel**, **Precio**, **Duración**, **Encabezado de la lista** and a few **Puntos de la lista**.

#### Title

The course name. It appears on all course cards, as the page heading, and under linked testimonials.

#### Main text area (description)

The **"Sobre el curso"** section. One to three plain paragraphs.

#### Extracto (Excerpt)

**The summary shown on the course card**, on both the home page and the Cursos page. It also appears under the page title when **Frase del encabezado** is empty. Keep it to one or two sentences, about 160 characters.

#### Imagen destacada (Featured image)

The photo on every course card, and the page header background. Cards crop it to different shapes in different places, so keep the subject in the centre.

#### Orden (Order)

The course's position on the Cursos page (with its "01", "02", "03" number), on the home page and in "Otros programas".

#### Frase del encabezado

The sentence under the title in the page header. If empty, the **Extracto** is used. Up to 250 characters.

#### Etiqueta del programa \*

The small pill above the title in the page header. For example, "Curso intermedio de canalización y sanación". Up to 80 characters.

#### Nivel \*

**Básico**, **Intermedio** or **Abierto a todos**. It's shown on the small course cards in "Otros programas".

#### Precio

The course price as a **whole number only**. For example, `5900` is displayed as **$5,900 MXN**.

**Leave it empty if the price is on request.** The price box then disappears, and the card and contact box show "Escríbenos para conocer el precio" instead. That wording is set in Ajustes de Álmica.

#### Duración

Free text such as "2 meses", up to 40 characters. It's shown inside the price box, so **it only appears when Precio is filled in**.

#### Encabezado de la lista \*

The heading of the numbered list box: **Objetivos**, **Beneficios** or **Temas**.

#### Puntos de la lista \*

The numbered points, from 1 to 10. Add them with **Añadir punto**. **Don't type the numbers.** The website numbers the points automatically. Each point is up to 200 characters.

#### Facilitador/a

The person (1 or 2) leading the course, chosen from **Profesionales**. On the course page they're shown in the sidebar with a small portrait, name and role. The bio isn't shown here.

### Text that comes from Ajustes de Álmica

The box titled "¿Te interesa este programa?", its text and the contact email appear on **every** course page. They're edited once, in **Ajustes de Álmica**. See [Global website content](#10-global-website-content).

### Publishing checklist — Courses

- [ ] Title, programme label and level are correct.
- [ ] The Extracto reads well as a card summary.
- [ ] Price is a whole number, or empty on purpose for "price on request".
- [ ] Duration is filled in if there's a price.
- [ ] The list heading matches the points; no numbers are typed in the points.
- [ ] Facilitator is selected.
- [ ] Featured image is set.
- [ ] **Orden** is correct, remembering that only the first 3 show on the home page.
- [ ] Previewed, published, and checked on the course page, the Cursos page and the home page.

## 7. Managing Professionals

### What a Professional is

A **Professional** is a therapist, facilitator or the founder. Each person is written **once** and then selected wherever they appear:

- on services, under "Quién imparte"
- on courses, under "Facilitador/a"
- on Acerca de, as the founder

Professionals don't have their own page on the website.

### Where to find Professionals

Click **Profesionales** in the left sidebar.

### Creating a Professional

1. Go to **Profesionales** and click the add-new button. The screen is titled **Añadir profesional**.
2. Type the person's full name as the title.
3. Write their bio in the main text area.
4. Set their portrait as the **Imagen destacada** (*Featured image*).
5. Fill in **Rol** in the **Profesional** panel.
6. **Publicar** (*Publish*).
7. Open each service or course they deliver and add them under **Quién imparte** or **Facilitador/a**. Creating the person doesn't place them anywhere on its own.

### Editing a Professional

Go to **Profesionales**, click the name, edit and **Actualizar** (*Update*). The change appears everywhere that person is selected.

### Removing a Professional

First, remove them from every service (**Quién imparte**), every course (**Facilitador/a**) and, if they're the founder, from Acerca de. **Then** move them to the trash.

### Fields

> 📷 **Screenshot needed:** Alma Solís's edit screen, showing the portrait in the featured-image sidebar, the bio, **Rol**, and two or three **Formación** rows.

#### Title (name)

The person's full name, as it should appear on the website.

#### Main text area (bio)

One to three short paragraphs. It's shown on service pages and on Acerca de, but not in the course sidebar.

#### Imagen destacada (Featured image) — portrait

Displayed as a **circle**. Use a square photo with the face centred and some space around it. Without a portrait, an empty circle is shown.

#### Rol \*

The gold line under the name. For example, "Terapeuta Holística. Especialista en Terapia Centrada en Soluciones". Up to 140 characters.

#### Formación

A list of training and credentials, added with **Añadir formación**. Each row has a **Título** (required), and optionally an **Año**, an **Institución** and a **Descripción**.

**This list is shown only for the person selected as founder on Acerca de.** For anyone else, it's stored but not displayed.

### Publishing checklist — Professionals

- [ ] Name spelled correctly.
- [ ] Role is filled in.
- [ ] Square portrait with the face centred.
- [ ] Bio proofread.
- [ ] The person is selected on the right services and courses.
- [ ] Checked on at least one service or course page where they appear.

## 8. Managing Testimonials

### What a Testimonial is

A short client quote shown in the **"Experiencias que dejan huella"** slider on the home page.

### Where to find Testimonials

Click **Testimonios** in the left sidebar.

### Creating or editing a Testimonial

1. Go to **Testimonios** and click the add-new button (**Añadir testimonio**), or click an existing testimonial.
2. **Title:** the client's display name. The convention is first name and initial, for example "Valentina R."
3. **Main text area:** the quote itself.
4. In the **Testimonio** panel, choose the service or course the quote is about in **Sobre**.
5. Set **Orden** (*Order*) in the sidebar to place it in the slider.
6. **Publicar** (*Publish*) or **Actualizar** (*Update*).

> 📷 **Screenshot needed:** A Testimonio edit screen showing the title, the quote and the **Sobre** dropdown with a service selected.

### Fields

#### Title

The client's name as displayed under the quote.

#### Main text area (quote)

Shown as **plain text**: bold, italics, links and paragraph breaks are dropped. Keep it to one paragraph, about 300 characters or fewer.

#### Sobre

The service or course the client is talking about. Its current name appears under the client's name, so if that service is renamed, the label updates automatically. Leave it empty for no label.

#### Orden (Order)

Position in the slider. Lower numbers come first.

If you see an **Extracto** (*Excerpt*) box on this screen, leave it alone. The website doesn't display it.

### Publishing checklist — Testimonials

- [ ] The client has agreed to be quoted, and the name is shown the agreed way.
- [ ] The quote is a single, proofread paragraph.
- [ ] **Sobre** points to the right service or course.
- [ ] Checked in the home page slider.

## 9. Managing Pages

### What the Pages are

The site has six pages you edit. Their main content (service cards, course cards, testimonials) comes from the sections above. On the pages themselves, you edit the header and a few blocks of text.

Go to **Páginas** (*Pages*) in the left sidebar.

> **Important:** Don't change the **web address (slug)** of any of these pages, and don't delete them. The site's links and templates depend on them.

| Page | What you can edit there |
|---|---|
| **Inicio** (home page) | Header, plus every section in the **Inicio** panel |
| **Acerca de** | Header, plus which professional is the founder |
| **Servicios** | Header only. The catalogue comes from **Servicios** |
| **Cursos** | Header only. The list comes from **Cursos** |
| **Aviso de privacidad** | The legal text |
| **Términos y condiciones** | The legal text |

On **Inicio, Acerca de, Servicios and Cursos**, the main text area at the top of the edit screen **isn't shown on the website**. Type nothing there and use the panels below it.

### The page header ("Encabezado de página")

Every page has an **Encabezado de página** panel with these fields:

- **Antetítulo**: the small line above the title, up to 60 characters.
- **Título**: the large heading, up to 120 characters.
- **Subtítulo**: the text under the heading.
- **Imagen de fondo**: the background photo. See [Images and media](#12-images-and-media).
- **Texto del botón** and **Enlace del botón**: a button. **Only the home page shows it.**

Which fields each page uses:

| Page | Fields used |
|---|---|
| Inicio | All six |
| Acerca de, Servicios, Cursos | Antetítulo, Título, Subtítulo, Imagen de fondo (the button fields are ignored) |
| Aviso de privacidad, Términos y condiciones | None. These pages have a fixed header |

**If you empty a header field, the website shows the original design text instead.** Emptying a field doesn't hide it. Servicios and Cursos show a plain green header when they have no background image.

> 📷 **Screenshot needed:** The **Encabezado de página** panel on the Servicios page, next to the live Servicios page header, with arrows matching each field to what it controls.

### Inicio (home page)

Below the page header, the **Inicio** panel holds the copy for each home page section, in page order:

1. **Introducción**: the "Todo comienza cuando volvemos a conectar" block. It has **Título**, **Texto** (a small text editor with basic formatting), **Imagen**, and **Texto del botón** / **Enlace del botón**. The image is shown in a tall, arched frame, so only its centre is visible.
2. **Servicios (encabezado)**: **Antetítulo**, **Título** and **Subtítulo** above the featured services. The services themselves come from **Destacado en Inicio** on each service.
3. **Cómo funciona**: **exactly 3 steps**, each with a **Título** and **Texto**. The icons, the 01/02/03 numbers and the heading "Tu proceso comienza aquí" are part of the design.
4. **Cita**: the quote over a photo. It has **Línea 1**, **Línea 2** (shown in italics) and **Imagen de fondo**.
5. **Cursos (encabezado)**: **Antetítulo**, **Título** and **Texto** above the course cards.
6. **Testimonios (título)**: the heading above the testimonial slider.

**Don't empty these fields to hide something.** Depending on the field, an empty value either brings back the original text or leaves a gap (an empty **Texto del botón** hides that button). To remove a whole section, ask development.

> 📷 **Screenshot needed:** The **Inicio** panel on the Inicio edit screen, with the **Introducción** and **Cómo funciona** groups expanded.

### Acerca de

- **Header:** see above.
- **Fundadora \*** (in the **Acerca de** panel): choose the founder from **Profesionales**. Her portrait, name, role and bio come from that entry, and so does the **"Formación"** list. To change the founder's text or photo, edit her entry under **Profesionales**, not this page.
- The **"Historia / Nosotros"** text is part of the page design and has no field. Changes go to development.

### Servicios and Cursos

Only the header is edited on these pages. The cards update automatically when you add, edit, reorder or unpublish services and courses.

### Legal pages: Aviso de privacidad and Términos y condiciones

1. Go to **Páginas** and open the page.
2. Edit the document in the main text area.
3. Make each numbered section a **Heading** (*Encabezado*) block at **H2** level. The website numbers H2 headings automatically ("1.", "2.", …), so **don't type the numbers**.
4. Write the section text as normal paragraphs under each heading.
5. Leave the **Plantilla** (*Template*) setting on **Legal**.
6. **Actualizar** (*Update*) and check both pages.

The header ("Información legal y de privacidad."), the tabs linking the two documents and the footer links are fixed. The contact note at the bottom of both pages comes from **Ajustes de Álmica → Legales**.

> 📷 **Screenshot needed:** The Aviso de privacidad edit screen, showing an H2 heading block selected with the block toolbar visible, and the **Plantilla: Legal** setting in the sidebar.

### Publishing checklist — Pages

- [ ] The web address (slug) hasn't changed.
- [ ] Header fields are filled in, not emptied to hide them.
- [ ] Home page: still exactly 3 "Cómo funciona" steps.
- [ ] Legal pages: sections are H2 headings, with no typed numbers; the template is still **Legal**.
- [ ] Checked on desktop and on a phone.

## 10. Global website content

### Ajustes de Álmica

**Ajustes de Álmica** in the left sidebar holds information that appears on **many pages at once**. **A change here affects the whole website**, so double-check before saving. This screen needs an **Administrator** account.

Fields are grouped into tabs. Click **Guardar ajustes** to save.

> 📷 **Screenshot needed:** The **Ajustes de Álmica** screen with the **Contacto** tab open and the tab list (Contacto, Redes sociales, Pie de página, Precios, Cursos, Legales) visible.

#### Contacto tab

- **Correo de contacto**: shown in the footer, on every course page and on both legal pages.
- **Teléfono**: shown in the footer as text.
- **WhatsApp**: **not currently shown anywhere on the website.** Filling it in won't change the site. Ask development if you want WhatsApp links.
- **Ubicación**: the location line in the footer, for example "México · sesiones virtuales".

Changing **Correo de contacto** does **not** change where contact-form messages are emailed. That's a development change.

#### Redes sociales tab

- **Instagram** and **Facebook**: the full profile address, starting with `https://`. These power the IG and FB buttons in the footer. If a field is empty, its button stays visible but goes nowhere.
- **TikTok**: **not currently shown on the website.**

#### Pie de página tab

- **Descripción**: the sentence under the logo in the footer.
- **Lema**: the tagline in the footer's bottom bar.

#### Precios tab

- **Moneda**: the currency label after **every** price on the site, for example "MXN".
- **Base del precio (servicios)**: the standard line under service prices ("por sesión individual"). An individual service can override it.
- **Texto de precio a consultar**: shown on courses that have no price.

#### Cursos tab

- **Título de la tarjeta de contacto** and **Texto de la tarjeta de contacto**: the "¿Te interesa este programa?" box on every course page.

#### Legales tab

- **Nota de contacto**: the note at the bottom of both legal pages. The contact email is added after it automatically.

**Emptying an Ajustes field brings back its original default text.** It doesn't remove the item from the website.

### Navigation menus

The header and footer link lists are managed in **Apariencia → Menús** (*Appearance → Menus*). This needs an **Administrator** account.

- **Menú principal**: the header links (Inicio, Acerca de, Servicios, Cursos).
- **Menú de pie de página**: the footer's "Navegación" column (Acerca de, Servicios, Cursos).

Menus are one level only, with no dropdowns. The footer's **Legal** and **Contacto** columns aren't menus. They're built automatically from the legal pages and from Ajustes de Álmica.

> 📷 **Screenshot needed:** **Apariencia → Menús** with **Menú principal** selected, showing its four items and the "Menu locations" checkboxes.

### Site title and tagline

The site name in the footer's copyright line comes from **Ajustes → Generales** (*Settings → General*), which needs Administrator access. Only change it as part of an agreed rebrand.

## 11. Contact form messages

**Contactos** in the left sidebar lists messages sent through the website's contact form.

- Click an entry to read the details: name, email, phone, country, service of interest and message.
- **Exportar CSV**, at the top of the list, downloads every message as a spreadsheet.
- You can't create entries by hand.
- For privacy, messages older than **18 months** are moved to the trash automatically.

These entries contain personal data. Don't share exports outside the people who need them.

> **Needs verification:** the contact form isn't currently placed on any of the main pages (Inicio, Acerca de, Servicios, Cursos). Confirm with development where it should live before relying on this list.

## 12. Images and media

### Uploading

Upload images straight from the field: click the image field's add button, or the featured-image box in the sidebar. You can also upload in **Medios** (*Media*) first and pick the image later.

### Recommended sizes

The website crops images automatically. Uploading at least these sizes gives the sharpest result.

| Where | Shape on the website | Upload at least | Keep the subject… |
|---|---|---|---|
| Service card (featured image) | Tall portrait card | 640 × 480 px, landscape | In the **centre**. The card shows only the middle slice |
| Course card (featured image) | Portrait card / small landscape card | 640 × 480 px, landscape | In the centre |
| Service and course page header | Wide banner under a green tint | 1600 × 900 px, landscape | In the centre |
| Page headers (Inicio, Acerca de, Servicios, Cursos) | Wide banner | 1600 × 900 px, landscape | Home page: on the **right**. The left side is darkened behind the text |
| Home "Introducción" image | Tall arched frame | 1600 × 900 px | In the centre. The edges are cut off |
| Home "Cita" background | Wide banner under a green tint | 1600 × 900 px | Anywhere; the image is muted |
| Professional portrait | Circle | 400 × 400 px, **square** | Face centred, with space around |

WordPress doesn't check image sizes when you upload. Smaller images are accepted but may look soft or be cropped unexpectedly.

### Good practice

- **Compress large photos** before uploading. Photos straight from a camera or phone are often much bigger than needed.
- **Keep the same shape when replacing an image.** Swapping a landscape photo for a portrait one (or the reverse) changes what gets cropped.
- **Use descriptive file names**, such as `arteterapia-sesion.jpg` instead of `IMG_4821.jpg`.
- **Fill in Texto alternativo** (*Alternative text*) in the media details. Briefly describe the photo for visitors who use screen readers.
- **Check the result** on the website, on desktop and on a phone, after every image change.

> 📷 **Screenshot needed:** The **Medios** (*Media*) attachment-details panel for one service photo, showing the dimensions and the **Texto alternativo** field.

## 13. Links and buttons

Most links on this site are created automatically from content. Service cards link to their service, the "Volver a servicios" link goes back to the catalogue, and the menus link to the pages. Only a few fields take a web address you type yourself:

| Field | Where | What to enter |
|---|---|---|
| **Enlace del botón** (Encabezado de página) | Home page header button | An internal page, for example `/acerca-de/`, or a full address |
| **Enlace del botón** (Inicio → Introducción) | Home intro button | Same as above |
| **Instagram**, **Facebook** (Ajustes de Álmica) | Footer buttons | The full profile address starting with `https://` |
| **Correo de contacto** (Ajustes de Álmica) | Footer, course pages, legal pages | Just the email address, for example `nombre@dominio.com`. The website makes it clickable |

Tips:

- **Internal links:** copy the address from the page on the website and keep only the part after the domain, for example `/servicios/arteterapia/`. That keeps the link working if the domain ever changes.
- **External links:** paste the full address, including `https://`.
- **Test every link** after saving by clicking it on the live website.
- **Phone numbers** are shown as text. They aren't clickable call links.
- **WhatsApp links** aren't supported yet. See [section 3](#3-what-requires-development).
- Inside a text editor, select the words and use the link button in the toolbar. Don't paste raw addresses into the text.

## 14. FAQ

### Can I change text myself?

Yes. Anything that has a field can be changed in WordPress: titles, descriptions, prices, benefits, bios, quotes, page headers, home page copy, legal text and the global settings. Text that's part of the design, like section labels, needs development.

### Can I replace an image?

Yes. Select a new image in the same field and save. Keep the same shape (landscape or square) as the original, and check the page afterwards.

### Can I create another service, course, professional or testimonial?

Yes. Use the add-new button in **Servicios**, **Cursos**, **Profesionales** or **Testimonios**. New services and courses automatically appear on the Servicios and Cursos pages. New services also appear in the contact form. Remember:

- The home page shows at most **6 featured services** and the **first 3 courses**.
- A new professional only appears where you select them on a service or course.

### Can I create a new page?

Not as a designed page. The site has no general-purpose page design, so a new page would look very plain. Ask development.

### Can I change the layout?

No. Layout, section order, colours and fonts are part of the design. Send layout requests to development.

### What if I need information that doesn't have a field?

Don't squeeze it into another field, such as putting a schedule into the description or a link into a benefit title. Ask development for a proper field, so it appears consistently on every item.

### Should I update the original Excel file?

No. The spreadsheet was only used to load the first version of the content. **WordPress is now the official version.** Changes made in the spreadsheet won't reach the website. If the spreadsheet were imported again, it could overwrite your WordPress edits, so tell development if anyone plans to.

### Can editing content break the website?

Normal editing can't break the design, because the templates control the layout. A few actions can cause problems, though:

- changing a page's or service's web address (slug)
- deleting or unpublishing the main pages
- removing the **Legal** template from a legal page
- trashing a professional who is still selected on services or courses
- turning off every **Destacado en Inicio**, which hides the home page services section

If something looks wrong after a change, undo it (see [Troubleshooting](#15-troubleshooting)) and contact development.

### When should I contact the developer?

Contact development whenever you need something [section 3](#3-what-requires-development) lists, when a fix in [Troubleshooting](#15-troubleshooting) doesn't work, or whenever you're unsure whether a change is content or structure. Asking first is always fine.

## 15. Troubleshooting

### I updated something but can't see the change

1. Make sure you clicked **Actualizar** / **Publicar** and the item isn't still a draft.
2. Reload the public page. If you're logged in, also try a private or incognito window.
3. Make sure you're looking in the right place. For example, a service's **Extracto** isn't shown on its card, and a course's **Duración** only shows when it has a price.
4. The website keeps a cached copy of its pages for speed, so a change can take a short while to appear.

> **Needs verification:** whether your account shows a "purge cache" option in the top admin bar, and whether saving clears the cache automatically.

### The image looks wrong

- **Cropped badly:** move the subject to the centre of the photo, or use a photo closer to the shape in [Images and media](#12-images-and-media), then re-upload.
- **Blurry:** the upload was too small. Upload a larger version.
- **The page header shows a different photo from the card:** the service or course has its own **Imagen del encabezado**. Change or clear that field.
- **A portrait shows an empty circle:** the professional has no featured image.

### My link doesn't work

- External links must start with `https://`.
- Internal links should start with `/`, for example `/acerca-de/`.
- Check for typos and spaces, then save and click the link on the live site.
- Instagram or Facebook buttons that go nowhere mean the field in **Ajustes de Álmica** is empty.

### I don't see a field for the information I need

- Scroll down. The site's fields are in a panel **below** the main text area.
- On the home page, look in the **Inicio** panel. On other pages, look in **Encabezado de página**.
- Contact details, prices wording and footer text are in **Ajustes de Álmica** (Administrator accounts only).
- If none of these have it, the field doesn't exist yet. Ask development.

### I'm not sure where a piece of content is managed

| You see on the website… | Edit it in… |
|---|---|
| A service's name, price, benefits, photo | **Servicios** → that service |
| A therapist's photo, role or bio | **Profesionales** → that person |
| A course card's summary | **Cursos** → that course → **Extracto** |
| "Escríbenos para conocer el precio" | **Ajustes de Álmica → Precios** |
| "¿Te interesa este programa?" box | **Ajustes de Álmica → Cursos** |
| Footer email, phone, location, social buttons | **Ajustes de Álmica** |
| Footer "Navegación" links, header links | **Apariencia → Menús** |
| Home page section text | **Páginas → Inicio → Inicio** panel |
| Founder on Acerca de and her "Formación" | **Profesionales** → the founder (chosen in **Páginas → Acerca de**) |
| A testimonial's label under the name | **Testimonios** → that testimonial → **Sobre** |
| "Nosotros" text, section labels, legal header | Not editable. Ask development |

### I made a mistake and want to go back

- **Pages** (Inicio, Acerca de, legal pages, …) keep a history of saved versions. In the settings sidebar, open **Revisiones** (*Revisions*), pick an earlier version and restore it.
- **Services, courses, professionals, testimonials and Ajustes de Álmica don't keep a version history.** Before a big edit, copy the current text somewhere safe so you can paste it back if needed.
- A trashed item can be restored from **Papelera** (*Trash*) at the top of its list.

> **Needs verification:** that revisions are enabled on production for Pages, and whether restoring a page revision also restores its header and Inicio fields.

# Recommended YouTrack Knowledge Base Structure

A parent article plus nine child articles. Each child is one or two H2 sections of this file, so it can be copied as-is. Promote the H2 to the article title, and its H3/H4 headings move up one level.

**Álmica Healing Website — Content Management** (parent)
Contents: the title and intro line, plus **1. About this guide**, including "A note on admin language". End with a list of links to the child articles.

| # | Child article | Sections from this file |
|---|---|---|
| 1 | **Start Here: What You Can and Can't Change** | 2. What you can safely edit · 3. What requires development |
| 2 | **WordPress Basics** | 4. WordPress basics, including the Spanish/English label table |
| 3 | **Managing Services** | 5. Managing Services |
| 4 | **Managing Courses** | 6. Managing Courses |
| 5 | **Managing Professionals** | 7. Managing Professionals |
| 6 | **Managing Testimonials** | 8. Managing Testimonials |
| 7 | **Managing Pages (Home, About, Listings, Legal)** | 9. Managing Pages |
| 8 | **Global Website Content, Menus and Contact Messages** | 10. Global website content · 11. Contact form messages |
| 9 | **Images & Links** | 12. Images and media · 13. Links and buttons |
| 10 | **FAQ & Troubleshooting** | 14. FAQ · 15. Troubleshooting |

Notes for publishing:

- Internal links in this file point to `#section` anchors. In YouTrack, replace them with links to the matching child article.
- Keep the **Needs verification** notes out of the published articles. Resolve them first, or move them to an internal comment.
- Replace each **📷 Screenshot needed** placeholder with the captured image when the screenshots are ready.
