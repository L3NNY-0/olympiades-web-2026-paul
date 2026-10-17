## A coller directement dans le terminal


## Creation de la base de donnees
DROP DATABASE IF EXISTS olympiade;
CREATE DATABASE olympiade;

USE olympiade;

DROP TABLE IF EXISTS univers;
DROP TABLE IF EXISTS attraction;
DROP TABLE IF EXISTS spectacle;
DROP TABLE IF EXISTS seance;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS billet;

## Creation des tables de la base
CREATE TABLE `univers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE univers AUTO_INCREMENT = 1;

CREATE TABLE `attraction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `taille_cm` int(11) DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  `url_img` varchar(75) DEFAULT NULL,
  `id_univers` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_univers` (`id_univers`),
  CONSTRAINT `attraction_ibfk_1` FOREIGN KEY (`id_univers`) REFERENCES `univers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE attraction AUTO_INCREMENT = 1;

CREATE TABLE `spectacle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `id_univers` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_univers` (`id_univers`),
  CONSTRAINT `spectacle_ibfk_1` FOREIGN KEY (`id_univers`) REFERENCES `univers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE spectacle AUTO_INCREMENT = 1;

CREATE TABLE `seance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_spectacle` int(11) DEFAULT NULL,
  `horaire` time DEFAULT NULL,
  `nb_places` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_spectacle` (`id_spectacle`),
  CONSTRAINT `seance_ibfk_1` FOREIGN KEY (`id_spectacle`) REFERENCES `spectacle` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE seance AUTO_INCREMENT = 1;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE users AUTO_INCREMENT = 1;

CREATE TABLE `billet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_util` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `billet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE billet AUTO_INCREMENT = 1;


## Jeu de donnees de test
INSERT INTO univers (nom, description) VALUES ("La Vallee des Dirigeables", "Decouvrez la beaute de la Cite Industrielle vue du ciel a bord de nos dirigeables nouvelle generation.");
INSERT INTO univers (nom, description) VALUES ("Le Quartier de l'industrie", "Plongez au coeur des fondations de la Cite, explorez chaque recoin des usines et ateliers fondateur de l'Industrie.");

INSERT INTO attraction (nom, description, statut, taille_cm, url_img, id_univers) VALUES ("Voyage au-dessus des Mondes", "Embarquez pour une balade aerienne inoubliable en survolant les univers de la Cite Industrielle.", 1, 150, "voyage_mondes", 1);
INSERT INTO attraction (nom, description, statut, taille_cm, url_img, id_univers) VALUES ("La Grande Parade", "Venez decouvrir la beaute des merveilles aeriennes de la Cite Industrielle a l'occasion de la Grande Parade des Dirigeables.", 1, 0, "grande_parade", 1);
INSERT INTO attraction (nom, description, statut, taille_cm, url_img, id_univers) VALUES ("Le Colosse d'Helios", "Osez monter dans le celebre train a vapeur du Dr. Victoria et faire face a sa nouvelle invention : Le Colosse d'Helios.", 1, 160, "colosse_helios", 2);
INSERT INTO attraction (nom, description, statut, taille_cm, url_img, id_univers) VALUES ("L'atelier du Dr. Victoria", "Plongez au coeur de l'usine d'une des meres fondatrices de la Cite dans cette visite a couper le souffle.", 1, 140, "atelier_dr_victoria", 2);

INSERT INTO users (username, password, nom, prenom) VALUES ("admin", "$2y$10$8FAZ9SDxDJXbLAKzf0lPWu7cFxG8nOMuU1Vw1nCOfJN/st2bwpimK", NULL, NULL);
