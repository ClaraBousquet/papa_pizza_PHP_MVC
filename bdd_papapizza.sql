-- table size
CREATE TABLE IF NOT EXISTS `size` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `label` VARCHAR(255) NOT NULL
) ;

INSERT INTO `size` (`label`) VALUES 
    ('small (24cm)'), 
    ('medium (32cm)'), 
    ('large (40cm)');

-- table ingredient
CREATE TABLE IF NOT EXISTS `ingredient` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `label` VARCHAR(255) NOT NULL,
    `category` VARCHAR(255) NOT NULL,
    `is_allergic` BOOLEAN NOT NULL DEFAULT 0,
    `is_active` BOOLEAN NOT NULL DEFAULT 1
) ;

INSERT INTO `ingredient`(`label`, `category`, `is_allergic`) VALUES 
    ('tomate','base', 0), 
    ('crème fraiche', 'base', 1),
    ('mozzarella', 'fromage', 0),
    ('emmental', 'fromage', 0),
    ('chèvre', 'fromage', 0),
    ('roquefort', 'fromage', 1),
    ('parmesan', 'fromage', 0),
    ('jambon', 'viande', 0),
    ('lardons', 'viande', 0),
    ('poulet', 'viande', 0),
    ('merguez', 'viande', 0),
    ('chorizo', 'viande', 0),
    ('saucisse', 'viande', 0),
    ('thon', 'poisson', 0),
    ('saumon', 'poisson', 0),
    ('anchois', 'poisson', 1),
    ('olives', 'légume', 0),
    ('champignons', 'légume', 0),
    ('oignons', 'légume', 0),
    ('poivrons', 'légume', 0),
    ('artichauts', 'légume', 0),
    ('aubergines', 'légume', 0),
    ('courgettes', 'légume', 0),
    ('pommes de terre', 'légume', 0),
    ('oeuf', 'viande', 0),
    ('câpres', 'autre', 0),
    ('miel', 'autre', 0),
    ('persil', 'autre', 0),
    ('basilic', 'autre', 0),
    ('origan', 'autre', 0),
    ('piment', 'autre', 0),
    ('huile piquante', 'autre', 0);

-- table unit
CREATE TABLE IF NOT EXISTS `unit` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `label` VARCHAR(255) NOT NULL
);

INSERT INTO `unit` (`label`) VALUES 
    ('g'), 
    ('ml'), 
    ('cl'), 
    ('l'), 
    ('unité'), 
    ('pincée');

-- table user
CREATE TABLE IF NOT EXISTS `user` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `lastname` VARCHAR(255) NOT NULL,
    `firstname` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255),
    `zip_code` VARCHAR(255),
    `city` VARCHAR(255),
    `country` VARCHAR(255),
    `phone` VARCHAR(255) NOT NULL,
    `is_admin` BOOLEAN NOT NULL DEFAULT 0,
    `is_active` BOOLEAN NOT NULL DEFAULT 1
) ;

-- ajout de l'admin uniquement
INSERT INTO `user` (`email`, `password`, `lastname`, `firstname`, `address`, `zip_code`, `city`, `country`, `phone`, `is_admin`) VALUES 
    ('admin@admin.com', 'admin', 'Yolo', 'Pizza', '3 rue de la pizza', '66000', 'Perpignan', 'France', '0601020304', 1);

-- table pizza
CREATE TABLE IF NOT EXISTS `pizza` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `image_path` VARCHAR(255) ,
    `is_active` BOOLEAN NOT NULL DEFAULT 1,
    `user_id` INT(11) NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `user`(`id`)
) ;

INSERT INTO `pizza` (`name`, `image_path`, user_id) VALUES 
    ('Margarita', 'margarita.jpg', 1),
    ('4 fromages', '4fromages.jpg', 1),
    ('Reine', 'reine.jpg', 1),
    ('Royale', 'royale.jpg', 1),
    ('Calzone', 'calzone.jpg', 1),
    ('Hawaienne', 'hawaienne.jpg', 1),
    ('Chorizo', 'chorizo.jpg', 1),
    ('Poulet', 'poulet.jpg', 1),
    ('Saumon', 'saumon.jpg', 1),
    ('Végétarienne', 'vegetarienne.jpg', 1),
    ('Paysanne', 'paysanne.jpg', 1),
    ('Orientale', 'orientale.jpg', 1),
    ('Océane', 'oceane.jpg', 1),
    ('Pizzaiolo', 'pizzaiolo.jpg', 1);

