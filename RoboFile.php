<?php

use Globalis\Robo\Core\Command;
use Globalis\Robo\Core\GitCommand;
use Globalis\Robo\Core\SemanticVersion;
use HideMe\Database;
use Symfony\Component\Process\Process;

class RoboFile extends \Globalis\Robo\Tasks
{
    /**
     * Variables de configuration chargées par Robo.
     * @var array<string,mixed>
     */
    private array $configVariables = [];

    /**
     * Propriétés de configuration depuis properties.php.
     * @var array<string,mixed>
     */
    private array $properties = [];

    /**
     * Répertoire contenant les variables de configuration
     * @var string
     */
    private string $configDirectory = __DIR__ . '/.robo/config/';

    /**
     * Répertoire contenant les fichiers de configuration de l'application
     * @var string
     */
    private string $buildDirectory = __DIR__ . '/.robo/build';

    /**
     * @var string
     */
    private string $partsDirectory = __DIR__ . '/.robo/parts';

    private ?Database $eloquentConfig = null;

    /**
     * Install project
     */
    public function install()
    {
        $this->loadConfig();
        $this->buildApp(__DIR__);
        $this->installDependencies(__DIR__);
        $this->migrateUp();
    }

    private function installDependencies($appPath)
    {
        // Install composer dependencies
        $task = $this->taskComposerInstall()
            ->workingDir($appPath)
            ->preferDist();
        if ($this->configVariables['ENVIRONEMENT'] == 'production') {
            $task->noDev()
                ->optimizeAutoloader();
        }
        $task->run();
    }

    private function buildApp($appPath)
    {
        $this->taskCopyReplaceDir([$this->buildDirectory => $appPath])
            ->from(array_keys($this->configVariables))
            ->to($this->configVariables)
            ->startDelimiter('<##')
            ->endDelimiter('##>')
            ->dirPermissions(0755)
            ->filePermissions(0644)
            ->run();
        // Build part
        $this->buildParts($appPath);
    }

    private function buildParts($path, $config = null)
    {

        $config = ($config?: $this->configVariables);
        $env = $config['ENVIRONEMENT'];


        $htaccess_parts_path = $this->partsDirectory . '/htaccess/';
        $htaccess_parts =
        [
            $htaccess_parts_path . 'htaccess-general',
            $htaccess_parts_path . 'htaccess-urls',
            $htaccess_parts_path . 'htaccess-performances',
            $htaccess_parts_path . 'htaccess-php',
            $htaccess_parts_path . 'htaccess-security',
        ];

        foreach($htaccess_parts as $key => $part) {
            $part_env = $part . '-' . $env;
            if(file_exists($part_env)) {
                $htaccess_parts[$key] = $part_env;
            }
        }

        $this->taskConcat($htaccess_parts)
        ->to($path . '/public/.htaccess')
        ->run();

        $this->taskReplacePlaceholders($path . '/public/.htaccess')
         ->from(array_keys($config))
         ->to($config)
         ->startDelimiter('<##')
         ->endDelimiter('##>')
         ->run();
    }

    /**
     * Configure App
     */
    public function config()
    {
        $this->configVariables = $this->taskConfiguration()
            ->initConfig($this->getProperties('config'))
            ->initLocal($this->getProperties('local'))
            ->initSettings($this->getProperties('settings'))
            ->configFilePath($this->configDirectory . 'my.config')
            ->force(true)
            ->run()
            ->getData();
        $this->configVariables['EMAIL_BCC'] = 'false';
        // Install project
        $this->install();
    }

    private function loadConfig()
    {
        $this->configVariables = $this->taskConfiguration()
         ->initConfig($this->getProperties('config'))
         ->initLocal($this->getProperties('local'))
         ->initSettings($this->getProperties('settings'))
         ->configFilePath($this->configDirectory . 'my.config')
         ->run()
         ->getData();

        $this->configVariables['EMAIL_BCC'] = 'false';
    }

    /**
     * Retourne les propriétés de configurations
     *
     * @param  string $type
     * @return array
     */
    private function getProperties($type)
    {
        if (!isset($this->properties)) {
            $this->properties = include $this->configDirectory . 'properties.php';
        }
        return $this->properties[$type];
    }

    /**
     * Database migrate
     * Runs all of the available migrations, optionally up to a specific version
     */
    public function migrateUp()
    {
        $this->taskExec('vendor/bin/phinx')
            ->arg('migrate')
            ->run();
    }

