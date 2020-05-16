import {UpdatableProperty, ValidationRule} from "./UpdatableProperty";

const isAnInteger = new ValidationRule<string>(input => !isNaN(parseInt(input, 10)), 'Must be a whole number');

export class IntegerProperty extends UpdatableProperty<string, number, number> {
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