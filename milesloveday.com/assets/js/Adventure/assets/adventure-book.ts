import {Book, startPageOption} from "../Model/Book";
import {Page} from "../Model/Page";

const introPage = new Page('You are outside a building for reasons. You go through the scary door.',new Map([['perilous', 'Go through the door']]), false, false);

const pages = new Map<string, Page>([
    ['perilous', new Page('You enter the building and immediately find yourself in a perilous situation. What do you do?', new Map([
        [startPageOption, 'Leave immediately'],
        ['fail', 'Wait and see what happens'],
        ['success', 'Push on through'],
    ]), false, false)],
    ['success', new Page('You push on through and find out the perilous thing wasn\'t all that. You got where you needed to get to without a scratch. Well done you!', new Map([]), true, false)],
    ['fail', new Page('Your soul is eaten alive by some foul beast. Tough luck', new Map([]), false, true)],
]);

export const adventureBook = new Book(introPage, pages);