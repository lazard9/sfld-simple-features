# Plugin Name: SFLD Simple Features

This plugin is designed for testing and learning purposes, combining various tutorials and courses.

## Table of Contents

- [Description](#description)
- [Project Structure](#project-structure)
- [Autoloading](#autoloading)
- [Functionalities](#functionalities)
- [Installation](#installation)
- [Usage](#usage)
- [Credits](#credits)
- [License](#license)

## Description

A modular WordPress plugin built using Object-Oriented Programming (OOP) principles.  
It integrates modern development practices including custom post types, taxonomies, Ajax, shortcode rendering, and GDPR compliance.

🔧 PHP | 🎨 SCSS | 🧩 Modular | 🧠 Educational

## Project Structure

- 📁 lib/ – Autoloader implementation
- 📁 includes/ – Main logic and class files
  - 📁 abstract/ – Abstract singleton class
  - 📁 admin/ – Admin pages and settings
  - 📁 frontend/ – Frontend logic and assets
  - 📁 cpt/ – Custom Post Types and meta fields
  - 📁 taxonomies/ – Custom taxonomies logic
  - 📁 ajax/ – Ajax endpoints
  - 📁 shortcodes/ – Register shortcodes
  - 📁 templates/ – Template overrides
  - 📁 gdpr/ – GDPR compliance features
- 📄 sfld-simple-features.php – Main plugin file

## Autoloading

The plugin uses a PSR-like autoloader located in the `lib/autoloader.php` file.  
Classes are organized by namespace under the `SFLD\Includes\` base namespace and its subfolders.

## Functionalities

### Includes

- Admin scripts and styles  
- Frontend scripts and styles  
- Swiper.js plugin scripts  

### Admin Pages

- Main settings page registered via `add_menu_page` under **SFLD**
- Subpages:
  - **Form Fields Page** – Showcases various WordPress field types (`text`, `textarea`, `checkbox`, `radio`, `select`)
  - **Description Page** – Displays plugin meta info stored in options (`sfld_simple_options`)
  - **Courses Subpage** – Appears under CPT `courses` menu
  - **Tools > SFLD Info** – Info/debug page accessible via `add_management_page`

### Settings Management

- Uses **Settings API** to register and render form fields
- Two distinct option groups: `sfld_main_settings`, `sfld_simple_settings`
- Includes safety checkboxes for:
  - Deleting CPT and taxonomy data
  - Deleting plugin-related options
  - Deleting plugin custom database table

### Load Course Template

- Displays single course content with **Swiper.js** carousel

### Load Archive Courses Template

- Features **AJAX-based Load More** button

### Custom Post Types:

- `Courses`  
- `Professors`  

### Custom Taxonomies for Courses

- `Level` taxonomy includes 4 terms and a custom **radio metabox**
- `Level`, `Subject`, and `Topics` taxonomies support autosave behavior with fallback `Any`

### Custom Taxonomies for Professors

- Automatically populated taxonomy

### Shortcodes

- Registers shortcode to display **Swiper.js** slider within Course templates

### Metaboxes and Custom Fields

- Assign Editor to post via select field
- Save Course Details into a **custom database table** (not just post meta)

### WooCommerce GDPR Compliance

- Adds GDPR checkbox to WooCommerce **Comments/Reviews** section

---

### Plugin Options

- Plugin stores user-defined options using the WordPress Options API.
- Option names include:
  - `sfld_main_settings`
  - `sfld_simple_settings`
  - `sfld_simple_options`

## Installation

1. Download the plugin zip file.
2. In your WordPress admin panel, navigate to Plugins -> Add New.
3. Click on the "Upload Plugin" button and select the downloaded zip file.
4. Activate the plugin.

## Usage

- Navigate to **Tools > Courses** to manage CPT content.
- Navigate to **SFLD** in the admin menu to configure plugin settings and view custom admin pages.
- Use the shortcode `[swiper_slider_01]` to embed the Swiper carousel inside course templates.
- Use `[ajax_load_more]` to enable Ajax-based pagination on archive pages.
- Customize plugin behavior in the **Settings** and **Form** subpages under **SFLD**.
- Use **Tools > SFLD Info** for plugin metadata and debugging purposes.

## Credits

This plugin was built as a modular and scalable learning tool.  
It follows OOP patterns and separates concerns into reusable components.  
All hooks and logic are abstracted through a central loader class for better maintainability.
Developed by [lazard9](https://github.com/lazard9).

## License

This project is licensed under the GNU General Public License v2.0 or later.