    /**
     * Migration rollback
     * Undo previous migrations executed, optionally down to a specific version
     */
    public function migrateDown()
    {
        $this->taskExec('vendor/bin/phinx')
            ->arg('rollback')
            ->run();
    }

    /**
     * Migration create
     * Create a new migration file
     *
     * @param  string $name The migration name
     */
    public function migrateCreate($name)
    {
        $name = explode(' ', str_replace(['_', '-'], ' ', $name));
        foreach ($name as &$word) {
            $word = mb_strtoupper(mb_substr($word, 0, 1)) . mb_substr($word, 1);
        }
        $name= implode('', $name);

        $this->taskExec('vendor/bin/phinx')
            ->arg('create')
            ->arg($name)
            ->run();
    }
    /**
     * Seed create
     * Create a seed file
     *
     * @param  string $name The seed name
     */
    public function seedCreate($name)
    {
        $this->taskExec('vendor/bin/phinx')
            ->arg('seed:create')
            ->arg($name)
            ->run();
    }

    /**
     * Seed run
     * Run a seed file
     *
     * @param  string $name The seed name
     */
    public function seedRun($name = null)
    {
        $task = $this->taskExec('vendor/bin/phinx')
            ->arg('seed:run');
        if ($name) {
            $task->option('-s ' . $name);
        }
        return $task->run();
    }

    /**
     * Clean project
     */
    public function clean()
    {
        $this->cleanGit();
        $this->cleanWaste();
    }

    /**
     * Git prune
     */
    public function cleanGit()
    {
        $this->loadConfig();
        $this->taskGitStack()
         ->stopOnFail()
         ->exec('fetch --all --prune')
         ->run();
    }

    /**
     * Delete files likes ._* .DS_Store, etc.
     */
    public function cleanWaste()
    {
        $this->taskCleanWaste(__DIR__)->run();
    }

    /**
     * Start a new feature
     *
     * @param  string $name The feature name
     */
    public function featureStart($name)
    {
        $this->loadConfig();
        return $this->taskFeatureStart($name, $this->configVariables['GIT_PATH'])->run();
    }

    /**
     * Finish a feature
     *
     * @param  string $name The feature name
     */
    public function featureFinish($name)
    {
        $this->loadConfig();
        return $this->taskFeatureFinish($name, $this->configVariables['GIT_PATH'])->run();
    }

    /**
     * Start a new hotfix
     *
     * @option string $semversion Version number
     * @option string $type    Hotfix type (path, minor)
     */
    public function hotfixStart($opts = ['semversion' => null, 'type' => 'patch'])
    {
        $this->loadConfig();
        if (empty($opts['semversion'])) {
            $version = $this->getVersion()
                ->increment($opts['type']);
        } else {
            $version = $opts['semversion'];
        }
        $this->loadConfig();
        return $this->taskHotfixStart((string)$version, $this->configVariables['GIT_PATH'])->run();
    }

    /**
     * Finish a hotfix
     *
     * @option string $semversion Version number
     * @option string $type    Hotfix type (path, minor)
     */
    public function hotfixFinish($opts = ['semversion' => null, 'type' => 'patch'])
    {
        $this->loadConfig();
        if (empty($opts['semversion'])) {
            $version = $this->getVersion()
                ->increment($opts['type']);
        } else {
            $version = $opts['semversion'];
        }
        return $this->taskHotfixFinish((string)$version, $this->configVariables['GIT_PATH'])->run();
    }

    /**
     * Start a new release
     *
     * @option string $semversion Version number
     * @option string $type    Relase type (minor, major)
     */
    public function releaseStart($opts = ['semversion' => null, 'type' => 'minor'])
    {
        $this->loadConfig();
        if (empty($opts['semversion'])) {
            $version = $this->getVersion()
                ->increment($opts['type']);
        } else {
            $version = $opts['semversion'];
        }
        return $this->taskReleaseStart((string)$version, $this->configVariables['GIT_PATH'])->run();
    }

    /**
     * Finish a release
     *
     * @option string $semversion Version number
     * @option string $type    Relase type (minor, major)
     */
    public function releaseFinish($opts = ['semversion' => null, 'type' => 'minor'])
    {
        $this->loadConfig();
        if (empty($opts['semversion'])) {
            $version = $this->getVersion()
                ->increment($opts['type']);
        } else {
            $version = $opts['semversion'];
        }
        return $this->taskReleaseFinish((string)$version, $this->configVariables['GIT_PATH'])->run();
    }

