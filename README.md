# Analytics Dashboard

A simple analytics dashboard built with Laravel, Blade templates, and Chart.js. This project demonstrates backend API development, MySQL data analysis, and data visualization.

## Features

- **Summary Statistics**: Total users, orders, revenue, and average order value
- **Sales Trend Chart**: Line chart showing daily revenue for the past 30 days
- **Top Products Chart**: Bar chart displaying the top 5 products by revenue
- **Clean Architecture**: Proper use of Models, Controllers, and Eloquent relationships
- **Performance Optimized**: Caching, eager loading, and N+1 query prevention

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL 5.7 or higher

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/Mkamil62/algogenius-assessment.git
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the example environment file and configure your database:

```bash
cp .env.example .env
```

Update the following database configuration in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=algogenius_assessment
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Create Database

Create a MySQL database named `algogenius_assessment`:

```sql
CREATE DATABASE algogenius_assessment;
```

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Seed the Database

Generate sample data for testing:

```bash
php artisan db:seed
```

This will create:
- 50 users
- 30 products
- Multiple orders with order items (each user gets 1-5 orders)

### 8. Start the Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Usage

### View the Dashboard

Navigate to:
```
http://localhost:8000/dashboard
```

The dashboard displays:
- Summary cards with key metrics
- Interactive line chart for sales trends
- Bar chart for top-selling products

### API Endpoints

The following JSON API endpoints are available:

#### Get Summary Statistics
```
GET /api/analytics/summary
```

Response:
```json
{
  "total_users": 50,
  "total_orders": 150,
  "total_revenue": 45678.90,
  "average_order_value": 304.53
}
```

#### Get Sales Trend (Last 30 Days)
```
GET /api/analytics/sales-trend
```

Response:
```json
{
  "labels": ["2025-09-27", "2025-09-28", "2025-09-29", ...],
  "values": [250.50, 400.75, 310.25, ...]
}
```

#### Get Top 5 Products
```
GET /api/analytics/top-products
```

Response:
```json
{
  "labels": ["Product A", "Product B", "Product C", ...],
  "values": [5432.10, 4321.50, 3210.75, ...]
}
```

## Project Structure

### Database Schema

**users**
- id
- name
- email
- created_at

**products**
- id
- name
- category
- price
- created_at

**orders**
- id
- user_id (foreign key)
- total_amount
- created_at

**order_items**
- id
- order_id (foreign key)
- product_id (foreign key)
- quantity
- price

### Key Files

- **Migrations**: `database/migrations/`
- **Models**: `app/Models/`
- **Factories**: `database/factories/`
- **Seeder**: `database/seeders/DatabaseSeeder.php`
- **Controller**: `app/Http/Controllers/AnalyticsController.php`
- **Routes**: `routes/web.php` and `routes/api.php`
- **View**: `resources/views/dashboard.blade.php`

## Best Practices Implemented

### 1. Eloquent Relationships
All models have proper relationships defined:
- User → hasMany Orders
- Order → belongsTo User, hasMany OrderItems
- Product → hasMany OrderItems
- OrderItem → belongsTo Order, Product

### 2. Caching
API responses are cached to improve performance:
- Summary data: 5 minutes
- Sales trend: 10 minutes
- Top products: 10 minutes

### 3. N+1 Query Prevention
Uses eager loading to avoid N+1 queries:
```php
->with('product:id,name')
```

### 4. Clean Code
- Proper comments explaining logic
- Consistent formatting
- Clear variable names
- Separation of concerns

### 5. Database Optimization
- Uses raw SQL aggregations for performance
- Proper indexing through foreign keys
- Efficient grouping and ordering

## Testing the Application

### Clear Cache

If you make changes to the data and want to see updated results immediately:

```bash
php artisan cache:clear
```

### Re-seed the Database

To regenerate sample data:

```bash
php artisan migrate:fresh --seed
```

**Warning**: This will delete all existing data!

## Customization

### Adjust Sample Data Volume

Edit `database/seeders/DatabaseSeeder.php` to change the number of records:

```php
$users = User::factory(100)->create(); // Change from 50 to 100
$products = Product::factory(50)->create(); // Change from 30 to 50
```

### Modify Date Range

To change the sales trend date range, edit `AnalyticsController.php`:

```php
->where('created_at', '>=', now()->subDays(60)) // Change from 30 to 60 days
```

### Add More Charts

You can extend the dashboard by:
1. Adding new methods to `AnalyticsController`
2. Creating new API routes in `routes/api.php`
3. Adding canvas elements and Chart.js code to `dashboard.blade.php`

## Troubleshooting

### Database Connection Error

Make sure MySQL is running and credentials in `.env` are correct.

### Cache Issues

Clear all caches:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Charts Not Displaying

- Check browser console for JavaScript errors
- Ensure Chart.js CDN is accessible
- Verify API endpoints are returning data

## License

This project is open-source and available under the MIT License.

## Support

For issues or questions, please check the Laravel documentation at https://laravel.com/docs