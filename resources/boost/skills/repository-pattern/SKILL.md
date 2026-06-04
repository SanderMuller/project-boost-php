---
name: repository-pattern
description: Apply the Repository pattern in PHP. Doctrine-flavored and ORM-agnostic shapes. When to use, when to skip.
---

# Repository pattern

## When to apply

- Adding domain-level access to a persistence-backed aggregate
- Reviewing a PR that uses an ORM query builder inside business logic
- Asked "how should I fetch / persist X?"

## The pattern

Repositories abstract persistence behind a domain-language interface.
Domain code calls `$orders->byId($id)`, not `$em->find(Order::class, $id)`.

```php
// Domain
interface OrderRepository
{
    public function byId(OrderId $id): ?Order;
    public function save(Order $order): void;
    public function pending(): iterable; // generator preferred for large sets
}

// Infrastructure
final class DoctrineOrderRepository implements OrderRepository
{
    public function __construct(private readonly EntityManagerInterface $em) {}

    public function byId(OrderId $id): ?Order
    {
        return $this->em->find(Order::class, $id);
    }

    public function save(Order $order): void
    {
        $this->em->persist($order);
        $this->em->flush();
    }

    public function pending(): iterable
    {
        return $this->em->createQuery('SELECT o FROM Order o WHERE o.status = :s')
            ->setParameter('s', OrderStatus::Pending)
            ->toIterable();
    }
}
```

## When to skip

- Read-side queries that don't fit the aggregate model — use a dedicated
  query service (CQRS read model) instead of bloating the repository
- Pure CRUD on a tiny app — a Doctrine repo or query builder direct
  call is fine; don't ceremony-fy
- The aggregate is just a row → reconsider whether it's actually an
  aggregate vs a DTO

## ORM-agnostic shape

For non-Doctrine projects (PDO, Eloquent, native SQL):

```php
final class PdoOrderRepository implements OrderRepository
{
    public function __construct(private readonly PDO $db) {}

    public function byId(OrderId $id): ?Order
    {
        $row = $this->db->prepare('SELECT * FROM orders WHERE id = ?')
            ->execute([$id->toString()])
            ->fetch(PDO::FETCH_ASSOC);

        return $row === false ? null : Order::fromRow($row);
    }
    // ...
}
```

Same interface, swap implementations per backend or for tests
(`InMemoryOrderRepository`).

## Anti-patterns

- Generic `findBy(['status' => 'pending'])` — leaks the persistence
  model into Domain
- Returning `QueryBuilder` from a repository method — the caller now
  knows about Doctrine
- Repository that wraps another repository (decorator stacks) without
  a clear reason — flatten the graph

## See also

- `ddd-layering` for which layer owns the interface vs implementation
- `domain-modeling` for what constitutes an aggregate worth a repository