    /**
     * Return current version
     *
     * @return SemanticVersion
     */
    private function getVersion()
    {
        // Get version from tag
        $cmd = new Command($this->configVariables['GIT_PATH']);
        $cmd = $cmd->arg('tag')
            ->execute();
        $output = explode(PHP_EOL, trim($cmd->getOutput()));
        $currentVersion = '0.0.0';
        foreach ($output as $tag) {
            if (preg_match(SemanticVersion::REGEX, $tag)) {
                if (version_compare($currentVersion, $tag, '<')) {
                    $currentVersion = $tag;
                }
            }
        }
        return new SemanticVersion($currentVersion);
    }

    /**
     * Deploy application to staging
     *
     * @option string $semversion Version number (Default last tag version)
     */
    public function deployStaging($releaseVersion)
    {
        $this->deploy($releaseVersion, 'staging');
    }

    /**
     * Deploy application to production
     *
     * @option string $semversion Version number (Default last tag version)
     */
    public function deployProduction($releaseVersion)
    {
        $this->deploy($releaseVersion, 'production');
    }

    /**
     * Deploy application
     *
     * @option string $semversion Version number (Default last tag version)
     * @option string $to Destination environment
     */
    private function deploy($releaseVersion, $to)
    {
        $this->loadConfig();

        $this->io()->title('Deploy version ' . $releaseVersion . ' to ' . $to);

        // Checkout
        if (!$this->gitCheckout($releaseVersion)) {
            $this->io->error('Deploy abort: Can\'t checkout to' . $releaseVersion);
            return;
        }

        $this->io()->title('Start deploy version ' . $releaseVersion . ' to ' . $to);
        // Load remote config
        $remoteConfig = $this->loadRemoteConfig($to);
        $collection = $this->collectionBuilder();
        $workDir = rtrim($collection->tmpDir(), '/\\' ) . '/';

        // Create archive files
        $cmd = new Command($this->configVariables['GIT_PATH']);
        $cmd = $cmd->arg('archive')
           ->option('--format=tar')
           ->option('--prefix=' . basename($workDir) . DIRECTORY_SEPARATOR)
           ->arg($releaseVersion)
           ->pipe('(cd')
           ->arg(dirname($workDir))
           ->getCommand();
        $cmd .= ' && tar xf -)';

        if (!$this->taskExec($cmd)->run()->wasSuccessful()) {
            return;
        }

        $this->installRemote($to, $workDir, $remoteConfig);

        // 1. Dry Run
        $this->rsync($workDir, $remoteConfig['REMOTE_USER'], $remoteConfig['REMOTE_HOST'], $remoteConfig['REMOTE_PATH'], $remoteConfig['REMOTE_PORT'], true);

        if ($this->io()->confirm('Do you want to run', false)) {
            // 2. Run
            if (!$this->rsync($workDir, $remoteConfig['REMOTE_USER'], $remoteConfig['REMOTE_HOST'], $remoteConfig['REMOTE_PATH'],  $remoteConfig['REMOTE_PORT'], false)->wasSuccessful()) {
                return;
            }
            // 3. Update database
            $this->migrateRemote($remoteConfig);
        }
        $this->taskDeleteDir($workDir)->run();
    }

