import {UpdatableProperty, ValidationRule} from "./UpdatableProperty";

const stringIsNotTooLong = new ValidationRule<string>(input => input.length < 10, 'Must be fewer than 10 characters long');
const stringIsNotEmpty = new ValidationRule<string>(input => input !== '', 'Must not be empty');

export class LengthLimitedStringProperty extends UpdatableProperty<string, string, string> {
    public static fromApi(api: string) {
        return new LengthLimitedStringProperty(api, api.toString(), api, input => input, [stringIsNotEmpty, stringIsNotTooLong]);
    }

    public with(input?: string) {
        if (input === undefined) {
            return this; // allows us to blindly input optional params of objects in a similar with method in the parent entity
        }
        // can do more complex stuff here if we're, e.g. converting between dates
        return new LengthLimitedStringProperty(this.api, input, this.isInputValid(input) ? this.parseInput(input) : this.value, this.parseInput, this.validationRules);
    }
}