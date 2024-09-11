# Roka\DML

[![Build Status](https://app.travis-ci.com/rokaromeo/DML.svg?token=qpaV7LwjGXrpYgLBoZiB&branch=main)](https://app.travis-ci.com/rokaromeo/DML)

MySQL DML in PHP. For fun.

```php
$select = Select::fields('count(*)');
$select->from('users');

$select = Select::fields('name');
$select->from('users');
$select->orderBy('length(name) DESC');
$select->limit(10);
$select->page(12);

$select = Select::fields('name');
$select->from('users');
$select->orderBy('length(name) DESC');
$select->limit(10);
$select->page(12);

$select = Select::fields('foo, bar');
$select = Select::fields(['foo, bar']);
$select = Select::fields('foo', 'bar');
$select = Select::fields(['foo', 'bar']);

$select = Select::fields('name');
$select->from('users AS u');
$select->join('posts AS p ON p.created_by = u.user_id');
$select->leftJoin('comments AS c ON c.post_id = p.post_id');

print $select->getJoin('p');
print $select->getJoin('c');

print $select->getSQL();
```
