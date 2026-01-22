# Laravel Form Generator & PDF Export System

## 📋 Project Overview

A professional **Laravel-based form management system** designed to generate dynamic PDF documents from user-submitted data. The application provides a web interface for data entry and generates formatted PDF documents based on predefined templates with precise positioning and styling.

### Key Features

- **Dynamic Form Generation**: Customizable input forms with validation
- **PDF Export**: High-quality PDF generation using DomPDF
- **Template-based Layout**: Precise positioning system using CSS absolute positioning
- **Database Management**: MySQL/MariaDB integration with Eloquent ORM
- **Material Management**: Track materials, batches, and purchase orders
- **Responsive Design**: Modern CSS styling for both web and PDF outputs

---

## 🏗️ Architecture

This project follows the **MVC (Model-View-Controller) pattern** using the Laravel framework:

### Architectural Components

<img width="1024" height="1024" alt="image" src="https://github.com/user-attachments/assets/56f41b11-3e3e-4b7c-a9b5-aba4501d873b" />


### Design Patterns

- **MVC Pattern**: Separation of concerns between data, presentation, and logic
- **Repository Pattern**: Eloquent ORM models for data abstraction
- **Service Container**: Laravel's dependency injection for loose coupling
- **Blade Templates**: Server-side rendering with reusable components

---

## 🛠️ Technology Stack

### Backend

- **PHP**: ^8.2
- **Laravel Framework**: ^12.0
- **Database**: MySQL/MariaDB
- **ORM**: Eloquent

### Frontend

- **Template Engine**: Blade
- **CSS**: Vanilla CSS3 (with custom positioning system)
- **JavaScript**: Vanilla JS with Vite bundling

### Key Dependencies

#### Production

```json
{
    "barryvdh/laravel-dompdf": "^3.1", // PDF generation
    "league/csv": "^9.28", // CSV handling
    "maatwebsite/excel": "^3.1", // Excel import/export
    "laravel/tinker": "^2.10.1" // REPL for debugging
}
```

#### Development

```json
{
    "vite": "^7.0.7", // Modern build tool
    "tailwindcss": "^4.0.0", // Utility-first CSS framework
    "laravel-vite-plugin": "^2.0.0", // Laravel-Vite integration
    "concurrently": "^9.0.1", // Run multiple dev processes
    "phpunit": "^11.5.3" // Testing framework
}
```

### Build Tools

- **Vite**: Fast build tool and dev server
- **Composer**: PHP dependency management
- **NPM**: Node package management

---

## 📦 Installation Guide

### Prerequisites

- **PHP**: >= 8.2
- **Composer**: Latest version
- **Node.js**: >= 18.x
- **MySQL/MariaDB**: >= 8.0
- **Web Server**: Apache/Nginx (Laragon recommended for Windows)

### Step-by-Step Setup

#### 1. Clone the Repository

```bash
git clone <repository-url>
cd project
```

#### 2. Install PHP Dependencies

```bash
composer install
```

#### 3. Install Node Dependencies

```bash
npm install
```

#### 4. Environment Configuration

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 5. Database Configuration

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### 6. Run Database Migrations

```bash
php artisan migrate
```

#### 7. Create Storage Links

```bash
php artisan storage:link
```

#### 8. Build Assets

```bash
# For development
npm run dev

# For production
npm run build
```

#### 9. Start Development Servers

**Option A: Using Composer Scripts (Recommended)**

```bash
composer dev
```

This runs all services concurrently:

- Laravel development server (`php artisan serve`)
- Queue worker (`php artisan queue:listen`)
- Logs viewer (`php artisan pail`)
- Vite dev server (`npm run dev`)

