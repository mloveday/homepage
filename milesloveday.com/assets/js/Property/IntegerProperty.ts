import {UpdatableProperty, ValidationRule} from "./UpdatableProperty";

const isANumber = new ValidationRule<string>(input => !isNaN(input as any), 'Must be a valid number');
const isAnInteger = new ValidationRule<string>(input => Number.isInteger(parseFloat(input)), 'Must be a whole number');

export class IntegerProperty extends UpdatableProperty<string, number, number> {
    public static fromApi(api: number) {
        return new IntegerProperty(api, api.toString(), api, input => parseInt(input, 10), [isANumber, isAnInteger], false);
    }

    public with(input?: string) {
        if (input === undefined) {
            return this; // allows us to blindly input optional params of objects in a similar with method in the parent entity
        }
        // can do more complex stuff here if we're, e.g. converting between dates
        return new IntegerProperty(this.api, input, this.isInputValid(input) ? this.parseInput(input) : this.value, this.parseInput, this.validationRules, this.api !== parseInt(input, 10));
    }
}