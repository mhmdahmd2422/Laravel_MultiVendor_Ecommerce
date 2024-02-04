## Sazao - Multi-Vendor Ecommerce

Sazao is an open-source multi-vendor ecommerce web application developed using the Laravel framework and MySQL database. It aims to provide a robust and scalable solution for individuals and businesses to create their online marketplace, enabling them to sell their products or services to a wide audience. With OpenMarket, vendors can easily set up their stores, manage inventory, process orders, track and collect payments through reliable payment gateways, and engage with customers in a seamless and efficient manner.

- Live Demo : http://44.196.54.81/

## Features Overview:

- Multi-Vendor Support: Sazao allows multiple vendors to sign up and create their own storefronts within the platform, offering a diverse range of products or services.

- Product Management: Vendors can add, edit, and manage their products listings, including product descriptions, images, pricing, and inventory levels, through a convenient dashboard.

- Order Processing: Sazao facilitates the smooth processing of orders, including order placement, payment processing, order tracking, and order fulfillment, ensuring a seamless shopping experience for customers.

- Payment Gateway Integration: The platform integrates with popular payment gateways, allowing secure online transactions and providing multiple payment options for customers.

- Ratings and Reviews: Customers can leave ratings and reviews for products they have purchased, as well as save products in their wishlist for late, helping other users make informed decisions and fostering trust within the community.

- Dynamic Homepage: Sazao provide a fully dynamic and customizable homepage to help promote hot items and vendors, as well as flash sales, popular products, and most-selling items on the marketplace.

- Advanced Search and Filtering: Implementing advanced search and filtering options to help customers easily find the products they are looking for based on specific criteria.

- Blogs Section: Sazao incorporates a robust blogging feature designed to enhance engagement, educate users, and inspire interaction within the marketplace community. Blog posts are seamlessly integrated with social media platforms, allowing users to easily share articles across their social networks and expand the reach of the marketplace content. All blog content is optimized for search engines to enhance discoverability and attract organic traffic to the marketplace website.

- Newsletter Subscriptions: Users have the option to subscribe to the blog newsletter to receive regular updates, notifications, and curated content directly in their inbox. Newsletter subscribers stay informed about the latest blog posts, product releases, promotions, and events

- Analytics and Reporting: The application provides vendors with valuable insights into their sales performance, customer behavior, and inventory management through comprehensive analytics and reporting tools.

- Responsive Design: Sazao is built with a responsive design, ensuring that the platform is accessible and optimized for various devices and screen sizes, including desktops, tablets, and smartphones.

- Scalability and Extensibility: The architecture of Sazao is designed to be highly scalable and extensible, allowing for easy customization and integration of additional features and functionalities as per the requirements of the users.

## Functional Features

- Vendor Management:

1. Onboarding: Admins can review and approve vendor registration requests, ensuring compliance with platform policies and standards.
2. Profile Management: Admins can view and manage vendor profiles, including contact information, store details, and verification status.
3. Suspension and Termination: Admins have the authority to suspend or terminate vendor accounts for violations of terms of service or other infractions.

- Product Management:

1. Catalog Management: Admins can oversee the entire product catalog, including adding, editing, or removing products as needed.
2. Inventory Management: Admins can monitor inventory levels, track stock movements, and receive alerts for low stock or out-of-stock items.
3. Product Approval: Admins can review and approve new product listings submitted by vendors before they are published on the marketplace.
4. Product Variations: Vendors can create product variations such as size, color, or style variants, enabling customers to choose from different options within the same product listing.
5. Order Management: Vendors can view and manage orders placed by customers, including order status, payment verification, and fulfillment status, from a centralized dashboard.
6. Promotions and Discounts: Admins can create and manage promotional offers, discounts, and coupon codes

- User Management:

1. User Roles and Permissions: Admins can assign different roles and permissions to users based on their responsibilities and access requirements, ensuring security and compliance.

- Content Management:

1. Website Content: Admins can manage website content, including static pages, banners, promotional materials, and announcements, to keep the platform up-to-date and engaging.
2. Blog Management: Admins can publish, edit, or delete blog posts, manage comments, and monitor engagement on the blog section of the platform.

- Secure Authentication:

1. Remember Me Option: To enhance user convenience, Sazao offers a "Remember Me" option on the login page. Eliminating the need to re-enter credentials every time they visit the platform.
2. Forgot Password Functionality: In case users forget their passwords, Sazao provides a "Forgot Password" feature. Users can reset their passwords by following a simple email-based verification process.
3. Account Management: Logged-in users have access to their account settings, where they can update personal information, change passwords, and manage communication preferences.

4. Security & Privacy: User passwords are hashed and stored securely, and login attempts are monitored for suspicious activity.

## Sample Views

- [Home Page Screenshot](https://i.imgur.com/aG5vNdL.jpg)
- [Product Page Screenshot](https://i.imgur.com/gVPQiZe.png)
- [Admin Dashboard Screenshot](https://i.imgur.com/bCOBojU.png)

## Prerequisites:

- Web server (Apache, Nginx, or any server supporting PHP)
- PHP (>= 7.3.0)
- Composer (PHP dependency manager)
- MySQL or any other supported database

## Installation

1. Install Dependencies
```php
composer install
```
2. Environment Configuration
   Duplicate the .env.example file and rename it to .env. Update the database configuration and any other environment variables as needed.
```php
cp .env.example .env
```
3. Generate Application Key
```php
php artisan key:generate
```
4. Run Migrations and Seeders
```php
php artisan migrate --seed
```
5. Serve Your Application
```php
php artisan serve --port={port}
```
## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.