**Option B: Manual Start**

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server
npm run dev
```

#### 10. Access the Application

```
http://localhost:8000
```

---

## 📁 Project Structure

```
project/
├── app/
│   ├── Console/              # Artisan commands
│   ├── Http/
│   │   ├── Controllers/      # Request handlers
│   │   │   ├── PdfController.php          # PDF generation logic
│   │   │   ├── PlantillaController.php    # Template form display
│   │   │   └── ProductoController.php     # Product CRUD operations
│   │   └── Middleware/       # HTTP middleware
│   ├── Imports/              # Data import classes (Excel/CSV)
│   ├── Models/               # Eloquent ORM models
│   │   ├── Batch.php         # Batch inventory model
│   │   ├── Registro.php      # Material registration model
│   │   └── User.php          # User authentication model
│   └── Providers/            # Service providers
│
├── bootstrap/                # Framework bootstrap files
│
├── config/                   # Configuration files
│   ├── app.php              # Application settings
│   ├── database.php         # Database connections
│   └── ...
│
├── database/
│   ├── migrations/          # Database schema versions
│   │   ├── create_registros_table.php    # Materials table
│   │   └── create_batches_table.php      # Batches table
│   ├── seeders/             # Database seeders
│   └── factories/           # Model factories for testing
│
├── public/
│   ├── css/                 # Compiled & custom CSS
│   │   ├── plantilla.css    # Web form styles
│   │   └── pdf.css          # PDF-specific styles
│   ├── images/              # Static images
│   │   └── plantilla.png    # PDF background template
│   └── index.php            # Application entry point
│
├── resources/
│   ├── css/                 # Source CSS files
│   ├── js/                  # Source JavaScript files
│   └── views/               # Blade templates
│       ├── productos/       # Product-related views
│       │   ├── plantilla.blade.php  # Main form template
│       │   ├── index.blade.php      # Products list
│       │   └── create.blade.php     # Product creation form
│       ├── main.blade.php   # Master layout
│       └── welcome.blade.php # Landing page
│
├── routes/
│   ├── web.php              # Web application routes
│   └── api.php              # API routes (if applicable)
│
├── storage/
│   ├── app/                 # Application storage
│   ├── framework/           # Framework generated files
│   └── logs/                # Application logs
│
├── tests/                   # Automated tests
│   ├── Feature/             # Feature tests
│   └── Unit/                # Unit tests
│
├── vendor/                  # Composer dependencies (gitignored)
├── node_modules/            # NPM dependencies (gitignored)
│
├── .env.example             # Environment template
├── .gitignore               # Git ignore rules
├── artisan                  # CLI tool
├── composer.json            # PHP dependencies
├── package.json             # Node dependencies
├── phpunit.xml              # PHPUnit configuration
├── vite.config.js           # Vite build configuration
└── README.md                # This file
```

### Key Directory Explanations

#### `/app/Http/Controllers`

Contains the application's request handling logic:

- **PdfController**: Handles PDF generation from form data
- **PlantillaController**: Renders the template form
- **ProductoController**: Manages product CRUD operations

#### `/app/Models`

Eloquent ORM models representing database tables:

- **Registro**: Manages material records (one-to-many with Batch)
- **Batch**: Tracks batch numbers and quantities per material

#### `/resources/views`

Blade template files for rendering HTML:

- Uses dual-mode rendering (web vs PDF) based on `$modo` variable
- Template positioning via absolute CSS positioning system

#### `/public/css`

- **plantilla.css**: Styles for web form with input fields
- **pdf.css**: Optimized styles for PDF output (legal size, 216mm x 356mm)

---

## 🚀 Usage

### Generating a PDF Form

1. Navigate to the home page (`/`)
2. Fill in the form fields:
    - Purchase Order
    - Material Number
    - EAN
    - Material Description
    - Batch
    - Quantity
3. Click **"Descargar PDF"** to generate and download the PDF

### PDF Template Customization

The system uses a background template image (`plantilla.png`) with absolute-positioned text overlays. To customize:

1. Design your form template as a PNG image (216mm x 356mm @ 72 DPI)
2. Replace `public/images/plantilla.png`
3. Adjust CSS positioning in `public/css/plantilla.css` and `public/css/pdf.css`

Example positioning:

```css
.Purchase_Order {
    position: absolute;
    top: 51mm; /* Vertical position */
    left: 60mm; /* Horizontal position */
    width: 40mm; /* Field width */
}
```

---

## 🔧 Configuration

### Database Models

#### Registro Model

Represents material registrations with the following attributes:

- `material`: Material identifier
- `material_document`: Document reference
- `material_description`: Material description
- **Relationship**: `hasMany(Batch::class)`

#### Batch Model

Tracks batches for materials:

- `batch`: Batch identifier
- `quantity`: Quantity in batch
- `registro_id`: Foreign key to Registro
- **Relationship**: `belongsTo(Registro::class)`

### Routes

```php
// Display form
GET / -> PlantillaController@plantilla

// Generate PDF
POST /pdf -> PdfController@descargarPdf

// Product management
GET /productos -> ProductoController@mostrar
GET /producto/crear -> ProductoController@create
POST /productos -> ProductoController@store
```

---

## 🧪 Testing

```bash
# Run all tests
composer test

# Or directly with PHPUnit
php artisan test

# Run specific test file
php artisan test tests/Feature/PdfGenerationTest.php
```

---

## 📚 Development Workflow

### Available Composer Scripts

```bash
# Complete project setup
composer setup

# Run development environment (all services)
composer dev

# Run tests
composer test
```

### Development Best Practices

1. **Code Style**: Follow PSR-12 coding standards

    ```bash
    ./vendor/bin/pint  # Laravel Pint for code formatting
    ```

2. **Database Changes**: Always create migrations

    ```bash
    php artisan make:migration create_table_name
    ```

3. **New Models**: Use Artisan generators

    ```bash
    php artisan make:model ModelName -mcr
    # -m: migration, -c: controller, -r: resource controller
    ```

4. **Asset Changes**: Vite will hot-reload automatically in dev mode

---

## 🔒 Security Considerations

- **CSRF Protection**: All POST routes are protected with `@csrf` token
- **SQL Injection**: Eloquent ORM uses parameterized queries
- **XSS Protection**: Blade escapes output by default (`{{ }}`)
- **Environment Variables**: Sensitive data stored in `.env` (gitignored)

---

## 🐛 Troubleshooting

### Common Issues

#### PDF Generation Fails

```bash
# Clear cache
php artisan config:clear
php artisan cache:clear

# Check DomPDF installation
composer show barryvdh/laravel-dompdf
```

#### Database Connection Error

```bash
# Verify credentials in .env
# Test connection
php artisan tinker
>>> DB::connection()->getPdo();
```

#### Assets Not Loading

```bash
# Rebuild assets
npm run build

# Check Vite server is running
npm run dev
```

#### Permission Issues (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👥 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📞 Support

For issues and questions:

- Create an issue in the repository
- Check existing documentation
- Review Laravel documentation: https://laravel.com/docs

---

**Built with Laravel 12 & PHP 8.2+**
