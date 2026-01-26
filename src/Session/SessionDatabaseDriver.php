<?php

namespace Globalis\PuppetSkilled\Session;

use Globalis\PuppetSkilled\Core\Application;

class SessionDatabaseDriver extends \CI_Session_driver
{
    /**
     * Is session regenerate id
     */
    protected $sessionRegenerateId = false;

    /**
     * DB object
     *
     * @var    object
     */
    protected $connection;

    /**
     * Row exists flag
     *
     * @var    bool
     */
    protected $row_exists = false;

    /**
     * Lock "driver" flag
     *
     * @var    string
     */
    protected $platform;

    private $retryGetLock = 6;

    private $delayBeforeRetry = 150000; // µs
    /**
     * Class constructor
     *
     * @param   array    $params    Configuration parameters
     * @return  void
     */
    public function __construct($params)
    {
        parent::__construct($params);
    }

    /**
     * Open
     *
     * Initializes the database connection
     *
     * @param    string    $savePath    Table name
     * @param    string    $name        Session cookie name, unused
     * @return    bool
     */
    public function open(string $savePath, string $name): bool
    {
        return $this->_success;
    }

    /**
     * Read
     *
     * Reads session data and acquires a lock
     *
     * @param    string    $sessionId    Session ID
     * @return    string    Serialized session data
     */
    #[\ReturnTypeWillChange]
    public function read(string $sessionId): string
    {
        $this->connection = $this->getConnection();

        for ($i = 0; $i < $this->retryGetLock; $i++) {
            if ($this->get_lock($sessionId) !== false) {
                if (!$this->_session_id) {
                    $this->_session_id = $sessionId;
                }

                $query = $this->newQuery()->select('timestamp', 'data')->where('id', $sessionId);
                if ($this->_config['match_ip']) {
                    $query->where('ip_address', $_SERVER['REMOTE_ADDR']);
                }

                if (($result = $query->first()) === null) {
                    $this->row_exists = false;
                    $this->_fingerprint = md5('');
                    return '';
                }

                $this->row_exists = true;

                if ($result->timestamp < (time() - $this->_config['expiration'])) {
                    $this->_fingerprint = md5('');
                    return '';
                }

                $this->_fingerprint = md5($result->data);
                return $result->data;
            } else {
                usleep($this->delayBeforeRetry);
            }
        }

        $this->_fingerprint = md5('');
        return '';
    }

    /**
     * Write
     *
     * Writes (create / update) session data
     *
     * @param    string    $sessionId    Session ID
     * @param    string    $session_data    Serialized session data
     * @return    bool
     */
    #[\ReturnTypeWillChange]
    public function write(string $sessionId, string $sessionData): bool
    {
        $fingerprint = md5($sessionData);

        // Gestion du session_write_close
        if (session_status() !== PHP_SESSION_ACTIVE) {
            // return true;
        }

        // Si aucune donnée ou identique à avant → pas besoin d'écrire
        if ($sessionData === '' || $fingerprint === $this->_fingerprint) {
            return true;
        }

        // Si pas de lock → on skip pour éviter l'erreur, sauf si c'est une nouvelle session
        if ($this->_lock === false && $this->_session_id === $sessionId) {
            return true;
        }

        try {
            $i = 0;
            while (!$this->insertData($sessionId, $sessionData)) {
                log_message('error', sprintf(
                    'Session WRITE failed for %s after %d retries (lock=%s, row_exists=%s, last_error=%s)',
                    $sessionId,
                    $i,
                    var_export($this->_lock, true),
                    var_export($this->row_exists, true),
                    $this->connection ? implode(' | ', $this->connection->getPdo()->errorInfo()) : 'no PDO error'
                ));
                if ($i++ >= $this->retryGetLock) {
                    log_message('error', 'Session WRITE failed (insert/update false) for ' . $sessionId);
                    return false;
                }
                usleep($this->delayBeforeRetry);
            }
            $this->_fingerprint = $fingerprint;
            return true;

        } catch (\Throwable $e) {
            log_message('error', 'Session WRITE EXCEPTION for ' . $sessionId . ': ' . $e->getMessage());
        }

        log_message('error', sprintf(
            'Session WRITE failed for %s FIN DE FONCTION WRITE (lock=%s, row_exists=%s, last_error=%s)',
            $sessionId,
            var_export($this->_lock, true),
            var_export($this->row_exists, true),
            $this->connection ? implode(' | ', $this->connection->getPdo()->errorInfo()) : 'no PDO error'
        ));
        return false;
    }

