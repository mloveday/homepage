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
  const [fetchState, setFetchState] = React.useState<'empty'|'requested'|'loading'|'loaded'|'error'>('empty');
  const [abortController, setAbortController] = React.useState(new AbortController());
  React.useEffect(() => () => abortController.abort(), [abortController]); // abort "request" on dismount

  // local
  if (fetchState === 'requested') {
    setFetchState('loading');
    // mock an API call with setTimeout
    setTimeout(() => {
      if (abortController.signal.aborted) {
        // do nothing, as the "request" was aborted
        return;
      }
      if (Math.random() < 0.2) {
        setFetchState('error');
        return;
      }
      setFetchState('loaded');
      setSomeEntity(SomeEntity.fromApi({
        id: 1,
        name: 'Foo Bar',
        quantity: 40,
      }));
    }, 2000);
  }

  const Preamble = (<div>
    <h3>Working example of react form with property-based validation</h3>
    <p>
      In <a href='https://milesloveday.com/blog/front-end-data'>a blog post</a>, I explained how I'd approached validating user inputs in the past using property-based validation. Re-reading it, I realised how dense it is, and a useful, working example is always useful, exposing normally hidden information to the user so they can see it working.
    </p>
    <p>
      This example fixes a couple of issues with the code that I published, and can be seen in the repo for the homepage <a href='https://github.com/mloveday/homepage/tree/master/milesloveday.com/assets/js'>here</a> (see ReactForm/* for components, Model/* for API models and internally used entities and /Property* for individual property type definitions).
    </p>
    <p>
      This pretends to fetch an entity from an API (mocked using setTimeout, making use of an abortController & useEffect for component dismounting), handling the status of the request to display accurate information to the user. This is parsed into a model, which converts basic number/string/whatever properties into the property types discussed in the blog post. These do all of the heavy lifting of validation, checking for dirtiness, etc, and leave the components concerned only with displaying the relevant controls in the appropriate way.
    </p>
    <p>
      The only validation on these are a rather annoying length limit of 9 characters on the name as well as it not being empty, and the quantity must be an integer (and by extension a number). They allow any text to be entered in, where in reality we might prevent this with a mask. Try it out, type some stuff in and see what happens.
    </p>
    <p>Start the "API request" by clicking the load button. Approximately 1 in 5 requests will 'fail', showing an error message. The request can be retried by clicking the load button again.</p>
    <button disabled={!['empty','loaded','error'].includes(fetchState)} onClick={() => setFetchState('requested')}>Load data</button>
  </div>);

  // render
  switch (fetchState) {
    case "empty":
      return <div>
        {Preamble}
        Hi, nothing to see here yet. Try clicking the load button to make a fake API request to get some data.
      </div>;
    case "loading":
      return <div>
        {Preamble}
        Loading...
      </div>;
    case "error":
      return <div>
        {Preamble}
        There was an error fulfilling the previous request - click the load button to retry
      </div>;
  }

  if (someEntity === undefined) {
    return <div>SomeEntity not found</div>
  }
  return <div>
    {Preamble}
    <Properties>
      <TextInput label={'Name'} property={someEntity.name} onChange={value => setSomeEntity(someEntity.with({name: value}))}/>
      <TextInput label={'Quantity'} property={someEntity.quantity} onChange={value => setSomeEntity(someEntity.with({quantity: value}))}/>
    </Properties>
  </div>;
};