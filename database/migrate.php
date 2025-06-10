<?php

require __DIR__ . '/../vendor/autoload.php';

use App\System\DatabaseConnector;

try {
    $db_reference = new DatabaseConnector();
    $db = $db_reference->getConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criar tabela Users
    $statement = $db->prepare(
        "CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"
    );
    $statement->execute();

    // Criar tabela Clients
    $statement = $db->prepare(
        "CREATE TABLE IF NOT EXISTS clients (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            cpf VARCHAR(14) NOT NULL UNIQUE,
            address TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"
    );
    $statement->execute();

    // Criar tipo ENUM para status do produto
    $db->exec("DO \$\$ BEGIN
        IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'product_status') THEN
            CREATE TYPE product_status AS ENUM ('active', 'inactive', 'maintenance');
        END IF;
    END \$\$;");

    // Criar tabela Products
    $statement = $db->prepare(
        "CREATE TABLE IF NOT EXISTS products (
            id SERIAL PRIMARY KEY,
            description VARCHAR(255) NOT NULL,
            status product_status DEFAULT 'active',
            warranty_time DATE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"
    );
    $statement->execute();

    // Criar tipo ENUM para status das ordens de serviço
    $db->exec("DO \$\$ BEGIN
        IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'service_order_status') THEN
            CREATE TYPE service_order_status AS ENUM ('pending', 'in_progress', 'completed', 'cancelled');
        END IF;
    END \$\$;");

    // Criar tabela ServiceOrders
    $statement = $db->prepare(
        "CREATE TABLE IF NOT EXISTS service_orders (
            id SERIAL PRIMARY KEY,
            product_id INT NOT NULL,
            client_id INT NOT NULL,
            user_id INT NOT NULL,
            status service_order_status DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT fk_product FOREIGN KEY (product_id) REFERENCES products(id),
            CONSTRAINT fk_client FOREIGN KEY (client_id) REFERENCES clients(id),
            CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id)
        )"
    );
    $statement->execute();

    // Criar índices separadamente
    $db->exec("CREATE INDEX IF NOT EXISTS idx_service_orders_product ON service_orders(product_id);");
    $db->exec("CREATE INDEX IF NOT EXISTS idx_service_orders_client ON service_orders(client_id);");
    $db->exec("CREATE INDEX IF NOT EXISTS idx_service_orders_user ON service_orders(user_id);");

    echo "Migração concluída com sucesso!\n";

} catch (PDOException $e) {
    die("Erro na migração: " . $e->getMessage());
}
