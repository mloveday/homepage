export class ValidationRule<I> {
    public readonly isValid: (input: I) => boolean;
    public readonly description: string;

    constructor(isValid: (input: I) => boolean, description: string) {
        this.isValid = isValid;
        this.description = description;
    }
}

export abstract class UpdatableProperty<I, A, V> {
    public readonly api: A; // initial value from api (or from new entity, pre-persist)
    public readonly input: I; // user input. Usually a string.
    public readonly value: V; // or 'validated', if you find this easier to decode. Usually the same as api, but can be different, e.g. a moment for a date.
    public readonly isDirty: boolean; // set in constructor using given parseInput method, comparing input to parse value. Not required as constructor param :)
    protected readonly parseInput: (input: I) => V; // helps to allow us to check validity of a given input. Useful for when api, value and input are different types, e.g. numeric inputs and dates
    protected readonly validationRules: ValidationRule<I>[]; // each rule object has a method that returns true for a valid input, and a user-readable description of why it failed

    constructor(api: A, input: I, value: V, parseInput: (input: I) => V, validationRules: ValidationRule<I>[]) {
        this.api = api;
        this.input = input;
        this.value = value;
        this.parseInput = parseInput;
        this.validationRules = validationRules;
        this.isDirty = true; // todo how do we set this
    }

    // filter out rules that state the input is valid
    public isInputValid = (input: I): boolean => this.validationRules.filter(rule => !rule.isValid(input)).length > 0;
    public isValid = (): boolean => this.isInputValid(this.input);
    public getValidityDescriptions = (): string[] => this.validationRules.filter(rule => !rule.isValid(this.input)).map(rule => rule.description);
    public abstract with(input: I): UpdatableProperty<I, A, V>;
}