
# StyleFolio WordPress Theme

A modern, responsive WordPress portfolio theme designed for showcasing creative work and professional portfolios.

## Features

- 🎨 Modern and clean design
- 📱 Fully responsive layout
- ⚡ Fast loading and optimized
- � Advanced Custom Fields (ACF) integration
- � Custom post types for portfolio management
- 🎯 Skills and testimonials sections
- � Built-in contact form
- �️ Portfolio gallery with lightbox
- 📚 Education and experience sections
- 🎪 Hero section with dynamic content

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Advanced Custom Fields (ACF) plugin

## Installation

1. Download or clone this repository
2. Upload the theme to your WordPress `/wp-content/themes/` directory
3. Install and activate the Advanced Custom Fields plugin
4. Activate the StyleFolio theme from your WordPress admin dashboard
5. Configure the theme settings and add your content

## Theme Structure
│  │  ├─ 📄data-loader.php
│  │  ├─ 📄data-projects.php
│  │  └─ 📄data-skills.php
│  ├─ 📁tgmpa
│  │  └─ 📄class-tgm-plugin-activation.php
│  ├─ 📄acf-fields.php
```
📁 stylefolio/
├── � assets/                 # Static assets
│   ├── � css/               # Stylesheets
│   ├── � js/                # JavaScript files
│   ├── 📁 images/            # Theme images
│   └── � fonts/             # Custom fonts
├── � inc/                   # PHP includes
│   ├── � acf/               # ACF field configurations
│   ├── � admin/             # Admin customizations
│   ├── � core/              # Core functionality
│   ├── � cpt/               # Custom post types
│   └── � data/              # Data handlers
├── 📁 template-parts/        # Template partials
├── 📄 style.css              # Main stylesheet
├── 📄 functions.php          # Theme functions
├── 📄 index.php              # Main template
└── 📄 README.md              # Documentation
```

## Custom Post Types

- **Portfolio**: Showcase your projects and work
- **Skills**: Display your technical and professional skills
- **Education**: Academic background and certifications
- **Experience**: Professional work history
- **Testimonials**: Client and colleague feedback
- **Contact**: Contact form submissions management

## Getting Started

1. **Configure ACF Fields**: The theme uses Advanced Custom Fields for content management
2. **Add Portfolio Items**: Create portfolio entries through the WordPress admin
3. **Set Up Skills**: Add your skills with proficiency levels
4. **Configure Hero Section**: Set up your main banner content
5. **Customize Appearance**: Use the WordPress Customizer for theme options

## Development

### Prerequisites
- WordPress development environment
- Node.js (for asset compilation)
- PHP 7.4+

### File Structure
- `assets/` - All static assets (CSS, JS, images)
- `inc/` - PHP includes and functionality
- `template-parts/` - Reusable template components

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

This theme is licensed under the GPL v2 or later.

## Support

For support and questions, please create an issue in the GitHub repository.

## Changelog

### Version 1.0.0
- Initial release
- Portfolio management system
- Skills and testimonials sections
- Responsive design
- ACF integration