ALTER TABLE TrashesTypes ADD eco_point integer;
alter table TrashesTypes add degradation text;

INSERT INTO `TrashesTypes`(`id`, `name`, `eco_point`, `degradation`) VALUES
(1,'Plastique',8,'1000 years'),
(2,'Metal',4,'200 years'),
(3,'Carton',3,'about several month'),
(4,'Papier',3,'about several month'),
(5,'Verre',10,'4000 years'),
(6,'Dechet menager',2,'about several month'),
(7,'Produit toxique',2,'10 years'),
(8,'Encombrant',10,'2000 years'),
(9,'Dechets verts',2,'about several day'),
(10,'Equipement electronique',15,'2000 ans'),
(11,'Piles, Cartouches et Ampoules',15, '5000 years'),
(12,'Vetements uses',3,'100 years'),
(13,'Medicament',2,'about several month');

alter table Trashes add img_url text;