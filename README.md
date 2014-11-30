# PlayCool.

### Architecture
I've tried to do some DDD. But as you will see is not a 100% DDD implementation.
I wanted to try the DDD approach but I didn't want to be too much strict with the code.

The APP has 3 layers from the Domain objects to the Presentation.

#### Domain Layer
This layer contains the objects of our domain, and contracts for the repositories.

In the `Entity` folder we have
- Track: Object with and ID and a Name of the track
- Playlist: A list of tracks with a name and an ID.
- Album: Same as Playlist (we can add album release, album type, etc...)
- Artist: A list of Albums and the name of the artist + the id.

In the `ValueObject` folder we have objects to represent our unique ID's.
This was really useful when changing the id validations and types.

The `Contract`folder has al the interfaces for the repositories.

`Aggregate` has an PPO called `AggregateSearch` this is the result of mixing Tracks, Albums and Artists in one search.

And finally we have a `ArrayCollection` adapter for the Doctrine ArrayCollection object. This is just a more OOP implementation of the basic PHP array.

#### Application Layer
Here we have code that interacts with the domain in order to produce behaviour.

He have `Commands`. This are the inputs for our `UseCase`.
Commands should validate the input and throw exceptions when something is not valid.

The UseCases are how our application interacts. We have use cases for creating playlists, adding tracks, searching, etc...

#### Infrastructure Layer
This layer is all about Persistence.
Here we have our `Repository` folder.

Inside we have different implementations of our data sources.
In the `Spotify` folder we have Repositories that use the Spotify API.

In the `File` folder we have repositories that interact directly with the OS.
This is my persistence layer. I didn't implement MySQL because I find this easier to set-up in the tests.

The `Redis` folder is my cache system. And all the repositories there act as a decorator for other implementations.

Finally, in our infrastructure we have `Spotify` and `Cache` folders.
This are adapters for third party libraries.

### Presentation Layer
This is the layer where we actually display something to the user. In my case is a web API using `Silex`

In this folder we have the `Routes` of the application and the `Services` being used by silex.

Also we have a folder called `Services` where I set-up some custom services for silex. Like the `RepositoryService` this allows me to change Data Sources in a really easy way.

Then we have `Controllers`nothing to say about that. And `Transformer`.
The last ones are about transforming the Domain objects into API resources.
Hidding possible private data and making our life easier with versioning.

### Third party libraries.

For the Domain layer I've used `Doctrine/Collections`.
The only reason was that this library adds a better OOP approach for arrays.

For the presentation layer I used `Silex` and `Fractal`

I used Silex because is Symfony but without all the overhead that Symfony adds.
I've been using silex for a few months and I really like it.
It's simple, it's quick and has a good compatibility with Symfony libraries.

In this case was even better because Silex is really straightforward for API's

Fractal was more about an experiment. The same can be accomplished with a few classes. But I wanted to give it a try.

Is easy to set-up and easy to maintain. And makes really easy to maintain compatibility withing output and data schema.

Finally, for the Infrastructure layer I've used:

For the API SDK: `jwilsson/spotify-web-api-php`
It does what is supossed to do. I don't really liked how it was structured and how Exceptions are handled. But I didn't had too much alternatives and I didn't have the time to implement one on my own.

`Redis`and `Predis`.
Redis is just amazing. I had a few ideas on how to implement the cache system and Redis was a great fit.

I wanted to have all the tracks in their own key of cache.
The playlists will be Redis sets with the key reference. And I also will have some cache-tags for easier deletion of related caches.

Finally I didn't do all that. For two main reasons.
1. Time
2. I didn't need it.

The current implementation don't allow to update albums or Artists so I didn't need to keep a tag-system.
The playlists where easier to cach and update in a hash-map so I finally used that.

But anyway, I still think Redis is a great fit for this.
It has great datastructures for other kind of implementations (not only cache), it has pub-sub for distributed system.
So I think it can have a great fit in a more extended implementation.

### About the exam.

I've really enjoyed the exam. The main idea was fun and not having to do a front-end website helps a lot, as I'm not really good with colors and design.

I found the challenge interesting, I liked that you don't care that much about the MySQL part, because that is trivial. And cared about optimization and performing as less calls as possible.

Saddly I wasn't able to finish my cache system as I wished but I think the final result is interesting.

I also take the oportunity to layer the APP in a DDD fashion and that was really funny too.

Finally, Thanks for the opportunity of make this test.
And for the time,

Regards Ignacio T.