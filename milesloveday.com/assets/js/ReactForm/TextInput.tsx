import * as React from 'react';
import {SomeEntity} from "../Model/SomeEntity";
import styled from 'styled-components';
import {UpdatableProperty} from "../Property/UpdatableProperty";

const PropertyWrapper = styled.div`
  border: 1px solid #eee;
  border-radius: 4px;
  padding: 8px;
`;

const Input = styled.input`
  border: 1px solid #ddd;
  margin: 1px;
  border-radius: 4px;
  padding: 6px;
  &:focus {
    border: 1px solid #aaa;
  }
  &.invalid {
    border: 2px solid #f66;
    margin: 0;
  }
`;

export const TextInput: React.FC<{ property: UpdatableProperty<any, any, any>, onChange: (value: string) => void }> = props => {
    return (
        <PropertyWrapper>
            <label>Quantity <Input className={props.property.isValid() ? 'valid' : 'invalid'} type='text'
                                   value={props.property.input} onChange={ev => props.onChange(ev.target.value)}/>
            </label>
            <div>Original API value: {props.property.api}</div>
            <div>Input value: {props.property.input}</div>
            <div>Parsed (last known good) value: {props.property.value}</div>
            <div>Is valid?: {props.property.isValid() ? 'yup' : 'nope'}</div>
            <div>{props.property.getValidityDescriptions().map((v, k) => <div key={k}>{v}</div>)}</div>
            <div>Is dirty?: {props.property.isDirty ? 'yup' : 'nope'}</div>
        </PropertyWrapper>
    );
};