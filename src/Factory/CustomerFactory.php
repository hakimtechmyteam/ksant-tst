<?php

namespace App\Factory;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Customer>
 *
 * @method        Customer|Proxy                     create(array|callable $attributes = [])
 * @method static Customer|Proxy                     createOne(array $attributes = [])
 * @method static Customer|Proxy                     find(object|array|mixed $criteria)
 * @method static Customer|Proxy                     findOrCreate(array $attributes)
 * @method static Customer|Proxy                     first(string $sortedField = 'id')
 * @method static Customer|Proxy                     last(string $sortedField = 'id')
 * @method static Customer|Proxy                     random(array $attributes = [])
 * @method static Customer|Proxy                     randomOrCreate(array $attributes = [])
 * @method static CustomerRepository|RepositoryProxy repository()
 * @method static Customer[]|Proxy[]                 all()
 * @method static Customer[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Customer[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Customer[]|Proxy[]                 findBy(array $attributes)
 * @method static Customer[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Customer[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class CustomerFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'email' => self::faker()->email(),
            'firstname' => self::faker()->firstName(),
            'gender' => self::faker()->randomElement(['male', 'female']),
            'lastname' => self::faker()->lastName(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Customer $customer): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Customer::class;
    }
}
