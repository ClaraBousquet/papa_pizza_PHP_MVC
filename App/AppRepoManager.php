<?php 

namespace App;

use App\App;
use App\Repository\SizeRepository;
use App\Repository\UnitRepository;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\PizzaRepository;
use App\Repository\PriceRepository;
use App\Repository\OrderRowRepository;
use App\Repository\IngredientRepository;
use Core\Repository\RepositoryManagerTrait;
use App\Repository\PizzaIngredientRepository;

class AppRepoManager 
{
    //on récupère le trait RepositoryManagerTrait
    use RepositoryManagerTrait;
    //on déclare une propriété privée qui va contenir une intance du repo
    private IngredientRepository $ingredientRepository;
    private OrderRepository $orderRepository;
    private OrderRowRepository $orderRowRepository;
    private PizzaIngredientRepository $pizzaIngredientRepository;
    private PizzaRepository $pizzaRepository;
    private PriceRepository $priceRepository;
    private SizeRepository $sizeRepository;
    private UnitRepository $unitRepository;
    private UserRepository $userRepository;



    public function getPizzaRepository(): PizzaRepository
    {
        return $this->pizzaRepository;
    }

    public function getIngredientRepository(): IngredientRepository
    {
        return $this->ingredientRepository;
    }

    public function getOrderRepository(): OrderRepository
    {
        return $this->orderRepository;
    }

    public function getOrderRowRepository(): OrderRowRepository
    {
        return $this->orderRowRepository;
    }

    public function getPizzaIngredientRepository(): PizzaIngredientRepository
    {
        return $this->pizzaIngredientRepository;
    }

    public function getPriceRepository(): PriceRepository
    {
        return $this->priceRepository;
    }

    public function getSizeRepository(): SizeRepository
    {
        return $this->sizeRepository;
    }

    public function getUnitRepository(): UnitRepository
    {
        return $this->unitRepository;
    }

    public function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }

    protected function __construct()
    {
        $config = App::getApp();
        //ici on enregistrera les repositories des différentes classes
        $this->pizzaRepository = new PizzaRepository($config);
        $this->ingredientRepository = new IngredientRepository($config);
        $this->orderRepository = new OrderRepository($config);
        $this->orderRowRepository = new OrderRowRepository($config);
        $this->pizzaIngredientRepository = new PizzaIngredientRepository($config);
        $this->priceRepository = new PriceRepository($config);
        $this->sizeRepository = new SizeRepository($config);
        $this->unitRepository = new UnitRepository($config);
        $this->userRepository = new UserRepository($config);
    }
}