INSERT INTO pizzas(name, image)
VALUES
	('Margherita', "images/margherita.jpg"),
	('Biancaneve', "images/biancaneve.jpg"),
	('Capricciosa', "images/capricciosa.jpg"),
	('Norma', "images/norma.jpg"),
	('Pistacchio', "images/pistacchio.jpg"),
	('Diavola', "images/diavola.jpg"),
	('Romana', "images/romana.jpg"),
	('Parmigiana', "images/parmigiana.jpg"),
	('Quattro formaggi', "images/quattro_formaggi.jpg"),
	('Patapizza', "images/patapizza.jpg");
	

INSERT INTO menus(Num_pizze)
VALUES
	(NULL),
	(NULL),
	(NULL),
	(NULL),
	(NULL),
	(NULL),
	(NULL),
	(NULL);

INSERT INTO menu_pizza(menu_id, pizza_id, cost)
VALUES
	(1, 1, 6.50),
	(1, 2, 7.50),
	(1, 3, 8),
	(2, 1, 6),
	(2, 10, 7),
	(3, 1, 5.50),
	(3, 3, 9),
	(3, 4, 6),
	(3, 5, 7.50),
	(4, 4, 6.50),
	(4, 6, 7.90),
	(4, 8, 10),
	(5, 2, 4),
	(5,7, 8.90),
	(5, 9, 11),
	(6, 7, 12);

INSERT INTO pizzerias(name, image, description, opening, address, menu_id, age, discount)
VALUES
	("Pizzeria la Pace", "images/pippo's.jpg", "La pizzeria più fashion della città", '2010-03-15', "Via Milano 120", 1, NULL, NULL),
	("Pippo's", "images/pizzeria_2.jpg", "Pippo's è la più antica pizzeria di Catania", '2008-09-17', "Via Firenze 77", 2, NULL, NULL),
	("Da Giuseppe", "images/pizzeria_3.jpg", "Vieni a provare l'inimitabile pizza di compare Giuseppe", '2001-11-18', "Via Leucatia 58", 3, NULL, NULL),
	("1000 Gradi", "images/pizzeria_4.jpg", "Vieni, mangia e fai un giro in centro!", '1990-04-26', "Lungomare 170", 4, NULL, NULL),
	("Pizzeria 1 cereale", "images/pizzeria_5.jpg", "Prodotti rigorosamente biologici e impasti ad alta digeribilità", '1982-12-04', "Via Messina 97", 5, NULL, NULL),
	("10elode", "images/pizzeria_6.jpg", "L'unica con la pizza da 10 e lode", '2015-10-17', "Via Napoli 89", 6, NULL, NULL),
	("Don Carmelo", "images/pizzeria_7.jpg", "Tradizione e gusto solo da Don Carmelo", '1985-06-15', "Via Trieste 14", 7, NULL, NULL),
	("Seaside", "images/pizzeria_8.jpg", "Gustati la miglior pizza con un panorama mozzafiato", '1999-06-15', "Via Genova 51", 8, NULL, NULL);
	
INSERT INTO ingredients(name)
VALUES
	('Pomodoro'),
	('Mozzarella'),
	("Prosciutto cotto"),
	('Funghi'),
	('Olive'),
	("Crema di Pistacchio"),
	('Pistacchio'),
	("Salame Piccante"),
	('Acciughe'),
	("Patatine Fritte"),
	("Wurstel"),
	("Melanzane"),
	("Ricotta salata"),
	("Gorgonzola"),
	("Fontina"),
	("Grana");

INSERT INTO composition(pizza_id, ingredient_id)
VALUES
	(1, 1),
	(1, 2),
	(2, 2),
	(3, 1),
	(3, 2),
	(3, 3),
	(3, 4),
	(3, 5),
	(4, 1),
	(4, 2),
	(4, 12),
	(4, 13),
	(5, 2),
	(5, 6),
	(5, 7),
	(6, 1),
	(6, 2),
	(6, 8),
	(7, 1),
	(7, 2),
	(7, 9),
	(8, 1),
	(8, 2),
	(8, 12),
	(8, 13),
	(9, 2),
	(9, 14),
	(9, 15),
	(9,16),
	(10, 1),
	(10, 2),
	(10, 10),
	(10, 11);

