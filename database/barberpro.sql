CREATE DATABASE IF NOT EXISTS barberpro
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE barberpro;

CREATE TABLE IF NOT EXISTS businesses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NULL,
    phone VARCHAR(30) NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO businesses (id, name, description)
SELECT 1, 'BarberHouse', 'Barbería de prueba de BarberPro'
WHERE NOT EXISTS (SELECT 1 FROM businesses WHERE id = 1);

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    business_id INT UNSIGNED NOT NULL DEFAULT 1,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(30) NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('owner','barber','client') NOT NULL DEFAULT 'client',
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_business FOREIGN KEY (business_id)
        REFERENCES businesses(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS barber_profiles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL UNIQUE,
    specialty VARCHAR(150) NULL,
    biography TEXT NULL,
    photo VARCHAR(255) NULL,
    CONSTRAINT fk_barber_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS services (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    business_id INT UNSIGNED NOT NULL DEFAULT 1,
    name VARCHAR(120) NOT NULL,
    description TEXT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    duration_minutes SMALLINT UNSIGNED NOT NULL DEFAULT 30,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_services_business FOREIGN KEY (business_id)
        REFERENCES businesses(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS appointments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    business_id INT UNSIGNED NOT NULL DEFAULT 1,
    client_id INT UNSIGNED NOT NULL,
    barber_id INT UNSIGNED NOT NULL,
    service_id INT UNSIGNED NOT NULL,
    requested_at DATETIME NOT NULL,
    proposed_at DATETIME NULL,
    confirmed_at DATETIME NULL,
    status ENUM('pending','confirmed','rejected','change_proposed',
      'client_accepted','client_rejected','completed','cancelled')
      NOT NULL DEFAULT 'pending',
    client_notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_appointments_business FOREIGN KEY (business_id) REFERENCES businesses(id),
    CONSTRAINT fk_appointments_client FOREIGN KEY (client_id) REFERENCES users(id),
    CONSTRAINT fk_appointments_barber FOREIGN KEY (barber_id) REFERENCES users(id),
    CONSTRAINT fk_appointments_service FOREIGN KEY (service_id) REFERENCES services(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS appointment_history (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    action VARCHAR(100) NOT NULL,
    previous_date DATETIME NULL,
    new_date DATETIME NULL,
    comments TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_history_appointment FOREIGN KEY (appointment_id)
        REFERENCES appointments(id) ON DELETE CASCADE,
    CONSTRAINT fk_history_user FOREIGN KEY (user_id)
        REFERENCES users(id)
) ENGINE=InnoDB;
