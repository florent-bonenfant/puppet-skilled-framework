<?php
namespace App\Service\Secure\Resource;

class Customer extends \Globalis\PuppetSkilled\Auth\Resource
{
    public function buildFromUserHasRoleid($id)
    {
        $this->resources = [];
        $table = new \App\Model\UsersRoles();
        $resources = $table->where('user_id', $id)->get();
        foreach ($resources as $resource) {
            $this->resources[] = $resource->customer_id;
        }
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