-- table pizza_ingredient
CREATE TABLE IF NOT EXISTS `pizza_ingredient`(
    `pizza_id` INT(11) NOT NULL,
    `ingredient_id` INT(11) NOT NULL,
    `unit_id` INT(11) NOT NULL,
    `quantity` INT(11) NOT NULL,
    FOREIGN KEY (`pizza_id`) REFERENCES `pizza`(`id`),
    FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient`(`id`),
    FOREIGN KEY (`unit_id`) REFERENCES `unit`(`id`)
);

INSERT INTO `pizza_ingredient`(`pizza_id`, `ingredient_id`, `unit_id`, `quantity`) VALUES 
    (1, 1, 5, 1),
    (1, 3, 5, 1),
    (1, 4, 5, 1),
    (2, 1, 5, 1),
    (2, 3, 5, 1),
    (2, 4, 5, 1),
    (2, 5, 5, 1),
    (3, 1, 5, 1),
    (3, 3, 5, 1),
    (3, 4, 5, 1),
    (3, 7, 5, 1),
    (4, 1, 5, 1),
    (4, 3, 5, 1),
    (4, 4, 5, 1),
    (4, 8, 5, 1),
    (5, 1, 5, 1),
    (5, 3, 5, 1),
    (5, 4, 5, 1),
    (5, 9, 5, 1),
    (6, 1, 5, 1),
    (6, 3, 5, 1),
    (6, 4, 5, 1),
    (6, 10, 5, 1),
    (6, 11, 5, 1),
    (7, 1, 5, 1),
    (7, 3, 5, 1),
    (7, 4, 5, 1),
    (7, 12, 5, 1),
    (7, 13, 5, 1),
    (8, 1, 5, 1),
    (8, 3, 5, 1),
    (8, 4, 5, 1),
    (8, 14, 5, 1),
    (8, 15, 5, 1),
    (9, 1, 5, 1),
    (9, 3, 5, 1),
    (9, 4, 5, 1),
    (9, 16, 5, 1),
    (9, 17, 5, 1),
    (10, 1, 5, 1),
    (10, 3, 5, 1),
    (10, 4, 5, 1),
    (10, 18, 5, 1),
    (10, 19, 5, 1),
    (11, 1, 5, 1),
    (11, 3, 5, 1),
    (11, 4, 5, 1),
    (11, 20, 5, 1),
    (11, 21, 5, 1),
    (12, 1, 5, 1),
    (12, 3, 5, 1),
    (12, 4, 5, 1),
    (12, 22, 5, 1),
    (12, 23, 5, 1),
    (13, 1, 5, 1),
    (13, 3, 5, 1),
    (13, 4, 5, 1),
    (13, 24, 5, 1),
    (13, 25, 5, 1),
    (14, 1, 5, 1),
    (14, 3, 5, 1),
    (14, 4, 5, 1),
    (14, 26, 5, 1),
    (14, 27, 5, 1);

-- table price
CREATE TABLE IF NOT EXISTS `price` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `price` FLOAT NOT NULL,
    `size_id` INT(11) NOT NULL,
    `pizza_id` INT(11) NOT NULL,
    FOREIGN KEY (`size_id`) REFERENCES `size`(`id`),
    FOREIGN KEY (`pizza_id`) REFERENCES `pizza`(`id`)
) ;

INSERT INTO `price`(price, size_id, pizza_id) VALUES 
    (5.5, 1, 1),
    (7.5, 2, 1),
    (9.5, 3, 1),
    (6.5, 1, 2),
    (8.5, 2, 2),
    (10.5, 3, 2),
    (7.5, 1, 3),
    (9.5, 2, 3),
    (11.5, 3, 3),
    (8.5, 1, 4),
    (10.5, 2, 4),
    (12.5, 3, 4),
    (8.5, 1, 5),
    (10.5, 2, 5),
    (12.5, 3, 5),
    (9.5, 1, 6),
    (11.5, 2, 6),
    (13.5, 3, 6),
    (9.5, 1, 7),
    (11.5, 2, 7),
    (13.5, 3, 7),
    (9.5, 1, 8),
    (11.5, 2, 8),
    (13.5, 3, 8),
    (9.5, 1, 9),
    (11.5, 2, 9),
    (13.5, 3, 9),
    (9.5, 1, 10),
    (11.5, 2, 10),
    (13.5, 3, 10),
    (9.5, 1, 11),
    (11.5, 2, 11),
    (13.5, 3, 11),
    (9.5, 1, 12),
    (11.5, 2, 12),
    (13.5, 3, 12),
    (9.5, 1, 13),
    (11.5, 2, 13),
    (13.5, 3, 13),
    (9.5, 1, 14),
    (11.5, 2, 14),
    (13.5, 3, 14);

-- table order
CREATE TABLE IF NOT EXISTS `order` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `order_number` VARCHAR(255) NOT NULL,
    `date_order` DATETIME NOT NULL,
    `date_delivered` DATETIME,
    `status` VARCHAR(255) NOT NULL DEFAULT 'En cours',
    `user_id` INT(11) NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `user`(`id`)
);

-- table order_row
CREATE TABLE IF NOT EXISTS `order_row` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `quantity` INT(11) NOT NULL,
    `price` FLOAT NOT NULL,
    `order_id` INT(11) NOT NULL,
    `pizza_id` INT(11) NOT NULL,
    FOREIGN KEY (`order_id`) REFERENCES `order`(`id`),
    FOREIGN KEY (`pizza_id`) REFERENCES `pizza`(`id`)
);

SELECT p.id, p.name, p.image_path, pi.quantity, i.label, i.category, u.label AS unit, pr.price, s.label AS size
FROM pizza AS p 
INNER JOIN pizza_ingredient AS pi ON p.id = pi.pizza_id 
INNER JOIN ingredient AS i ON pi.ingredient_id = i.id
INNER JOIN unit AS u ON pi.unit_id = u.id
INNER JOIN price AS pr ON p.id = pr.pizza_id
INNER JOIN size AS s ON pr.size_id = s.id
WHERE p.id = 1;

