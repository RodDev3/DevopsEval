# Actions attendues par l'application

## 1. Ajout de Produits au Panier (Buy)

### Séquence :

- L'utilisateur sélectionne un produit (instance de la classe `Product``).
- L'utilisateur spécifie la quantité à acheter.
- L'application utilise la méthode `buy` de la classe `Cart` pour ajouter le produit au panier avec la quantité spécifiée.
- La méthode `buy` de la classe `Cart` calcule le total en tenant compte de la TVA et met à jour le stockage (par exemple, `Storage` ou une base de données).

```php
// Exemple d'utilisation dans l'application
// Storage stock le résultat dans la base de données
$cart = new Cart(new Storage());
$apple = new Product('apple', 10.5);

$cart->buy($apple, 3);
```

```javascript
const cart = new Cart(new InMemoryStorage());
const apple = new Product('apple', 10.5);

cart.buy(apple, 3);
```

## 2. Réinitialisation du Panier (Reset)

### Séquence :

- L'utilisateur demande la réinitialisation du panier.
- L'application utilise la méthode `reset` de la classe `Cart` pour vider le panier.

#### PHP

```php
// Exemple d'utilisation dans l'application
$cart->reset();
```

#### JS

```javascript
cart.reset();
```

## 3. Restauration d'un Produit (Restore)

### Séquence :

- L'utilisateur sélectionne un produit à restaurer.
- L'application utilise la méthode `restore` de la classe `Cart` pour restaurer le produit dans le panier.

#### PHP

```php
// Exemple d'utilisation dans l'application
$cart->restore($apple);
```

#### JS

```javascript
cart.restore(apple);
```

## 4. Calcul du Total du Panier

### Séquence :

- L'utilisateur demande le calcul du total du panier.
- L'application utilise la méthode `total` de la classe `Cart` pour obtenir le total actuel du panier.
  
#### PHP

```php
// Exemple d'utilisation dans l'application
$total = $cart->total();
```

#### JS

```javascript
const total = cart.total();
```

Remarques importantes :
Les classes Cart, InMemoryStorage, Product, et autres doivent être correctement implémentées pour que ces séquences fonctionnent.
Les tests unitaires (TDD) assurent que chaque fonctionnalité est correcte et que l'application répond aux spécifications.
La dockerisation et l'intégration continue (CI/CD) garantissent que l'application est déployable et testée de manière cohérente dans différents environnements.
Ces séquences représentent des actions de base que les utilisateurs peuvent effectuer dans une application de gestion de panier, et elles sont cruciales pour assurer un fonctionnement correct et fiable du système.
