#Coding to reduce cognitive load

One of the things I've encountered many a time in various projects I've worked on (yes, this includes stuff only I have worked on), is something that you have to stop in your tracks and just try and figure out. What is this little snippet (_hopefully_ just a snippet) of code actually trying to do? Why on earth did they write it that way? What on earth was I thinking?

Of course, if you're trying to fix a bug that runs through this code, you have to stop thinking about the problem you were actually dealing with and start trying to understand what the hell was _meant_ to be happening. The bug could be here, or it could not. This is itself is one of my main bugbears with reading & changing code - it may be smart, it may be efficient, it may simply be suggesting the developer who wrote it is far smarter than you'll ever be to understand it, but in reality it's a pain to deal with because who knows what it's meant to do, how it does it and what's going to happen if you tweak it slightly.

So what to do about it? This path has been trodden before, people have written books about it. What do I have to add? Just a few things that I've spotted from working with code that could be easily changed to make things much easier for the next poor sod who has to read your code.

## Keep it short
Yup, that old classic. Make a function that does one thing and does it well. Give it a super-long descriptive method name that describes what it accepts and what it does to it.

## Make it fluent
If you're calling a setter on an entity, make it return the object so you can make repeated setter calls on it.

## Don't use useless type hints
If you're using static typing (and you should, unless you're some kind of robot that never makes a typo or someone who hates QOL stuff like autocompletion of method names), avoid using any (in, e.g. Typescript) or mixed (PHP). It doesn't help, the next guy just has to do the mental calculation themselves and it stops them in their tracks.

## Make links between disconnected stuff
OK, a little more specific this one, basically it boils down to specifying strings as constants or in enums and using them instead of just typing out the string.

Service A fires an event using a string. It makes this string by concatenating various things together for some reason. When we look at Consumers B, C, D, E, etc, how do we know where the call is made? For that matter, how do we know what is going to happen when Service A dispatches the event? I know it probably makes for a few more lines of code, but a switch statement with direct references to a class constant makes that link between the service that dispatches the event and the consumer much more concrete, i.e. that a (rather smart) dumb IDE can simply click through between them rather than the poor dev having to do a lot of thinking.

Likewise, validating form types can happen within a method of the entity it is meant to be validating. Everything is laid out for all to see in the entity itself rather than having to search through various validation classes.

## Don't rely too much on magic
This one is the biggie, and I'll write some more blog posts on this to fit it all in. The biggest source of bugs I've seen (beyond the dev who wrote spaghetti code 5-10 years ago) is relying on magic that just happens. Entities are magically populated (except when they're not), listeners listen out for something to complete and do stuff without you realising.

This sort of thing is basically the same as more links between disconnected stuff, but in a world where we don't control the code that's doing it. When we rely on a dependency that does loads of things, there are usually a lot of options for how we want to deal with certain situations, and ways to make it do something we want it to do. The problem is that this custom behaviour is usually tucked away in a non-obvious place, using a config key or tag that tells the dependency when and where we want to use it.

Fine, if we know it's being used. For the poor dev who started a few weeks back, they have to
- know of the existence of this feature (i.e. they've read the docs cover to cover, for this dependency, and by that logic, all dependencies)
- know that we've set this particular feature up (i.e. they've read the config, and having read the docs understand what all the keys do)
- When expecting two and two to make four, but found we've actually got 5, put two and two together to make (the custom feature being used in secret by the dependency)

IMHO, if we're doing something unexpected like this, we should be really explicit about it. Write a comment explicitly telling the user when and where this happens in the most appropriate place. If we find we're writing this sort of stuff out a lot, we've either got a horrible to maintain codebase, or we're basically using this feature for everything. If it's the latter, we should probably just point it out somewhere hard to miss in the readme.