<?php

namespace Globalis\PuppetSkilled\Session;

interface SessionHandlerInterface {
    /**
     * Ouvre la session
     * @param string $savePath Le chemin où les sessions sont sauvegardées.
     * @param string $sessionName Le nom de la session.
     * @return bool Retourne TRUE en cas de succès, FALSE en cas d'échec.
     */
    public function open(string $savePath, string $sessionName): bool;

    /**
     * Ferme la session
     * @return bool Retourne TRUE en cas de succès, FALSE en cas d'échec.
     */
    public function close(): bool;

    /**
     * Lit les données de la session
     * @param string $sessionId L'ID de la session.
     * @return string Retourne les données de la session.
     */
    public function read(string $sessionId): string;

    /**
     * Écrit les données de la session
     * @param string $sessionId L'ID de la session.
     * @param string $sessionData Les données de la session.
     * @return bool Retourne TRUE en cas de succès, FALSE en cas d'échec.
     */
    public function write(string $sessionId, string $sessionData): bool;

    /**
     * Détruit la session
     * @param string $sessionId L'ID de la session.
     * @return bool Retourne TRUE en cas de succès, FALSE en cas d'échec.
     */
    public function destroy(string $sessionId): bool;

    /**
     * Nettoie les sessions expirées
     * @param int $maxlifetime Le temps de vie maximum des sessions.
     * @return int|false Retourne le nombre de sessions supprimées ou FALSE en cas d'échec.
     */
    public function gc(int $maxlifetime): int|false;
}
