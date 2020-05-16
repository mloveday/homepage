import * as React from 'react';
import {SomeEntity} from "../Model/SomeEntity";
import styled from 'styled-components';
import {TextInput} from "./TextInput";

const Properties = styled.div`
  display: grid;
  grid-auto-flow: row;
  grid-gap: 8px;
`;

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
    <Properties>
      <TextInput property={someEntity.name} onChange={value => setSomeEntity(someEntity.with({name: value}))}/>
      <TextInput property={someEntity.quantity} onChange={value => setSomeEntity(someEntity.with({quantity: value}))}/>
    </Properties>
  </div>;
};