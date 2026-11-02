# curriculum

## Installation

- Ajouter un .env.local qui reprend les variables d'environnement du .env :
    - ENV prend `prod` par défaut, ou `dev` qui est préconfigurée, ou une autre valeur. Cette valeur doit correspondre à une étape du dockerfile. Actuellement, les étapes disponibles sont l'étape générale et `prod`.
    - COMPOSE_FILE prend `docker-compose.yaml:docker-compose.dev.yaml` pour la dev, `docker-compose.yaml` pour la prod
    - CV_PDF_PATH : chemin vers le fichier pdf du CV. Ceci permet de ne pas avoir à le mettre dans le repo ou dans l'image.
- lancer traefik si cela n'est pas déjà fait
- lancer le serveur web : 
- docker compose --env-file .env.local up 
