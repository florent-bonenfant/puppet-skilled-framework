Bascule de Puppet skilled pour utilisation avec PHP8.4 et CodeIgniter 4.7
Cette version utilise CI 4.7 et remplace la version eloquent embarqué par une version gérer à travers composer de façon à retrouver tous les éléments de ce dernier sans restriction.

## Sessions
Adaptation des sessions avec PHP8, veuillez étendre les classes :
- Remplacer CI_session par \Globalis\PuppetSkilled\Session\APP_CI_Session
- Remplacer CI_SessionWrapper par \Globalis\PuppetSkilled\Session\APP_CI_SessionWrapper

### Sans webservices
Vous pouvez surcharger le CI_Session à travers un fichier APP_Session qui lui reprendra les informations ci-dessus et permettra ainsi l'utilisation d'eloquent

### Avec webservices
Si vous utilisez des webservices, vous avez très certainement déjà surcharger le CI_Session de codeigniter, il vous suffit d'adapter un peu votre fichier

## Utilisation ORM
On bascule maintenant dans une version plus standard d'Eloquent
Par exemple au lieu d'utiliser
```
use Globalis\PuppetSkilled\Database\Magic\Model;
use \Globalis\PuppetSkilled\Database\Query\Expression;
use Globalis\PuppetSkilled\Database\Query\Builder as QueryBuilder;
use Globalis\PuppetSkilled\Database\Magic\Model;
use Globalis\PuppetSkilled\Database\Magic\Relations\Pivot;
```
nous utiliserons
```
use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Query\Expression;
use \Illuminate\Database\Query\Builder as QueryBuilder;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
```
