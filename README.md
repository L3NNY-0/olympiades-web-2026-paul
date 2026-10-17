# Olympiades des métiers
## Métier n°17 - Technologies web

### Présentation du site

#### Contexte

Le projet est appelé STEAMLANDIA, il s'agit d'un site de promotion d'un parc d'attractions fictif du même nom.
Le site permet entre autres de visualiser la liste des attractions proposées par les administrateurs du parc.

Au cours de sa visite, l'utilisateur est guidé sur chacune des pages du site. Il peut par exemple consulter les attractions du parc, triéss par univers thématique, et voir davantage d'informations sur chacune d'entre elles sur leur page dédiée. Il découvre le thème du parc, ses univers et attractions correspondantes ainsi que les différents tarifs.



### Déploiement du projet

#### Site

Pour déployer localement le projet, il est suggéré d'utiliser une solution web locale comme XAMPP ou Laragon.
Allez au dossier racine de votre service (/htdocs/ pour XAMPP et /www/ pour Laragon), et collez-y l'intégralité des fichiers du repo GitHub, en veillant bien à voir le fichier index.php dans ce dossier.

#### Base de données

Dans le même répertoire que cette documentation, se trouve un fichier jeu_donnees.sql, copiez l'intégralité de son contenu et collez-le directement dans le terminal de base de données associé à votre solution d'hébergement locale.

#### Lancement

Une fois les fichiers du site correctement placés et la base de données créée avec les données de test, vérifiez que Apache et MySQL soient bien lancés sur XAMPP par exemple, puis saisissez simplement 'localhost' sur votre navigateur. Le site devrait s'afficher.



### Fonctionnalités

#### Liaison à la base de données

Toutes les pages qui ne sont pas statiques comportent une connexion à la base de données.
Le site étant développé en PHP, il utilise l'extension PDO (PHP Data Objects) pour y accéder.
Cette extension permet non seulement de se connecter à une base aisément, mais aussi de le faire de manière sécurisé grâce à des requêtes préparées, évitant donc les attaques par injection SQL.

Pour les requêtes SQL les plus simples, les fichiers font appel à la fonction requeteBdd() du fichier 'Models\database.php', qui retourne un tableau associatif de données contenu dans la table correspondante.

Pour les autres, une nouvelle connexion est réitérée. La requête est effectuée, les données sont récupérées puis affichées sur l'interface correspondante.
Chaque requête est effectuée par un utilisateur adapté, et chaque utilisateur suit le pincipe de moindre privilège : uniquement les droits nécessaires pour sa navigation sur le site, tous les autres sont refusés.

#### Palier 1 - Le parc en ligne

1. Page d'accueil
L'utilisateur déuite sa navigation sur une page d'accueil parlante : nom du parc et slogan, avec animations fluides.
Il dispose aussi d'un bouton de découverte des attractions le menant dans l'onglet Attractions.

2. Page Attractions
La page Attractions comporte le même design que la page d'accueil et liste l'intégralité des attractions mises en ligne par l'administrateur.
Chaque attraction est affichée grâce à une requête SQL à l'affichage de la page. Elles sont alors présentées et triées par univers, affichant son nom, sa description, la taille minimale d'accès et son statut. Un bouton "Voir plus" est aussi apposé sur chaque bandeau, menant à une page de description plus complète de chacune d'entre elles.

3. Page par attraction
Chaque attraction dispose donc d'une page dédiée unique, affichant plus précisemment chaque attribut de cette dernière. L'image d'accueil en arrière-plan correspond à la vignette de présentation affichée sur la liste globale de la page Attractions.


#### Palier 2 - Espace Administrateur

1. Connexion
L'administrateur se connecte avec un identifiant et un mot de passe. Ce mot de passe n'est jamais affiché ni enregistré en clair, il est toujours hashé, transformé de façon irréversible avec l'algorithme de chiffrement BCRYPT.

