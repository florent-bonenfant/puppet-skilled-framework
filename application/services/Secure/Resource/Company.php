<?php
namespace App\Service\Secure\Resource;

class Company extends \Globalis\PuppetSkilled\Auth\Resource
{
    public function buildFromUserHasRoleid($id)
    {
        $this->resources = [$id];
    }

    public function setResources(array $resources)
    {
        $this->resources = $resources;
    }

    public function __sleep()
    {
        return ['resources'];
    }
}
