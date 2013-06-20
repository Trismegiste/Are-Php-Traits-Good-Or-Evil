# PHP Traits : Good Or Evil ?

## Preamble

Ok guyz, today, I'll speak about this shiny feature of PHP 5.4 : Trait.

I was mitigated about these (relatively) new thing because of some concerns
about some possible infamous efferent coupling tricks.

After some experiences in concrete cases, here is how I see the real shit.

I've made this blog on Github because, it's about coding : what a better place ?

## Warning

For PHP fans : I love PHP. I hate PHP. There are fantastic features and there are
ugly features. Every language has. Today, I like PHP 5.3+ because the community
and the ecosystem are vast and pretty alive. Only Javascript can compete but
I'm not a huge fan of prototyping. Therefore : PHP.

I love c++, I like java, I have coded in perl, prolog and lisp. Today I code in PHP and
tomorrow ? Scala, JS or Clojure ? Who knows...

## Trait : the good part

Traits are defined as "horizontal inheritance". Therefore it's good to prevent
the copy-paste antipattern. Kewl.

Do you recall the "Impl" suffix in java API ?

```java
class RMIServerImpl implements RMIServer...

class MyServer extends Thing implements RMIServer
{

    protected RMIServerImpl wrapped;

    public RMIConnection newClient(Object credentials) throws IOException
    {
        return wrapped.newClient(credentials);
    }

    // ... some other "redirection methods" to the wrapped implementation

}
```

Why this ? Because unlike c++, java cannot inherit from multiple concrete classes.
You have to replace a "is-a" relation by a decorator pattern. This could be a good
thing (not static) but in many times it's too verbose, IMO.

Without trait, PHP 5.3 does the same trick.

Now with trait :

```php
interface RMIServer
{
    public function newClient(Object $credentials);
}

trait RMIServerImpl
{
    public function newClient(Object $credentials)
    {
        return 42;
    }
}

class MyServer extends Thing implements RMIServer
{

    use RMIServerImpl;

}
```

And that's it ! You have strong typing and you don't need to transform a "is-a" relation
by a "has-a" relation.

## Trait: the bad part

One must understand the major flaw with trait : using a trait don't
change the type of that object. If you add traits in many classes, it's like
copy-pasting the same code in many places without changing the interface of these
classes. This is a generator of hidden coupling and you're doom to break the Liskov
Substitution Principle :

```php
trait Service
{
    public function getThing()
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
    public function useService($srv)
    {
        if (in_array('Service', class_uses($srv)))
        {
            $srv->getThing();
        }
    }
}
```

This is ugly, evil and an anti-pattern. Using "method_exists" is Evil too.
There is hidden coupling, this is slow, hard-coded, static and not abstract.

We can say this is the Dark Side of efferent coupling.

What to do ?

```php
interface Service
{
    public function getThing();
}

trait ServiceImpl
{
    public function getThing()
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
        $srv->getThing();
    }
}
```

Here is the light side of the trait.

## Conclusion