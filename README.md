# Talent Tracker
[![Pipeline-CI](https://github.com/drkaine/talent-tracker/actions/workflows/CI.yml/badge.svg)](https://github.com/drkaine/talent-tracker/actions/workflows/CI.yml)

Talent Tracker is a web application designed to track and manage talents. This project uses Laravel for the back end and React for the front end, with integration of TypeScript, Jest, ESLint, and other libraries.

## Test technique fullstack

- Le test devra être livré via un repository Github, GitLab ou Bitbucket privé.
- Les travaux devront pouvoir être testés sans aucune modification à apporter au code, ni paramétrage et, si besoin, en suivant pas à pas une documentation.
- Nous vous demandons de réaliser le test en utilisant la dernière version de Laravel et d'intégrer la stack React dans Laravel (grâce à Laravel Vite).
- Merci d'utiliser ReactJS dans sa dernière version stable, et de privilégier les librairies de notre stack : Axios, Tanstack Query, Zustand, Formik, Yup et Material UI. Sinon, utilisez la librairie qui vous semble la plus adaptée.
- Veillez à soigner votre historique git, comme s'il s'agissait d'une situation projet réelle.
- N'hésitez pas à poser des questions si vous avez besoin de clarifications.

## Exercices à réaliser

### ACT-R1 - Spécifications de la Stack

Création d'un site factice de gestion de candidats pour une entreprise d'intérim comportant la page suivante :
- Page de liste des candidats (homepage) (contenu défini en *ACT-R2*)

Description du modèle de données :
- Les candidats peuvent être attribués à des missions (mais jamais plusieurs en même temps)
- Les missions comporteront les informations suivantes : Date de début, Date de fin, Intitulé de poste. 

Génération des données :-
- Utilisez des seeders afin de remplir la base de données avec les jeux de données qui vous semblent nécessaires.

Vous réaliserez le modèle de données grâce à Laravel et exposerez les routes API nécessaires pour le front. Pour plus de simplicité, il **n'est pas nécessaire** de mettre en place une couche d'authentification.

### ACT-R2 - Page de liste des candidats

Page regroupant l'ensemble des candidats sous forme de liste. Indiquez dans cette liste les informations suivantes :
- Prénom + Nom, mission en cours et nombre total de missions attribuées

En objectif bonus (*ACT-R6*), il sera possible de supprimer chaque candidat.

### ACT-R3 - Tests unitaires et fonctionnels

Mettez en place un jeu de tests fonctionnels et unitaires pour le back et le front. Il n'est pas demandé de réaliser un coverage de 100%, il s'agit uniquement de voir comment vous pouvez mettre en place des tests de non-régression.-

### ACT-R4 - Liste des candidats en fin de mission

Réalisez une commande qui permettra d'afficher la liste des candidats finissant leur mission un jour donné. Le jour sera une option de la commande, la valeur par défaut sera la date du jour.

Le format de sortie sera sous forme de tableau et voici les informations à afficher: Prénom + Nom, Intitulé et dates de la mission en cours, Intitulé et dates de la mission à venir.  

### ACT-R5 - Bonus

Ces objectifs sont facultatifs :

- Les éléments de la liste des candidats pourront être supprimés par l'utilisateur grâce à un bouton d'action rapide.
- Permettre la modification d'informations du candidat directement depuis la liste des candidats.

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18 or higher
- NPM
- SQLite

## Installation

### Clone the repository

```bash
git clone https://github.com/your-username/talent-tracker.git
cd talent-tracker
```

### Backend Configuration

1. Install PHP dependencies:

```bash
composer install
```

2. Copy the environment file and generate the application key:

```bash
cp .env.example .env
php artisan key:generate
```

3. Configure the SQLite database:

```bash
touch database/database.sqlite
```

Modify the `.env` file to use SQLite:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

4. Run the migrations:

```bash
php artisan migrate
```

5. Start the Laravel server:

```bash
php artisan serve
```

### Frontend Configuration

1. Install JavaScript dependencies:

```bash
npm install
```

2. Start the Vite development server:

```bash
npm run dev
```

### Testing and linter

#### Laravel Tests

To run the Laravel tests, use the following command:

```bash
php artisan test
```
To run php cs fixer :

```bash
vendor/bin/php-cs-fixer fix
```

#### React Tests

To run ESLint:

```bash
npm run lint
```

To run Jest:

```bash
npm test
```

### CI

This project uses GitHub Actions for continuous integration. The configuration is located in `.github/workflows/ci.yml`.

### Contributing

Contributions are welcome! Please follow these steps:

1. Fork the project
2. Create your feature branch (`git checkout -b feature/feature-name`)
3. Commit your changes (`git commit -m 'Add some feature'`)
4. Push to the branch (`git push origin feature/feature-name`)
5. Open a Pull Request

### License

This project is licensed under the MIT License. See the [LICENSE](./LICENSE) file for more details.
