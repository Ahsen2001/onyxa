# ONYXA Private Limited Database Design

This document defines the MySQL database structure for the ONYXA Private Limited coconut shell handicraft website. The schema supports Laravel authentication, product catalog management, company news, events, galleries, contact messages, editable pages, and global website settings.

## 1. `users`

Stores authenticated admin users.

| Column | Data Type | Null | Key | Purpose |
| --- | --- | --- | --- | --- |
| `id` | BIGINT UNSIGNED AUTO_INCREMENT | Required | Primary Key | Unique user ID. |
| `name` | VARCHAR(255) | Required |  | Admin display name. |
| `email` | VARCHAR(255) | Required | Unique | Login email address. |
| `email_verified_at` | TIMESTAMP | Nullable |  | Email verification timestamp. |
| `password` | VARCHAR(255) | Required |  | Hashed Laravel password. |
| `role` | ENUM('admin','user') | Required |  | User access role. Only `admin` can access admin routes. |
| `profile_image` | VARCHAR(255) | Nullable |  | Uploaded profile image path. |
| `phone` | VARCHAR(50) | Nullable |  | Admin phone number. |
| `status` | ENUM('active','inactive') | Required |  | Controls account access. |
| `remember_token` | VARCHAR(100) | Nullable |  | Laravel remember-me token. |
| `created_at` | TIMESTAMP | Nullable |  | Record creation time. |
| `updated_at` | TIMESTAMP | Nullable |  | Last update time. |

## 2. `product_categories`

Stores product grouping data.

| Column | Data Type | Null | Key | Purpose |
| --- | --- | --- | --- | --- |
| `id` | BIGINT UNSIGNED AUTO_INCREMENT | Required | Primary Key | Unique category ID. |
| `name` | VARCHAR(255) | Required |  | Product category name. |
| `slug` | VARCHAR(255) | Required | Unique | SEO-friendly category URL. |
| `description` | TEXT | Nullable |  | Category description. |
| `image` | VARCHAR(255) | Nullable |  | Category image path. |
| `sort_order` | INT UNSIGNED | Required |  | Display order in public/admin lists. |
| `status` | ENUM('active','inactive') | Required |  | Controls public visibility. |
| `created_at` | TIMESTAMP | Nullable |  | Record creation time. |
| `updated_at` | TIMESTAMP | Nullable |  | Last update time. |

## 3. `products`

Stores coconut shell handicraft products.

| Column | Data Type | Null | Key | Purpose |
| --- | --- | --- | --- | --- |
| `id` | BIGINT UNSIGNED AUTO_INCREMENT | Required | Primary Key | Unique product ID. |
| `product_category_id` | BIGINT UNSIGNED | Required | Foreign Key | References `product_categories.id`. |
| `name` | VARCHAR(255) | Required |  | Product name. |
| `slug` | VARCHAR(255) | Required | Unique | SEO-friendly product URL. |
| `sku` | VARCHAR(100) | Nullable | Unique | Internal product code. |
| `short_description` | VARCHAR(500) | Nullable |  | Short listing summary. |
| `description` | LONGTEXT | Nullable |  | Full product description. |
| `price` | DECIMAL(10,2) | Nullable |  | Optional product price. |
| `main_image` | VARCHAR(255) | Nullable |  | Main product image path. |
| `material` | VARCHAR(255) | Nullable |  | Materials used. |
| `size` | VARCHAR(255) | Nullable |  | Product size or dimensions. |
| `availability` | ENUM('available','out_of_stock','made_to_order') | Required |  | Product availability status. |
| `is_featured` | BOOLEAN | Required |  | Marks product for homepage/featured sections. |
| `status` | ENUM('draft','published','inactive') | Required |  | Product publishing status. |
| `meta_title` | VARCHAR(255) | Nullable |  | SEO title. |
| `meta_description` | VARCHAR(500) | Nullable |  | SEO description. |
| `created_at` | TIMESTAMP | Nullable |  | Record creation time. |
| `updated_at` | TIMESTAMP | Nullable |  | Last update time. |

Foreign key: `product_category_id` references `product_categories.id` with restricted delete.

## 4. `product_images`

Stores additional images for products.

