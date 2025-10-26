-- --------------------------------------------------------
-- Database: `shoppn`
-- Enhanced e-commerce version
-- --------------------------------------------------------

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- --------------------------------------------------------
-- Table: categories
-- --------------------------------------------------------
CREATE TABLE `categories` (
  `cat_id` INT(11) NOT NULL AUTO_INCREMENT,
  `cat_name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: brands
-- --------------------------------------------------------
CREATE TABLE `brands` (
  `brand_id` INT(11) NOT NULL AUTO_INCREMENT,
  `brand_name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: products
-- --------------------------------------------------------
CREATE TABLE `products` (
  `product_id` INT(11) NOT NULL AUTO_INCREMENT,
  `product_cat` INT(11) NOT NULL,
  `product_brand` INT(11) NOT NULL,
  `product_title` VARCHAR(200) NOT NULL,
  `product_price` DOUBLE NOT NULL,
  `product_desc` VARCHAR(500),
  `product_image` VARCHAR(255),
  `product_keywords` VARCHAR(150),
  `date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`),
  FOREIGN KEY (`product_cat`) REFERENCES `categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`product_brand`) REFERENCES `brands` (`brand_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: product_variants
-- (Handles sizes, colors, and stock for each product)
-- --------------------------------------------------------
CREATE TABLE `product_variants` (
  `variant_id` INT(11) NOT NULL AUTO_INCREMENT,
  `product_id` INT(11) NOT NULL,
  `size` VARCHAR(50),
  `color` VARCHAR(50),
  `stock_qty` INT(11) NOT NULL DEFAULT 0,
  `price_override` DOUBLE DEFAULT NULL,
  PRIMARY KEY (`variant_id`),
  FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: product_images
-- (Supports multiple images per product)
-- --------------------------------------------------------
CREATE TABLE `product_images` (
  `image_id` INT(11) NOT NULL AUTO_INCREMENT,
  `product_id` INT(11) NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`image_id`),
  FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: customer
-- --------------------------------------------------------
CREATE TABLE `customer` (
  `customer_id` INT(11) NOT NULL AUTO_INCREMENT,
  `customer_name` VARCHAR(100) NOT NULL,
  `customer_email` VARCHAR(100) NOT NULL UNIQUE,
  `customer_pass` VARCHAR(255) NOT NULL,
  `customer_country` VARCHAR(50) NOT NULL,
  `customer_city` VARCHAR(50) NOT NULL,
  `customer_contact` VARCHAR(20) NOT NULL,
  `customer_image` VARCHAR(255),
  `user_role` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: cart
-- --------------------------------------------------------
CREATE TABLE `cart` (
  `cart_id` INT(11) NOT NULL AUTO_INCREMENT,
  `variant_id` INT(11) NOT NULL,
  `customer_id` INT(11),
  `qty` INT(11) NOT NULL,
  PRIMARY KEY (`cart_id`),
  FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`variant_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: orders
-- --------------------------------------------------------
CREATE TABLE `orders` (
  `order_id` INT(11) NOT NULL AUTO_INCREMENT,
  `customer_id` INT(11) NOT NULL,
  `invoice_no` VARCHAR(100) NOT NULL,
  `order_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `order_status` VARCHAR(100) DEFAULT 'Pending',
  PRIMARY KEY (`order_id`),
  FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: orderdetails
-- --------------------------------------------------------
CREATE TABLE `orderdetails` (
  `orderdetail_id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL,
  `variant_id` INT(11) NOT NULL,
  `qty` INT(11) NOT NULL,
  `price_at_purchase` DOUBLE NOT NULL,
  PRIMARY KEY (`orderdetail_id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`variant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: payment
-- --------------------------------------------------------
CREATE TABLE `payment` (
  `pay_id` INT(11) NOT NULL AUTO_INCREMENT,
  `amt` DOUBLE NOT NULL,
  `customer_id` INT(11) NOT NULL,
  `order_id` INT(11) NOT NULL,
  `currency` VARCHAR(10) NOT NULL,
  `payment_method` VARCHAR(50) DEFAULT 'Card',
  `payment_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pay_id`),
  FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: product_reviews
-- --------------------------------------------------------
CREATE TABLE `product_reviews` (
  `review_id` INT(11) NOT NULL AUTO_INCREMENT,
  `product_id` INT(11) NOT NULL,
  `customer_id` INT(11) NOT NULL,
  `rating` INT(1) NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
  `review_text` TEXT,
  `review_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
