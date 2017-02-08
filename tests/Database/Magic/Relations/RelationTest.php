<?php
namespace Globalis\PuppetSkilled\Tests\Database\Magic\Relations;

use Mockery as m;
use Globalis\PuppetSkilled\Database\Grammar;
use Globalis\PuppetSkilled\Database\Magic\Model;
use Globalis\PuppetSkilled\Database\Magic\Builder;
use Globalis\PuppetSkilled\Database\Magic\Relations\HasOne;
use Globalis\PuppetSkilled\Database\Magic\Relations\Relation;
use Globalis\PuppetSkilled\Database\Query\Builder as QueryBuilder;
use Carbon\Carbon;

class RelationTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testSetRelationFail()
    {
        $parent = new ResetModelStub;
        $relation = new ResetModelStub;
        $parent->setRelation('test', $relation);
        $parent->setRelation('foo', 'bar');
        $this->assertArrayNotHasKey('foo', $parent->toArray());
    }

    public function testTouchMethodUpdatesRelatedTimestamps()
    {
        $builder = m::mock(Builder::class);
        $parent = m::mock(Model::class);
        $parent->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $builder->shouldReceive('getModel')->andReturn($related = m::mock(StdClass::class));
        $builder->shouldReceive('whereNotNull');
        $builder->shouldReceive('where');
        $relation = new HasOne($builder, $parent, 'foreign_key', 'id');
        $related->shouldReceive('getTable')->andReturn('table');
        $related->shouldReceive('getUpdatedAtColumn')->andReturn('updated_at');
        $now = Carbon::now();
        $related->shouldReceive('freshTimestampString')->andReturn($now);
        $builder->shouldReceive('update')->once()->with(['updated_at' => $now]);

        $relation->touch();
    }

    public function testSettingMorphMapWithNumericArrayUsesTheTableNames()
    {
        Relation::morphMap([ResetModelStub::class]);

        $this->assertEquals([
            'reset' => 'Globalis\PuppetSkilled\Tests\Database\Magic\Relations\ResetModelStub',
        ], Relation::morphMap());

        Relation::morphMap([], false);
    }

    public function testSettingMorphMapWithNumericKeys()
    {
        Relation::morphMap([1 => 'App\User']);

        $this->assertEquals([
            1 => 'App\User',
        ], Relation::morphMap());

        Relation::morphMap([], false);
    }

    /**
     * Testing to ensure loop does not occur during relational queries in global scopes.
     *
     * Executing parent model's global scopes could result in an infinite loop when the
     * parent model's global scope utilizes a relation in a query like has or whereHas
     */
    public function testDonNotRunParentModelGlobalScopes()
    {
        /* @var Mockery\MockInterface $parent */
        $eloquentBuilder = m::mock(Builder::class);
        $queryBuilder = m::mock(QueryBuilder::class);
        $parent = m::mock(ResetModelStub::class)->makePartial();
        $grammar = m::mock(Grammar::class);

        $eloquentBuilder->shouldReceive('getModel')->andReturn($related = m::mock(StdClass::class));
        $eloquentBuilder->shouldReceive('getQuery')->andReturn($queryBuilder);
        $queryBuilder->shouldReceive('getGrammar')->andReturn($grammar);
        $grammar->shouldReceive('wrap');
        $parent->shouldReceive('newQueryWithoutScopes')->andReturn($eloquentBuilder);

        $relation = new RelationStub($eloquentBuilder, $parent);
        $relation->wrap('test');
    }
}

class ResetModelStub extends Model
{
    protected $table = 'reset';

    // Override method call which would normally go through __call()

    public function getQuery()
    {
        return $this->newQuery()->getQuery();
    }
}

class RelationStub extends Relation
{
    public function addConstraints()
    {
    }

    public function addEagerConstraints(array $models)
    {
    }

    public function initRelation(array $models, $relation)
    {
    }

    public function match(array $models, array $results, $relation)
    {
    }

    public function getResults()
    {
    }
}
