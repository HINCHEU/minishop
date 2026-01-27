# Mini Shop - E-Commerce Application

A full-stack e-commerce application built with Laravel (backend) and Vue 3 (frontend).

## Features

- **Public Site**: Browse products, add to cart, checkout, and place orders
- **Admin Panel**: Manage products (create, edit, delete)
- **Order Management**: View orders with customer details
- **Responsive Design**: Works on desktop and mobile devices

## Project Structure

```
mini-shop/
├── minishop/          # Laravel backend (API)
└── minishop-ui/       # Vue 3 frontend
```

## Prerequisites

Before running this project, ensure you have installed:

- **PHP 8.0+** - [Download](https://www.php.net/)
- **Composer** - [Download](https://getcomposer.org/)
- **Node.js & npm** - [Download](https://nodejs.org/)
- **MySQL 5.7+** - [Download](https://www.mysql.com/)
- **Git** - [Download](https://git-scm.com/)

## Setup Instructions

### Step 1: Clone the Repository

```bash
git clone <repository-url>
cd mini-shop
```

### Step 2: Backend Setup (Laravel)

#### 2.1 Install PHP Dependencies

```bash
cd minishop
composer install
```

#### 2.2 Create Environment File

Copy the example environment file:
```bash
copy .env.example .env
```

#### 2.3 Generate Application Key

```bash
php artisan key:generate
```

#### 2.4 Configure Database

Edit the `.env` file and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_shop
DB_USERNAME=root
DB_PASSWORD=
```

#### 2.5 Create Database

```bash
mysql -u root -p
CREATE DATABASE mini_shop;
EXIT;
```

#### 2.6 Run Migrations

```bash
php artisan migrate
```

#### 2.7 Seed Sample Data (Optional)

```bash
php artisan db:seed
```

#### 2.8 Start Laravel Server

```bash
php artisan serve
```

The backend will run on: **http://localhost:8000**

---

### Step 3: Frontend Setup (Vue 3)

#### 3.1 Install Node Dependencies

Open a **new terminal** and navigate to the frontend folder:

```bash
cd minishop-ui
npm install
```

#### 3.2 Start Development Server

```bash
npm run dev
```

The frontend will run on: **http://localhost:5173**

---

## Running the Project

### Terminal 1: Backend (Laravel)

```bash
cd minishop
php artisan serve
```

Expected output:
```
INFO  Server running on [http://127.0.0.1:8000].
```

### Terminal 2: Frontend (Vue 3)

```bash
cd minishop-ui
npm run dev
```

Expected output:
```
  VITE v... ready in ... ms

  ➜  Local:   http://localhost:5173/
  ➜  press h to show help
```

### Access the Application

- **Public Site**: Open http://localhost:5173 in your browser
- **Admin Panel**: Click "Admin" button → Login with:
  - Username: `admin`
  - Password: `123`

---

## API Endpoints

### Public Endpoints

```
GET    /api/products              - Get all active products
GET    /api/products/{id}         - Get product by ID
POST   /api/orders                - Create new order
```

### Admin Endpoints

```
GET    /api/admin/products        - Get all products (including inactive)
POST   /api/admin/products        - Create new product
PUT    /api/admin/products/{id}   - Update product
DELETE /api/admin/products/{id}   - Delete product
```

---

## Database Schema

### Products Table

```sql
CREATE TABLE products (
  product_id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10, 2) NOT NULL,
  stock INT NOT NULL,
  image_url VARCHAR(255),
  status ENUM('ACTIVE', 'INACTIVE'),
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Orders Table

```sql
CREATE TABLE orders (
  order_id INT PRIMARY KEY AUTO_INCREMENT,
  customer_name VARCHAR(255) NOT NULL,
  customer_email VARCHAR(255) NOT NULL,
  customer_phone VARCHAR(20),
  shipping_address TEXT,
  total_amount DECIMAL(10, 2) NOT NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Order Items Table

```sql
CREATE TABLE order_items (
  order_item_id INT PRIMARY KEY AUTO_INCREMENT,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  unit_price DECIMAL(10, 2),
  subtotal DECIMAL(10, 2),
  created_at TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES orders(order_id),
  FOREIGN KEY (product_id) REFERENCES products(product_id)
);
```

---

## Troubleshooting

### Port Already in Use

If port 8000 or 5173 is already in use:

**For Laravel:**
```bash
php artisan serve --port=8001
```

**For Vue:**
```bash
npm run dev -- --port 5174
```

Then update the API URL in `minishop-ui/src/services/api.js`

### Database Connection Error

- Verify MySQL is running
- Check `.env` file database credentials
- Ensure database exists: `CREATE DATABASE mini_shop;`

### npm modules not found

```bash
cd minishop-ui
rm -rf node_modules
npm install
```

### Laravel dependencies issue

```bash
cd minishop
composer update
```

---

## Project Features

### User Features
- ✅ Browse products with categories
- ✅ Add products to shopping cart
- ✅ View cart summary
- ✅ Checkout with customer details
- ✅ Order confirmation with order ID and total

### Admin Features
- ✅ Create new products
- ✅ Edit existing products
- ✅ Delete products
- ✅ View all products (active & inactive)
- ✅ Set product status (ACTIVE/INACTIVE)

---

## Technologies Used

- **Backend**: Laravel 11, MySQL
- **Frontend**: Vue 3, Vite, Bootstrap 5\, Axios
- **Tools**: Composer, npm

---
