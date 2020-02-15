1. Front end data structures, storage and making things easy to work with
    - gotchas
    - consistency
    - not making mistakes (inevitable typescript mention)
    - nesting data (pros, cons)
    - URLs, params from routing
    
# Front end data structures, storage and making things easy to work with

Having worked with a few different frameworks over the years, I've noticed the one thing that seems to make writing a feature-rich SPA difficult is data management. Right now, my weapon(s) of choice are React and Redux, written in Typescript, so this has a leaning towards those technologies that might not apply elsewhere. Either way, I've found a happy place that I'm comfortable with and I feel makes for easily extendable code.

## What goes wrong
There are a few places where things can go wrong, this is certainly not exhaustive...
1. Updating existing state
    - mutability
    - reacting to changes
2. Accessing current state
    - Pass as props
    - global state (custom built)
    - global state (Flux-like)
3. Receiving data from an API, modifying, validating and then sending it back to the API
    - basic controlled form data
        - pristine vs mutated
        - resetting
        - not modifying user input
    - updating an entity with partial information
        - Object.assign
            - how do you validate?
        - constructor calls
            - really tedious and repetitive
        - type hints in method params
            - multiple setters?
            - with(x)?
    - validating data
        - Rule 1: don't interrupt the user
        - Rule 2: let them know immediately that something wasn't correct
        - Rule 3: let them undo everything
        - make it extensible to avoid repeating the same code over and over everywhere
4. Data structure
- flat
    - easy to reason with
    - super-quick API calls
    - bloody awkward getting targets of one-many or worse, many-many relationships
    - runs a little against, e.g. Doctrine
- nested
    - nice and easy to get lots of relevant data out of an API
    - can get really confusing to know which nested bits appear in which models where you have circular references between entities (bad for typescript)
    - super-easy to use in the back end - just json_encode o.e. and you're done
    - nasty having to parse nested objects to update other entities if that's something that should happen

## Potential solutions
1. Each editable entity has a with() method, and some complex typing that ensures the main entity also includes a kind-of duplicate of itself, but containing raw user input, and a copy of the original api data for resetting
2. Each property that is editable is parsed into a class that holds the original data, the raw user input and the validated 