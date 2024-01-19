# Développement TDD, Dockerisation, et CI/CD d'une Application de Gestion de Panier en PHP

## Description

> ⚠️ À LA FIN DE LA JOURNÉE VOUS DEVEZ M'ENVOYER UN LIEN VERS LE DÉPÔT CONTENANT VOTRE PROJET
> PENSEZ À COMMIT/PUSH AU FUR ET À MESURE

> _Note:_ L'application peut être faite soit avec NodeJS soit avec PHP.
 

> _Note 2:_ Je n'aurai pas PHP ou node d'installer sur ma machine mais juste Docker. Prévoyez que votre application fonctionne uniquement via Docker

Vous êtes responsable du développement d'une application de gestion de panier. Votre objectif est de mettre en place une approche de développement pilotée par les tests (TDD), de dockeriser l'application pour assurer sa portabilité, et d'implémenter une intégration continue (CI) avec GitHub Actions (GHA).

## Objectifs de l'exercice

### 1. **TDD - Tests Unitaires** :
   - Commencez par écrire des tests unitaires pour chaque fonctionnalité importante de l'application. Utilisez le concept TDD en écrivant d'abord les tests avant d'implémenter le code correspondant.
   - Les fonctionnalités à tester incluent l'**ajout de produits au panier**, **le calcul du total**, **la réinitialisation du panier**, et **la restauration de produits**.

   #### Noms des classes
   - `CartTest` pour tester les fonctionnalités de la classe `Cart`.
   - `InMemoryStorageTest` pour tester les fonctionnalités de la classe `InMemoryStorage`.
   - `ProductTest` pour tester les fonctionnalités de la classe `Product`.

   #### Méthodes à tester
   - Dans `CartTest` : `testBuy`, `testReset`, `testRestore`, `testTotal`.
   - Dans `InMemoryStorageTest` : `testSetValue`, `testRestore`, `testReset`, `testTotal`.
   - Dans `ProductTest` : `testGetName`, `testGetPrice`, `testSetName`, `testSetPrice`.

### 2. **Implémentation des Fonctionnalités** :
   - Implémentez le code de l'application en suivant le processus TDD. Assurez-vous que tous les tests passent avec succès.

   #### Noms des classes
   - `Cart` pour la gestion du panier.
   - `InMemoryStorage` pour le stockage en mémoire. (dans un `array`)
   - `Product` pour la représentation des produits.

   #### Méthodes à implémenter
   - Dans `Cart` : `buy`, `reset`, `restore`, `total`.
   - Dans `InMemoryStorage` : `setValue`, `restore`, `reset`, `total`.
   - Dans `Product` : `getName`, `getPrice`.

### 3. **Dockerisation** :
   - Créez un fichier `Dockerfile` pour l'application PHP. Assurez-vous d'utiliser une image PHP appropriée et configurez le conteneur pour exposer le port nécessaire avec les dépendances nécessaires
   - Utilisez `Docker Compose` pour définir les services nécessaires, y compris l'application, les tests, et les dépendances.

   #### Noms des services dans le fichier `docker-compose.yml`
   - `app` pour l'application PHP.
   - `test` pour l'exécution des tests unitaires.

### 4. **Intégration Continue avec GitHub Actions** :
   - Configurez un flux de travail GitHub Actions pour déclencher automatiquement les tests unitaires à chaque push sur la branche principale du référentiel.
   - Ajoutez une étape de construction Docker dans le flux de travail pour garantir que l'application peut être correctement conteneurisée.

   #### Noms des étapes dans le fichier de configuration de GitHub Actions
   - `Run Tests` pour l'étape des tests unitaires.
   - `Build Docker Image` pour l'étape de construction Docker.

5. **Ajouter une base de données** :
> Nous allons remplacer le `InMemoryStorage` par un `MySQLStorage` qui insérera les données dans une base MySQL au lieu de la mémoire. La class resemblera à:
> - `MySQLStorage` : `setValue`, `restore`, `reset`, `total`

- Commencez par écrire les tests unitaires de cette classe. Vous pouvez suivre le même modèle que dans les tests présent dans `01-le-concept-de-tdd/exercices/exercice-3-model`

### Requête SQL

Voici les requêtes SQL pour préparer les tables en base de données:

