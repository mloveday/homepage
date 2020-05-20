import * as React from 'react';
import * as ReactDOM from 'react-dom';
import {ReactFormExample} from "./ReactForm/ReactFormExample";
import {Adventure} from "./Adventure/Components/Adventure";

ReactDOM.render(
    <Adventure/>,
    document.getElementById('react-adventure-root') as HTMLElement
);