    private function insertData($sessionId, $sessionData)
    {
        $fingerprint = md5($sessionData);
        $insertData = [
            'id' => $sessionId,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
            'timestamp' => time(),
            'data' => $sessionData,
        ];

        $query = $this->newQuery();

        $result = $query->updateOrInsert(
            ['id' => $sessionId],
            [
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
                'timestamp' => time(),
                'data' => $sessionData,
            ]
        );

        if ($result !== false) {
            $this->_session_id = $sessionId;
            $this->row_exists = true;
            $this->_fingerprint = $fingerprint;
            return true;
        }

        log_message('error', 'Session WRITE error for ' . $sessionId);
        return false;
    }

    /**
     * Close
     *
     * Releases locks
     *
     * @return    bool
     */
    public function close(): bool
    {
        return ($this->_lock && !$this->_release_lock())
        ? $this->_failure
        : $this->_success;
    }

    /**
     * Destroy
     *
     * Destroys the current session.
     *
     * @param    string    $sessionId    Session ID
     * @return    bool
     */
    public function destroy(string $sessionId): bool
    {
        if ($this->_lock) {
            $query = $this->newQuery()
                ->where('id', $sessionId);
            if (!$query->delete()) {
                return $this->_failure;
            }
        }
        if ($this->close() === $this->_success) {
            $this->_cookie_destroy();
            return $this->_success;
        }

        return $this->_failure;
    }

    /**
     * Garbage Collector
     *
     * Deletes expired sessions
     *
     * @param    int     $maxlifetime    Maximum lifetime of sessions
     * @return    bool
     */
    #[\ReturnTypeWillChange]
    public function gc(int $maxlifetime): int|false
    {
        $toDelete = $this->newQuery()->select('id')->where('timestamp', '<', $maxlifetime)->get()->toArray();

        return ($this->newQuery()->whereIn('id', $toDelete)->delete())
        ? count($toDelete)
        : $this->_failure;
    }

    /**
     * Get lock
     *
     * Acquires a lock, depending on the underlying platform.
     *
     * @param    string    $sessionId    Session ID
     * @return    bool
     */
    protected function get_lock(string $sessionId)
    {
        $arg = md5($sessionId . ($this->_config['match_ip'] ? '_' . $_SERVER['REMOTE_ADDR'] : ''));
        $conn = $this->connection ?: $this->getConnection();

        if ($conn->query("SELECT GET_LOCK('" . $arg . "', 300) AS ci_session_lock")->row()->ci_session_lock) {
            $this->_lock = $arg;
            return true;
        }

        return false;
    }

    /**
     * Release lock
     *
     * Releases a previously acquired lock
     *
     * @return    bool
     */
    protected function _release_lock()
    {
        if (!$this->_lock) {
            return true;
        }

        $conn = $this->connection ?: $this->getConnection();
        if ($conn->query("SELECT RELEASE_LOCK('" . $this->_lock . "') AS ci_session_lock")->row()->ci_session_lock) {
            $this->_lock = false;
            return true;
        }

        return false;
    }

    protected function newQuery()
    {
        return Application::getInstance()->queryBuilder->from($this->_config['save_path']);
    }

    protected function getConnection()
    {
        return Application::getInstance()->db;
    }

    /**
     * Validate ID
     *
     * Checks whether a session ID record exists server-side,
     * to enforce session.use_strict_mode.
     *
     * @param    string    $id    Session ID
     * @return    bool
     */
    public function validateId(string $id): bool
    {
        $query = $this->newQuery()->where('id', $id);

        if (!empty($this->_config['match_ip'])) {
            $query->where('ip_address', $_SERVER['REMOTE_ADDR']);
        }

        return !empty($query->first());
    }

    /**
     * Update Timestamp
     *
     * Update session timestamp without modifying data
     *
     * @param    string    $id    Session ID
     * @param    string    $data    Unknown & unused
     * @return    bool
     */
    public function updateTimestamp($id, $data): bool
    {
        $query = $this->newQuery()->where('id', $id);
        if ($this->_config['match_ip']) {
            $query->where('ip_address', $_SERVER['REMOTE_ADDR']);
        }
        return (bool) $query->update(['timestamp' => time()]);
    }
}