| Column | Data Type | Null | Key | Purpose |
| --- | --- | --- | --- | --- |
| `id` | BIGINT UNSIGNED AUTO_INCREMENT | Required | Primary Key | Unique product image ID. |
| `product_id` | BIGINT UNSIGNED | Required | Foreign Key | References `products.id`. |
| `image` | VARCHAR(255) | Required |  | Uploaded product image path. |
| `alt_text` | VARCHAR(255) | Nullable |  | Image accessibility and SEO text. |
| `sort_order` | INT UNSIGNED | Required |  | Image display order. |
| `created_at` | TIMESTAMP | Nullable |  | Record creation time. |
| `updated_at` | TIMESTAMP | Nullable |  | Last update time. |

Foreign key: `product_id` references `products.id` with cascade delete.

## 5. `news`

Stores company news articles.

| Column | Data Type | Null | Key | Purpose |
| --- | --- | --- | --- | --- |
| `id` | BIGINT UNSIGNED AUTO_INCREMENT | Required | Primary Key | Unique news ID. |
| `title` | VARCHAR(255) | Required |  | News title. |
| `slug` | VARCHAR(255) | Required | Unique | SEO-friendly news URL. |
| `summary` | VARCHAR(500) | Nullable |  | Short article preview. |
| `content` | LONGTEXT | Required |  | Full article body. |
| `featured_image` | VARCHAR(255) | Nullable |  | News image path. |
| `author_id` | BIGINT UNSIGNED | Nullable | Foreign Key | References `users.id`. |
| `status` | ENUM('draft','published','archived') | Required |  | Article publishing status. |
| `published_at` | DATETIME | Nullable |  | Public publishing date/time. |
| `meta_title` | VARCHAR(255) | Nullable |  | SEO title. |
| `meta_description` | VARCHAR(500) | Nullable |  | SEO description. |
| `created_at` | TIMESTAMP | Nullable |  | Record creation time. |
| `updated_at` | TIMESTAMP | Nullable |  | Last update time. |

Foreign key: `author_id` references `users.id` with null on delete.

## 6. `events`

Stores exhibitions, fairs, workshops, and company events.

| Column | Data Type | Null | Key | Purpose |
| --- | --- | --- | --- | --- |
| `id` | BIGINT UNSIGNED AUTO_INCREMENT | Required | Primary Key | Unique event ID. |
| `author_id` | BIGINT UNSIGNED | Nullable | Foreign Key | References `users.id`. |
| `title` | VARCHAR(255) | Required |  | Event title. |
| `slug` | VARCHAR(255) | Required | Unique | SEO-friendly event URL. |
| `description` | LONGTEXT | Required |  | Full event description. |
| `location` | VARCHAR(255) | Nullable |  | Event location. |
| `event_date` | DATE | Required |  | Event date. |
| `event_time` | TIME | Nullable |  | Event time. |
| `featured_image` | VARCHAR(255) | Nullable |  | Event image path. |
| `status` | ENUM('draft','published','completed','cancelled') | Required |  | Event lifecycle status. |
| `meta_title` | VARCHAR(255) | Nullable |  | SEO title. |
| `meta_description` | VARCHAR(500) | Nullable |  | SEO description. |
| `created_at` | TIMESTAMP | Nullable |  | Record creation time. |
| `updated_at` | TIMESTAMP | Nullable |  | Last update time. |

Foreign key: `author_id` references `users.id` with null on delete.

## 7. `gallery_categories`

Stores gallery groupings.

| Column | Data Type | Null | Key | Purpose |
| --- | --- | --- | --- | --- |
| `id` | BIGINT UNSIGNED AUTO_INCREMENT | Required | Primary Key | Unique gallery category ID. |
| `name` | VARCHAR(255) | Required |  | Gallery category name. |
| `slug` | VARCHAR(255) | Required | Unique | SEO-friendly gallery category slug. |
| `description` | TEXT | Nullable |  | Gallery category description. |
| `sort_order` | INT UNSIGNED | Required |  | Display order. |
| `status` | ENUM('active','inactive') | Required |  | Controls public visibility. |
| `created_at` | TIMESTAMP | Nullable |  | Record creation time. |
| `updated_at` | TIMESTAMP | Nullable |  | Last update time. |

## 8. `galleries`

Stores gallery images.

