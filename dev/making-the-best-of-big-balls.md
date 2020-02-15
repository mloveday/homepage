# Making the best of a less-than ideal project
More often than not, you'll find yourself working on something a little long in the tooth. It's got warts and wrinkles and all sorts. How can you make things better?

I've spent a reasonable amount of time working on legacy projects, constantly trying to improve them, sometimes breaking them and generally trying to find a way to make it a little less painful.

Sometimes you're just lumped with something. You're not allowed a rewrite (though should you need to do one?), you're not even allowed to upgrade the framework or language because it costs too much (I can hear the warning klaxon going off about that viewpoint) or just because there is no clear upgrade path to a newer version. Can you make things a little easier?

## What makes you sad?
Sometimes the thing that makes it painful is not the shiny new feature, it's that your time is wasted because of some really slow, painful issue to do with tooling. Ask yourself if that can be mitigated.

For example, a recent project I worked on had an AngularJS (yup, Angular 1) built with Grunt, running in a Vagrant box in the dev environment. It worked, did the job, but there were a couple of issues when actually making any sort of changes to code.

Firstly, html templates and js were separate. That's not too much of an issue, but if you're trying to navigate between various components to see where things are rendered, or tracing back through said components to discover where a variable was instantiated, it doubles the number of files you look through, and the constant switching between camel and kebab casing for names of components and their definitions is painful. The solution? Inline the template in the component's definition. Instantly there are half as many files around, and whilst you can end up with some monstrously long files, that's really an issue with overly large components rather than this setup. Another downside is that some people simply don't like having it all together (html in a .js file? Blasphemy!), but personally (using lots of React & JSX) I like having it all in one place.

Secondly, Grunt could be replaced with webpack relatively easily, without modifying the existing code very much. Effectively Grunt is only concatenating the files together, so with some judicious use of require and a smattering of files that define where all of the stuff we should be using is going to be found, we can centralise our entry point, with that entry point basically concatenating all of the files together using require.

Thirdly, type safety. I like it. I like it a lot. I _hate_ having to figure out the structure of some random variable that is defined so far away as to be in another timezone, requested through an API call that you have to research for a week to find the actual expected structure. Changing the extension of the files is a great place to start, not too time consuming if you set appropriate (i.e. forgiving) config up for Typescript and helps you see some of the more gnarly parts of the code that you would have left alone otherwise. There's no need for immediate adding of types or models or any of that, just importing dependencies as you use them (e.g. moment.js, lodash, etc). Whenever you have to look up the data structure for something, make a simple type for it and add typings where appropriate.

Fourthly (that's surely not a word?), build tools. I know you can add extra things like babel onto Grunt, but in reality I found it more difficult to get anywhere than with just ripping out the build tool and starting from scratch. In no tie at all, we're supporting ESNext on old, old browsers. Lovely.

Lastly, is there anything silly going on? We were running Grunt inside the vagrant box, as it reduced the amount of steps a new dev would have to take to get going. What this meant was that whenever a change was made, Grunt would take up to a minute to work out that something was different before re-building. It was tortuous. "F*&$ing Grunt!" became frequently uttered as we waited for another minute to reap the benefits of the single character change in a template somewhere. The solution? build it on the host machine. Installing yarn once on a machine is not hard, only has to be done once, and gives near instantaneous builds. We also managed to set up shared run configurations (i.e. stored in git) for PHPStorm/IntelliJ, meaning one less step to remember, one less console open and one less thing for said new dev to do to get up and running.

As a source of pain, Grunt was it. Not the code, the legacy framework, the dev tooling. Replacing it was relatively simple, took a few days, but we really reaped the benefits. 

- add basic shell scripts for really common stuff
    - saves time and effort remembering console commands or flags
    - allows for super-easy db reset scripts to get you back to square one for testing, e.g. migrations
- document everything you find surprising
    - put it in the most difficult to miss place, e.g. in a doc block in the entity/service/whatever that has the surprising behaviour
- automate the hell out of getting vms set up
    - pretty much everything can be automated
    - ansible and ansible-galaxy get you a long way towards this without having to know everything about everything
    - write scripts for stuff that needs to be done manually post-provision

## Make it easy to read (see blog post 1)
- PHP-CS & PHPStan is your friend
- Some basic changes can make all the difference
    - e.g. return early, reducing nesting and preventing having to jump up and down the code to work out the flow
## Make it less surprising
- Add constants where possible
- Use enums rather than varchars or ints in DB
    - human readable
    - can be expressed as a constant :) :)
- document everything you have to do
    - and give yourself a pat on the back every time you read your own doc
## Add some tests for stuff that is really not obvious
- This is horribly time-consuming, but worth it for the peace of mind
- smoke tests are better than nothing
    - Can be really slow, so don't expect them to be run very often
- Keep an eye on the CRAP index in PHPUnit results - can be useful to optimise for this with new code or to find the worst offenders to attack next
## If necessary, make it easy to swap things in and out
- e.g. updating symfony to use flex, adding default autowiring for services
## Break it down into sensible chunks
- just refactor shit into smaller services
    - thin controller, micro-services (tm)