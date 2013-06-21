# PHP Traits : Good Or Evil ?

## Preamble

Ok guyz, today, I'll speak about this shiny feature of PHP 5.4 : Trait.

I was mitigated about these (relatively) new thing because of some concerns
about some possible infamous efferent coupling tricks.

After some experiences in concrete cases, here is how I see the real shit.

I've made this blog on Github because, it's about coding : what a better place ?

## Trait : the good part

Traits are defined as "horizontal inheritance". Therefore it's good to prevent
the copy-paste antipattern. Kewl. Let's take as example the wrapper/decorator
pattern:


```php
// interface for the server
interface RMIServer
{
    public function newClient($credentials);
}

// implementation for the server
class RMIServerImpl
{
    public function newClient($credentials)
    {
        // ... some code
    }
}

// Wrapping the server and extending class Thing
class MyServer extends Thing implements RMIServer
{
    protected $wrapped;

    // ...

    public function newClient($credentials)
    {
        return $this->wrapped->newClient($credentials);
    }

}
```

Why this ? Because unlike c++, PHP cannot inherit from multiple concrete classes.
You have to replace a "is-a" relation by a decorator pattern. This could be a good
thing (not static) but in many cases it's too verbose, IMO.

Now with trait in PHP 5.4 :

```php
// interface for the server
interface RMIServer
{
    public function newClient($credentials);
}

// implementation for the server
trait RMIServerImpl
{
    public function newClient($credentials)
    {
        // ... some code
    }
}

// implementing the server and extending class Thing
class MyServer extends Thing implements RMIServer
{

    use RMIServerImpl;

}
```

And that's it ! You have strong typing and you easily replace the "is-a" relation
by a "has-a" relation.

## Trait : the bad part

One must understand the major flaw with trait : unlike multiple inheritance,
using a trait don't change the type of that object.
If you add traits in many classes, it's like
copy-pasting the same code in many places without changing the interface of these
classes. This is a generator of hidden coupling and you're doomed to, one day,
break the Liskov Substitution Principle like this :

```php
/* The dark Side */

trait Service
{
    public function getAnswer()
    {
        return 42;
    }
}

class MyService extends OtherThing
{
    use Service;
}

class Broker
{
    public function useService(OtherThing $srv)
    {
        if (in_array('Service', class_uses($srv)))
        {
            $srv->getAnswer();
        }
    }
}
```

This is ugly, evil and an anti-pattern. Using "method_exists" is Evil too.
There is hidden coupling, this is slow, hard-coded, static and not abstract.

We can say this is the Dark Side of efferent coupling.

What to do ?

```php
/* The light Side */

interface Service
{
    public function getAnswer();
}

trait ServiceImpl
{
    public function getAnswer()
    {
        return 42;
    }
}

class MyService extends OtherThing implements Service
{
    use ServiceImpl;
}

class Broker
{
    public function useService(Service $srv)
    {
        $srv->getAnswer();
    }
}
```

Here is the light side of the trait :
 * You rely on abstraction
 * No copy-paste for "re-routing methods"
 * Strong typing

Still, there is a big problem : you cannot avoid a developper to add a new method
in the trait and using it elsewhere and forgetting to add the signature in the interface.
You have to keep trait and interface in sync ! In fact I think about creating a tool
for that.

## Conclusion

Today, if a trait has public method, I **always** make an interface for it.
I'm using the "Impl" suffix for every trait to show it is related with the interface.
Actually, The "Impl" suffix comes from Java API, but I think it's a good standard.

With traits feature, we can think OOP differently : interface on one side,
implementation in trait on the other side and concrete classes are the combo of
both sets. This concept feels like mixins in Common Lisp.

## TODO

 * Code real examples with tests and travisCI
 * trait with only protected : a way to replace helper classes ?
 * How GoF patterns are impacted ? The end of Decorator Pattern ?
 * An example of SplSubjectImpl
