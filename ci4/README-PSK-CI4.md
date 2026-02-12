# PuppetSkilled CI4 bootstrap

Ce dossier `ci4` est maintenant branché sur un fork local de PuppetSkilled:

- package local: `../libs/puppet-skilled-framework-ci4`
- version demandée: `globalis/puppet-skilled-framework: dev-ci4-bridge`
- commande recommandée sur cette machine: `/usr/bin/php8.4 /usr/local/bin/composer`

## Ce qui est déjà en place

- Bridge CI4 minimal dans le package:
  - `Globalis\PuppetSkilled\Bridge\Ci4\LegacyBridge`
  - proxies `Load`, `Input`, `Output`, `Router`, `Session`, `Config`
- Proxies complémentaires:
  - `Uri`, `Security`, `UserAgent`
- `Globalis\PuppetSkilled\Core\Application` détecte CI4 et expose un objet compatible via `app()`.
- helper `config_item()` compat CI3 ajouté côté package (quand absent).
- helper `get_instance()` compat CI3 ajouté.
- `FormValidation` réécrit pour CI4 en conservant l'API legacy (`set_rules`, `run`, `set_value`, `error`, `error_array`).
- `APP_CI_Session` protégé pour runtime CI4 (shim anti-fatal CI3).
- `ci4/composer.json` autoload maintenant directement le code legacy (`../application/{core,models,libraries,views/Cell,services,jobs}`).

## Étape suivante

1. Dans `ci4`, installer les dépendances:

```bash
/usr/bin/php8.4 /usr/local/bin/composer update globalis/puppet-skilled-framework --with-all-dependencies
```

Note: sur cette machine, `composer update` échoue actuellement car DNS/Internet indisponible.
Repo bloquant: `https://repo.packagist.org` (Packagist).

2. Migrer en premier les classes noyau de l'app (dans cet ordre):
- `application/core/Controller/Base.php`
- `application/core/Controller/Webservice.php`
- `application/services/Secure/Authentication.php`

3. Backoffice migré côté CI4:
- tous les contrôleurs `application/controllers/backoffice/*` ont été portés dans `ci4/app/Controllers/BackOffice/*`
- dispatcher dédié: `ci4/app/Controllers/BackOffice/Dispatcher.php`
- routage global: `backoffice` et `backoffice/*` vers `BackOffice\\Dispatcher::handle`

4. Webservices migrés côté CI4:
- tous les contrôleurs `application/controllers/webservice/*` ont été portés dans `ci4/app/Controllers/Webservice/*`
- dispatcher dédié: `ci4/app/Controllers/Webservice/Dispatcher.php`
- routage global: `webservice` et `webservice/*` vers `Webservice\\Dispatcher::handle`

5. Valider ensuite un flux API simple (`webservice/authentication/login`) avec le bridge.

## Smoke test rapide

Lancer le serveur CI4 en PHP 8.4:

```bash
/usr/bin/php8.4 spark serve --host 127.0.0.1 --port 8080
```

Dans un autre terminal, lancer le smoke test:

```bash
./scripts/smoke-test.sh http://127.0.0.1:8080
```

Le script vérifie des endpoints backoffice + webservice et échoue en cas de code HTTP inattendu ou de pattern d'erreur fatale PHP dans la réponse.

## Limites actuelles du bridge

- `load->language()` est pour l'instant un no-op.
- `ConfigProxy` charge prioritairement des fichiers legacy (`application/config/*.php`) ou `APPPATH/Config/*.php` si présents.
- L'adaptation de `View`/`QueryFilter`/`QueryPager` doit encore être finalisée selon les premiers endpoints migrés.
