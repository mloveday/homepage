import {LengthLimitedStringProperty} from "../Property/LengthLimitedStringProperty";
import {IntegerProperty} from "../Property/IntegerProperty";

export type ApiSomeEntity<T = number> = {
    id: number,
    name: string,
    quantity: T,
};

type UpdateSomeEntity = Partial<ApiSomeEntity<string>>;

export class SomeEntity {
    public readonly id: number;
    public readonly name: LengthLimitedStringProperty;
    public readonly quantity: IntegerProperty;

    public static fromApi = (obj: ApiSomeEntity) => {
        return new SomeEntity(
            obj.id,
            LengthLimitedStringProperty.fromApi(obj.name),
            IntegerProperty.fromApi(obj.quantity),
        );
    };

    constructor(id: number, name: LengthLimitedStringProperty, quantity: IntegerProperty) {
        this.id = id;
        this.name = name;
        this.quantity = quantity;
    }

    public with = (obj: UpdateSomeEntity) => {
        return new SomeEntity(
            this.id,
            this.name.with(obj.name),
            this.quantity.with(obj.quantity),
        );
    };

    public reset = () => SomeEntity.fromApi({
        id: this.id,
        name: this.name.api,
        quantity: this.quantity.api,
    });

    public isValid = () => this.editableProperties.reduce((carry, prop) => carry && prop.isValid(), true);
    public isDirty = () => this.editableProperties.reduce((carry, prop) => carry || prop.isDirty, false);

    private get editableProperties() {
        return [this.name, this.quantity];
    }
}