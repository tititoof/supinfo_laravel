Install Docker sous Ubuntu

# Add Docker's official GPG key:
sudo apt update
sudo apt install ca-certificates curl
sudo install -m 0755 -d /etc/apt/keyrings
sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
sudo chmod a+r /etc/apt/keyrings/docker.asc

# Add the repository to Apt sources:
sudo tee /etc/apt/sources.list.d/docker.sources <<EOF
Types: deb
URIs: https://download.docker.com/linux/ubuntu
Suites: $(. /etc/os-release && echo "${UBUNTU_CODENAME:-$VERSION_CODENAME}")
Components: stable
Signed-By: /etc/apt/keyrings/docker.asc
EOF

sudo apt update

sudo apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

Check si docker fonctionne
sudo systemctl status docker

Si en arrêt démarrage
sudo systemctl start docker

Création du group Docker s'il n'existe pas
sudo groupadd docker

Ajout de l'utilisateur au groupe Docker
sudo usermod -aG docker $USER


🚀 Utilisation
1. Installer Laravel (première fois uniquement)
bash# Crée un dossier et place le docker-compose.yml dedans
mkdir mon-projet && cd mon-projet
# Copie le fichier docker-compose.yml ici, puis :
docker compose --profile install run --rm installer
2. Configurer le .env
Après l'installation, édite le .env généré pour mettre les bonnes valeurs DB (elles correspondent déjà à celles du compose) :
env

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
3. Lancer l'application
bashdocker compose up -d
4. Finaliser Laravel
bash# Générer la clé d'app
docker compose exec app php artisan key:generate

# Lancer les migrations
docker compose exec app php artisan migrate
L'app est dispo sur http://localhost 🎉

📝 Ce que fait ce setup
ServiceImageRôleappdunglas/frankenphp:php8.3Serveur FrankenPHP (Caddy + PHP intégré)mysqlmysql:8.4Base de donnéesinstallercomposer:latestInstallation one-shot de Laravel 12 (profil install)
FrankenPHP expose les ports 80 et 443 (HTTP/HTTPS), et le service installer n'est lancé qu'à la demande grâce au profile: install, il ne démarre pas avec un simple docker compose up.Docker composeYML Téléchargercomment arrêter tout les container avec docker07:30Pour arrêter tous les conteneurs, tu as plusieurs options selon ce que tu veux faire :
Arrêter les conteneurs du projet actuel (dans le dossier avec ton docker-compose.yml) :
bashdocker compose down
Arrêter sans supprimer les volumes (données MySQL conservées) :
bashdocker compose stop
Arrêter TOUS les conteneurs en cours sur la machine (tous projets confondus) :
bashdocker stop $(docker ps -q)

Différence stop vs down
CommandeConteneursRéseauVolumescompose stopStoppés ✋ConservéConservéscompose downSupprimés 🗑️SuppriméConservéscompose down -vSupprimés 🗑️SuppriméSupprimés ⚠️

⚠️ down -v supprime aussi les données MySQL — à éviter sauf pour repartir de zéro.