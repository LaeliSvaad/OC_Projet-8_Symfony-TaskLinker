<?php

namespace App\Factory;

use App\Entity\Employee;
use App\Enum\EmployeeContract;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Employee>
 */
final class EmployeeFactory extends PersistentProxyObjectFactory{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Employee::class;
    }

        /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable    {
        return [
            'arrival_date' => self::faker()->dateTime(),
            'contract' => self::faker()->randomElement(EmployeeContract::cases()),
            'email' => self::faker()->text(150),
            'firstname' => self::faker()->text(100),
            'lastname' => self::faker()->text(150),
        ];
    }

        /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Employee $employee): void {})
        ;
    }
}
