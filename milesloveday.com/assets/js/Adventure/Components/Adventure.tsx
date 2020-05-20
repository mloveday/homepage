import * as React from 'react';
import {startPageOption} from "../Model/Book";
import {adventureBook} from "../assets/adventure-book";

export const Adventure: React.FC = props => {
    const [currentPageName, setCurrentPageName] = React.useState(startPageOption);

    const currentPage = currentPageName === startPageOption ? adventureBook.entryPoint : adventureBook.pages.get(currentPageName);
    if (currentPage === undefined) {
        return <div>Congratulations! You found the super-secret hidden room, alternatively known as a bug.</div>;
    }
    return <div>
        <div>{currentPage.description}</div>
        <div>What do you want to do now?</div>
        <ul>
            {Array.from(currentPage.progressionOptions).map(([key, description]) => <li key={key}><button type='button' onClick={() => setCurrentPageName(key)}>{description}</button></li>)}
            {(currentPage.isFailure || currentPage.isSuccess) && <li><button type='button' onClick={() => setCurrentPageName(startPageOption)}>Restart</button></li>}
        </ul>
    </div>
};