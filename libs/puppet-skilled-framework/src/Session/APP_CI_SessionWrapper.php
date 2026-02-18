<?php

namespace Globalis\PuppetSkilled\Session;

class APP_CI_SessionWrapper implements \SessionHandlerInterface, SessionDriverInterface
{
    protected SessionDriverInterface $driver;

    public function __construct(SessionDriverInterface $driver)
    {
        $this->driver = $driver;
    }

    public function open(string $savePath, string $name): bool
    {
        return $this->driver->open($savePath, $name);
    }

    public function close(): bool
    {
        return $this->driver->close();
    }

    public function read(string $id): string
    {
        $result = $this->driver->read($id);
        return $result !== false ? $result : '';
    }

    public function write(string $id, string $data): bool
    {
        return $this->driver->write($id, $data);
    }

    public function destroy(string $id): bool
    {
        return $this->driver->destroy($id);
    }

    public function gc(int $maxlifetime): int|false
    {
        return $this->driver->gc($maxlifetime);
    }

    public function updateTimestamp(string $id, string $data): bool
    {
        return $this->driver->updateTimestamp($id, $data);
    }

    public function validateId(string $id): bool
    {
        return $this->driver->validateId($id);
    }
}
