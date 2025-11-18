Tera Software Web – Sitio corporativo modular en PHP

Este repositorio contiene la web corporativa de Tera Software, desarrollada en PHP y organizada en una arquitectura modular pensada para facilitar el mantenimiento, la escalabilidad y la reutilización de componentes. La web está compuesta por bloques independientes, un sistema ligero de internacionalización, páginas públicas, formulario de contacto y una estructura limpia para gestionar estáticos (CSS, JS e imágenes).

El objetivo del proyecto es servir como base sólida para una web de agencia tecnológica moderna, con una estructura clara y fácilmente ampliable hacia funcionalidades más avanzadas.

Estructura del proyecto
tera-software/
├── .htaccess
├── composer.json
├── composer.lock
├── README.md
│
├── config/
│   └── env.php                # Configuración del entorno
│
├── forms/
│   └── contact.php            # Lógica del formulario de contacto
│
├── i18n/                      # Archivos de traducción e internacionalización
│
├── includes/
│   ├── header.php             # Cabecera HTML y navegación
│   ├── footer.php             # Pie de página
│   ├── layout.php             # Plantilla base para páginas
│   ├── i18n.php               # Cargador de idiomas y helpers
│   └── bloques/               # Secciones reutilizables
│       ├── contacto-cta.php
│       ├── equipo.php
│       ├── faq.php
│       ├── herramientas.php
│       ├── industrias.php
│       ├── metodo.php
│       ├── nosotros-hero.php
│       ├── nosotros-historia.php
│       ├── nosotros-mision.php
│       ├── portada.php
│       ├── proyectos.php
│       ├── razones.php
│       ├── servicios.php
│       ├── tecnologias.php
│       ├── testimonios.php
│       └── valores.php
│
├── public/
│   ├── index.php              # Página principal
│   ├── contacto.php
│   ├── legal.php
│   ├── nosotros.php
│   ├── privacidad.php
│   ├── proyectos.php
│   ├── servicios.php
│   │
│   ├── forms/                 # Formularios expuestos en el frontal
│   │
│   └── assets/
│       ├── css/
│       │   └── main.css
│       ├── js/
│       │   └── main.js
│       └── img/
│           ├── brand/         # Identidad visual
│           ├── tech/          # Iconos del stack tecnológico
│           └── ui/            # Imágenes de interfaz y recursos gráficos
│
└── vendor/                    # Dependencias instaladas con Composer

Filosofía del proyecto
  El sitio está construido sin frameworks pesados, únicamente con PHP y una estructura clara. La idea es mantener:
  Separación estricta entre vista, bloques y configuración.
  Bloques PHP reutilizables para construir páginas sin duplicar código.
  Un sistema sencillo de traducciones para futuras versiones multilingüe.
  Organización de assets por categorías (marca, tecnología, interfaz).
  Código ordenado para permitir una evolución futura del proyecto: blog, panel interno, API, etc.

Tecnologías utilizadas: 
  PHP (arquitectura modular sin framework)
  Composer para la gestión de dependencias
  HTML y CSS (archivo principal main.css)
  JavaScript sin dependencias (main.js)
  Servidor Apache o Nginx (archivo .htaccess incluido)
  Sistema básico de internacionalización propio
  Estructura MVC ligera sin controladores pesados

- Funcionamiento general
Bloques
  Cada sección del sitio (servicios, equipo, razones, proyectos, etc.) está separada en includes/bloques/.
  Las páginas públicas únicamente llaman a los bloques necesarios, manteniendo el código limpio y evitando duplicación.

Layout
  Todas las páginas pasan por layout.php, que carga el header, el contenido y el footer.

Internacionalización
  i18n.php se encarga de cargar un archivo de traducciones según la configuración del entorno.
  Está pensado para ampliar fácilmente a varios idiomas.

Formularios
  El formulario principal (contacto) está ubicado en forms/contact.php y separado de la capa de presentación.

Estáticos
  Los recursos se encuentran en public/assets/:
  css/main.css: estilos globales
  js/main.js: scripts para interactividad básica
  img/: imágenes organizadas por categorías:
  brand
  tech (iconos de tecnologías para mostrar el stack)
  ui (mapas, fotos internas, etc.)

Posibles mejoras a futuro
  Sistema de routing más avanzado sin depender de .htaccess
  Panel de administración ligero
  Blog corporativo con panel interno
  Integración con CMS si se desea
  Optimización de imágenes y carga diferida
  Implementación real del sistema multidioma (FR/EN/ES)

Licencia
  Puedes definirla según necesites (MIT, Apache 2.0, etc.). Si no se especifica, se puede añadir más adelante.
