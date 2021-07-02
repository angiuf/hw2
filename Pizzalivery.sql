--Creazione Tabelle
CREATE TABLE menus(
id INTEGER PRIMARY KEY AUTO_INCREMENT,
num_pizze INTEGER,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)
engine='InnoDB';

--Aggiunto Immagine e Descrizione; 
CREATE TABLE pizzerias(
id INTEGER PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(20),
image VARCHAR(50),
description VARCHAR(400),
opening DATE,
address VARCHAR(50),
menu_id INTEGER NOT NULL,
age INTEGER,
discount DECIMAL(5, 1),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
INDEX menu_idx(menu_id),
FOREIGN KEY(menu_id) REFERENCES menus(id))
Engine='InnoDB';

CREATE TABLE users(
id INTEGER PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(20),
surname VARCHAR(20),
email VARCHAR(50),
username VARCHAR(20),
password VARCHAR(100),
address VARCHAR(50),
phone VARCHAR(10),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)
Engine='InnoDB';

--Nuova Tabella
CREATE TABLE favorites(
user_id INTEGER,
pizzeria_id INTEGER,
INDEX cliente_idx(user_id),
INDEX pizzeria_idx(pizzeria_id),
FOREIGN KEY(user_id) REFERENCES users(id),
FOREIGN KEY(pizzeria_id) REFERENCES pizzerias(id),
PRIMARY KEY(user_id, pizzeria_id))
Engine='InnoDB';

CREATE TABLE pizzas(
id INTEGER PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(20),
image VARCHAR(50),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)
Engine='InnoDB';

CREATE TABLE order_infos(
id INTEGER PRIMARY KEY AUTO_INCREMENT,
user_id INTEGER,
total DECIMAL(5,2),
date DATE,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
INDEX cliente_idx(user_id),
FOREIGN KEY(user_id) REFERENCES users(id))
Engine='InnoDB';

CREATE TABLE orders(
order_info_id INTEGER,
pizzeria_id INTEGER,
pizza_id INTEGER,
cost DECIMAL(5,2),
quantity INTEGER,
INDEX order_idx(order_info_id),
INDEX pizzeria_idx(pizzeria_id),
INDEX pizza_idx(pizza_id),
FOREIGN KEY(order_info_id) REFERENCES order_infos(id),
FOREIGN KEY(pizzeria_id) REFERENCES pizzerias(id),
FOREIGN KEY(pizza_id) REFERENCES pizzas(id),
PRIMARY KEY(order_info_id, pizza_id, pizzeria_id))
Engine='InnoDB';

CREATE TABLE menu_pizza(
menu_id INTEGER,
pizza_id INTEGER,
cost DECIMAL(4,2),
INDEX menu_idx(menu_id),
INDEX pizza_idx(pizza_id),
FOREIGN KEY(menu_id) REFERENCES menus(id),
FOREIGN KEY(pizza_id) REFERENCES pizzas(id),
PRIMARY KEY(menu_id, pizza_id))
Engine='InnoDB';

CREATE TABLE ingredients(
id INTEGER PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(20),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)
Engine='InnoDB';

CREATE TABLE composition(
pizza_id INTEGER,
ingredient_id INTEGER,
INDEX pizza_index(pizza_id),
INDEX ingredient_index(ingredient_id),
FOREIGN KEY(pizza_id) REFERENCES pizzas(id),
FOREIGN KEY(ingredient_id) REFERENCES ingredients(id),
PRIMARY KEY(pizza_id, ingredient_id))
Engine='InnoDB';

--Trigger
--Allinea l'attributo ridondante Eta_pizzeria
DELIMITER //
CREATE TRIGGER age_pizzeria
BEFORE INSERT ON pizzerias
FOR EACH ROW
BEGIN
SET NEW.age=TIMESTAMPDIFF(YEAR,NEW.opening, CURDATE());
END //
DELIMITER ;
--select * from pizzeria;

DELIMITER //
CREATE PROCEDURE aggiorna_eta_pizzeria()
BEGIN
UPDATE pizzerias
SET age=TIMESTAMPDIFF(YEAR, opening, CURDATE());
END //
DELIMITER ;


