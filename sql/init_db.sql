-- 1. USERS TABLE
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('customer', 'admin', 'team') DEFAULT 'customer',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2. ORDERS TABLE
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    created_by INT NULL,  -- Team member who created the order
    plan ENUM('basic', 'advanced', 'pro', 'custom') NOT NULL,
    status ENUM('pending', 'paid', 'in_progress', 'complete', 'cancelled') DEFAULT 'pending',
    total_price DECIMAL(10, 2) DEFAULT 0.00,
    notes TEXT,
    reset_token VARCHAR(64),
    reset_expires DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 3. ORDER ITEMS TABLE
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    service_name VARCHAR(100) NOT NULL,
    quantity INT DEFAULT 1,
    unit_price DECIMAL(10, 2) DEFAULT 0.00,
    total_price DECIMAL(10, 2) GENERATED ALWAYS AS (quantity * unit_price) STORED
);

-- 4. UPLOADS TABLE (for client brand files, etc.)
CREATE TABLE uploads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    file_name VARCHAR(255),
    file_path VARCHAR(255),
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);



CREATE INDEX idx_user_email ON users(email);
CREATE INDEX idx_order_user ON orders(user_id);
CREATE INDEX idx_order_created_by ON orders(created_by);
CREATE INDEX idx_order_items_order_id ON order_items(order_id);
CREATE INDEX idx_uploads_order_id ON uploads(order_id);
CREATE INDEX idx_payments_order_id ON payments(order_id);





-- *************NOT USED**************************
-- 5. PAYMENTS TABLE
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    stripe_payment_id VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    status ENUM('success', 'failed', 'pending') DEFAULT 'pending',
    paid_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 6. ORDER STATUS LOG (optional audit trail)
CREATE TABLE order_status_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    status ENUM('pending', 'paid', 'in_progress', 'complete', 'cancelled'),
    updated_by INT NOT NULL,
    comment TEXT,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (updated_by) REFERENCES users(id)
);

-- Admin User
INSERT INTO users (name, email, password, role)
VALUES ('Admin User', 'admin@vsnnetworks.com', 'admin_hashed_pwd', 'admin');

-- Team Member
INSERT INTO users (name, email, password, role)
VALUES ('Team Member', 'team@vsnnetworks.com', 'team_hashed_pwd', 'team');

-- Customer
INSERT INTO users (name, email, password, role)
VALUES ('John Doe', 'john.doe@example.com', 'customer_hashed_pwd', 'customer');

-- Order by Customer for Basic Plan
INSERT INTO orders (user_id, created_by, plan, status, total_price, notes)
VALUES (3, NULL, 'basic', 'paid', 199.00, 'Self-serve basic package purchase');

-- Order Created by Team Member
INSERT INTO orders (user_id, created_by, plan, status, total_price, notes)
VALUES (3, 2, 'advanced', 'pending', 449.00, 'Client was onboarded during consultation call');

-- Order ID 1: Basic Plan (just main service)
INSERT INTO order_items (order_id, service_name, quantity, unit_price)
VALUES (1, 'Basic On-Page SEO Setup', 1, 199.00);

-- Order ID 2: Advanced Plan with Addons
INSERT INTO order_items (order_id, service_name, quantity, unit_price) VALUES
(2, 'Advanced On-Page SEO + Google Analytics Setup', 1, 299.00),
(2, '2 Meta Ads', 2, 50.00),
(2, 'Technical SEO Audit', 1, 100.00);

INSERT INTO uploads (order_id, file_name, file_path)
VALUES (2, 'john-logo.png', '/uploads/john-logo.png');