2. Accès
Les pages de l'espace administrateur ne sont jamais accessibles sans connexion, si un utilisateur tente d'afficher le tableau de bord par exemple, il est immédiatement redirigé vers le formulaire de connexion. Ce formulaire n'est d'ailleurs accessible qu'en saisissant son URL, aucun lien cliquable n'est présent sur le site.
Tous les formulaires utilisent des requêtes préparées et sont donc protégés contre les injections SQL.

3. Fonctions
L'administrateur peut ajouter, modifier, et supprimer une attraction ainsi que changer son statut. Une confirmation est demandée avant chaque suppression, et le serveur refuse un formulaire mal rempli.

Le site dispose d'un Compte Administrateur, accessible uniquement sur authentification sécurisée. Il doit d'abord s'identifier en saisissant l'adresse 'localhost/Views/Admin/login.php', non accessible pour un visiteur classique.
L'administrateur saisit ensuite ses identifiants de connexion :
- Identifiant : "admin" ;
- Mot de passe : "admin" ;

Pour valider la création d'une attraction, il doit saisir un nom, une description courte, un statut par défaut, une taille d'accès minimale en centimètres, sélectionner l'univers rattaché à cette attraction, et choisir une image de présentation.

L'ajout et la modification sont effectives immédiatement au clic du bouton correspondant, et sur validation du formulaire par le serveur.
La suppression en revanche, doit être validée une seconde fois par l'administrateur par le biais d'une pop-up de confirmation en JavaScript.

#### Palier 3 - Billetterie

1. Création de compte
Chaque utilisateur est en mesure de se créer un compte gratuit identifiable par son adresse mail. Une adresse mail ne peut être assignée qu'à un seul utilisateur, un seul compte client. Le mot de passe est hashé et cette variable n'est jamais stockée en clair dans la base de données. Le client peut aussi choisir de saisir un nom et un prénom.
Les adresses mail doivent avoir un format valide (example@host.com), et les mots de passe doivent comporter au moins 12 caractères.  
La création du compte est refusée si :
- L'adresse mail est déjà utilisée pour un autre compte ou non valide ;
- Le mot de passe ne contient pas suffisamment de caractères ;
- Un problème de connexion à la base de données survient.
Après s'être inscrit, l'utilisateur est redirigé sur l'interface de connexion, sur laquelle il doit saisir à nouveau ses identifiants de connexion pour accéder à son espace client.

2. Billets
Une fois connecté, l'utilisateur peut voir la liste complète de ses réservations
Il a aussi accès à une interface Billetterie, sur laquelle il peut réserver une place selon 3 forfaits différents :
- Adulte de plus de 12 ans pour 20€ ;
- Enfant entre 3 et 11 ans pour 15€ ;
- Junior de moins de 3 ans gratuit.
Une fois la commande réalisée, son billet est affiché dans m'onglet Mes Réservations.



### Bugs et fonctionnalités non effectives

#### Statut

Le statut est stocké en base de données comme un entier ayant comme valeur possible 1, 2 et 3, correspondant à "Ouvert", "Fermé", et "En panne".
Ce statut est affiché sous la forme d'entier dans certaines pages et non comme il devrait l'être sur l'interface utilisateur.

#### Page d'erreur customisée

Il était demandé de réaliser une page d'erreur propre à afficher si l'utilisateur essaie d'accéder à une page non existante, ce qui n'a pas pu être fait.

#### Billetterie

Le serveur ne calcule pas le total des billets, et n'effectue pas de faux paiement.
La limitation à 2000 billets par jour n'a pas pu être réalisée.



### Choix techniques

#### Hebergement local

J'ai décidé d'utiliser XAMPP comme solution web locale car il s'agit d'un outil accessible, avec une interface lisible et avec lequel j'ai l'habitude de travailler.
MariaDB est aussi un Système de Gestion de Base de Données Relationnelles que j'apprécie.

#### Figma
 
Le choix du design graphique s'est fait en manipulant Figma et les composants qu'il propose.
Lien Figma : https://www.figma.com/design/OdaTpBSjpk32YszDJGF360/Sans-titre?node-id=0-1&t=TxAFEgNTL0ZTrniW-1