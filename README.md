# Olympiades des métiers
## Métier n°17 - Tech

### Présentation du site

#### Contexte

Le projet est appelé STEAMLANDIA, il s'agit d'un site de promotion d'un parc d'attractions fictif du même nom.
Le site permet entre autres de visualiser la liste des attractions proposées par les administrateurs du parc.

Au cours de sa visite, l'utilisateur est guidé sur chacune des pages du site. Il peut par exemple consulter les attractions du parc, triéss par univers thématique, et voir davantage d'informations sur chacune d'entre elles sur leur page dédiée. Il découvre le thème du parc, ses univers et attractions correspondantes ainsi que les différents tarifs.

#### Espace Client

Chaque utilisateur est en mesure de se créer un compte gratuit identifiable par son adresse mail. Une adresse mail ne peut être assignée qu'à un seul utilisateur, un seul compte client. Le mot de passe est hashé et cette variable n'est jamais stockée en clair dans la base de données. Le client peut aussi choisir de saisir un nom et un prénom.
Les adresses mail doivent avoir un format valide (example@host.com), et les mots de passe doivent comporter au moins 12 caractères.  
La création du compte est refusée si :
- L'adresse mail est déjà utilisée pour un autre compte ou non valide ;
- Le mot de passe ne contient pas suffisamment de caractères ;
- Un problème de connexion à la base de données survient.

Après s'être inscrit, l'utilisateur est redirigé sur l'interface de connexion, sur laquelle il doit saisir à nouveau ses identifiants de connexion pour accéder à son espace client.

Une fois connecté, l'utilisateur peut voir la liste complète de ses réservations
Il a aussi accès à une interface Billetterie, sur laquelle il peut réserver une place selon 3 forfaits différents :
- Adulte de plus de 12 ans pour 20€ ;
- Enfant entre 3 et 11 ans pour 15€ ;
- Junior de moins de 3 ans gratuit.
Une fois la commande réalisée, son billet est affiché dans m'onglet Mes Réservations.

#### Espace Administrateur

Le site dispose d'un Compte Administrateur, accessible uniquement sur authentification sécurisée. Il doit d'abord s'identifier en saisissant l'adresse 'localhost/Views/Admin/login.php', non accessible pour un visiteur classique.
L'administrateur saisit ensuite ses identifiants de connexion :
- Identifiant : "admin" ;
- Mot de passe : "admin" ;

Une fois authentifié, ce dernier à accès à la supervision de toutes les attractions du parc sur la page d'accueil.
Il dispose de 3 autres onglets lui permettant l'ajout, la modification et la suppression d'attractions.

Pour valider la création d'une attraction, il doit saisir un nom, une description courte, un statut par défaut, une taille d'accès minimale en centimètres, sélectionner l'univers rattaché à cette attraction, et choisir une image de présentation.

L'ajout et la modification sont effectives immédiatement au clic du bouton correspondant, et sur validation du formulaire par le serveur.
La suppression en revanche, doit être validée une seconde fois par l'administrateur par le biais d'une pop-up de confirmation.



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

L'utilisateur débite sa navigation sur une page d'accueil parlante : nom du parc et slogan, avec animations fluides.
Il dispose aussi d'un bouton de découverte des attractions le menant dans l'onglet Attractions.

La page Attractions comporte le même design que la page d'accueil et liste l'intégralité des attractions mises en ligne par l'administrateur.
Chaque attraction est affichée grâce à une requête SQL à l'affichage de la page. Elles sont alors présentées et triées par univers, affichant son nom, sa description, la taille minimale d'accès et son statut. Un bouton "Voir plus" est aussi apposé sur chaque bandeau, menant à une page de description plus complète de chacune d'entre elles.









### Bugs et fonctionnalités non effectives

#### Statut

Le statut est stocké en base de données comme un entier ayant comme valeur possible 1, 2 et 3, correspondant à "Ouvert", "Fermé", et "En panne".
Ce statut est affiché sous la forme d'entier dans certaines pages et non comme il devrait l'être sur l'interface utilisateur.

#### Page d'erreur customisée

Il était demandé de réaliser une page d'erreur propre à afficher si l'utilisateur essaie d'accéder à une page non existante, ce qui n'a pas pu être fait.