```sql
-- Création de la base de données
CREATE DATABASE IF NOT EXISTS cart_database;

-- Utilisation de la base de données
USE cart_database;

-- Création de la table des produits
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

-- Ajout de quelques produits de test
INSERT INTO products (name, price) VALUES
('apple', 10.5),
('raspberry', 13.0),
('orange', 7.5);

-- Création de la table de stockage en mémoire
CREATE TABLE in_memory_storage (
    product_id INT,
    quantity INT,
    PRIMARY KEY (product_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Création de la table des paniers
CREATE TABLE carts (
    id INT PRIMARY KEY AUTO_INCREMENT
);

-- Création de la table des produits dans le panier
CREATE TABLE cart_products (
    cart_id INT,
    product_id INT,
    quantity INT,
    PRIMARY KEY (cart_id, product_id),
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Ajout de quelques paniers et produits dans les paniers
INSERT INTO carts DEFAULT VALUES;
INSERT INTO cart_products (cart_id, product_id, quantity) VALUES
(1, 1, 3),
(1, 2, 2);
```

### Méthodes à tester
- Dans `MySQLStorageTest` : `testSetValue`, `testRestore`, `testReset`, `testTotal`.

Vous pouvez vous inspirer des codes suivants pour interagir avec la base de données:

#### PHP

```php
<?php

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "cart_database";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ajout de quelques produits de test
    $products = [
        ['apple', 10.5],
        ['raspberry', 13.0],
        ['orange', 7.5],
    ];

    foreach ($products as $product) {
        $name = $product[0];
        $price = $product[1];

        $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (:name, :price)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->execute();
    }

    // Ajout de quelques paniers et produits dans les paniers
    $stmt = $conn->prepare("INSERT INTO carts DEFAULT VALUES");
    $stmt->execute();

    $cartId = $conn->lastInsertId(); // Récupère l'ID du panier créé

    $cartProducts = [
        ['cart_id' => $cartId, 'product_id' => 1, 'quantity' => 3],
        ['cart_id' => $cartId, 'product_id' => 2, 'quantity' => 2],
    ];

    foreach ($cartProducts as $cartProduct) {
        $stmt = $conn->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        $stmt->bindParam(':cart_id', $cartProduct['cart_id']);
        $stmt->bindParam(':product_id', $cartProduct['product_id']);
        $stmt->bindParam(':quantity', $cartProduct['quantity']);
        $stmt->execute();
    }

    echo "Données insérées avec succès.";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
```

#### JS

```javascript
const mysql = require('mysql2/promise');

const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'password',
    database: 'cart_database'
});

async function insertTestData() {
    try {
        // Ajout de quelques produits de test
        const products = [
            ['apple', 10.5],
            ['raspberry', 13.0],
            ['orange', 7.5],
        ];

        for (const product of products) {
            const [name, price] = product;

            await connection.execute("INSERT INTO products (name, price) VALUES (?, ?)", [name, price]);
        }

        // Ajout de quelques paniers et produits dans les paniers
        await connection.execute("INSERT INTO carts DEFAULT VALUES");

        const [cartId] = await connection.query("SELECT LAST_INSERT_ID() as lastId");

        const cartProducts = [
            { cart_id: cartId[0].lastId, product_id: 1, quantity: 3 },
            { cart_id: cartId[0].lastId, product_id: 2, quantity: 2 },
        ];

        for (const cartProduct of cartProducts) {
            await connection.execute("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (?, ?, ?)", [
                cartProduct.cart_id,
                cartProduct.product_id,
                cartProduct.quantity
            ]);
        }

        console.log("Données insérées avec succès.");

    } catch (error) {
        console.error("Erreur :", error.message);
    } finally {
        connection.end();
    }
}

insertTestData();
```

## Conseils
- Utilisez un framework de test tel que PHPUnit (Jest pour Node) pour écrire vos tests unitaires.
- Assurez-vous que vos tests couvrent des scénarios variés, y compris des cas limites et des erreurs. (Ayez un coverage élevé)
- Documentez vos tests et expliquez comment ils valident chaque fonctionnalité.
- Commentez votre Dockerfile pour expliquer les étapes et les choix de configuration.
- Assurez-vous que le fichier `README.md` contient des instructions claires sur la manière d'exécuter les tests, de dockeriser l'application et d'utiliser GitHub Actions.

⚠️ À LA FIN DE LA JOURNÉE VOUS DEVEZ M'ENVOYER UN LIEN VERS LE DÉPÔT CONTENANT VOTRE PROJET
> PENSEZ À COMMIT/PUSH AU FUR ET À MESURE
