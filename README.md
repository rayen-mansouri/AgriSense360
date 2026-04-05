# AgriSense 360

AgriSense 360 is a modern farm management web experience designed to help teams track animals, equipment, stock, culture, users, and workers from one place.

## Overview

This project presents a clean, responsive interface for agricultural operations with a strong focus on clarity, speed, and smooth interaction.

## Highlights

- Elegant sidebar navigation with smooth transitions
- Dashboard-style home experience with ambient visuals
- Management sections for animals, equipment, stock, culture, users, and workers
- Twig-based Symfony templates
- Responsive layout for desktop and mobile

## Tech Stack

- Backend Framework: Symfony (PHP)
- Template Engine: Twig
- Language: PHP 8+
- Frontend: HTML5, CSS3, vanilla JavaScript
- Dependency Management: Composer
- Dev Server: PHP built-in server / Symfony local server workflow
- Data Layer: Doctrine-style project structure (Entity/Repository pattern)

## Technology Details

- Symfony handles routing, controller flow, and dependency injection.
- Twig renders server-side views with reusable templates and partials.
- CSS is organized by page/feature under the public assets folder.
- Controllers map management pages to route names used directly in Twig navigation.
- Entities and repositories define domain models and database-access responsibilities.

## Getting Started

1. Install dependencies:
	 `composer install`
2. If your app dependencies are inside `app/`, install there too:
	 `cd app && composer install`
3. Run the project from the workspace root with the document root pointing to `app/public`:
	 `php -S 127.0.0.1:8000 -t app/public`
4. Open:
	 `http://127.0.0.1:8000`

## Project Structure

- `app/`
	Main Symfony application directory.
- `app/src/Controller/`
	HTTP controllers for pages and management sections.
- `app/src/Entity/`
	Domain entities such as equipment and maintenance models.
- `app/src/Repository/`
	Query/data-access classes tied to entities.
- `app/src/Form/`
	Form definitions and validation bindings.
- `app/config/`
	Framework, routing, services, and package configuration.
- `app/templates/`
	Twig view layer.
	- `home/` for landing dashboard pages
	- `management/` for management modules
	- `equipment/` for equipment CRUD pages
- `app/public/`
	Web root.
	- `index.php` front controller
	- `assets/styles/` CSS files by feature/page
	- `assets/images/` static images and brand assets
- `app/migrations/`
	Database migration files.

## Navigation Map

Primary sidebar navigation is organized by management modules:

- Animals Management
- Equipments Management
- Stock Management
- Culture Management
- User Management
- Workers Management

These links are rendered in the home template and connected to Symfony route names, including:

- `management_animals`
- `management_equipments`
- `management_stock`
- `management_culture`
- `management_users`
- `management_workers`

## UI and Interaction Notes

- Sidebar supports collapsed/expanded interaction states.
- Hover and button interactions are tuned with smooth easing curves.
- Home dashboard uses visual cards, metrics, and ambient decorative elements.
- Layout adapts for desktop, tablet, and mobile breakpoints.

## Architecture Summary

- Routing layer: Symfony routes to controller actions.
- Controller layer: builds page view models and coordinates services.
- Domain layer: entities represent business data.
- Data access layer: repositories encapsulate persistence logic.
- Presentation layer: Twig templates + CSS assets.

## Notes

The interface is currently tuned for a polished local demo experience and can be extended with database-driven features, authentication, and reporting.
