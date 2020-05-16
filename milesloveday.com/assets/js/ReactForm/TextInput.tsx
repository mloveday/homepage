import * as React from 'react';
import {SomeEntity} from "../Model/SomeEntity";
import styled from 'styled-components';
import {UpdatableProperty} from "../Property/UpdatableProperty";

const PropertyWrapper = styled.div`
  border: 1px solid #eee;
  border-radius: 4px;
  padding: 8px;
  display: grid;
  grid-auto-flow: row;
  grid-gap: 8px;
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

const StateFeedback = styled.div`
  display: grid;
  grid-gap: 4px;
  padding: 8px;
  border: 1px solid #ddd;
  background-color: #eee;
`;

const StateFeedbackTitle = styled.h5`
  margin: 1rem 0;
`;

const StateFeedbackSubtitle = styled.div`
  font-style: italic;
  color: #666;
`;

const FeedbackTable = styled.table`
  width: 320px;
  border-collapse: collapse;
  background: #fff;
`;

const FeedbackHeaderCell = styled.th`
  border: 1px solid #ccc;
  padding: 4px;
`;

const FeedbackCell = styled.td`
  border: 1px solid #ccc;
  padding: 4px;
`;

const InputWrapper = styled.div`
  display: grid;
  grid-template-columns: 2fr 1fr;
`;

export const TextInput: React.FC<{ property: UpdatableProperty<any, any, any>, onChange: (value: string) => void }> = props => {
    return (
        <PropertyWrapper>
            <InputWrapper>
                <label>Quantity <Input className={props.property.isValid() ? 'valid' : 'invalid'} type='text'
                                       value={props.property.input} onChange={ev => props.onChange(ev.target.value)}/>
                </label>
                <div>{props.property.getValidityDescriptions().map((v, k) => <div key={k}>{v}</div>)}</div>
            </InputWrapper>
            <StateFeedback>
                <StateFeedbackTitle>Internal state for property</StateFeedbackTitle>
                <StateFeedbackSubtitle>
                    This information would normally not be shown, but illustrates what is happening behind the scenes for the given property
                </StateFeedbackSubtitle>
                <FeedbackTable>
                    <thead><tr>
                        <FeedbackHeaderCell>Attribute</FeedbackHeaderCell>
                        <FeedbackHeaderCell>Value</FeedbackHeaderCell>
                    </tr></thead>
                    <tbody>
                        <tr>
                            <FeedbackCell>Original "API" value</FeedbackCell>
                            <FeedbackCell>{props.property.api}</FeedbackCell>
                        </tr>
                        <tr>
                            <FeedbackCell>User input</FeedbackCell>
                            <FeedbackCell>{props.property.input}</FeedbackCell>
                        </tr>
                        <tr>
                            <FeedbackCell>Last known good value</FeedbackCell>
                            <FeedbackCell>{props.property.value}</FeedbackCell>
                        </tr>
                        <tr>
                            <FeedbackCell>Is valid</FeedbackCell>
                            <FeedbackCell>{props.property.isValid() ? 'yup' : 'nope'}</FeedbackCell>
                        </tr>
                        <tr>
                            <FeedbackCell>Is dirty</FeedbackCell>
                            <FeedbackCell>{props.property.isDirty ? 'yup' : 'nope'}</FeedbackCell>
                        </tr>
                    </tbody>
                </FeedbackTable>
            </StateFeedback>
        </PropertyWrapper>
    );
};