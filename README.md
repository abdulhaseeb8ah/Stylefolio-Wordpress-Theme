# StyleFolio WordPress Theme

A modern, responsive WordPress portfolio theme designed for showcasing creative work and professional profiles.

## Features

- Modern, clean design
- Fully responsive layout
- Fast loading and performance optimized
- Advanced Custom Fields (ACF) integration
- Custom post types for portfolio management
- Skills and testimonials sections
- Built-in contact form
- Portfolio gallery with lightbox
- Education and experience sections
- Hero section with dynamic content

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Advanced Custom Fields (ACF) plugin

## Installation

1. Download or clone this repository.
2. Upload the theme to your WordPress `/wp-content/themes/` directory.
3. Install and activate the Advanced Custom Fields (ACF) plugin.
4. Activate the StyleFolio theme from your WordPress admin dashboard.
5. Configure the theme settings and add your content.

## Theme Structure

```text
stylefolio/
├── assets/                 # Static assets
│   ├── css/                # Stylesheets
│   ├── js/                 # JavaScript files
│   ├── images/             # Theme images
│   └── fonts/              # Custom fonts
├── inc/                    # PHP includes
│   ├── acf/                # ACF field configurations
│   ├── admin/              # Admin customizations
│   ├── core/               # Core functionality
│   ├── cpt/                # Custom post types
│   ├── data/               # Data handlers
│   │   ├── data-loader.php
│   │   ├── data-projects.php
│   │   └── data-skills.php
│   └── tgmpa/
│       └── class-tgm-plugin-activation.php
├── template-parts/         # Template partials
├── style.css               # Main stylesheet
├── functions.php           # Theme functions
├── index.php               # Main template
└── README.md               # Documentation
