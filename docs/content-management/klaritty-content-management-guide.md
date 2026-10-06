# Sitio web de Álmica Healing — Guía de administración de contenido

Para el equipo de Klaritty que mantiene actualizado el sitio web de Álmica Healing.

## 1. Acerca de esta guía

El sitio web de Álmica Healing está construido con **contenido estructurado**. Los servicios, cursos, profesionales y testimonios no son páginas libres. Cada uno es un conjunto de campos con nombre, como un título, un precio, una lista de beneficios o una foto. Las plantillas del sitio convierten esos campos en páginas terminadas y con un diseño uniforme.

En resumen: **tú administras la información y el sitio se encarga de cómo se ve.**

Esto significa que:

- Nunca tienes que acomodar diseños, elegir tipografías ni definir colores. Llena los campos y la página se arma sola.
- Un cambio puede aparecer en varios lugares. Por ejemplo, si cambias la foto de un profesional, se actualiza en todos los servicios y cursos donde aparece.
- Si necesitas algo que los campos no ofrecen, es una solicitud para desarrollo (consulta [Qué requiere desarrollo](#3-que-requiere-desarrollo)).

El contenido del sitio se cargó por primera vez desde una hoja de cálculo. **Esa hoja de cálculo ya no se usa.** A partir de ahora, la versión oficial del contenido es la que está en WordPress. Haz todos los cambios en WordPress y no edites la hoja de cálculo esperando que el sitio se actualice.

### Sobre el idioma del panel

El panel de WordPress está configurado en **español (México)**, y esta guía usa las etiquetas en español que verás en pantalla.

Si tu pantalla aparece en inglés, tu perfil tiene su propio ajuste de idioma. Ve a **Usuarios → Perfil**, elige **Predeterminado del sitio** en **Idioma** y guarda. Algunas pantallas de terceros, como la del plugin de caché, pueden seguir en inglés porque no tienen traducción al español.

## 2. Qué puedes editar

Puedes crear, editar y eliminar por tu cuenta lo siguiente:

- **Servicios**: títulos, descripciones, precios, duraciones, modalidad, beneficios, fotos, quién imparte cada servicio, qué servicios aparecen en la página de inicio y el orden del catálogo.
- **Cursos**: títulos, descripciones, precios, duraciones, nivel, etiqueta del programa, la lista numerada, fotos, facilitadores y orden.
- **Profesionales**: nombres, roles, biografías, retratos y la formación de la fundadora («Formación»).
- **Testimonios**: citas, nombres de clientes, el servicio o curso del que habla cada uno y su orden.
- **Textos e imágenes de las páginas** Inicio, Acerca de, Servicios y Cursos, en los campos disponibles.
- **Los documentos legales**: el texto del Aviso de privacidad y de los Términos y condiciones.

Quienes editan contenido usan cuentas de **Editor**, que cubren todo lo anterior. Hay dos áreas que maneja el administrador del sitio de Klaritty:

- **Contenido global del sitio** (Ajustes de Álmica): correo de contacto, teléfono, ubicación, redes sociales, textos del pie de página, textos de precios y la tarjeta de contacto de los cursos.
- **Menús de navegación**: las listas de enlaces del encabezado y del pie de página.

Estas pantallas no aparecen en las cuentas de Editor. Aun así son cambios de contenido, no de desarrollo: envía el texto nuevo al administrador del sitio de Klaritty, que se encarga de hacer el cambio.

## 3. Qué requiere desarrollo

Una regla sencilla:

> Si estás cambiando **lo que dice algo**, probablemente es un cambio de contenido y lo puedes hacer tú.
>
> Si estás cambiando **qué información existe**, **cómo está estructurado algo** o **cómo se muestra**, probablemente es un cambio de desarrollo.

Contacta a desarrollo para cualquiera de estos casos:

- **Un campo nuevo para todos los elementos.** Por ejemplo, un «horario de sesiones» o un «enlace de reserva» en cada servicio, o una fecha de inicio en cada curso.
- **Un tipo de contenido nuevo.** Por ejemplo, una tienda, productos, eventos o un blog. (La tienda en línea y las reservas de servicios se dejaron fuera de esta versión del sitio a propósito.)
- **Cambiar un diseño.** Por ejemplo, mover los beneficios arriba de la descripción, mostrar más de 6 servicios destacados en la página de inicio o cambiar la forma de las tarjetas.
- **Textos que forman parte del diseño.** Las etiquetas de sección como «Sobre este servicio», «Inversión», «Quién imparte», «Otros servicios», «Sobre el curso», «Otros programas», «Tu proceso comienza aquí», «Ver más» y «Contáctanos» no tienen campo.
- **El texto de historia «Nosotros» en Acerca de.** Es parte de la página y todavía no tiene un campo editable.
- **El encabezado de las páginas legales.** Incluye el título «Información legal y de privacidad.» y los nombres de las pestañas.
- **Íconos de beneficios nuevos.** Solo puedes elegir de la lista existente.
- **Páginas nuevas.** El sitio no tiene un diseño de página de uso general. Una página nueva tendría un diseño muy básico.
- **El formulario de contacto**: sus preguntas, su correo de confirmación, la dirección que recibe las notificaciones o colocar el formulario en otra página.
- **Enlaces de WhatsApp o TikTok.** Los ajustes tienen campos para ellos, pero el sitio todavía no los muestra.
- **Cualquier cosa relacionada con plugins, analítica, el dominio o el envío de correos.**
- **Cambiar la dirección web (URL) de una página, servicio o curso.**

## 4. Conceptos básicos de WordPress

### Iniciar sesión

Inicia sesión en la dirección `/wp-admin` del sitio con tu propia cuenta. La barra lateral izquierda muestra todo lo que puedes administrar.

> 📷 **Captura necesaria:** La barra lateral izquierda de wp-admin como la ve un **Editor**, mostrando **Servicios**, **Cursos**, **Testimonios**, **Profesionales** y **Páginas**. Los editores son el público principal, así que tómala desde una cuenta de Editor.

### El flujo de trabajo diario

1. **Abre la sección** en la barra lateral izquierda, por ejemplo **Servicios**.
2. **Busca el elemento.** Haz clic en su título en la lista o usa el buscador en la parte superior derecha de la lista.
3. **Edita los campos.** El área de texto principal está en la parte superior de la pantalla de edición. Los campos propios del sitio están en un panel **debajo** de ella, con el nombre del tipo de contenido (por ejemplo **Servicio**). Desplázate hacia abajo para encontrarlos.
4. **Previsualiza** si vas a hacer un cambio grande: abre el menú **Ver** (el ícono de pantalla arriba a la derecha) y elige **Previsualizar en nueva pestaña**.
5. **Guarda.** Haz clic en **Publicar** si es algo nuevo, o en **Guardar** si ya estaba publicado. Usa **Guardar como borrador** para seguir trabajando después sin que se muestre en el sitio.
6. **Vacía la caché.** En la barra negra de la parte superior de la pantalla, abre **Breeze** y haz clic en **Purge All Cache**. Hazlo después de cualquier cambio que se vea en más de una página y, si tienes duda, siempre. Consulta [Solución de problemas](#14-solucion-de-problemas) para saber por qué.
7. **Revisa la página pública en una ventana privada o de incógnito.** Mientras tienes la sesión iniciada siempre ves la versión más reciente, así que una ventana privada es la única forma de ver lo que ven los visitantes.

> 📷 **Captura necesaria:** La barra negra superior de cualquier pantalla de wp-admin, con el menú **Breeze** abierto y **Purge All Cache** resaltado. Tómala desde una cuenta de Editor.

> 📷 **Captura necesaria:** La pantalla de edición de un servicio, desplazada de forma que se vean el área de texto principal y la parte superior del panel de campos **Servicio**. Señala «Texto principal» y «Campos del servicio», e indica la barra lateral de ajustes a la derecha.

### Campos marcados con asterisco

Los campos marcados con **\*** son obligatorios. Llénalos antes de publicar. Si falta un campo obligatorio, puede que el elemento no se guarde o que quede un hueco en la página.

### La barra lateral de ajustes

El panel a la derecha de la pantalla de edición tiene algunos ajustes estándar de WordPress que usa este sitio:

- **Imagen destacada**: la foto principal de servicios, cursos y profesionales.
- **Extracto**: un resumen corto. Lo usan los servicios y los cursos. Consulta cada sección para saber dónde aparece.
- **Orden**: un número que controla el orden de servicios, cursos y testimonios. Los números más bajos aparecen primero.
- **Plantilla**: solo importa en las páginas legales.

### Borradores y papelera

- Los borradores y los elementos en la papelera desaparecen de los listados del sitio: las páginas Servicios y Cursos, la página de inicio y el carrusel de testimonios. Los elementos en la papelera se quedan en **Papelera** y se pueden restaurar desde ahí.
- **Una excepción: los elementos que elegiste a mano en otro lugar.** Un profesional seleccionado en un servicio, un curso o Acerca de, o un servicio seleccionado en **Otros servicios** de otro servicio, **sigue apareciendo** aunque lo mandes a la papelera o lo regreses a borrador. Quítalo primero de esos lugares. Consulta [Retirar a un profesional](#retirar-a-un-profesional) y [Retirar un servicio](#retirar-un-servicio).

### Si tu pantalla está en inglés

El panel está configurado en español. Si cambiaste tu perfil a inglés, estas son las equivalencias de las etiquetas que usa esta guía:

| Español | Inglés |
|---|---|
| Páginas | Pages |
| Medios | Media |
| Entradas | Posts |
| Apariencia → Menús | Appearance → Menus |
| Imagen destacada | Featured image |
| Extracto | Excerpt |
| Orden | Order |
| Plantilla | Template |
| Ver → Previsualizar en nueva pestaña | View → Preview in new tab |
| Publicar / Guardar | Publish / Save |
| Guardar como borrador | Save draft |
| Añadir | Add |
| Mover a la papelera | Move to trash |
| Texto alternativo | Alternative text |

## 5. Administrar servicios

### Qué es un servicio

Un **servicio** es una sesión individual que los clientes pueden reservar, como Arteterapia o Biodescodificación. Cada servicio tiene su propia página. También aparece como tarjeta en el catálogo de servicios y, si se destaca, en la página de inicio.

### Dónde encontrar los servicios

Haz clic en **Servicios** en la barra lateral izquierda. La lista muestra todos los servicios, publicados o no.

### Crear un servicio

1. Ve a **Servicios** y haz clic en **Añadir** en la parte superior de la lista. La pantalla que se abre se llama **Añadir servicio**.
2. Escribe el nombre del servicio como título.
3. Escribe la descripción en el área de texto principal.
4. En la barra lateral derecha, define la **Imagen destacada**, el **Extracto** y el **Orden**.
5. Desplázate hasta el panel **Servicio** y llena los campos. Todos los obligatorios están marcados con **\***.
6. Haz clic en **Guardar como borrador** y luego previsualízalo con **Ver → Previsualizar en nueva pestaña**.
7. Haz clic en **Publicar**.

El servicio nuevo aparece automáticamente en el catálogo de **Servicios**. Solo aparece en la página de inicio si activas **Destacado en Inicio**.

### Editar un servicio existente

1. Ve a **Servicios** y haz clic en el título del servicio.
2. Cambia los campos que necesites.
3. Haz clic en **Guardar** y revisa la página pública.

### Retirar un servicio

1. Revisa si algún otro servicio eligió este en **Otros servicios** y quítalo de ahí. Los servicios elegidos a mano siguen apareciendo aunque estén en la papelera.
2. Si algún testimonio habla de este servicio (**Sobre**), cámbialo a otro servicio o curso, o deja el campo vacío.
3. Abre el servicio y haz clic en **Mover a la papelera**, o regrésalo a borrador si lo vas a volver a usar.
4. Vacía la caché y revisa la página Servicios y la página de inicio.

### Campos

> 📷 **Captura necesaria:** El panel de campos **Servicio** de Arteterapia, desde **Frase del encabezado** hasta **Beneficios**, con al menos dos beneficios visibles.

#### Título

El nombre del servicio. Aparece en la tarjeta del servicio, como título grande en su página, en las tarjetas de «Otros servicios» y debajo de cualquier testimonio vinculado a este servicio. Si cambias el nombre, se actualiza en todos esos lugares a la vez.

Los nombres largos no son problema. Se acomodan en dos líneas en el encabezado de la página.

#### Área de texto principal (descripción)

La sección **«Sobre este servicio»** de la página del servicio. Escribe de uno a tres párrafos sencillos. Evita títulos, imágenes y otros bloques.

#### Extracto

Un resumen de una oración. Aparece debajo del título en el encabezado de la página **solo cuando «Frase del encabezado» está vacía**. Los buscadores también pueden mostrarlo como descripción de la página. Procura no pasar de unos 160 caracteres.

#### Imagen destacada

La foto de la tarjeta del servicio. También se usa como fondo del encabezado de la página cuando **Imagen del encabezado** está vacía. La tarjeta muestra una franja alta y angosta del **centro** de la foto. Consulta [Imágenes y medios](#11-imagenes-y-medios).

#### Orden

Controla la posición del servicio en el catálogo y entre los servicios destacados de la página de inicio. También decide qué tres servicios aparecen de forma predeterminada en «Otros servicios». Los números más bajos aparecen primero.

#### Frase del encabezado

La oración debajo del título en el encabezado de la página. Si está vacía, se usa el **Extracto**. Hasta 200 caracteres.

#### Imagen del encabezado

Una foto distinta y opcional para el encabezado de la página. Si está vacía, se usa la imagen destacada. El encabezado pone un tono verde oscuro sobre la foto para que el texto se lea bien, así que la foto funciona como un fondo suave.

#### Precio \*

El precio de la sesión, **solo el número**: sin «$», sin «MXN» y sin comas. Por ejemplo, `1150` se muestra como **$1,150.00 MXN**. La etiqueta de moneda viene de **Ajustes de Álmica**.

#### Base del precio

La línea pequeña debajo del precio. **Déjala vacía** para usar el texto estándar («por sesión individual», definido en Ajustes de Álmica). Llénala solo si este servicio se cobra de otra forma, por ejemplo «por paquete de 3 sesiones». Hasta 80 caracteres.

#### Duración (minutos) \*

La duración de la sesión en minutos, en intervalos de 15, de 15 a 480. Aparece en **dos lugares**: la etiqueta del encabezado de la página («60 min») y el recuadro de precio «Inversión».

#### Modalidad \*

Elige **Presencial**, **Virtual** o **Presencial y virtual**. Se muestra en el recuadro «Inversión».

#### Beneficios \*

Las tarjetas debajo de **«Lo que esta sesión puede ofrecerte»**. Agrega **entre 1 y 6** con **Añadir beneficio**. Arrastra las filas para reordenarlas. Cada beneficio tiene tres partes:

- **Icono \***: elige de la lista (Corazón, Ondas, Brote, Ojo, Círculos, Equilibrio, Espiral, Manos, Luna, Chispa). Para un aspecto uniforme, prefiere **Corazón, Ondas, Brote, Ojo, Círculos y Manos**. Los otros cuatro tienen un estilo de dibujo anterior.
- **Título \***: el beneficio en sí, hasta 90 caracteres. Por ejemplo, «Favorece la expresión emocional».
- **Descripción**: opcional, hasta 180 caracteres. La forma en que empieza cambia cómo se muestra:
  - Si empieza con **mayúscula**, se muestra como una oración de apoyo aparte, debajo del título. Por ejemplo, título «Reduce el estrés» y descripción «El proceso creativo ofrece un espacio de calma.»
  - Si empieza con **minúscula**, se muestra como la *continuación* de la oración del título, con el mismo estilo. Por ejemplo, título «Te ayuda a» y descripción «soltar lo que ya no te pertenece.»

> 📷 **Captura necesaria:** La página de un servicio en el sitio, mostrando las tarjetas de beneficios. Incluye una tarjeta con descripción en mayúscula y, si existe, una con continuación en minúscula, una junto a la otra.

#### Quién imparte

El o los profesionales que imparten este servicio, hasta 3. Busca a la izquierda y haz clic en un nombre para agregarlo. Arrastra para reordenar. Cada persona se muestra con su retrato, nombre, rol y biografía, tomados de su ficha en **Profesionales**.

**Si lo dejas vacío, se oculta toda la sección «Quién imparte».** Úsalo así mientras el terapeuta no esté confirmado.

#### Otros servicios

Opcional. Elige los servicios (hasta 3) que se muestran al final de la página. **Déjalo vacío** para mostrar automáticamente los tres servicios siguientes en el orden del catálogo, lo que le da a cada servicio un grupo distinto. Si eliges menos de 3, solo se muestran los que elegiste.

#### Destacado en Inicio

Actívalo para destacar el servicio en la página de inicio. La página de inicio muestra **hasta 6** servicios destacados, en el orden del catálogo. Si hay más de 6 activados, solo aparecen los primeros 6 según el **Orden**.

Si **ninguno** está activado, desaparece por completo la sección de servicios de la página de inicio.

#### Incluye cuadernillo

Actívalo para agregar la línea «Incluye cuadernillo descargable.» debajo de la descripción. Es solo una línea de texto. El sitio no entrega ningún archivo.

### Lista de verificación antes de publicar — Servicios

- [ ] El título está bien escrito.
- [ ] La descripción se lee bien y no tiene títulos ni imágenes sueltas.
- [ ] La imagen destacada está definida y el motivo está al centro.
- [ ] El precio es solo un número; la duración y la modalidad son correctas.
- [ ] Hay de 1 a 6 beneficios, cada uno con ícono y título.
- [ ] «Quién imparte» muestra a la persona correcta, o está vacío a propósito.
- [ ] «Destacado en Inicio» está como debe y no hay más de 6 servicios destacados.
- [ ] El **Orden** coloca el servicio donde quieres en el catálogo.
- [ ] Previsualizado, publicado y revisado en el sitio: la página del servicio, la página Servicios y la página de inicio.

## 6. Administrar cursos

### Qué es un curso

Un **curso** es un programa de formación de varias semanas, como Kriutunmi o Clantanra. Cada curso tiene su propia página. También aparece como tarjeta en la página **Cursos** y en la página de inicio, y en «Otros programas» al final de las páginas de los demás cursos.

### Dónde encontrar los cursos

Haz clic en **Cursos** en la barra lateral izquierda.

### Crear un curso

1. Ve a **Cursos** y haz clic en **Añadir** en la parte superior de la lista. La pantalla se llama **Añadir curso**.
2. Escribe el título y la descripción, y define la **Imagen destacada**, el **Extracto** y el **Orden** en la barra lateral.
3. Llena el panel **Curso** debajo del área de texto principal.
4. Guarda un borrador, previsualiza y luego haz clic en **Publicar**.

Ten en cuenta que la página de inicio solo muestra los **primeros 3 cursos** según el **Orden**. Todos los cursos aparecen en la página **Cursos**.

### Editar un curso existente

Ve a **Cursos**, haz clic en el título, haz tus cambios, haz clic en **Guardar** y revisa la página.

### Campos

> 📷 **Captura necesaria:** El panel de campos **Curso** de Kriutunmi, mostrando **Etiqueta del programa**, **Nivel**, **Precio**, **Duración**, **Encabezado de la lista** y algunos **Puntos de la lista**.

#### Título

El nombre del curso. Aparece en todas las tarjetas del curso, como título de su página y debajo de los testimonios vinculados.

#### Área de texto principal (descripción)

La sección **«Sobre el curso»**. De uno a tres párrafos sencillos.

#### Extracto

**El resumen que se muestra en la tarjeta del curso**, tanto en la página de inicio como en la página Cursos. También aparece debajo del título de la página cuando **Frase del encabezado** está vacía. Mantenlo en una o dos oraciones, unos 160 caracteres.

#### Imagen destacada

La foto de todas las tarjetas del curso y el fondo del encabezado de su página. Las tarjetas la recortan con formas distintas en distintos lugares, así que mantén el motivo al centro.

#### Orden

La posición del curso en la página Cursos (con su número «01», «02», «03»), en la página de inicio y en «Otros programas».

#### Frase del encabezado

La oración debajo del título en el encabezado de la página. Si está vacía, se usa el **Extracto**. Hasta 250 caracteres.

#### Etiqueta del programa \*

La etiqueta pequeña arriba del título en el encabezado de la página. Por ejemplo, «Curso intermedio de canalización y sanación». Hasta 80 caracteres.

#### Nivel \*

**Básico**, **Intermedio** o **Abierto a todos**. Se muestra en las tarjetas pequeñas de «Otros programas».

#### Precio

El precio del curso, **solo como número entero**. Por ejemplo, `5900` se muestra como **$5,900 MXN**.

**Déjalo vacío si el precio es a consultar.** Entonces desaparece el recuadro de precio, y la tarjeta y el recuadro de contacto muestran «Escríbenos para conocer el precio». Ese texto se define en Ajustes de Álmica.

#### Duración

Texto libre como «2 meses», hasta 40 caracteres. Se muestra dentro del recuadro de precio, así que **solo aparece cuando Precio está lleno**.

#### Encabezado de la lista \*

El título del recuadro con la lista numerada: **Objetivos**, **Beneficios** o **Temas**.

#### Puntos de la lista \*

Los puntos numerados, de 1 a 10. Agrégalos con **Añadir punto**. **No escribas los números.** El sitio numera los puntos automáticamente. Cada punto puede tener hasta 200 caracteres.

#### Facilitador/a

La persona (1 o 2) que imparte el curso, elegida de **Profesionales**. En la página del curso se muestra en la barra lateral con un retrato pequeño, su nombre y su rol. Aquí no se muestra la biografía.

### Textos que vienen de Ajustes de Álmica

El recuadro «¿Te interesa este programa?», su texto y el correo de contacto aparecen en **todas** las páginas de cursos. Se editan una sola vez, en **Ajustes de Álmica**. Consulta [Contenido global del sitio](#10-contenido-global-del-sitio).

### Lista de verificación antes de publicar — Cursos

- [ ] El título, la etiqueta del programa y el nivel son correctos.
- [ ] El extracto se lee bien como resumen de tarjeta.
- [ ] El precio es un número entero, o está vacío a propósito para «precio a consultar».
- [ ] La duración está llena si hay precio.
- [ ] El encabezado de la lista corresponde a los puntos; no hay números escritos en los puntos.
- [ ] El facilitador está seleccionado.
- [ ] La imagen destacada está definida.
- [ ] El **Orden** es correcto, recordando que solo los primeros 3 aparecen en la página de inicio.
- [ ] Previsualizado, publicado y revisado en la página del curso, la página Cursos y la página de inicio.

## 7. Administrar profesionales

### Qué es un profesional

Un **profesional** es un terapeuta, un facilitador o la fundadora. Cada persona se registra **una sola vez** y luego se selecciona en cada lugar donde aparece:

- en servicios, en «Quién imparte»
- en cursos, en «Facilitador/a»
- en Acerca de, como fundadora

Los profesionales no tienen su propia página en el sitio.

### Dónde encontrar a los profesionales

Haz clic en **Profesionales** en la barra lateral izquierda.

### Crear un profesional

1. Ve a **Profesionales** y haz clic en **Añadir** en la parte superior de la lista. La pantalla se llama **Añadir profesional**.
2. Escribe el nombre completo de la persona como título.
3. Escribe su biografía en el área de texto principal.
4. Define su retrato como **Imagen destacada**.
5. Llena **Rol** en el panel **Profesional**.
6. Haz clic en **Publicar**.
7. Abre cada servicio o curso que imparte y agrégalo en **Quién imparte** o **Facilitador/a**. Crear a la persona no la coloca en ningún lugar por sí solo.

### Editar un profesional

Ve a **Profesionales**, haz clic en el nombre, edita y haz clic en **Guardar**. El cambio aparece en todos los lugares donde esa persona está seleccionada.

### Retirar a un profesional

**Mandar a un profesional a la papelera, o regresarlo a borrador, no lo quita del sitio.** Sigue apareciendo, con foto, rol y biografía, en todos los lugares donde siga seleccionado. Por eso:

1. Quítalo de todos los servicios (**Quién imparte**) y de todos los cursos (**Facilitador/a**). Si es la fundadora, elige a otra persona en **Fundadora** en Acerca de.
2. **Después** mándalo a la papelera.
3. Vacía la caché y revisa los servicios y cursos donde aparecía.

### Campos

> 📷 **Captura necesaria:** La pantalla de edición de Alma Solís, mostrando el retrato en la barra lateral de imagen destacada, la biografía, **Rol** y dos o tres filas de **Formación**.

#### Título (nombre)

El nombre completo de la persona, tal como debe aparecer en el sitio.

#### Área de texto principal (biografía)

De uno a tres párrafos cortos. Se muestra en las páginas de servicios y en Acerca de, pero no en la barra lateral de los cursos.

#### Imagen destacada — retrato

Se muestra como un **círculo**. Usa una foto cuadrada con la cara al centro y algo de espacio alrededor. Sin retrato, se muestra un círculo vacío.

#### Rol \*

La línea dorada debajo del nombre. Por ejemplo, «Terapeuta Holística. Especialista en Terapia Centrada en Soluciones». Hasta 140 caracteres.

#### Formación

Una lista de estudios y certificaciones, que se agregan con **Añadir formación**. Cada fila tiene un **Título** (obligatorio) y, de forma opcional, **Año**, **Institución** y **Descripción**.

**Esta lista solo se muestra para la persona seleccionada como fundadora en Acerca de.** Para cualquier otra persona, se guarda pero no se muestra.

### Lista de verificación antes de publicar — Profesionales

- [ ] El nombre está bien escrito.
- [ ] El rol está lleno.
- [ ] El retrato es cuadrado y tiene la cara al centro.
- [ ] La biografía está revisada.
- [ ] La persona está seleccionada en los servicios y cursos correctos.
- [ ] Revisado en al menos una página de servicio o curso donde aparece.

## 8. Administrar testimonios

### Qué es un testimonio

Una cita corta de un cliente que se muestra en el carrusel **«Experiencias que dejan huella»** de la página de inicio.

### Dónde encontrar los testimonios

Haz clic en **Testimonios** en la barra lateral izquierda.

### Crear o editar un testimonio

1. Ve a **Testimonios** y haz clic en **Añadir** (la pantalla se llama **Añadir testimonio**), o haz clic en un testimonio existente.
2. **Título:** el nombre del cliente tal como se mostrará. La convención es nombre e inicial, por ejemplo «Valentina R.»
3. **Área de texto principal:** la cita.
4. En el panel **Testimonio**, elige en **Sobre** el servicio o curso del que habla la cita.
5. Define el **Orden** en la barra lateral para ubicarlo en el carrusel.
6. Haz clic en **Publicar** si es un testimonio nuevo, o en **Guardar** si ya existe.

> 📷 **Captura necesaria:** La pantalla de edición de un testimonio, mostrando el título, la cita y el menú desplegable **Sobre** con un servicio seleccionado.

### Campos

#### Título

El nombre del cliente tal como aparece debajo de la cita.

#### Área de texto principal (cita)

Se muestra como **texto simple**: se eliminan las negritas, cursivas, enlaces y saltos de párrafo. Mantenla en un solo párrafo, de unos 300 caracteres o menos.

#### Sobre

El servicio o curso del que habla el cliente. Su nombre actual aparece debajo del nombre del cliente, así que si se cambia el nombre de ese servicio, la etiqueta se actualiza sola. Déjalo vacío si no quieres etiqueta.

#### Orden

La posición en el carrusel. Los números más bajos aparecen primero.

Si ves un recuadro **Extracto** en esta pantalla, no lo toques. El sitio no lo muestra.

### Lista de verificación antes de publicar — Testimonios

- [ ] El cliente aceptó que se publique su testimonio, y el nombre aparece como se acordó.
- [ ] La cita es un solo párrafo revisado.
- [ ] **Sobre** apunta al servicio o curso correcto.
- [ ] Revisado en el carrusel de la página de inicio.

## 9. Administrar páginas

### Qué son las páginas

El sitio tiene seis páginas que puedes editar. Su contenido principal (tarjetas de servicios, tarjetas de cursos, testimonios) viene de **Servicios**, **Cursos** y **Testimonios**. En las páginas en sí, editas el encabezado y algunos bloques de texto.

Ve a **Páginas** en la barra lateral izquierda.

> **Importante:** No cambies la **dirección web (slug)** de ninguna de estas páginas y no las elimines. Los enlaces y las plantillas del sitio dependen de ellas.

| Página | Qué puedes editar ahí |
|---|---|
| **Inicio** (página de inicio) | El encabezado y todas las secciones del panel **Inicio** |
| **Acerca de** | El encabezado y qué profesional es la fundadora |
| **Servicios** | Solo el encabezado. El catálogo viene de **Servicios** |
| **Cursos** | Solo el encabezado. La lista viene de **Cursos** |
| **Aviso de privacidad** | El texto legal |
| **Términos y condiciones** | El texto legal |

En **Inicio, Acerca de, Servicios y Cursos**, el área de texto principal en la parte superior de la pantalla de edición **no se muestra en el sitio**. No escribas nada ahí y usa los paneles de abajo.

### El encabezado de la página («Encabezado de página»)

Todas las páginas tienen un panel **Encabezado de página** con estos campos:

- **Antetítulo**: la línea pequeña arriba del título, hasta 60 caracteres.
- **Título**: el título grande, hasta 120 caracteres.
- **Subtítulo**: el texto debajo del título.
- **Imagen de fondo**: la foto de fondo. Consulta [Imágenes y medios](#11-imagenes-y-medios).
- **Texto del botón** y **Enlace del botón**: un botón. **Solo la página de inicio lo muestra.**

Qué campos usa cada página:

| Página | Campos que usa |
|---|---|
| Inicio | Los seis |
| Acerca de, Servicios, Cursos | Antetítulo, Título, Subtítulo, Imagen de fondo (los campos del botón se ignoran) |
| Aviso de privacidad, Términos y condiciones | Ninguno. Estas páginas tienen un encabezado fijo |

**Si vacías un campo del encabezado, el sitio muestra el texto original del diseño.** Vaciar un campo no lo oculta. Servicios y Cursos muestran un encabezado verde liso cuando no tienen imagen de fondo.

> 📷 **Captura necesaria:** El panel **Encabezado de página** de la página Servicios, junto al encabezado de la página Servicios en el sitio, con flechas que relacionen cada campo con lo que controla.

### Inicio (página de inicio)

Debajo del encabezado de página, el panel **Inicio** contiene los textos de cada sección de la página de inicio, en el orden en que aparecen:

1. **Introducción**: el bloque «Todo comienza cuando volvemos a conectar». Tiene **Título**, **Texto** (un pequeño editor con formato básico), **Imagen**, y **Texto del botón** / **Enlace del botón**. La imagen se muestra en un marco alto con forma de arco, así que solo se ve el centro.
2. **Servicios (encabezado)**: **Antetítulo**, **Título** y **Subtítulo** arriba de los servicios destacados. Los servicios en sí vienen de **Destacado en Inicio** en cada servicio.
3. **Cómo funciona**: **exactamente 3 pasos**, cada uno con **Título** y **Texto**. Los íconos, los números 01/02/03 y el título «Tu proceso comienza aquí» son parte del diseño.
4. **Cita**: la frase sobre una foto. Tiene **Línea 1**, **Línea 2** (en cursivas) e **Imagen de fondo**.
5. **Cursos (encabezado)**: **Antetítulo**, **Título** y **Texto** arriba de las tarjetas de cursos.
6. **Testimonios (título)**: el título arriba del carrusel de testimonios.

**No vacíes estos campos para ocultar algo.** Según el campo, un valor vacío regresa el texto original o deja un hueco (un **Texto del botón** vacío oculta ese botón). Para quitar una sección completa, pídelo a desarrollo.

> 📷 **Captura necesaria:** El panel **Inicio** en la pantalla de edición de Inicio, con los grupos **Introducción** y **Cómo funciona** desplegados.

### Acerca de

- **Encabezado:** consulta lo anterior.
- **Fundadora \*** (en el panel **Acerca de**): elige a la fundadora de **Profesionales**. Su retrato, nombre, rol y biografía vienen de esa ficha, igual que la lista **«Formación»**. Para cambiar el texto o la foto de la fundadora, edita su ficha en **Profesionales**, no esta página.
- El texto **«Historia / Nosotros»** es parte del diseño de la página y no tiene campo. Los cambios van a desarrollo.

### Servicios y Cursos

En estas páginas solo se edita el encabezado. Las tarjetas se actualizan solas cuando agregas, editas, reordenas o despublicas servicios y cursos.

### Páginas legales: Aviso de privacidad y Términos y condiciones

1. Ve a **Páginas** y abre la página.
2. Edita el documento en el área de texto principal.
3. Haz que cada sección numerada sea un bloque **Encabezado** de nivel **H2**. El sitio numera los encabezados H2 automáticamente («1.», «2.», …), así que **no escribas los números**.
4. Escribe el texto de cada sección como párrafos normales debajo de su encabezado.
5. Deja el ajuste **Plantilla** en **Legal**.
6. Haz clic en **Guardar** y revisa las dos páginas.

El encabezado («Información legal y de privacidad.»), las pestañas que enlazan los dos documentos y los enlaces del pie de página son fijos. La nota de contacto al final de las dos páginas viene de **Ajustes de Álmica → Legales**.

> 📷 **Captura necesaria:** La pantalla de edición del Aviso de privacidad, mostrando un bloque de encabezado H2 seleccionado con su barra de herramientas visible, y el ajuste **Plantilla: Legal** en la barra lateral.

### Lista de verificación antes de publicar — Páginas

- [ ] La dirección web (slug) no cambió.
- [ ] Los campos del encabezado están llenos, no vaciados para ocultarlos.
- [ ] Página de inicio: siguen siendo exactamente 3 pasos en «Cómo funciona».
- [ ] Páginas legales: las secciones son encabezados H2, sin números escritos; la plantilla sigue siendo **Legal**.
- [ ] Revisado en computadora y en celular.

## 10. Contenido global del sitio

### Ajustes de Álmica

**Ajustes de Álmica**, en la barra lateral izquierda, contiene información que aparece en **muchas páginas a la vez**. **Un cambio aquí afecta todo el sitio**, así que revisa dos veces antes de guardar. Solo el administrador del sitio de Klaritty ve esta pantalla. Los editores le envían sus cambios al administrador.

Guardar esta pantalla no actualiza las páginas en caché del sitio. Después de **Guardar ajustes**, usa siempre **Breeze → Purge All Cache** en la barra superior, o los visitantes podrían ver el pie de página y los datos de contacto anteriores hasta por 24 horas.

Los campos están agrupados en pestañas. Haz clic en **Guardar ajustes** para guardar.

> 📷 **Captura necesaria:** La pantalla **Ajustes de Álmica** con la pestaña **Contacto** abierta y la lista de pestañas visible (Contacto, Redes sociales, Pie de página, Precios, Cursos, Legales).

#### Pestaña Contacto

- **Correo de contacto**: se muestra en el pie de página, en todas las páginas de cursos y en las dos páginas legales.
- **Teléfono**: se muestra en el pie de página como texto.
- **WhatsApp**: **actualmente no se muestra en ninguna parte del sitio.** Llenarlo no cambia nada. Pide a desarrollo si quieres enlaces de WhatsApp.
- **Ubicación**: la línea de ubicación del pie de página, por ejemplo «México · sesiones virtuales».

#### Pestaña Redes sociales

- **Instagram** y **Facebook**: la dirección completa del perfil, empezando con `https://`. Alimentan los botones IG y FB del pie de página. Si un campo está vacío, su botón sigue visible pero no lleva a ningún lado.
- **TikTok**: **actualmente no se muestra en el sitio.**

#### Pestaña Pie de página

- **Descripción**: la oración debajo del logo en el pie de página.
- **Lema**: el lema en la franja inferior del pie de página.

#### Pestaña Precios

- **Moneda**: la etiqueta de moneda después de **todos** los precios del sitio, por ejemplo «MXN».
- **Base del precio (servicios)**: la línea estándar debajo de los precios de los servicios («por sesión individual»). Cada servicio puede cambiarla.
- **Texto de precio a consultar**: se muestra en los cursos que no tienen precio.

#### Pestaña Cursos

- **Título de la tarjeta de contacto** y **Texto de la tarjeta de contacto**: el recuadro «¿Te interesa este programa?» en todas las páginas de cursos.

#### Pestaña Legales

- **Nota de contacto**: la nota al final de las dos páginas legales. El correo de contacto se agrega automáticamente después.

**Si vacías un campo de Ajustes, regresa su texto original.** No quita el elemento del sitio.

### Menús de navegación

Las listas de enlaces del encabezado y del pie de página se administran en **Apariencia → Menús**. Solo el administrador del sitio de Klaritty ve esta pantalla.

- **Menú principal**: los enlaces del encabezado (Inicio, Acerca de, Servicios, Cursos).
- **Menú de pie de página**: la columna «Navegación» del pie de página (Acerca de, Servicios, Cursos).

Los menús tienen un solo nivel, sin submenús desplegables. Las columnas **Legal** y **Contacto** del pie de página no son menús. Se generan automáticamente a partir de las páginas legales y de Ajustes de Álmica.

> 📷 **Captura necesaria:** **Apariencia → Menús** con **Menú principal** seleccionado, mostrando sus cuatro elementos y la sección **Ajustes del menú** donde se asigna el menú a su ubicación.

### Título y descripción corta del sitio

El nombre del sitio en la línea de derechos de autor del pie de página viene de **Ajustes → Generales**, que solo puede cambiar el administrador del sitio. Cámbialo únicamente como parte de un cambio de marca acordado.

## 11. Imágenes y medios

### Subir imágenes

Sube las imágenes directamente desde el campo: haz clic en el botón para agregar del campo de imagen, o en el recuadro de imagen destacada de la barra lateral. También puedes subirlas primero en **Medios** y elegirlas después.

### Tamaños recomendados

El sitio recorta las imágenes automáticamente. Subirlas al menos con estos tamaños da el resultado más nítido.

| Dónde | Forma en el sitio | Sube al menos | Mantén el motivo… |
|---|---|---|---|
| Tarjeta de servicio (imagen destacada) | Tarjeta vertical alta | 640 × 480 px, horizontal | Al **centro**. La tarjeta solo muestra la franja central |
| Tarjeta de curso (imagen destacada) | Tarjeta vertical / tarjeta horizontal pequeña | 640 × 480 px, horizontal | Al centro |
| Encabezado de servicio y de curso | Banda ancha con tono verde encima | 1600 × 900 px, horizontal | Al centro |
| Encabezados de página (Inicio, Acerca de, Servicios, Cursos) | Banda ancha | 1600 × 900 px, horizontal | Página de inicio: a la **derecha**. El lado izquierdo se oscurece detrás del texto |
| Imagen de «Introducción» en Inicio | Marco alto con forma de arco | 1600 × 900 px | Al centro. Los bordes se recortan |
| Fondo de «Cita» en Inicio | Banda ancha con tono verde encima | 1600 × 900 px | En cualquier lugar; la imagen queda atenuada |
| Retrato de profesional | Círculo | 400 × 400 px, **cuadrada** | La cara al centro, con espacio alrededor |

WordPress no revisa el tamaño de las imágenes al subirlas. Las imágenes más pequeñas se aceptan, pero pueden verse borrosas o recortarse de forma inesperada.

### Buenas prácticas

- **Comprime las fotos grandes** antes de subirlas. Las fotos que salen directo de una cámara o un celular suelen ser mucho más pesadas de lo necesario.
- **Conserva la misma forma al reemplazar una imagen.** Cambiar una foto horizontal por una vertical (o al revés) cambia lo que se recorta.
- **Usa nombres de archivo descriptivos**, como `arteterapia-sesion.jpg` en lugar de `IMG_4821.jpg`.
- **Llena el Texto alternativo** en los detalles del archivo. Describe brevemente la foto para los visitantes que usan lectores de pantalla.
- **Revisa el resultado** en el sitio, en computadora y en celular, después de cada cambio de imagen.

> 📷 **Captura necesaria:** El panel de detalles de un archivo en **Medios** para una foto de servicio, mostrando las dimensiones y el campo **Texto alternativo**.

## 12. Enlaces y botones

La mayoría de los enlaces del sitio se crean automáticamente a partir del contenido. Las tarjetas de servicio enlazan a su servicio, el enlace «Volver a servicios» regresa al catálogo y los menús enlazan a las páginas. Solo algunos campos reciben una dirección web que escribes tú:

| Campo | Dónde | Qué escribir |
|---|---|---|
| **Enlace del botón** (Encabezado de página) | Botón del encabezado de la página de inicio | Una página interna, por ejemplo `/acerca-de/`, o una dirección completa |
| **Enlace del botón** (Inicio → Introducción) | Botón de la introducción de la página de inicio | Igual que el anterior |
| **Instagram**, **Facebook** (Ajustes de Álmica) | Botones del pie de página | La dirección completa del perfil, empezando con `https://` |
| **Correo de contacto** (Ajustes de Álmica) | Pie de página, páginas de cursos, páginas legales | Solo la dirección de correo, por ejemplo `nombre@dominio.com`. El sitio la convierte en enlace |

Consejos:

- **Enlaces internos:** copia la dirección de la página en el sitio y conserva solo la parte después del dominio, por ejemplo `/servicios/arteterapia/`. Así el enlace sigue funcionando si algún día cambia el dominio.
- **Enlaces externos:** pega la dirección completa, incluyendo `https://`.
- **Prueba cada enlace** después de guardar, haciendo clic en él en el sitio publicado.
- **Los números de teléfono** se muestran como texto. No son enlaces para llamar.
- **Los enlaces de WhatsApp** todavía no son compatibles. Consulta [Qué requiere desarrollo](#3-que-requiere-desarrollo).
- Dentro de un editor de texto, selecciona las palabras y usa el botón de enlace de la barra de herramientas. No pegues direcciones sueltas en el texto.

## 13. Preguntas frecuentes

### ¿Puedo cambiar los textos por mi cuenta?

Sí. Todo lo que tiene un campo se puede cambiar en WordPress: títulos, descripciones, precios, beneficios, biografías, citas, encabezados de página, textos de la página de inicio, textos legales y los ajustes globales. Los textos que forman parte del diseño, como las etiquetas de sección, requieren desarrollo.

### ¿Puedo reemplazar una imagen?

Sí. Elige una imagen nueva en el mismo campo y guarda. Conserva la misma forma (horizontal o cuadrada) que la original y revisa la página después.

### ¿Puedo crear otro servicio, curso, profesional o testimonio?

Sí. Haz clic en **Añadir** en **Servicios**, **Cursos**, **Profesionales** o **Testimonios**. Los servicios y cursos nuevos aparecen automáticamente en las páginas Servicios y Cursos. Recuerda:

- La página de inicio muestra como máximo **6 servicios destacados** y los **primeros 3 cursos**.
- Un profesional nuevo solo aparece donde lo selecciones en un servicio o curso.

### ¿Puedo crear una página nueva?

No como página con diseño. El sitio no tiene un diseño de página de uso general, así que una página nueva se vería muy básica. Pídelo a desarrollo.

### ¿Puedo cambiar el diseño?

No. El diseño, el orden de las secciones, los colores y las tipografías son parte del diseño del sitio. Envía las solicitudes de diseño a desarrollo.

### ¿Qué hago si necesito información que no tiene campo?

No la metas en otro campo, como poner un horario en la descripción o un enlace en el título de un beneficio. Pide a desarrollo un campo adecuado, para que aparezca de forma uniforme en todos los elementos.

### ¿Debo actualizar el archivo de Excel original?

No. La hoja de cálculo solo se usó para cargar la primera versión del contenido. **Ahora la versión oficial es WordPress.** Los cambios en la hoja de cálculo no llegan al sitio. Si la hoja se volviera a importar, podría sobrescribir tus cambios en WordPress, así que avisa a desarrollo si alguien planea hacerlo.

### ¿Editar contenido puede descomponer el sitio?

La edición normal no puede romper el diseño, porque las plantillas controlan cómo se ve. Aun así, algunas acciones pueden causar problemas:

- cambiar la dirección web (slug) de una página o de un servicio
- eliminar o despublicar las páginas principales
- quitar la plantilla **Legal** de una página legal
- mandar a la papelera a un profesional, o un servicio elegido a mano en «Otros servicios», mientras sigue seleccionado en algún lugar. Sigue apareciendo en el sitio.
- desactivar todos los **Destacado en Inicio**, lo que oculta la sección de servicios de la página de inicio

Si algo se ve mal después de un cambio, deshazlo (consulta [Solución de problemas](#14-solucion-de-problemas)) y contacta a desarrollo.

### ¿Cuándo debo contactar a desarrollo?

Contacta a desarrollo cuando necesites algo de la lista de [Qué requiere desarrollo](#3-que-requiere-desarrollo), cuando una solución de [Solución de problemas](#14-solucion-de-problemas) no funcione, o cuando tengas dudas sobre si un cambio es de contenido o de estructura. Preguntar primero siempre está bien.

## 14. Solución de problemas

### Hice un cambio pero no lo veo

1. Asegúrate de haber hecho clic en **Guardar** o **Publicar** y de que el elemento no siga como borrador.
2. Asegúrate de estar buscando en el lugar correcto. Por ejemplo, el **Extracto** de un servicio no se muestra en su tarjeta, y la **Duración** de un curso solo aparece cuando tiene precio.
3. **Vacía la caché.** En la barra negra de la parte superior de la pantalla, abre **Breeze** y haz clic en **Purge All Cache**.
4. Vuelve a revisar en una **ventana privada o de incógnito**.

Por qué pasa: el sitio guarda una copia de cada página para que cargue rápido para los visitantes. Al guardar un elemento se actualiza su propia página, pero **no** las demás páginas donde aparece: la página de inicio, los listados de Servicios y Cursos o las tarjetas de «Otros servicios». Los cambios en **Ajustes de Álmica** no actualizan ninguna página. Si no vacías la caché, los visitantes pueden ver la versión anterior **hasta por 24 horas**.

Mientras tienes la sesión iniciada, siempre ves la versión más reciente. Por eso importa la ventana privada: muestra lo que ven los visitantes.

### La imagen se ve mal

- **Mal recortada:** mueve el motivo al centro de la foto, o usa una foto más parecida a la forma indicada en [Imágenes y medios](#11-imagenes-y-medios), y vuelve a subirla.
- **Borrosa:** la imagen era demasiado pequeña. Sube una versión más grande.
- **El encabezado de la página muestra una foto distinta a la de la tarjeta:** el servicio o curso tiene su propia **Imagen del encabezado**. Cambia o vacía ese campo.
- **Un retrato muestra un círculo vacío:** el profesional no tiene imagen destacada.

### Mi enlace no funciona

- Los enlaces externos deben empezar con `https://`.
- Los enlaces internos deben empezar con `/`, por ejemplo `/acerca-de/`.
- Revisa que no haya errores de escritura ni espacios, guarda y haz clic en el enlace en el sitio publicado.
- Si los botones de Instagram o Facebook no llevan a ningún lado, el campo en **Ajustes de Álmica** está vacío.

### No veo un campo para la información que necesito

- Desplázate hacia abajo. Los campos del sitio están en un panel **debajo** del área de texto principal.
- En la página de inicio, busca en el panel **Inicio**. En las demás páginas, busca en **Encabezado de página**.
- Los datos de contacto, los textos de precios y los textos del pie de página están en **Ajustes de Álmica**. Los editores no lo ven; pídeselo al administrador del sitio de Klaritty.
- Si no está en ninguno de esos lugares, el campo todavía no existe. Pídelo a desarrollo.

### No sé dónde se administra un contenido

| Lo que ves en el sitio… | Se edita en… |
|---|---|
| Nombre, precio, beneficios o foto de un servicio | **Servicios** → ese servicio |
| Foto, rol o biografía de un terapeuta | **Profesionales** → esa persona |
| El resumen de la tarjeta de un curso | **Cursos** → ese curso → **Extracto** |
| «Escríbenos para conocer el precio» | **Ajustes de Álmica → Precios** |
| El recuadro «¿Te interesa este programa?» | **Ajustes de Álmica → Cursos** |
| Correo, teléfono, ubicación y botones de redes del pie de página | **Ajustes de Álmica** |
| Enlaces de «Navegación» del pie de página, enlaces del encabezado | **Apariencia → Menús** |
| Textos de las secciones de la página de inicio | **Páginas → Inicio →** panel **Inicio** |
| La fundadora en Acerca de y su «Formación» | **Profesionales** → la fundadora (elegida en **Páginas → Acerca de**) |
| La etiqueta debajo del nombre en un testimonio | **Testimonios** → ese testimonio → **Sobre** |
| El texto «Nosotros», las etiquetas de sección, el encabezado legal | No se puede editar. Pídelo a desarrollo |

### Me equivoqué y quiero regresar a la versión anterior

- Las **páginas** (Inicio, Acerca de, páginas legales, …) guardan un historial de versiones. En la barra lateral de ajustes, abre **Revisiones**, elige una versión anterior y restáurala. Al restaurar se recuperan tanto el texto principal como los campos de la página (el encabezado y el panel Inicio) tal como estaban al guardarse. La versión más antigua de cada página viene de la carga inicial de contenido y solo tiene el texto principal, así que restaurarla deja los campos como están.
- **Los servicios, cursos, profesionales, testimonios y Ajustes de Álmica no guardan historial de versiones.** Antes de un cambio grande, copia el texto actual en un lugar seguro para poder pegarlo de nuevo si hace falta.
- Un elemento en la papelera se puede restaurar desde **Papelera**, en la parte superior de su lista.

# Base de conocimiento de YouTrack

Publicada el 2026-10-06 en la base de conocimiento de Klaritty Work (KW), visible para los miembros del proyecto KW. Cada artículo corresponde a una o dos secciones H2 de este archivo. En los artículos de una sola sección, el H2 se convierte en el título del artículo y los encabezados H3/H4 suben un nivel; los enlaces `#sección` se convierten en enlaces al artículo correspondiente.

**Este archivo es la fuente.** Cuando cambie, actualiza también el artículo correspondiente.

| Artículo | Título | Secciones de este archivo |
|---|---|---|
| KW-A-1 (principal) | **Sitio web de Álmica Healing — Administración de contenido** | Línea de introducción · 1. Acerca de esta guía · enlaces a los artículos hijos |
| KW-A-2 | **Empieza aquí: qué puedes cambiar y qué no** | 2. Qué puedes editar · 3. Qué requiere desarrollo |
| KW-A-3 | **Conceptos básicos de WordPress** | 4. Conceptos básicos de WordPress |
| KW-A-4 | **Administrar servicios** | 5. Administrar servicios |
| KW-A-5 | **Administrar cursos** | 6. Administrar cursos |
| KW-A-6 | **Administrar profesionales** | 7. Administrar profesionales |
| KW-A-7 | **Administrar testimonios** | 8. Administrar testimonios |
| KW-A-8 | **Administrar páginas (Inicio, Acerca de, listados y legales)** | 9. Administrar páginas |
| KW-A-9 | **Contenido global del sitio y menús** | 10. Contenido global del sitio |
| KW-A-10 | **Imágenes y enlaces** | 11. Imágenes y medios · 12. Enlaces y botones |
| KW-A-11 | **Preguntas frecuentes y solución de problemas** | 13. Preguntas frecuentes · 14. Solución de problemas |

Los marcadores **📷 Captura necesaria** se publicaron tal cual. Cuando tengas las capturas, reemplázalos por las imágenes en los dos lugares.