    private function rsync($workDir, $remoteUser, $remoteHost, $remotePath, $remotePort, $dryRun = false) {
        $cmd = $this->taskRsync()
            ->fromPath($workDir)
            ->toHost($remoteHost)
            ->toUser($remoteUser)
            ->toPath($remotePath)
            ->verbose()
            ->recursive()
            ->delete()
            ->checksum()
            ->compress()
            ->itemizeChanges()
            ->excludeVcs()
            ->progress()
            ->option('rsh \'ssh -p '.$remotePort.'\'')
            ->option('copy-links')
            ->option('perms')
            ->option('chmod', 'Du=rwx,Dgo=rx,Fu=rw,Fgo=r')
            ->stats();
        if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . '.rsyncignore')) {
            $cmd->excludeFrom(__DIR__ . DIRECTORY_SEPARATOR . '.rsyncignore');
        }
        if (true === $dryRun) {
            $cmd->dryRun();
        }
        return $cmd->run();
    }

    private function loadRemoteConfig($remote)
    {
        $configVars = $this->getProperties('config');

        $configVars['REMOTE_HOST'] = [
            'question' => 'Remote host name',
        ];
        $configVars['REMOTE_USER'] = [
            'question' => 'Remote username',
        ];
        $configVars['REMOTE_PATH'] = [
            'question' => 'Remote path',
        ];
        $configVars['REMOTE_PORT'] = [
            'question' => 'Remote port',
            'default' => '22'
        ];
        $configVars['EMAIL_BCC'] = [
            'question' => 'Email BCC',
            'default' => '',
            'empty' => true,
        ];

        $return = $this->taskConfiguration()
         ->initConfig($configVars)
         ->initLocal($this->getProperties('local'))
         ->initSettings($this->getProperties('settings'))
         ->configFilePath($this->configDirectory . $remote .'.config')
         ->force(true)
         ->run()
         ->getData();

        if ($return['EMAIL_BCC']) {
            $return['EMAIL_BCC'] = var_export(explode(',', $return['EMAIL_BCC']), true);
        } else {
            $return['EMAIL_BCC'] = 'false';
        }
        return $return;
    }

    private function installRemote($env, $dir, $remoteConfig)
    {
        $this->taskCopyReplaceDir([$this->buildDirectory => $dir])
            ->from(array_keys($remoteConfig))
            ->to($remoteConfig)
            ->startDelimiter('<##')
            ->endDelimiter('##>')
            ->dirPermissions(0755)
            ->filePermissions(0644)
            ->run();

        $this->buildParts($dir, $remoteConfig);

        // Install composer
        $this->taskComposerInstall()
            ->workingDir($dir)
            ->noDev()
            ->optimizeAutoloader()
            ->preferDist()
            ->run();

    }

    private function migrateRemote($remoteConfig)
    {
        $sshTunneling = $this->openSshTunneling($remoteConfig['REMOTE_USER'], $remoteConfig['REMOTE_HOST'], 23306, $remoteConfig['DB_PORT'], 'localhost', $remoteConfig['REMOTE_PORT']);
        $phinxFileOldContent =  file_get_contents(__DIR__ .'/phinx.php');
        // Rewrite phinx.php
        copy($this->buildDirectory . '/phinx.php', __DIR__ .'/phinx.php');
        $tmp = [];
        foreach ($remoteConfig as $key => $value) {
            $tmp['<##'  . $key. '##>'] = $value;
        }
        $tmp['<##DB_HOST##>'] = '127.0.0.1';
        $tmp['<##DB_PORT##>'] = 23306;
        $this->taskReplaceInFile(__DIR__ .'/phinx.php')
            ->from(array_keys($tmp))
             ->to($tmp)
             ->run();
        $this->migrateUp();
        $this->closeSshTunneling($sshTunneling);
        file_put_contents(__DIR__ .'/phinx.php',$phinxFileOldContent);
    }

    private function gitCheckout($branch)
    {
        $cmd = new GitCommand($this->configVariables['GIT_PATH']);
        if (!$cmd->isCleanWorkingTree()) {
            $this->io->error("Working tree contains unstaged changes. Aborting.");
            return false;
        }
        return $cmd->checkout($branch);
    }

    public function openSshTunneling($remoteUser, $remoteHost, $localPort, $remotePort, $localhost = 'localhost', $sshPort = 22)
    {
        //@TODO Ne fonction pas sans SSH KEY
        //@TODO L'option -f lance un nouveau process (Detectable ??)
        $cmd = sprintf(
            'ssh -p %s %s@%s -L %s:%s:%s -N -o ExitOnForwardFailure=yes -o StrictHostKeyChecking=no',
            $sshPort,
            $remoteUser,
            $remoteHost,
            $localPort,
            $localhost,
            $remotePort
        );
        $process = Process::fromShellCommandline($cmd);
        $process->setTimeout(60);
        $process->start();
        // Solution crade. Mais ssh n'est pas très verbeux
        sleep(2);
        return $process;
    }

    private function closeSshTunneling(Process $process)
    {
        if ($process->isRunning()) {
            $process->signal(SIGKILL);
        }
    }

    private function getPathModels($relativePath = '')
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'anonymize' . $relativePath;
    }

    /**
     * Affiche la configuration de la BDD utilisée pour l'anonymisation
     *
     * @return    void
     */
    public function anonymizeCheckConfig()
    {
        $this->output()->getFormatter()->setStyle('green', new \Symfony\Component\Console\Formatter\OutputFormatterStyle('green'));
        $this->output()->getFormatter()->setStyle('blue', new \Symfony\Component\Console\Formatter\OutputFormatterStyle('blue'));

        $this->writeln('Configuration de la base de données :');
        foreach ((new Database())->displayDatabase() as $type => $value) {
            $this->say("<blue>$type</blue>: <green>$value</green>");
        }
    }

    /**
     * Lance l'anonymisation sur le/s model(s)
     *
     * @param     string|null    $model    Nom du model
     *
     * @return    void
     */
    public function anonymize(?string $model = null)
    {
        $pathModels = $this->getPathModels();
        $this->output()->getFormatter()->setStyle('green', new \Symfony\Component\Console\Formatter\OutputFormatterStyle('green'));
        $this->output()->getFormatter()->setStyle('blue', new \Symfony\Component\Console\Formatter\OutputFormatterStyle('blue'));
        $this->eloquentConfig = new Database();

        if ($model) {
            $this->runModel($model);
            return;
        }

        if (!file_exists($pathModels)) {
            $this->writeln("Le répertoire des models n'a pas été trouvé !");
            $ask = $this->ask("Voulez-vous définir le répertoire y/n ?", false);
            if ($ask === 'y') {
                $pathModels = $this->ask("Merci d'indiquer le répertoire absolu des models", false);
            }
            if (!file_exists($pathModels)) {
                throw new \Exception("Aucun model trouvé, arrêt de la procédure !");
            }
        }

        $models = scandir($pathModels);
        $startModels = microtime(true);
        foreach ($models as $model) {
            if (\in_array($model, ['.', '..']) || strpos($model, '.php') === false) {
                continue;
            }
            sleep(5);
            $this->runModel($model);
        }
        $this->writeln("Terminé en: <blue>" . number_format((microtime(true) - $startModels) / 60, 2) . " min.</blue>");
    }

    /**
     * Génère des données pour le model demandé (par défaut 50)
     *
     * @param     string    $model    nom du model
     * @param     int       $rows     nombre de lignes à générer
     *
     * @return    void
     */
    public function anonymizeFakeit(string $model, int $rows = 50) {
        $this->output()->getFormatter()->setStyle('green', new \Symfony\Component\Console\Formatter\OutputFormatterStyle('green'));
        $this->eloquentConfig = new Database();

        if ($model) {
            $model = ucfirst($model);
            if (!file_exists($this->getPathModels(DIRECTORY_SEPARATOR . $model . '.php'))) {
                throw new \Exception("La classe d'anonymisation est introuvable");
            }
            require_once $this->getPathModels(DIRECTORY_SEPARATOR . $model . '.php');
            $currentModel = new $model();
            $currentModel->setDatabase($this->eloquentConfig);
            $this->writeln("Données en cours de génération pour le model: <green>$model</green>");
            $startModel = microtime(true);
            $currentModel->fakeIt($rows);
            $this->writeln("Terminé en: <green>" . number_format((microtime(true) - $startModel) / 60, 2) . " min.</green>");
            return;
        }
    }

    /**
     * Exécute l'action pour le model donné
     *
     * @param     string        $class     Nom de la classe
     * @param     string        $action    [run, fakeit]
     * @param     int|null      $rows      Nombre de lignes à générer
     */
    private function runModel($class, $action = 'run', $rows = null)
    {
        $model = ucfirst($class);
        if (strpos($model, '.php') !== false) {
            $model = strstr($model, '.php', true);
        }

        if (!file_exists($this->getPathModels(DIRECTORY_SEPARATOR . $model . '.php'))) {
            throw new \Exception("La classe d'anonymisation est introuvable");
        }
        require_once $this->getPathModels(DIRECTORY_SEPARATOR . $model . '.php');

        $currentModel = new $model();
        $currentModel->setDatabase($this->eloquentConfig);
        $this->writeln("Model en cours d'anonymisation: <green>$model</green>");
        $startModel = microtime(true);
        $currentModel->$action($rows);
        $this->writeln("Terminé en: <green>" . number_format((microtime(true) - $startModel) / 60, 2) . " min.</green>");
    }
}