| Column | Data Type | Null | Key | Purpose |
| --- | --- | --- | --- | --- |
| `id` | BIGINT UNSIGNED AUTO_INCREMENT | Required | Primary Key | Unique gallery item ID. |
| `gallery_category_id` | BIGINT UNSIGNED | Nullable | Foreign Key | References `gallery_categories.id`. |
| `title` | VARCHAR(255) | Nullable |  | Gallery image title. |
| `image` | VARCHAR(255) | Required |  | Uploaded gallery image path. |
| `alt_text` | VARCHAR(255) | Nullable |  | Image accessibility and SEO text. |
| `caption` | VARCHAR(500) | Nullable |  | Optional image caption. |
| `sort_order` | INT UNSIGNED | Required |  | Display order. |
| `status` | ENUM('active','inactive') | Required |  | Controls public visibility. |
| `created_at` | TIMESTAMP | Nullable |  | Record creation time. |
| `updated_at` | TIMESTAMP | Nullable |  | Last update time. |

Foreign key: `gallery_category_id` references `gallery_categories.id` with null on delete.

## 9. `contact_messages`

Stores visitor contact form submissions.

| Column | Data Type | Null | Key | Purpose |
| --- | --- | --- | --- | --- |
| `id` | BIGINT UNSIGNED AUTO_INCREMENT | Required | Primary Key | Unique message ID. |
| `name` | VARCHAR(255) | Required |  | Visitor name. |
| `email` | VARCHAR(255) | Required |  | Visitor email address. |
| `phone` | VARCHAR(50) | Nullable |  | Visitor phone number. |
| `subject` | VARCHAR(255) | Nullable |  | Message subject. |
| `message` | TEXT | Required |  | Message body. |
| `is_read` | BOOLEAN | Required |  | Read/unread admin status. |
| `replied_at` | DATETIME | Nullable |  | Time admin replied externally. |
| `ip_address` | VARCHAR(45) | Nullable |  | Visitor IP address. |
| `created_at` | TIMESTAMP | Nullable |  | Message received time. |
| `updated_at` | TIMESTAMP | Nullable |  | Last update time. |

## 10. `pages`

Stores editable static website pages.

| Column | Data Type | Null | Key | Purpose |
| --- | --- | --- | --- | --- |
| `id` | BIGINT UNSIGNED AUTO_INCREMENT | Required | Primary Key | Unique page ID. |
| `page_key` | VARCHAR(100) | Required | Unique | Stable page identifier, such as `about` or `sustainability`. |
| `title` | VARCHAR(255) | Required |  | Page title. |
| `slug` | VARCHAR(255) | Required | Unique | SEO-friendly page URL. |
| `content` | LONGTEXT | Nullable |  | Editable page body. |
| `featured_image` | VARCHAR(255) | Nullable |  | Optional page image. |
| `meta_title` | VARCHAR(255) | Nullable |  | SEO title. |
| `meta_description` | VARCHAR(500) | Nullable |  | SEO description. |
| `status` | ENUM('draft','published') | Required |  | Page publishing status. |
| `created_at` | TIMESTAMP | Nullable |  | Record creation time. |
| `updated_at` | TIMESTAMP | Nullable |  | Last update time. |

## 11. `settings`

Stores global website settings.

| Column | Data Type | Null | Key | Purpose |
| --- | --- | --- | --- | --- |
| `id` | BIGINT UNSIGNED AUTO_INCREMENT | Required | Primary Key | Unique setting ID. |
| `key` | VARCHAR(150) | Required | Unique | Setting identifier. |
| `value` | LONGTEXT | Nullable |  | Setting value. |
| `type` | ENUM('text','textarea','image','email','phone','url','json') | Required |  | Value input/display type. |
| `group_name` | VARCHAR(100) | Nullable |  | Setting group, such as company, social, SEO, or contact. |
| `created_at` | TIMESTAMP | Nullable |  | Record creation time. |
| `updated_at` | TIMESTAMP | Nullable |  | Last update time. |

## Main Relationships

| Relationship | Type |
| --- | --- |
| `product_categories` -> `products` | One to many |
| `products` -> `product_images` | One to many |
| `users` -> `news` | One to many |
| `gallery_categories` -> `galleries` | One to many |
