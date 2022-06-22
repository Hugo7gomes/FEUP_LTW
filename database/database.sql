	/*CRIAR*/

drop table if exists Category;

drop table if exists User;

drop table if exists Restaurant;

drop table if exists Dishes;

drop table if exists Review;

drop table if exists Orders;

drop table if exists FavoriteRestaurant;

drop table if exists FavoriteDish;

drop table if exists OrderDish;

drop table if exists Answers;

create table User(
					UserId INTEGER,
					Password VARCHAR(255) NOT NULL,
					Address VARCHAR(255),
					PhoneNumber CHAR(9),
					Email VARCHAR(255) NOT NULL,
					Name VARCHAR(255) NOT NULL,

					CONSTRAINT UNIQUE_User_Email UNIQUE (Email),
					CONSTRAINT UNIQUE_User_PhoneNumber UNIQUE (PhoneNumber),
					CONSTRAINT PK_User PRIMARY KEY (UserId)
);


create table Restaurant(
					RestaurantId INTEGER,
					UserId INTEGER NOT NULL,
					Name NVARCHAR(255) NOT NULL,
					PhoneNumber CHAR(9) NOT NULL,
					Email VARCHAR(255),
					CategoryName VARCHAR(255) NOT NULL,
					Address VARCHAR(255) NOT NULL,

					CONSTRAINT UNIQUE_Restaurant_Email UNIQUE (Email),
					CONSTRAINT UNIQUE_Restaurant_Name UNIQUE (Name),
					CONSTRAINT UNIQUE_Restaurant_PhoneNumber UNIQUE (PhoneNumber),
					CONSTRAINT PK_Restaurant PRIMARY KEY (RestaurantId),
					CONSTRAINT FOREIGNKEY_UserId FOREIGN KEY (UserId) REFERENCES User(UserId)
);

create table Review(
					ReviewId INTEGER,
					RestaurantId INTEGER NOT NULL,
					Score INTEGER NOT NULL,
					Comment VARCHAR(255) NOT NULL,
					UserId INTEGER NOT NULL,

			
					CONSTRAINT PK_Review PRIMARY KEY (ReviewId),
					CONSTRAINT FOREIGNKEY_UserId FOREIGN KEY (UserId) REFERENCES User(UserId),					
					CONSTRAINT FOREIGNKEY_RestaurantId FOREIGN KEY (RestaurantId) REFERENCES Restaurant(RestaurantId)
);

create table Dishes(
					DishId INTEGER,
					Name VARCHAR(255) NOT NULL,
					Price REAL NOT NULL,
					RestaurantId INTEGER NOT NULL,

			
					CONSTRAINT PK_Dishes PRIMARY KEY (DishId),					
					CONSTRAINT FOREIGNKEY_RestaurantId FOREIGN KEY (RestaurantId) REFERENCES Restaurant(RestaurantId)
);

create table Orders(
					OrderId INTEGER,
					RestaurantId INTEGER NOT NULL,
					State VARCHAR(255) NOT NULL,
					UserId INTEGER NOT NULL,

					CONSTRAINT CHECK_Orders_State CHECK (State = 'Ready' or State = 'Received' or State = 'Preparing' or State = 'Delivered'),
					CONSTRAINT PK_Orders PRIMARY KEY (OrderId),
					CONSTRAINT FOREIGNKEY_UserId FOREIGN KEY (UserId) REFERENCES User(UserId),										
					CONSTRAINT FOREIGNKEY_RestaurantId FOREIGN KEY (RestaurantId) REFERENCES Restaurant(RestaurantId)
);

create table OrderDish(
	OrderId INTEGER,
	DishId INTEGER NOT NULL,

	CONSTRAINT PK_Orders PRIMARY KEY (OrderId, DishId),
	CONSTRAINT FOREIGNKEY_OrderId FOREIGN KEY (OrderId) REFERENCES Orders(OrderId),
	CONSTRAINT FOREIGNKEY_DishId FOREIGN KEY (DishId) REFERENCES Dishes(DishId)
);

create table FavoriteRestaurant(
					RestaurantId INTEGER NOT NULL,
					UserId INTEGER NOT NULL,

					CONSTRAINT PK_Favorite_Restaurant_User PRIMARY KEY (RestaurantId,UserId)
);

create table FavoriteDish(
		DishId INTEGER NOT NULL,
		UserId INTEGER NOT NULL,

		CONSTRAINT PK_Favorite_Dish_User PRIMARY KEY (DishId,UserId)
);

create table Answers(
		RestaurantId INTEGER,
		ReviewId INTEGER,
		Answer VARCHAR(255) NOT NULL,

		CONSTRAINT PK_Review PRIMARY KEY (ReviewId, RestaurantId),
		CONSTRAINT FOREIGNKEY_RestaurantId FOREIGN KEY (RestaurantId) REFERENCES Restaurant(RestaurantId),
		CONSTRAINT FOREIGNKEY_ReviewId FOREIGN KEY (ReviewId) REFERENCES Review(ReviewId)
);



