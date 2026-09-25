# Benefit icons (`beneficio-*.svg`)

The closed set behind `almicahealing_benefit_icon_choices()` (content model Q8).
Editors pick a slug; `almicahealing_benefit_icon()` inlines the file.

## Provenance

Six slugs carry the designer's delivered art, extracted from the
`assets-…` drop (`assets/servicios/*/iconos/`). Figma numbers those
files per service rather than naming them, so the mapping comes from
Arteterapia — the one service whose five `iconos/` files line up
one-for-one with its five benefit rows:

| slug       | source                               | evidence                       |
|------------|--------------------------------------|--------------------------------|
| `corazon`  | `Arte-terapia/iconos/1.svg`          | Arteterapia benefit 0          |
| `ondas`    | `Arte-terapia/iconos/2.svg`          | Arteterapia benefit 1          |
| `brote`    | `Arte-terapia/iconos/3.svg`          | Arteterapia benefit 2          |
| `ojo`      | `Arte-terapia/iconos/4.svg`          | designer position 2, all 11 services |
| `manos`    | `Arte-terapia/iconos/5.svg`          | Arteterapia benefit 4          |
| `circulos` | `Limpieza-energetica/iconos/1.svg`   | designer position 1, all 10 services |

`chispa`, `equilibrio`, `espiral` and `luna` are still the older 24x24
stroked drawings — the designer has not delivered art for them. Until
they do, a benefits list mixing those slugs with the six above shows
two different icon styles side by side.

One delivered icon is unplaced: the crossed-leaves shape at designer
position 3 (`Limpieza-energetica/iconos/3.svg`, five services). The
slugs at that position vary across services, so it has no home yet.

## Conversion applied

Figma wraps each export in `<g clip-path>` + `<defs><clipPath><rect>`
where the rect exactly covers the viewBox — a no-op clip. Stripping it
keeps `id` attributes off the page, so several icons inline together
without colliding, and keeps the `wp_kses` allowlist narrow. Also:
`width`/`height` dropped so CSS sizes them, and the literal `#263B33`
(the `dark-green` token) swapped for `currentColor` so
`.benefit-tile__icon` keeps applying `text-dark-green/70`.

The set is 24 high with variable width; size it by height, never as a
square.