--Allinea l'attributo ridondante Num_pizze
DELIMITER //
CREATE TRIGGER num_pizze
AFTER INSERT ON menu_pizza
FOR EACH ROW
BEGIN
UPDATE menus
SET num_pizze = (SELECT count(*) FROM menu_pizza WHERE menu_pizza.menu_id=New.menu_id) WHERE id=NEW.menu_id;
END //
DELIMITER ;

--Allinea l'attributo ridondante prezzo
DELIMITER //
CREATE TRIGGER Calc_cost
BEFORE INSERT ON orders
FOR EACH ROW
BEGIN
IF((SELECT discount FROM pizzerias WHERE pizzerias.id=NEW.pizzeria_id) IS NOT NULL AND (SELECT date FROM order_infos WHERE id = NEW.order_info_id)=CURDATE()) THEN
SET NEW.cost=(SELECT cost FROM menu_pizza P WHERE P.menu_id=(SELECT menu_id FROM pizzerias PZ WHERE PZ.id=NEW.pizzeria_id) AND P.pizza_id=NEW.pizza_id) * NEW.quantity
*(1-((SELECT discount FROM pizzerias PZ1 WHERE PZ1.ID=NEW.pizzeria_id)/100));
ELSE
SET NEW.cost=(SELECT cost FROM menu_pizza P WHERE P.menu_id=(SELECT menu_id FROM pizzerias PZ WHERE PZ.id=NEW.pizzeria_id) AND P.pizza_id=NEW.pizza_id)*NEW.quantity;
END IF;
END //
DELIMITER ;

--Controlla che la pizza sia presente nel menu della pizzeria
DELIMITER //
CREATE TRIGGER Controlla_pizza_pizzeria
BEFORE INSERT ON orders
FOR EACH ROW
BEGIN
IF NOT EXISTS(SELECT * FROM menu_pizza P WHERE P.menu_id=(SELECT menu_id FROM pizzerias PZ WHERE PZ.id=NEW.pizzeria_id) AND P.pizza_id=NEW.pizza_id) THEN
Signal SQLSTATE '45000' SET MESSAGE_TEXT="La pizza non è presente nel menu della pizzeria";
END IF;
END //
DELIMITER ;

--Operazioni
--OP1
CREATE VIEW Clienti_completo AS
SELECT C.id AS ID, C.name AS Name, C.surname AS Surname, P.id AS ID_Pizza, P.name AS Pizza, sum(quantity) AS Num_pizze_ordinate
FROM users C LEFT JOIN Order_infos OI ON C.id=OI.user_id
JOIN orders O ON OI.id=O.order_info_id
JOIN pizzas P ON O.pizza_id=P.id
GROUP BY C.ID, P.ID;


DELIMITER //
CREATE PROCEDURE OP1
(In user INTEGER)
BEGIN
DROP TEMPORARY TABLE IF EXISTS Pizze_pref;
CREATE TEMPORARY TABLE Pizze_pref AS
SELECT ID_Pizza, Num_pizze_ordinate FROM Clienti_completo WHERE Num_pizze_ordinate = 
(SELECT max(Num_pizze_ordinate) FROM Clienti_completo WHERE ID=user) AND ID=user;
END //
DELIMITER ;

--OP3
DELIMITER //
CREATE PROCEDURE OP3
(IN Pizz INTEGER, IN Sc DECIMAL)
BEGIN
UPDATE pizzerias
SET discount = (CASE
	WHEN (DAYNAME(CURDATE()) = 'Friday' AND age=10) THEN Sc*2
	WHEN(DAYNAME(CURDATE()) = 'Tuesday' AND age=30) THEN Sc*1.5
	ELSE
		Sc
	END)
WHERE pizzerias.ID=Pizz;
END //
DELIMITER ;

--OP4
DELIMITER //
CREATE PROCEDURE OP4(
IN n INTEGER)
BEGIN
DROP TEMPORARY TABLE IF EXISTS Info_menu;
CREATE TEMPORARY TABLE Info_menu AS
SELECT * FROM menus M1 WHERE EXISTS(SELECT count(*) FROM menus M2 WHERE M2.num_pizze=M1.Num_pizze AND M2.id<>M1.id HAVING count(*) >= n);
END //
DELIMITER ;

