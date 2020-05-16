import * as React from 'react';
import {SomeEntity} from "../Model/SomeEntity";

export const ReactFormExample: React.FC = props => {
  // TODO show mock save button & disable when clean || invalid

  // hooks
  const [someEntity, setSomeEntity] = React.useState<SomeEntity>();
  const [fetchState, setFetchState] = React.useState<'empty'|'loading'|'loaded'|'error'>('empty');
  const [abortController, setAbortController] = React.useState(new AbortController());
  React.useEffect(() => () => abortController.abort(), [abortController]); // abort "request" on dismount

  // local
  if (fetchState === 'empty') {
    setFetchState('loading');
    // mock an API call with setTimeout
    setTimeout(() => {
      if (abortController.signal.aborted) {
        // do nothing, as the "request" was aborted
        return;
      }
      // TODO mock a failed request and show error handling
      setFetchState('loaded');
      setSomeEntity(SomeEntity.fromApi({
        id: 1,
        name: 'Joe Bloggs',
        quantity: 40,
      }));
    }, 2000);
  }

  // render
  switch (fetchState) {
    case "empty":
      return <div>Hi, nothing to see here yet</div>;
    case "loading":
      return <div>Loading...</div>;
    case "error":
      return <div>Whoops! Something went wrong</div>;
  }

  if (someEntity === undefined) {
    return <div>SomeEntity not found</div>
  }
  return <div>
    <div>
      <label>Name <input type='text' value={someEntity.name.input} onChange={ev => setSomeEntity(someEntity.with({name: ev.target.value}))} /></label>
      <div>Original API value: {someEntity.name.api}</div>
      <div>Input value: {someEntity.name.input}</div>
      <div>Parsed (last known good) value: {someEntity.name.value}</div>
      <div>Is valid?: {someEntity.name.isValid() ? 'yup' : 'nope'}</div>
      <div>Is dirty?: {someEntity.name.isDirty ? 'yup' : 'nope'}</div>
    </div>

    <div>
      <label>Quantity <input type='text' value={someEntity.quantity.input} onChange={ev => setSomeEntity(someEntity.with({quantity: ev.target.value}))} /></label>
      <div>Original API value: {someEntity.quantity.api}</div>
      <div>Input value: {someEntity.quantity.input}</div>
      <div>Parsed (last known good) value: {someEntity.quantity.value}</div>
      <div>Is valid?: {someEntity.quantity.isValid() ? 'yup' : 'nope'}</div>
      <div>{someEntity?.quantity.getValidityDescriptions().map((v,k) => <div key={k}>{v}</div>)}</div>
      <div>Is dirty?: {someEntity.quantity.isDirty ? 'yup' : 'nope'}</div>
    </div>
  </div>;
};