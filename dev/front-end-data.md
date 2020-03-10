## What I'm trying to solve here
I've worked with a few front end JS frameworks in my time, and the one thing I've noticed is that the time always ends up being spent coping with basic form stuff: validating user input, checking whether a form has been edited, informing the user of invalid entries, resetting changes, and just plain storing it sensibly in an easy to understand way.

My weapons of choice right now are React and Redux in Typescript, I'm really enjoying how much less faff there is using hooks compared to using classes, JSX in Typescript is just wonderful as I don't need to guess what the variables are in my templates as it's literally a template literal, and I love the immutability aspect of Redux, as well as make a change once, and it magically appears everywhere.

So the main issues I've found when doing front end SPA work for a CRUD app is that we need to fetch information in one format from an API, store it somewhere, change it easily, revert it, validate it and crucially do all this _safely_, as if an idiot (me) is doing the coding. That's basically why I love Typescript - I've got a brain that doesn't like to remember the structure of stuff I did ages ago (as in anything I'm not currently working on, and sometimes not even that), so the self documenting nature of it plus autocomplete makes me very happy. However, it can be difficult when there can be so many different ways of editing one entity (as I'll explain later), shortcuts can be taken to avoid nasty typings and then it's open season on bugs. Also, user input validation can easily double the number of properties you are storing, as well as all the other metadata about the properties, such as dirtiness, original state, error messages for validation failures, etc.

## A little preamble - flat state

I'm a fan of a flat API. What I mean by that is that in the front end, it is much simpler to reason with and store entities in the same way they are stored in the back end - they are stored independently and contain references to other entities by ID only. There's no nesting of data how it's stored, and I find that whilst it can be quite nice to get one big lump of data containing everything you'll ever need and more, what happens when we edit some part of that data elsewhere in the app? Do we need to remember everywhere that will consume this? What if we miss a place nested two levels deep? When we parse a nested object, do we update the store for that object type? How do we handle partial information about a nested entity?

Take a many to many relationship for example: A and B have a many to many relationship (with a nominal entity, M, in the middle, which actually stores this information). If you serialise an entity, A, you might get something like this from an API:
```lang-json
{
    id: 1,
    name: 'foo',
    bs: [
        { id: 1, name: 'bar' },
        { id: 2, name: 'baz' }
    ]
}
```
Nothing too complicated there, right? So we store the entity in the store for objects of type A. What do we do with the entities in the array? If we parse them into a different store, we're missing information about them - that they link to the entity A with id of 1 (plus potentially others). If we then know that the entities are incomplete, we need to fetch them to get the full information about them. Why then store them in the first place? What happens if we then start adding more information to the entity in the middle of this relationship, e.g. a count or a name or a reference number, or something like that? We then have to completely change the API structure to return something different, _plus_ we have to change the front end to handle this. If we had kept the API flatter, we would need to make more API requests initially (one for entity A, another for the entities related to A, and potentially more for the entities related to _that_), but the information in each case, crucially, is complete. Changing the format of one entity does just that, changes it in one place.

On the flip side, in the front end you have to then piece together disparate information and figure out the best way of making complex requests back to the API (though that can easily be mitigated in the back end at least). 

Anyway, just my two cents.

## My solutions to the front end data issue 

I'll write this historically, if you just want to know a "good enough" way to handle data, skip to the end where there's a little more code...

I started in state models, adding a consistent with() method to make reducers easy to read. Type hinting was pretty much non existent, I figured it was always reasonably obvious what was expected to be passed into these methods (ha!). They were a simple wrapper around an Object.assign() call, so anything was allowed in and it just plain overrode any existing properties, as you would expect.

Step two was adding a couple of naive flags to allow checking for whether a form had been edited. This was fine, but didn't check for whether the form data had actually changed.