/*POVOAR*/
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (1, 'Art Pizza', '220902067', 'artPizza@gmail.com','R. de São Brás 483, 4000-143 Porto', 'Pizza');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (1, 'Luzzo', '221100159','luzzoPizza@gmail.com', 'R. de Mouzinho da Silveira 115, 4050-421 Porto','Pizza');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (1, 'Bella Mia','934895680', 'bellamia@gmail.com','R. do Ferraz 22, 4050-141 Porto','Pizza');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (2,'Iber Sushi','227837227','iberSushi@gmail.com','R. 25 de Abril 2580, 4415-079','Sushi');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (2,'Yes Sushi','226001333','yesSushi@gmail.com',' Av. da Boavista 1711','Sushi');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (2,'Genki Sushi','223491249','genkisushi@gmail.com',' Av. do Dr. Antunes Guimarães','Sushi');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (3,'O prego Cia','222427868','opregoCia@gmail.com','R. Vasques de Mesquita 98','FastFood');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (3,'Nook','220124895','nook@gmail.com','R. São João de Brito 36','FastFood');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (3,'McDonald','226066515','mcDonalds@gmail.pt','Av. Boavista, nº1745, 4100-133','FastFood');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (4,'EGA','224918832','ega@gmail.com','R. de Cedofeita 378, 4050-174', 'Italian');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (4,'Fornaio 178','220124175','fornaio@gmail.com','R. Francois Guichard 128C', 'Italian');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (4,'PRIMA DONA','226162161','primaDona@gmail.com','R. Correia de Sá 15, 4150-229', 'Italian');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (5,'Li-Jin','226175072','liJin@gmail.com','R. São João de Brito 35', 'Chinese');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (5,'King Long','222053988','kingLong@gmail.com','Largo do Dr. Tito Fontes 115', 'Chinese');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (5,'Hua Fu','225490948','huaFu@gmail.com','Av. de Fernão de Magalhães', 'Chinese');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (6, 'Antunes','222052406','antunes@gmail.com','R. do Bonjardim 525', 'Traditional');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (6,'Casa Guedes','222002874','casaguedes@gmail.com','Praça dos Poveiros 130', 'Traditional');
INSERT INTO Restaurant (UserId, Name, PhoneNumber, Email, Address,CategoryName) VALUES (6,'A Cozinha do Manel','225363388','cozinhaManue@gmail.com',' Rua do Heroísmo 215', 'Traditional');

INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Pizza Margarita', 9.50, 10);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Tagliatelle Bolonhesa', 10.40, 10);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Lasanha de Carne', 10.60, 11);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Lasanha Vegetariana', 10.80, 11);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Pizza Caprichosa', 13.00, 12);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Pizza Bresaola', 17.43, 12);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Pato Pequim', 15.40, 13);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Chop-suey de Camarão', 15.50, 13);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Chop-suey de Frango', 15.50, 14);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Vaca com camarão', 14.50, 14);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Crepe chinês', 2.00, 15);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Bacalhau à Braga', 12.50, 16);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Lulas Grelhadas', 7.90, 16);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Lombo no Forno', 14.00, 17);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Cozido à Portuguesa', 13.30, 17); 
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Feijoada', 16.00, 18);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Arroz de Cabidela', 14.50, 18); 
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Pizza Margarita', 8.50, 1);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Pizza Havaiana', 7.30, 1);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Pizza Caprichosa', 12.00, 2);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Pizza Vegetariana', 9.40, 2);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Pizza Camponesa', 10.40, 3);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Pizza Tropical', 9.50, 3);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Crepes de Legumes', 2.60, 4);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Espetadas de Gambas', 4.30, 4);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Sashimi', 5.50, 5);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Hossomaki Camarão', 5.50, 5);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Nigiri Salmão', 8.30, 6);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Temaki de Camarão', 4.30, 6);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Cachorro', 7.20, 7);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Hamburguer', 8.10, 9);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Batatas Fritas', 3.50, 8);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Asas de Frango', 4.30, 8);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Nuggets', 4.40, 7);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Gelado', 3.20, 10);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Waffle com Nutella', 3.00, 12);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Brownie', 2.50, 15);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Bolo de Bolacha', 2.20, 18);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Natas do Céu', 3.40, 16);
INSERT INTO Dishes (Name, Price, RestaurantId) VALUES ('Fruta', 3.00, 17);

INSERT INTO Review (RestaurantId, Score, Comment, UserId) VALUES (1, 3,'Restaurante mau', 1);
INSERT INTO Review (RestaurantId, Score, Comment, UserId) VALUES (1, 5,'Restaurante muito bom', 2);
INSERT INTO Review (RestaurantId, Score, Comment, UserId) VALUES (1, 4,'Restaurante muito bom', 3);


INSERT INTO Answers (RestaurantId, ReviewId, Answer) VALUES (1, 1,'Obrigado pela sua review');
INSERT INTO Answers (RestaurantId, ReviewId, Answer) VALUES (1, 2,'Obrigada pela sua review');
INSERT INTO Answers (RestaurantId, ReviewId, Answer) VALUES (1, 3,'Obrigado pela seu comentário :)');