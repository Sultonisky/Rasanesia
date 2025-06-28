# CSS File Organization

## Overview
CSS files have been organized into separate modules for better maintainability and code organization.

## File Structure

### `main-home.css`
- **Purpose**: Main styles for the frontend application
- **Contains**: 
  - Global styles (body, container)
  - Main content layout
  - Search bar styles
  - Carousel styles
  - Card grid layouts
  - Form styles
  - Alert styles
  - Pagination styles
  - Responsive design for main content

### `sidebar.css`
- **Purpose**: Dedicated styles for the frontend sidebar navigation
- **Contains**:
  - Sidebar container styles
  - Navigation item styles
  - Dropdown menu styles
  - Toggle button styles
  - Responsive sidebar behavior
  - Mobile navigation adaptations

### `saved.css`
- **Purpose**: Styles for saved/favorites page
- **Contains**: Specific styles for saved recipes page

### `created.css`
- **Purpose**: Styles for user-created recipes page
- **Contains**: Specific styles for user's created recipes page

## Usage

### Frontend Layout
The main frontend layout (`resources/views/frontend/layouts/app.blade.php`) includes:
```html
<link rel="stylesheet" href="{{ asset('assets/css/main-home.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/saved.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/created.css') }}">
```

### Backend Layout
The backend uses a separate admin template with its own CSS files located in `public/admin_assets/`.

## Benefits of Separation

1. **Modularity**: Each file has a specific responsibility
2. **Maintainability**: Easier to find and modify specific styles
3. **Performance**: Can load only necessary CSS files per page
4. **Team Development**: Multiple developers can work on different CSS files simultaneously
5. **Debugging**: Easier to identify and fix styling issues

## Color Scheme

The application uses a consistent green color scheme:
- Primary: `#a3b48b`
- Secondary: `#c7d3b0`
- Background: `#f6fff8`
- Text: `#2e3a32`

## Responsive Design

All CSS files include responsive design considerations:
- Mobile-first approach
- Breakpoints at 600px, 768px, and 900px
- Flexible layouts that adapt to different screen sizes 