When I got to actually doing things with the data, I found I started getting really odd results. Numbers were strings (I hadn't validated user input), dates that I thought were moments were actually strings or vice versa. Stuff was going wrong. Turns out I was reusing the with method for parsing API input _and_ for editing in the front end and everything was getting mixed up. Adding basic validation onto user inputs then caused all sorts of trouble, since I was directly editing the data they were inputting, making the inputs behave in odd ways (cursors jumping around, not allowing a user to input a full date/time, etc).

So. My first stab at this was to maintain the concept of the entity being my own source of truth (i.e. the most recent correct validated input), then also store inside that entity a copy of the parsed api input (to allow resetting a form back to its original state) and a similar object for user inputs. The flow of data is as follows:
1. Api response (fromApi() method)
  - populate API object (direct copy)
  - validate object into main entity (use some predefined functions for this). In theory the inputs should all be valid.
  - concert API response into input object. Essentially converting to strings of the appropriate format.
2. User edit (with() method)
  - in all cases, create new object, update only property that has changed and use existing properties
  - validate user input. If valid, update root object, else use existing value.
  - update user input property no matter what. Don't mess with what they're doing!
  
```lang-typescript
// don't take these type/class names too seriously, I'm just illustrating a point here
class Foo extends EntityVariantOf<SomeGenericEntity<number>> {
    public readonly id: number;
    public readonly name: string;
    public readonly quantity: number; // relates to number in generic. In the inputs, it's actually a string
    
    public readonly inputs: InputVariantOf<SomeGenericEntity<string>>;
    public readonly api: ApiVariantOf<SomeGenericEntity<number>>;
    
    // constructor, which has to take each property, plus inputs and api
    
    public with(obj: Partial<InputVariantOf<SomeGenericEntity<string>>>) {
        // ... do loads of stuff here for each property for this model, plus the inputs model (which has its own variant of this method)
    }
    
    public static fromApi(obj: InputVariantOf<SomeGenericEntity<string>>) {
        // ... do loads of stuff here for each property for this model, plus the inputs model (which has its own variant of this method), plus the api model (which has its own variant)
    }
}
// etc. I actually used all this. It didn't have simple isDirty checks, these had to be done in components for each property, or loads of properties needed getters
// also, there are no validation rules defined anywhere, these need to be added in the with() and fromApi() methods, for each model type, for each property. i.e. lots of repetition
```

This was fine, though a little (OK, maybe a lot) repetitive as I was no longer using Object.assign. The real issue came with type hints. We needed variants of the core object definition containing an ID (API create request/response model), without an ID (API request model for new entity), with number type properties (API model, validated model) with string type properties (user input model), and partial variants of these (for updating). I managed it but the typings were complex and needed copy/pasting for each new entity to get right - it was quite fragile.

So version 2 needed to be a little different. I realised that instead of duplicating the entire entity, I could just do it for each property instead. Given each property was of a limited number of types, I could reuse the same model for each type. No more copy/pasting! As an added bonus, I could extend these types by adding custom validation rules at the point of creating them, like so:
```lang-typescript
class ValidationRule {
    public readonly isValid: (input) => boolean;
    public readonly description: string;
    // ... plus constructor
}

const isAnInteger = new ValidationRule(input => !isNaN(parseInt(input, 10)), 'Must be a whole number');

abstract class UpdatableProperty<I, A, V> {
    public readonly api: A; // initial value from api (or from new entity, pre-persist)
    public readonly input: I; // user input. Usually a string.
    public readonly value: V; // or 'validated', if you find this easier to decode. Usually the same as api, but can be different, e.g. a moment for a date.
    public readonly isDirty: boolean; // set in constructor using given parseInput method, comparing input to parse value. Not required as constructor param :)
    protected readonly parseInput: (input: I) => V; // helps to allow us to check validity of a given input. Useful for when api, value and input are different types, e.g. numeric inputs and dates
    protected readonly validationRules: ValidationRule[]; // each rule object has a method that returns true for a valid input, and a user-readable description of why it failed
    // ... constructor, sets properties given above in order
    // filter out rules that state the input is valid
    public isInputValid = (input: I): boolean => this.validationRules.filter(rule => !rule.isValid(input)).length > 0;
    public isValid = (): boolean => this.isInputValid(this.input);
    public getValidityDescriptions = (): string[] => this.validationRules.filter(rule => !rule.isValid(this.input)).map(rule => rule.description);
    public abstract with(input: I): UpdatableProperty<I, A, V>;
}

class IntegerProperty extends UpdatableProperty<string, number, number> {
    public static fromApi(api: number) {
        return new IntegerProperty(api, api.toString(), api, input => parseInt(input, 10), [isAnInteger]);
    }

    public with(input?: string) {
        if (input === undefined) {
            return this; // allows us to blindly input optional params of objects in a similar with method in the parent entity
        }
        // can do more complex stuff here if we're, e.g. converting between dates
        return new IntegerProperty(this.api, input, this.isInputValid(input) ? this.parseInput(input) : this.value, this.parseInput, this.validationRules);
    }
}
// ... likewise for, e.g. IdProperty, DateProperty, DateTimeProperty, StringProperty, etc

class Foo {
    public readonly id: number; // this is never edited
    public readonly quantity: IntegerProperty;
    public readonly name: StringProperty;
    // ... constructor
    
    public with(obj: Partial<ApiFoo<string>>) { // ApiFoo<T> is {id: number, quantity: T, name: string}
        return new Foo(this.id, this.quantity.with(obj.quantity), this.name.with(obj.name));
    }
}
```

Now I can have integer values with different rules, e.g. one property must be greater than zero, one must be in a given range, etc, etc. These validation rules can be created with a small user visible message, allowing validation errors to be displayed next to the user inputs as they are editing them, alerting the user to anything they need to fix. As the rules are stored in an array, the error messages can be filtered down to only the failing rules, making it super clear exactly why the input is wrong.

The usage of this setup is really nice in the components that need to change properties:
```lang-tsx
type Props = { id: number, };

export const FooComponent: React.FC<Props> = props => {
    const dispatch = useDispatch();
    const entity = useSelector((state: AppState) => state.foo.loadEntityWithIdIfRequired(props.id, dispatch)); // dispatches thunk to get entity if we don't have it
    if (entity === undefined) {
        return <LoadingPlaceholder/>
    }
    return (
        <div>
            <div className={entity.name.isValid() ? 'valid' : 'invalid'}>
                <label>Name <input type='text' value={entity.name.input} onChange={ev => dispatch(updateFoo(entity.with({name: ev.target.value})))}/></label>
                {entity.name.getValidityDescriptions().map(description => <div>{description}</div>)}
            </div>
            <div className={entity.name.isValid() ? 'valid' : 'invalid'}>
                <label>Quantity <input type='text' value={entity.name.input} onChange={ev => dispatch(updateFoo(entity.with({quantity: ev.target.value})))}/></label>
                {entity.quantity.getValidityDescriptions().map(description => <div>{description}</div>)}
            </div>
        </div>
    );
};
```

As should be clear from the duplication from just two inputs in the component above, the inputs and surrounding elements can then be moved into their own components, which accept an UpdatableProperty, a label and an onChange callback prop and reduce the load when creating a new form. Note that because of the type hinting on the with() methods, typescript will warn you if you make a typo in the object you're giving it, or the type is incorrect, e.g. you forgot to use `type='checkbox'` and passed `ev.target.value` instead of `ev.target.checked` (yup, been there, done that, had typescript save me, bless it).

All of this takes some setup, and more complex interactions do require thought, especially with the many to many relationships described earlier. However, once you've clearly defined the entities, the UpdatableProperty types and the reusable form components, you are free to think about these things that are actually worth thinking about, rather than debugging little quirks in your code or repeating the same pattern of elements to get the styling just right.

Having said this, there are form dependencies out there, e.g. Formik, but why go to that effort when you can have some fun doing it yourself :)